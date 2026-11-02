<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $userId = $user->id;

        /* Items - All Users */

        // Count all items created by all users
        $totalItems = Item::count();

        // Count all low-stock items from all users
        $lowStockCount = Item::where('stock', '<=', 5)->count();

        // Get only 5 low-stock items for display
        $lowStockItems = Item::where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();


        /* Orders - Admin and Normal User */

        // Check whether the logged-in user is admin
        $isAdmin = $user->role === 'admin';

        // Admin can see all orders, normal user can see only own orders
        $ordersQuery = Order::query()
            ->when(!$isAdmin, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            });

        // Count total orders
        $totalOrders = (clone $ordersQuery)->count();

        // Count orders by status
        $statusCounts = (clone $ordersQuery)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Get each order status count
        $pendingOrders = $statusCounts->get('pending', 0);
        $processingOrders = $statusCounts->get('processing', 0);
        $completedOrders = $statusCounts->get('completed', 0);
        $cancelledOrders = $statusCounts->get('cancelled', 0);

        // Data for Order Status Overview
        $orderStatus = [
            'pending' => $pendingOrders,
            'processing' => $processingOrders,
            'completed' => $completedOrders,
            'cancelled' => $cancelledOrders,
        ];

        // Get latest 5 orders
        $recentOrders = (clone $ordersQuery)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();


        /* Return Dashboard Data */

        return view('dashboard', compact(
            'totalItems',
            'lowStockCount',
            'lowStockItems',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            'orderStatus',
            'recentOrders',
            'isAdmin'
        ));
    }
}