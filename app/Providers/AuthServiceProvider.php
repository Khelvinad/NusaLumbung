<?php

namespace App\Providers;

use App\Models\HarvestPool;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Policies\HarvestPoolPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ReviewPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Product::class => ProductPolicy::class,
        Order::class => OrderPolicy::class,
        HarvestPool::class => HarvestPoolPolicy::class,
        Review::class => ReviewPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}