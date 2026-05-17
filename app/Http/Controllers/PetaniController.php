<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PetaniController extends Controller
{

    public function dashboard()
    {
        $user = Auth::user();

        $totalProduk = Product::where('user_id', $user->id)->count();
        $totalOrder  = Order::where('petani_id', $user->id)->count();
        $orderBaru   = Order::where('petani_id', $user->id)->where('status', 'pending')->count();
        $totalPendapatan = Order::where('petani_id', $user->id)
            ->whereIn('status', ['confirmed', 'shipped', 'done'])
            ->sum('total_amount');

        $orderTerbaru = Order::where('petani_id', $user->id)
            ->with('pembeli')
            ->latest()
            ->take(5)
            ->get();

        return view('petani.dashboard', compact(
            'totalProduk', 'totalOrder', 'orderBaru', 'totalPendapatan', 'orderTerbaru'
        ));
    }

    public function produkIndex()
    {
        $produk = Product::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('petani.produk.index', compact('produk'));
    }

    public function produkCreate()
    {
        $kategoris = Product::CATEGORIES;
        return view('petani.produk.create', compact('kategoris'));
    }

    public function produkStore(Request $request)
    {
        $request->merge([
            'name' => strip_tags($request->name ?? ''),
            'description' => strip_tags($request->description ?? ''),
        ]);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'required|in:' . implode(',', Product::CATEGORIES),
            'photo'       => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('products', 'public');
        }

        unset($validated['photo']);
        Product::create($validated);

        return redirect()->route('petani.produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function produkEdit(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);
        $kategoris = Product::CATEGORIES;
        return view('petani.produk.edit', compact('product', 'kategoris'));
    }

    public function produkUpdate(Request $request, Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);

        $request->merge([
            'name' => strip_tags($request->name ?? ''),
            'description' => strip_tags($request->description ?? ''),
        ]);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'required|in:' . implode(',', Product::CATEGORIES),
            'photo'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $product->deletePhoto();
            $validated['photo_path'] = $request->file('photo')->store('products', 'public');
        }

        unset($validated['photo']);
        $product->update($validated);

        return redirect()->route('petani.produk.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    public function produkDestroy(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);
        $product->deletePhoto();
        $product->delete();

        return redirect()->route('petani.produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}