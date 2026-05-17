<?php

namespace App\Policies;

use App\Models\HarvestPool;
use App\Models\User;

class HarvestPoolPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, HarvestPool $harvestPool): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('petani');
    }

    public function join(User $user, HarvestPool $harvestPool): bool
    {
        return $user->hasRole('petani') && $harvestPool->isJoinable();
    }

    public function update(User $user, HarvestPool $harvestPool): bool
    {
        return $this->isOwner($user, $harvestPool);
    }

    public function delete(User $user, HarvestPool $harvestPool): bool
    {
        return $this->isOwner($user, $harvestPool);
    }

    public function restore(User $user, HarvestPool $harvestPool): bool
    {
        return $this->isOwner($user, $harvestPool);
    }

    public function forceDelete(User $user, HarvestPool $harvestPool): bool
    {
        return $this->isOwner($user, $harvestPool);
    }

    protected function isOwner(User $user, HarvestPool $harvestPool): bool
    {
        return $user->hasRole('petani')
            && (int) $user->id === (int) $harvestPool->created_by;
    }
}
