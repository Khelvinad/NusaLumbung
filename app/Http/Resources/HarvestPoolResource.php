<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HarvestPoolResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'commodity' => $this->commodity,
            'unit' => $this->unit,
            'target_qty' => $this->target_qty,
            'current_qty' => $this->current_qty,
            'progress_percent' => $this->target_qty > 0
                ? round(($this->current_qty / $this->target_qty) * 100, 2)
                : 0,
            'status' => $this->status->value,
            'deadline' => $this->deadline->toDateString(),
            'creator' => $this->whenLoaded('creator', fn () => [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
            ]),
            'members' => HarvestPoolMemberResource::collection($this->whenLoaded('members')),
            'members_count' => $this->whenCounted('members'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
