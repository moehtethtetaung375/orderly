<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderCancelledNotification extends Notification
{
    use Queueable;

    /*
     * Receive cancelled order information.
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
     * Save cancelled order information into database.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'order_cancelled',
            'title' => 'Order Cancelled',

            'message' => $this->orderData['user_name']
                . ' cancelled order #'
                . $this->orderData['order_id'] . '.',

            'order_id' => $this->orderData['order_id'],
            'user_id' => $this->orderData['user_id'],
            'user_name' => $this->orderData['user_name'],
            'previous_status' => $this->orderData['previous_status'],
            'new_status' => 'cancelled',
            'total_amount' => $this->orderData['total_amount'],

            'cancelled_at' => now()->toDateTimeString(),
        ];
    }
}
