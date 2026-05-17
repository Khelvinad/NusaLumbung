<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('user.petaniProfile');

        // Search
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // Filter kategori
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('category', $request->kategori);
        }

        // Sort
        match ($request->get('sort', 'terbaru')) {
            'termurah'  => $query->orderBy('price', 'asc'),
            'termahal'  => $query->orderBy('price', 'desc'),
            'stok'      => $query->orderBy('stock', 'desc'),
            default     => $query->latest(),
        };

        $produk = $query->paginate(12)->withQueryString();

        $kategoris = [
            'semua'  => 'Semua',
            'beras'  => '🌾 Beras',
            'sayur'  => '🥬 Sayuran',
            'buah'   => '🍎 Buah',
            'kopi'   => '☕ Kopi',
            'rempah' => '🌶️ Rempah',
        ];

        $ticker = [
            ['nama' => 'Beras Medium',    'harga' => 13500, 'naik' => true,  'perubahan' => '1.2'],
            ['nama' => 'Cabai Merah',     'harga' => 34000, 'naik' => false, 'perubahan' => '2.5'],
            ['nama' => 'Bawang Merah',    'harga' => 28000, 'naik' => true,  'perubahan' => '0.8'],
            ['nama' => 'Jagung Pipilan',  'harga' => 6500,  'naik' => true,  'perubahan' => '3.1'],
            ['nama' => 'Kedelai Lokal',   'harga' => 11000, 'naik' => false, 'perubahan' => '1.0'],
            ['nama' => 'Gula Pasir',      'harga' => 17500, 'naik' => false, 'perubahan' => '0.5'],
            ['nama' => 'Minyak Goreng',   'harga' => 19000, 'naik' => true,  'perubahan' => '0.3'],
            ['nama' => 'Kopi Arabika',    'harga' => 85000, 'naik' => true,  'perubahan' => '2.0'],
        ];

        return view('produk', compact('produk', 'kategoris', 'ticker'));
    }
}