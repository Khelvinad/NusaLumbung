<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product_name_snapshot' => $this->product_name_snapshot,
            'quantity' => $this->quantity,
            'price_snapshot' => $this->price_snapshot,
            'subtotal' => $this->price_snapshot * $this->quantity,
            'product' => $this->whenLoaded('product', fn () => new ProductResource($this->product)),
        ];
    }
}
