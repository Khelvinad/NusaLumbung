<?php

namespace Database\Factories;

use App\Enums\HarvestPoolStatus;
use App\Models\HarvestPool;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HarvestPool>
 */
class HarvestPoolFactory extends Factory
{
    protected $model = HarvestPool::class;

    public function definition(): array
    {
        return [
            'name' => 'Pool ' . fake()->words(2, true),
            'commodity' => fake()->randomElement(['Beras', 'Jagung', 'Kedelai', 'Kopi']),
            'unit' => 'kg',
            'target_qty' => 100,
            'current_qty' => 0,
            'status' => HarvestPoolStatus::Open,
            'deadline' => now()->addDays(7),
            'created_by' => User::factory(),
        ];
    }

    public function fulfilled(): static
    {
        return $this->state([
            'status' => HarvestPoolStatus::Fulfilled,
            'current_qty' => 100,
        ]);
    }

    public function expired(): static
    {
        return $this->state([
            'deadline' => now()->subDay(),
        ]);
    }
}
