@extends('layouts.app')

@section('title', 'Marketplace - Nusa Lumbung')

@section('content')

{{-- Commodity Ticker --}}
<x-commodity-ticker :komoditas="$ticker" />

{{-- Header Marketplace --}}
<section class="bg-[#2D5A27] py-12">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2">Marketplace</h1>
        <p class="text-white/70">Produk segar langsung dari tangan petani Indonesia.</p>

        {{-- Search Bar --}}
        <form method="GET" action="{{ route('produk.index') }}" class="mt-6 flex gap-2 max-w-xl">
            @if(request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif
            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari produk, petani, atau komoditas..."
                class="flex-1 px-4 py-3 rounded-xl text-sm text-[#1A1C19] placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#F2A65A]"
            >
            <button type="submit"
                class="bg-[#F2A65A] hover:bg-[#e09448] text-white px-5 py-3 rounded-xl font-semibold text-sm transition">
                Cari
            </button>
        </form>
    </div>
</section>

{{-- Filter & Sort --}}
<section class="max-w-7xl mx-auto px-6 py-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

        {{-- Filter Kategori --}}
        <div class="flex items-center gap-2 flex-wrap">
            @foreach($kategoris as $key => $label)
                <a href="{{ route('produk.index', array_merge(request()->except('kategori', 'page'), ['kategori' => $key])) }}"
                    class="px-4 py-2 rounded-full text-sm font-semibold border-2 transition
                        {{ request('kategori', 'semua') === $key
                            ? 'bg-[#2D5A27] border-[#2D5A27] text-white'
                            : 'border-gray-200 text-[#1A1C19]/60 hover:border-[#2D5A27] hover:text-[#2D5A27]' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Sort Dropdown --}}
        <form method="GET" action="{{ route('produk.index') }}" id="sort-form">
            @if(request('q'))
                <input type="hidden" name="q" value="{{ request('q') }}">
            @endif
            @if(request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif
            <select name="sort" onchange="document.getElementById('sort-form').submit()"
                class="text-sm border-2 border-gray-200 rounded-xl px-4 py-2 text-[#1A1C19] focus:outline-none focus:border-[#2D5A27] cursor-pointer">
                <option value="terbaru"  {{ request('sort', 'terbaru') === 'terbaru'  ? 'selected' : '' }}>Terbaru</option>
                <option value="termurah" {{ request('sort') === 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                <option value="termahal" {{ request('sort') === 'termahal' ? 'selected' : '' }}>Harga Termahal</option>
                <option value="stok"     {{ request('sort') === 'stok'     ? 'selected' : '' }}>Stok Terbanyak</option>
            </select>
        </form>

    </div>
</section>

{{-- Status Pooling Panen --}}
<section class="max-w-7xl mx-auto px-6 pb-8">
    <div class="bg-[#1A1C19] rounded-2xl p-6">
        <div class="flex items-center gap-2 mb-5">
            <span class="w-2 h-2 rounded-full bg-[#F2A65A] animate-pulse"></span>
            <h3 class="text-white font-bold">Status Pooling Panen</h3>
            <span class="text-xs text-white/40 ml-auto">Update real-time</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-pool-progress komoditas="Jagung Manis" :terkumpul="1800" :target="2000" satuan="kg" pembeli="UMKM Berkah Jaya" />
            <x-pool-progress komoditas="Cabai Rawit"  :terkumpul="300"  :target="500"  satuan="kg" pembeli="Restoran Padang Sejati" />
            <x-pool-progress komoditas="Beras Organik" :terkumpul="500" :target="2000" satuan="kg" pembeli="Koperasi Tani Makmur" />
        </div>
    </div>
</section>

{{-- Info hasil pencarian --}}
@if(request('q') || (request('kategori') && request('kategori') !== 'semua'))
<section class="max-w-7xl mx-auto px-6 pb-4">
    <p class="text-sm text-[#1A1C19]/50">
        Menampilkan <span class="font-semibold text-[#1A1C19]">{{ $produk->total() }}</span> produk
        @if(request('q')) untuk pencarian "<span class="font-semibold text-[#1A1C19]">{{ request('q') }}</span>"@endif
        @if(request('kategori') && request('kategori') !== 'semua') dalam kategori <span class="font-semibold text-[#1A1C19]">{{ $kategoris[request('kategori')] ?? '' }}</span>@endif
    </p>
</section>
@endif

{{-- Grid Produk --}}
<section class="max-w-7xl mx-auto px-6 pb-16">
    @if($produk->isEmpty())
        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <div class="text-6xl mb-4">🌾</div>
            <h3 class="text-xl font-bold text-[#1A1C19] mb-2">Produk tidak ditemukan</h3>
            <p class="text-[#1A1C19]/50 text-sm mb-6">Coba kata kunci lain atau ubah filter pencarian.</p>
            <a href="{{ route('produk.index') }}"
                class="bg-[#2D5A27] text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#7FB069] transition">
                Lihat Semua Produk
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach($produk as $item)
                <x-product-card
                    :id="$item->id"
                    :gambar="$item->photo_path ?? ''"
                    :kategori="ucfirst($item->category)"
                    :nama="$item->name"
                    :asal="($item->user->petaniProfile->farm_name ?? $item->user->name ?? 'Petani Nusa Lumbung') . ($item->user->petaniProfile->location ? ' · ' . $item->user->petaniProfile->location : '')"
                    :harga="(int) $item->price"
                    :satuan="'kg'"
                    :stok="$item->stock > 0 ? 'Tersedia' : 'Habis'"
                    :dataKategori="$item->category"
                />
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($produk->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $produk->links() }}
            </div>
        @endif
    @endif
</section>

<script>
    let keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];

    function updateBadge() {
        const badge = document.getElementById('cart-badge');
        if (!badge) return;
        const total = keranjang.reduce((sum, item) => sum + item.qty, 0);
        badge.textContent = total;
        badge.classList.toggle('hidden', total === 0);
    }

    function tambahKeKeranjang(id, nama, harga) {
        @guest
            alert('Silakan masuk atau daftar terlebih dahulu untuk berbelanja.');
            window.location.href = '{{ route("login") }}';
            return;
        @else
            if (!id) return;
            const existing = keranjang.find(item => item.id === id);
            if (existing) {
                existing.qty += 1;
            } else {
                keranjang.push({ id, nama, harga, qty: 1 });
            }
            localStorage.setItem('keranjang', JSON.stringify(keranjang));
            updateBadge();

            const notif = document.createElement('div');
            notif.className = 'fixed bottom-6 right-6 bg-[#2D5A27] text-white text-sm px-5 py-3 rounded-xl shadow-lg z-50 flex items-center gap-2';
            notif.innerHTML = `<span>✓</span><span>${nama} ditambahkan ke keranjang</span>`;
            document.body.appendChild(notif);
            setTimeout(() => notif.remove(), 2500);
        @endguest
    }

    updateBadge();
</script>

@endsection