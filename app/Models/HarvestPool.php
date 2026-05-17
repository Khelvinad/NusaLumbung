<?php

namespace App\Models;

use App\Enums\HarvestPoolStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HarvestPool extends Model
{
    protected $fillable = [
        'name',
        'commodity',
        'unit',
        'target_qty',
        'current_qty',
        'status',
        'deadline',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'target_qty' => 'decimal:2',
            'current_qty' => 'decimal:2',
            'status' => HarvestPoolStatus::class,
            'deadline' => 'date',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members(): HasMany
    {
        return $this->hasMany(HarvestPoolMember::class);
    }

    public function isJoinable(): bool
    {
        return $this->status === HarvestPoolStatus::Open
            && $this->deadline->isFuture();
    }
}
