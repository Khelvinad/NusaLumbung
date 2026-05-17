<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderReceived extends Notification
{
    use Queueable;

    public function __construct(
        public readonly Order $order,
    ) {}

    /**
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Pesanan Baru',
            'message' => "Pesanan #{$this->order->id} dari {$this->order->pembeli->name} senilai Rp " . number_format((float) $this->order->total_amount, 0, ',', '.'),
            'order_id' => $this->order->id,
            'type' => 'order_received',
        ];
    }
}
