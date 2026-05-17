<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Commodity extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'unit',
        'price',
        'source',
        'price_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'price_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Commodity $commodity): void {
            if (empty($commodity->slug)) {
                $commodity->slug = Str::slug($commodity->name);
            }
        });
    }
}
