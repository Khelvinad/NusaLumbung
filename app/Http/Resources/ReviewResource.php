<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'pembeli' => [
                'id' => $this->pembeli_id,
                'name' => $this->whenLoaded('pembeli', fn () => $this->pembeli->name),
            ],
            'petani' => [
                'id' => $this->petani_id,
                'name' => $this->whenLoaded('petani', fn () => $this->petani->name),
            ],
            'product' => [
                'id' => $this->product_id,
                'name' => $this->whenLoaded('product', fn () => $this->product->name),
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
