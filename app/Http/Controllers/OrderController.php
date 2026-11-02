<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Item;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();

        $userId = (int) $user->id;

        $isAdmin = $user->role === 'admin';

        $search = $request->input('search');

        $orders = $this->orderService->getUserOrders(
            $userId,
            $search,
            10,
            $isAdmin
        );

        $totalOrders = \App\Models\Order::query()
            ->when(!$isAdmin, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->count();

        return view('orders.index', compact(
            'orders',
            'totalOrders',
            'search'
        ));
    }

    public function create()
    {
        $items = Item::query()
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('orders.create', compact('items'));
    }

    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->createOrder(
            (int) $request->user()->id,
            $request->validated()
        );

        return redirect()
            ->route('orders.show', $order->id)
            ->with('success', 'Order created successfully.');
    }

    public function show(Request $request, string $id)
    {
        $order = $this->orderService->getOrderById(
            (int) $id,
            (int) $request->user()->id,
            $request->user()->role === 'admin'
        );

        $order->load('user', 'orderItems.item');

        return view('orders.show', compact('order'));
    }

    public function edit(Request $request, string $id)
    {
        $order = $this->orderService->getOrderById(
            (int) $id,
            (int) $request->user()->id,
            $request->user()->role === 'admin'
        );

        $order->load('user', 'orderItems.item');

        // Include available items and items already in this order,
        // even if their remaining stock is zero.
        $existingItemIds = $order->orderItems
            ->pluck('item_id')
            ->all();

        $items = Item::query()
            ->where(function ($query) use ($existingItemIds) {
                $query->where('stock', '>', 0);

                if (!empty($existingItemIds)) {
                    $query->orWhereIn('id', $existingItemIds);
                }
            })
            ->orderBy('name')
            ->get();

        return view('orders.edit', compact('order', 'items'));
    }

    public function update(
        UpdateOrderRequest $request,
        string $id
    ) {
        $order = $this->orderService->updateOrder(
            (int) $id,
            (int) $request->user()->id,
            $request->validated(),
            $request->user()->role === 'admin'
        );

        return redirect()
            ->route('orders.show', $order->id)
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(Request $request, string $id)
    {
        $this->orderService->deleteOrder(
            (int) $id,
            (int) $request->user()->id,
            $request->user()->role === 'admin'
        );

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}
