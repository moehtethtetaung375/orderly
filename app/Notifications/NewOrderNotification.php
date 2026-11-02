<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    /*
     * Receive order information from OrderService.
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
     * Save notification data into the database.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'new_order',
            'title' => 'New Order Received',

            'message' => 'A new order #'
                . $this->orderData['order_id']
                . ' was created by '
                . $this->orderData['user_name'] . '.',

            'order_id' => $this->orderData['order_id'],
            'user_id' => $this->orderData['user_id'],
            'user_name' => $this->orderData['user_name'],
            'total_amount' => $this->orderData['total_amount'],
            'status' => $this->orderData['status'],

            'created_at' => now()->toDateTimeString(),
        ];
    }
}
