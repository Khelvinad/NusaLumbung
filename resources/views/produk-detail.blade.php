@extends('layouts.app')

@section('title', $product->name . ' - Nusa Lumbung')

@section('content')

{{-- Breadcrumb --}}
<section class="max-w-7xl mx-auto px-6 pt-8 pb-4">
    <div class="flex items-center gap-2 text-sm text-[#1A1C19]/50">
        <a href="{{ route('produk.index') }}" class="hover:text-[#2D5A27] transition">Marketplace</a>
        <span>/</span>
        <a href="{{ route('produk.index', ['kategori' => $product->category]) }}" class="hover:text-[#2D5A27] transition capitalize">{{ $product->category }}</a>
        <span>/</span>
        <span class="text-[#1A1C19]">{{ $product->name }}</span>
    </div>
</section>

{{-- Detail Produk --}}
<section class="max-w-7xl mx-auto px-6 pb-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        {{-- Foto Produk --}}
        <div class="rounded-2xl overflow-hidden bg-white border border-gray-100 aspect-square">
            @if($product->photo_path)
                <img src="{{ asset('storage/' . $product->photo_path) }}"
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gray-50">
                    <span class="text-6xl">🌾</span>
                </div>
            @endif
        </div>

        {{-- Info Produk --}}
        <div class="flex flex-col justify-between">
            <div>
                <span class="inline-block bg-[#2D5A27]/10 text-[#2D5A27] text-xs font-semibold px-3 py-1 rounded-full mb-3 capitalize">
                    {{ $product->category }}
                </span>
                <h1 class="text-3xl font-extrabold text-[#1A1C19] mb-2">{{ $product->name }}</h1>

                {{-- Rating & Stok --}}
                <div class="flex items-center gap-3 mb-4">
                    @if($product->user->petaniProfile)
                        <div class="flex items-center gap-1">
                            <span class="text-[#F2A65A]">★</span>
                            <span class="text-sm font-semibold">{{ number_format($product->user->petaniProfile->rating_avg, 1) }}</span>
                        </div>
                        <span class="text-gray-300">|</span>
                    @endif
                    <span class="text-sm {{ $product->stock > 0 ? 'text-[#7FB069]' : 'text-[#D32F2F]' }} font-semibold">
                        {{ $product->stock > 0 ? 'Stok Tersedia · ' . $product->stock . ' kg' : 'Stok Habis' }}
                    </span>
                </div>

                {{-- Harga --}}
                <div class="bg-[#F9FBF9] border border-gray-100 rounded-2xl p-5 mb-6">
                    <p class="text-sm text-[#1A1C19]/50 mb-1">Harga per satuan</p>
                    <p class="text-4xl font-bold font-mono text-[#F2A65A]">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>

                {{-- Deskripsi --}}
                @if($product->description)
                <div class="mb-6">
                    <h3 class="font-bold text-[#1A1C19] mb-2">Deskripsi Produk</h3>
                    <p class="text-sm text-[#1A1C19]/70 leading-relaxed">{{ $product->description }}</p>
                </div>
                @endif

                {{-- Quantity + Keranjang --}}
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                        <button onclick="changeQty(-1)" class="px-4 py-3 text-[#1A1C19] hover:bg-gray-100 transition font-bold">−</button>
                        <span id="qty-display" class="px-5 py-3 text-sm font-semibold border-x-2 border-gray-200">1</span>
                        <button onclick="changeQty(1)" class="px-4 py-3 text-[#1A1C19] hover:bg-gray-100 transition font-bold">+</button>
                    </div>
                    <button onclick="tambahKeKeranjang({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})"
                        class="flex-1 bg-[#2D5A27] text-white font-semibold py-3 rounded-xl hover:bg-[#7FB069] transition text-sm">
                        + Tambah ke Keranjang
                    </button>
                </div>

            </div>

            {{-- Info Petani --}}
            @if($product->user)
            <a href="{{ route('petani.show', $product->user) }}"
                class="flex items-center gap-4 bg-white border border-gray-100 rounded-2xl p-4 hover:border-[#2D5A27] transition group">
                @if($product->user->photo_path)
                    <img src="{{ Storage::url($product->user->photo_path) }}" alt="{{ $product->user->name }}" class="w-12 h-12 rounded-full object-cover flex-shrink-0 border border-gray-200">
                @else
                    <div class="w-12 h-12 rounded-full bg-[#2D5A27]/10 flex items-center justify-center text-xl flex-shrink-0">
                        🧑‍🌾
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-[#1A1C19]/50 mb-0.5">Dijual oleh</p>
                    <p class="font-bold text-[#1A1C19] truncate">
                        {{ $product->user->petaniProfile->farm_name ?? $product->user->name }}
                    </p>
                    @if($product->user->petaniProfile)
                        <p class="text-xs text-[#1A1C19]/50 truncate">📍 {{ $product->user->petaniProfile->location }}</p>
                    @endif
                </div>
                <span class="text-[#2D5A27] text-sm font-semibold group-hover:translate-x-1 transition-transform">→</span>
            </a>
            @endif

        </div>
    </div>
</section>

{{-- Produk Lain dari Petani Ini --}}
@if($produkLain->count() > 0)
<section class="max-w-7xl mx-auto px-6 pb-12">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-[#1A1C19]">Produk Lain dari Petani Ini</h2>
        @if($product->user)
            <a href="{{ route('petani.show', $product->user) }}" class="text-sm text-[#2D5A27] font-semibold hover:underline">Lihat Semua →</a>
        @endif
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($produkLain as $item)
            <x-product-card
                :id="$item->id"
                :gambar="$item->photo_path ?? ''"
                :kategori="ucfirst($item->category)"
                :nama="$item->name"
                :asal="$item->user->petaniProfile->farm_name ?? $item->user->name ?? 'Petani Nusa Lumbung'"
                :harga="(int) $item->price"
                satuan="kg"
                :stok="$item->stock > 0 ? 'Tersedia' : 'Habis'"
                :dataKategori="$item->category"
            />
        @endforeach
    </div>
</section>
@endif

{{-- Produk Serupa --}}
@if($produkSerupa->count() > 0)
<section class="max-w-7xl mx-auto px-6 pb-16">
    <h2 class="text-xl font-bold text-[#1A1C19] mb-5">Produk Serupa</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($produkSerupa as $item)
            <x-product-card
                :id="$item->id"
                :gambar="$item->photo_path ?? ''"
                :kategori="ucfirst($item->category)"
                :nama="$item->name"
                :asal="$item->user->petaniProfile->farm_name ?? $item->user->name ?? 'Petani Nusa Lumbung'"
                :harga="(int) $item->price"
                satuan="kg"
                :stok="$item->stock > 0 ? 'Tersedia' : 'Habis'"
                :dataKategori="$item->category"
            />
        @endforeach
    </div>
</section>
@endif

<script>
    let qty = 1;
    const maxStok = {{ $product->stock }};

    function changeQty(delta) {
        qty = Math.max(1, qty + delta);
        if (qty > maxStok) {
            qty = maxStok;
            nusaAlert('Maksimal stok yang tersedia adalah ' + maxStok, 'warning');
        }
        document.getElementById('qty-display').textContent = qty;
    }

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
            nusaAlert('Silakan masuk atau daftar terlebih dahulu untuk berbelanja.', 'warning').then(() => {
                window.location.href = '{{ route("login") }}';
            });
            return;
        @else
            if (!id) return;
            const existing = keranjang.find(item => item.id === id);
            if (existing) {
                existing.qty += qty;
            } else {
                keranjang.push({ id, nama, harga, qty: qty });
            }
            localStorage.setItem('keranjang', JSON.stringify(keranjang));
            updateBadge();

            const notif = document.createElement('div');
            notif.className = 'fixed bottom-6 right-6 bg-[#2D5A27] text-white text-sm px-5 py-3 rounded-xl shadow-lg z-50 flex items-center gap-2';
            notif.innerHTML = `<span>✓</span><span>${qty}x ${nama} ditambahkan ke keranjang</span>`;
            document.body.appendChild(notif);
            setTimeout(() => notif.remove(), 2500);
        @endguest
    }

    updateBadge();
</script>

@endsection