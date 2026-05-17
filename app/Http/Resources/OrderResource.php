<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status->value,
            'total_amount' => $this->total_amount,
            'pembeli' => $this->whenLoaded('pembeli', fn () => [
                'id' => $this->pembeli->id,
                'name' => $this->pembeli->name,
            ]),
            'petani' => $this->whenLoaded('petani', fn () => [
                'id' => $this->petani->id,
                'name' => $this->petani->name,
            ]),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
