<?php

namespace App\Providers;

use App\Models\HarvestPool;
use App\Models\Order;
use App\Models\Product;
use App\Policies\HarvestPoolPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
        Order::class => OrderPolicy::class,
        HarvestPool::class => HarvestPoolPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
