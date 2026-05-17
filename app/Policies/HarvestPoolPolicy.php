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

    public function view(?User $user, HarvestPool $pool): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('petani');
    }

    public function join(User $user, HarvestPool $pool): bool
    {
        return $user->hasRole('petani') && $pool->isJoinable();
    }
}
