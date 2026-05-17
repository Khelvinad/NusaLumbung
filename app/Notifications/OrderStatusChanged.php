<?php

namespace App\Notifications;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        public readonly Order $order,
        public readonly OrderStatus $newStatus,
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
        $statusLabels = [
            'confirmed' => 'dikonfirmasi',
            'shipped' => 'dikirim',
            'done' => 'selesai',
            'cancelled' => 'dibatalkan',
        ];

        $label = $statusLabels[$this->newStatus->value] ?? $this->newStatus->value;

        return [
            'title' => 'Status Pesanan Berubah',
            'message' => "Pesanan #{$this->order->id} telah {$label}.",
            'order_id' => $this->order->id,
            'status' => $this->newStatus->value,
            'type' => 'order_status_changed',
        ];
    }
}
