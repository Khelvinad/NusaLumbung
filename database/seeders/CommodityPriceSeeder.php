<?php

namespace Database\Seeders;

use App\Models\Commodity;
use Illuminate\Database\Seeder;

class CommodityPriceSeeder extends Seeder
{
    /**
     * Harga referensi per kg (IDR) — estimasi Pasar Induk Kramat Jati & BPS, Mei 2026.
     * Update manual oleh admin via Filament bila diperlukan.
     */
    public function run(): void
    {
        $today = now()->toDateString();

        $commodities = [
            [
                'name' => 'Cabai Merah',
                'slug' => 'cabai-merah',
                'unit' => 'kg',
                'price' => 45000,
                'source' => 'Pasar Induk Kramat Jati (referensi BPS)',
            ],
            [
                'name' => 'Bawang Merah',
                'slug' => 'bawang-merah',
                'unit' => 'kg',
                'price' => 32000,
                'source' => 'Pasar Induk Kramat Jati (referensi BPS)',
            ],
            [
                'name' => 'Tomat',
                'slug' => 'tomat',
                'unit' => 'kg',
                'price' => 11500,
                'source' => 'Pasar Induk Kramat Jati (referensi BPS)',
            ],
            [
                'name' => 'Jagung',
                'slug' => 'jagung',
                'unit' => 'kg',
                'price' => 6800,
                'source' => 'Pasar Induk Kramat Jati (referensi BPS)',
            ],
            [
                'name' => 'Padi',
                'slug' => 'padi',
                'unit' => 'kg',
                'price' => 13500,
                'source' => 'BPS — Beras Medium (setara gabah kering)',
            ],
        ];

        foreach ($commodities as $data) {
            Commodity::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    ...$data,
                    'price_date' => $today,
                    'is_active' => true,
                ],
            );
        }
    }
}
