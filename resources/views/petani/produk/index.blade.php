@extends('layouts.app')

@section('title', 'Kelola Produk - Nusa Lumbung')

@section('content')

<section class="bg-[#2D5A27] py-10">
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white mb-1">Kelola Produk</h1>
            <p class="text-white/70 text-sm">Produk yang Anda jual di marketplace.</p>
        </div>
        <a href="{{ route('petani.produk.create') }}"
            class="bg-white text-[#2D5A27] text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-[#F2A65A] hover:text-white transition">
            + Tambah Produk
        </a>
    </div>
</section>

<section class="max-w-7xl mx-auto px-6 py-8">
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($produk->isEmpty())
        <div class="text-center py-20">
            <p class="text-5xl mb-4">📦</p>
            <h3 class="text-xl font-bold text-[#1A1C19] mb-2">Belum ada produk</h3>
            <p class="text-[#1A1C19]/50 text-sm mb-6">Mulai tambahkan produk pertama Anda.</p>
            <a href="{{ route('petani.produk.create') }}"
                class="bg-[#2D5A27] text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-[#7FB069] transition">
                + Tambah Produk
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($produk as $item)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="h-40 bg-gray-50">
                        @if($item->photo_path)
                            <img src="{{ asset('storage/' . $item->photo_path) }}" alt="{{ $item->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-4xl">🌾</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-[#1A1C19] mb-1">{{ $item->name }}</h3>
                        <p class="text-[#F2A65A] font-bold font-mono text-sm mb-1">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-[#1A1C19]/50 mb-3">
                            Stok: {{ $item->stock }} · {{ ucfirst($item->category) }}
                        </p>
                        <div class="flex gap-2">
                            <a href="{{ route('petani.produk.edit', $item) }}"
                                class="flex-1 text-center text-sm bg-[#2D5A27]/10 text-[#2D5A27] font-semibold py-2 rounded-lg hover:bg-[#2D5A27] hover:text-white transition">
                                Edit
                            </a>
                            <form action="{{ route('petani.produk.destroy', $item) }}" method="POST" class="flex-1"
                                onsubmit="return confirm('Yakin hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full text-sm bg-red-50 text-red-600 font-semibold py-2 rounded-lg hover:bg-red-600 hover:text-white transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($produk->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $produk->links() }}
            </div>
        @endif
    @endif
</section>

@endsection
