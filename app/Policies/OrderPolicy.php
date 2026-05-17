<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Order $order): bool
    {
        return $this->isPembeli($user, $order) || $this->isRelatedPetani($user, $order);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('pembeli');
    }

    public function update(User $user, Order $order): bool
    {
        return $this->isPembeli($user, $order);
    }

    public function delete(User $user, Order $order): bool
    {
        return $this->isPembeli($user, $order);
    }

    public function confirm(User $user, Order $order): bool
    {
        return $this->isRelatedPetani($user, $order);
    }

    public function restore(User $user, Order $order): bool
    {
        return false;
    }

    public function forceDelete(User $user, Order $order): bool
    {
        return false;
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
