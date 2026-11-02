<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification
{
    use Queueable;

    /*
     * Receive order status information.
     */
    public function __construct(private array $orderData)
    {
    }

    /*
     * Use database notification.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /*
     * Save order status information into database.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'order_status_changed',
            'title' => 'Order Status Updated',

            'message' => 'Your order #'
                . $this->orderData['order_id']
                . ' status has changed from '
                . ucfirst($this->orderData['previous_status'])
                . ' to '
                . ucfirst($this->orderData['new_status']) . '.',

            'order_id' => $this->orderData['order_id'],
            'previous_status' => $this->orderData['previous_status'],
            'new_status' => $this->orderData['new_status'],
            'total_amount' => $this->orderData['total_amount'],

            'updated_at' => now()->toDateTimeString(),
        ];
    }
}
