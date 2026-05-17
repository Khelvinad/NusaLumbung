<?php

namespace App\Services;

use App\Models\Commodity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class CommodityPriceService
{
    /**
     * @return Collection<int, Commodity>
     */
    public function listActive(): Collection
    {
        return Commodity::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function findBySlug(string $slug): ?Commodity
    {
        return Commodity::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }

    public function updatePrice(Commodity $commodity, float $price, ?Carbon $priceDate = null): Commodity
    {
        $commodity->update([
            'price' => $price,
            'price_date' => $priceDate ?? now(),
        ]);

        return $commodity->fresh();
    }
}
