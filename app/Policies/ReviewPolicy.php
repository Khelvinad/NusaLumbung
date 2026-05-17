<?php

namespace App\Policies;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;

class ReviewPolicy
{
    /**
     * Pembeli can create a review if the order is done and they haven't reviewed yet.
     */
    public function create(User $user, Order $order): bool
    {
        return $user->hasRole('pembeli')
            && (int) $user->id === (int) $order->pembeli_id
            && $order->status === OrderStatus::Done
            && ! $order->reviews()->where('pembeli_id', $user->id)->exists();
    }
}
