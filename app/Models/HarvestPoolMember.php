<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HarvestPoolMember extends Model
{
    protected $fillable = [
        'harvest_pool_id',
        'user_id',
        'qty',
    ];

    protected function casts(): array
    {
        return [
            'qty' => 'decimal:2',
        ];
    }

    public function harvestPool(): BelongsTo
    {
        return $this->belongsTo(HarvestPool::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
