<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /* Display logged-in user's notifications */
    public function index(Request $request)
    {
        $user = $request->user();

        $notifications = $user->notifications()
            ->latest()
            ->paginate(10);

        $unreadCount = $user->unreadNotifications()->count();

        return view('notifications.index', compact(
            'notifications',
            'unreadCount'
        ));
    }

    /* Mark one notification as read */
    public function markAsRead(Request $request, string $id)
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        $orderId = $notification->data['order_id'] ?? null;

        if ($orderId) {
            return redirect()->route('orders.show', $orderId);
        }

        return redirect()->route('notifications.index');
    }

    /* Mark all notifications as read */
    public function markAllAsRead(Request $request)
    {
        $request->user()
            ->unreadNotifications()
            ->update([
                'read_at' => now(),
            ]);

        return redirect()
            ->route('notifications.index')
            ->with('success', 'All notifications marked as read.');
    }
}