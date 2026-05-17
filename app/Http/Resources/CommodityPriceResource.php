<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommodityPriceResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'unit' => $this->unit,
            'price' => $this->price,
            'price_formatted' => 'Rp '.number_format((float) $this->price, 2, ',', '.'),
            'source' => $this->source,
            'price_date' => $this->price_date->toDateString(),
            'updated_at' => $this->updated_at,
        ];
    }
}
