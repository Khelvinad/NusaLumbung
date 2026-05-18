<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Order $order): bool
    {
        return $user->id === $order->pembeli_id 
            && $order->status->value === 'done' 
            && $order->reviews()->where('pembeli_id', $user->id)->doesntExist();
    }
}
