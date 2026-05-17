<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'in:semua,beras,sayur,buah,kopi,rempah'],
            'sort' => ['nullable', 'string', 'in:terbaru,termurah,termahal,stok'],
        ]);

        $query = Product::query()->with('user.petaniProfile');

        // Search — parameterized LIKE query, strip_tags untuk sanitasi XSS
        if ($request->filled('q')) {
            $search = str_replace(['%', '_'], ['\%', '\_'], strip_tags($request->string('q')));
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Filter kategori
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('category', $request->string('kategori'));
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

    public function show(Product $product)
    {
        $product->load('user.petaniProfile');

        $produkLain = Product::where('user_id', $product->user_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        $produkSerupa = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        return view('produk-detail', compact('product', 'produkLain', 'produkSerupa'));
    }

    public function petani(User $user)
    {
        $user->load('petaniProfile');

        $produk = Product::where('user_id', $user->id)
            ->latest()
            ->paginate(12);

        return view('petani-publik', compact('user', 'produk'));
    }
}