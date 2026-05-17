<?php

namespace App\Policies;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('pembeli') || $user->hasRole('petani');
    }

    public function view(User $user, Order $order): bool
    {
        return $this->isPembeli($user, $order) || $this->isRelatedPetani($user, $order);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('pembeli');
    }

    public function confirm(User $user, Order $order): bool
    {
        return $this->isRelatedPetani($user, $order)
            && $order->status === OrderStatus::Pending;
    }

    public function updateStatus(User $user, Order $order, OrderStatus $status): bool
    {
        return match ($status) {
            OrderStatus::Shipped => $this->isRelatedPetani($user, $order)
                && $order->status === OrderStatus::Confirmed,
            OrderStatus::Done => $this->isPembeli($user, $order)
                && $order->status === OrderStatus::Shipped,
            OrderStatus::Cancelled => ($this->isPembeli($user, $order) && $order->status === OrderStatus::Pending)
                || ($this->isRelatedPetani($user, $order) && $order->status === OrderStatus::Confirmed),
            default => false,
        };
    }

    protected function isPembeli(User $user, Order $order): bool
    {
        return (int) $user->id === (int) $order->pembeli_id;
    }

    protected function isRelatedPetani(User $user, Order $order): bool
    {
        return $user->hasRole('petani')
            && (int) $user->id === (int) $order->petani_id;
    }
}
