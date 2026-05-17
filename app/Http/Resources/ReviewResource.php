<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'pembeli' => $this->whenLoaded('pembeli', fn () => [
                'id' => $this->pembeli->id,
                'name' => $this->pembeli->name,
            ]),
            'petani' => $this->whenLoaded('petani', fn () => [
                'id' => $this->petani->id,
                'name' => $this->petani->name,
            ]),
            'product' => $this->whenLoaded('product', fn () => [
                'id' => $this->product->id,
                'name' => $this->product->name,
            ]),
            'created_at' => $this->created_at,
        ];
    }
}
