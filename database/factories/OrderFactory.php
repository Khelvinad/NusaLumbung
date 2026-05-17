<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'pembeli_id' => User::factory(),
            'petani_id' => User::factory(),
            'status' => OrderStatus::Pending,
            'total_amount' => fake()->randomFloat(2, 10000, 500000),
        ];
    }

    public function confirmed(): static
    {
        return $this->state(['status' => OrderStatus::Confirmed]);
    }

    public function shipped(): static
    {
        return $this->state(['status' => OrderStatus::Shipped]);
    }

    public function done(): static
    {
        return $this->state(['status' => OrderStatus::Done]);
    }

    public function cancelled(): static
    {
        return $this->state(['status' => OrderStatus::Cancelled]);
    }
}
