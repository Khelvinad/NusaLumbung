@extends('layouts.app')

@section('title', isset($product) ? 'Edit Produk - Nusa Lumbung' : 'Tambah Produk - Nusa Lumbung')

@section('content')

<section class="bg-[#2D5A27] py-10">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-2xl font-extrabold text-white mb-1">
            {{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}
        </h1>
        <p class="text-white/70 text-sm">
            {{ isset($product) ? 'Perbarui informasi produk Anda.' : 'Isi detail produk yang ingin dijual.' }}
        </p>
    </div>
</section>

<section class="max-w-3xl mx-auto px-6 py-8">
    <form action="{{ isset($product) ? route('petani.produk.update', $product) : route('petani.produk.store') }}"
        method="POST" enctype="multipart/form-data"
        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        {{-- Nama Produk --}}
        <div>
            <label class="block text-sm font-semibold text-[#1A1C19] mb-1">Nama Produk</label>
            <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required
                placeholder="Contoh: Beras Organik Premium"
                class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition">
            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Kategori --}}
        <div>
            <label class="block text-sm font-semibold text-[#1A1C19] mb-1">Kategori</label>
            <select name="category" required
                class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition">
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $cat)
                    <option value="{{ $cat }}" {{ old('category', $product->category ?? '') === $cat ? 'selected' : '' }}>
                        {{ ucfirst($cat) }}
                    </option>
                @endforeach
            </select>
            @error('category') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Harga & Stok --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-[#1A1C19] mb-1">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" required min="0"
                    placeholder="14500"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition">
                @error('price') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-[#1A1C19] mb-1">Stok (kg)</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock ?? '') }}" required min="0"
                    placeholder="100"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition">
                @error('stock') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-semibold text-[#1A1C19] mb-1">Deskripsi</label>
            <textarea name="description" rows="4" placeholder="Ceritakan keunggulan produk Anda..."
                class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Foto Produk --}}
        <div x-data="{ preview: '{{ isset($product) && $product->photo_path ? asset('storage/' . $product->photo_path) : '' }}' }">
            <label class="block text-sm font-semibold text-[#1A1C19] mb-1">Foto Produk</label>
            <input type="file" name="photo" accept="image/jpeg,image/png" @change="preview = URL.createObjectURL($event.target.files[0])"
                class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#2D5A27]/10 file:text-[#2D5A27]">
            <p class="text-xs text-[#1A1C19]/50 mt-1">Maks 2MB. Format: JPG, PNG.</p>
            @error('photo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror

            {{-- Preview --}}
            <div x-show="preview" class="mt-3">
                <img :src="preview" class="h-40 w-40 object-cover rounded-xl border border-gray-200">
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="bg-[#2D5A27] text-white font-semibold px-6 py-3 rounded-lg hover:bg-[#7FB069] transition">
                {{ isset($product) ? 'Simpan Perubahan' : 'Tambah Produk' }}
            </button>
            <a href="{{ route('petani.produk.index') }}"
                class="border-2 border-gray-200 text-[#1A1C19]/70 font-semibold px-6 py-3 rounded-lg hover:border-[#2D5A27] hover:text-[#2D5A27] transition">
                Batal
            </a>
        </div>
    </form>
</section>

@endsection
