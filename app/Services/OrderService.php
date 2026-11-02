<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderStatusChangedNotification;
use App\Notifications\OrderCancelledNotification;
use Illuminate\Support\Facades\Notification;

class OrderService
{
    /**
     * Get paginated orders.
     * Admin sees all orders; regular users see their own orders.
     */
    public function getUserOrders(
        int $userId,
        ?string $search = null,
        int $perPage = 10,
        bool $isAdmin = false
    ): LengthAwarePaginator {
        return Order::query()
            ->when(!$isAdmin, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when(
                $search !== null && trim($search) !== '',
                function ($query) use ($search) {
                    $term = trim($search);

                    $query->where(function ($q) use ($term) {
                        $q->where('status', 'like', "%{$term}%")
                            ->orWhere('id', 'like', "%{$term}%")
                            ->orWhereHas('orderItems.item', function ($itemQuery) use ($term) {
                                $itemQuery->where('name', 'like', "%{$term}%");
                            })
                            ->orWhereHas('user', function ($userQuery) use ($term) {
                                $userQuery->where('name', 'like', "%{$term}%");
                            });
                    });
                }
            )
            ->with(['orderItems.item', 'user'])
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
    /**
     * Find an order and check access permission.
     */
    public function getOrderById(
        int $orderId,
        int $userId,
        bool $isAdmin = false
    ): Order {
        $order = Order::with('orderItems.item', 'user')
            ->findOrFail($orderId);

        if (!$isAdmin && (int) $order->user_id !== $userId) {
            abort(403, 'You cannot access this order.');
        }

        return $order;
    }

    
    /**
     * Create a new order and notify all Admin users.
     */
    public function createOrder(int $userId, array $data): Order
    {
        /* Create order and order items inside a transaction */
        $order = DB::transaction(function () use ($userId, $data) {

            $order = Order::create([
                'user_id' => $userId,
                'status' => 'pending',
                'total_amount' => 0,
            ]);

            /* Keep the existing item and stock management logic */
            $this->replaceItems(
                $order,
                $data['items'] ?? []
            );

            return Order::with('orderItems.item', 'user')
                ->findOrFail($order->id);
        });

        /* Notify all Admin users after the transaction succeeds */
        $admins = User::where('role', 'admin')->get();

        if ($admins->isNotEmpty()) {
            Notification::send(
                $admins,
                new NewOrderNotification([
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'user_name' => $order->user->name,
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                ])
            );
        }

        return $order;
    }

    /**
     * Update an existing order and send notifications when its status changes.
     */
    public function updateOrder(
        int $orderId,
        int $userId,
        array $data,
        bool $isAdmin = false
    ): Order {

        /* Update the order inside a database transaction */
        $result = DB::transaction(function () use (
            $orderId,
            $userId,
            $data,
            $isAdmin
        ) {

            $order = Order::query()
                ->lockForUpdate()
                ->findOrFail($orderId);

            /* Check order ownership */
            if (
                !$isAdmin &&
                (int) $order->user_id !== $userId
            ) {
                abort(403, 'You cannot access this order.');
            }

            /* Store the previous status */
            $previousStatus = strtolower($order->status);

            /* Keep the existing completed/cancelled restriction */
            if (in_array($previousStatus, ['completed', 'cancelled'], true)) {
                throw ValidationException::withMessages([
                    'order' => 'Completed or cancelled orders cannot be edited.',
                ]);
            }

            /* Get the new status */
            $newStatus = strtolower($data['status'] ?? $previousStatus);

            /* Restore stock when the order is cancelled */
            if ($newStatus === 'cancelled') {

                $this->restoreOrderStock($order);

                $order->status = 'cancelled';
                $order->save();

            } else {

                /* Update order items when provided */
                if (array_key_exists('items', $data)) {
                    $this->replaceItems(
                        $order,
                        $data['items'] ?? []
                    );
                }

                /* Update status when provided */
                if (isset($data['status'])) {
                    $order->status = $newStatus;
                    $order->save();
                }
            }

            /* Get the updated order */
            $updatedOrder = Order::with('orderItems.item', 'user')
                ->findOrFail($order->id);

            /* Return order and status information */
            return [
                'order' => $updatedOrder,
                'previous_status' => $previousStatus,
                'new_status' => strtolower($updatedOrder->status),
            ];
        });

        /* Get transaction result */
        $order = $result['order'];
        $previousStatus = $result['previous_status'];
        $newStatus = $result['new_status'];

        /* Send notification only when status actually changes */
        if ($previousStatus !== $newStatus) {

            /* Normal user cancels an order: notify all Admins */
            if (!$isAdmin && $newStatus === 'cancelled') {

                $admins = User::where('role', 'admin')->get();

                if ($admins->isNotEmpty()) {
                    Notification::send(
                        $admins,
                        new OrderCancelledNotification([
                            'order_id' => $order->id,
                            'user_id' => $order->user_id,
                            'user_name' => $order->user->name,
                            'previous_status' => $previousStatus,
                            'total_amount' => $order->total_amount,
                        ])
                    );
                }

            } elseif ($isAdmin) {

                /* Admin changes status: notify the order owner */
                $order->user->notify(
                    new OrderStatusChangedNotification([
                        'order_id' => $order->id,
                        'previous_status' => $previousStatus,
                        'new_status' => $newStatus,
                        'total_amount' => $order->total_amount,
                    ])
                );
            }
        }

        return $order;
    }

    /**
     * Delete an order and restore stock when appropriate.
     */
 
    public function deleteOrder(
        int $orderId,
        int $userId,
        bool $isAdmin = false
    ): void {
        DB::transaction(function () use (
            $orderId,
            $userId,
            $isAdmin
        ) {
            $order = Order::query()
                ->with('orderItems')
                ->lockForUpdate()
                ->findOrFail($orderId);

            if (
                !$isAdmin &&
                (int) $order->user_id !== $userId
            ) {
                abort(403, 'You cannot delete this order.');
            }

            $status = strtolower($order->status);

            // Only cancelled and completed orders can be deleted.
            if (!in_array(
                $status,
                ['cancelled', 'completed'],
                true
            )) {
                throw ValidationException::withMessages([
                    'order' => 'Only cancelled and completed orders can be deleted.',
                ]);
            }

            // Delete the order.
            $order->delete();
        });
    }

    /**
     * Restore stock when an order is cancelled.
     */
    private function restoreOrderStock(Order $order): void
    {
        $orderLines = $order->orderItems()
            ->lockForUpdate()
            ->get();

        foreach ($orderLines as $line) {
            $item = Item::query()
                ->lockForUpdate()
                ->findOrFail($line->item_id);

            $item->increment(
                'stock',
                (int) $line->quantity
            );
        }
    }

    /**
     * Replace all items in an order.
     *
     * Expected form structure:
     * items[ITEM_ID][selected] = 1
     * items[ITEM_ID][quantity] = 2
     */
    private function replaceItems(
        Order $order,
        array $rows
    ): void {
        $quantities = [];

        foreach ($rows as $itemId => $row) {
            if (!is_array($row)) {
                continue;
            }

            if (empty($row['selected'])) {
                continue;
            }

            $validatedItemId = filter_var(
                $itemId,
                FILTER_VALIDATE_INT
            );

            $quantity = filter_var(
                $row['quantity'] ?? null,
                FILTER_VALIDATE_INT
            );

            if (
                $validatedItemId === false ||
                $validatedItemId === null ||
                $validatedItemId < 1
            ) {
                throw ValidationException::withMessages([
                    'items' => 'Please select a valid food item.',
                ]);
            }

            if (
                $quantity === false ||
                $quantity === null ||
                $quantity < 1
            ) {
                throw ValidationException::withMessages([
                    'items' => 'Each selected item must have a quantity of at least 1.',
                ]);
            }

            if (isset($quantities[$validatedItemId])) {
                throw ValidationException::withMessages([
                    'items' => 'An item cannot be selected more than once.',
                ]);
            }

            $quantities[$validatedItemId] = $quantity;
        }

        if (empty($quantities)) {
            throw ValidationException::withMessages([
                'items' => 'Please select at least one food item.',
            ]);
        }

        // Lock existing order lines.
        $oldLines = $order->orderItems()
            ->lockForUpdate()
            ->get();

        // Restore the stock used by the previous order lines.
        foreach ($oldLines as $line) {
            $item = Item::query()
                ->lockForUpdate()
                ->findOrFail($line->item_id);

            $item->increment(
                'stock',
                (int) $line->quantity
            );
        }

        $order->orderItems()->delete();

        $total = 0;

        foreach ($quantities as $itemId => $quantity) {
            $item = Item::query()
                ->lockForUpdate()
                ->findOrFail($itemId);

            if ($item->stock < $quantity) {
                throw ValidationException::withMessages([
                    'items' => "Insufficient stock for {$item->name}.",
                ]);
            }

            $unitPrice = (float) $item->price;

            $order->orderItems()->create([
                'item_id' => $item->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
            ]);

            $item->decrement('stock', $quantity);

            $total += $unitPrice * $quantity;
        }

        $order->total_amount = round($total, 2);
        $order->save();
    }
    /* Get Admin Dashboard Data */
    public function getAdminDashboardData(): array
    {
        /* Count all orders from all users */
        $totalOrders = Order::count();

        /* Get the latest 5 orders with user information */
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        /* Group orders by status and count each status */
        $statusOverview = Order::selectRaw(
            'status, COUNT(*) as total'
        )
            ->groupBy('status')
            ->pluck('total', 'status');

        /* Return all dashboard data */
        return [
            'totalOrders' => $totalOrders,
            'recentOrders' => $recentOrders,
            'statusOverview' => $statusOverview,
        ];
    }
}
