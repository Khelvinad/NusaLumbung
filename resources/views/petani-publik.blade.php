@extends('layouts.app')

@section('title', ($user->petaniProfile->farm_name ?? $user->name) . ' - Nusa Lumbung')

@section('content')

{{-- Header Profil Petani --}}
<section class="bg-[#2D5A27] py-14">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center md:items-start gap-6">

        {{-- Avatar --}}
        <div class="w-24 h-24 rounded-full bg-white/20 flex items-center justify-center text-5xl flex-shrink-0">
            🧑‍🌾
        </div>

        {{-- Info --}}
        <div class="text-center md:text-left">
            <h1 class="text-3xl font-extrabold text-white mb-1">
                {{ $user->petaniProfile->farm_name ?? $user->name }}
            </h1>
            @if($user->petaniProfile)
                <p class="text-white/70 text-sm mb-2">📍 {{ $user->petaniProfile->location }}</p>
                @if($user->petaniProfile->bio)
                    <p class="text-white/60 text-sm max-w-xl">{{ $user->petaniProfile->bio }}</p>
                @endif
            @endif
        </div>

        {{-- Stats --}}
        @if($user->petaniProfile)
        <div class="md:ml-auto flex gap-6 text-center">
            <div class="bg-white/10 rounded-2xl px-6 py-4">
                <p class="text-2xl font-bold text-[#F2A65A] font-mono">{{ number_format($user->petaniProfile->rating_avg, 1) }}</p>
                <p class="text-white/60 text-xs mt-1">Rating</p>
            </div>
            <div class="bg-white/10 rounded-2xl px-6 py-4">
                <p class="text-2xl font-bold text-white font-mono">{{ $produk->total() }}</p>
                <p class="text-white/60 text-xs mt-1">Produk</p>
            </div>
        </div>
        @endif

    </div>
</section>

{{-- Produk Petani --}}
<section class="max-w-7xl mx-auto px-6 py-10">
    <h2 class="text-xl font-bold text-[#1A1C19] mb-6">Semua Produk</h2>

    @if($produk->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <div class="text-6xl mb-4">🌱</div>
            <h3 class="text-xl font-bold text-[#1A1C19] mb-2">Belum ada produk</h3>
            <p class="text-[#1A1C19]/50 text-sm">Petani ini belum menambahkan produk.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach($produk as $item)
                <x-product-card
                    :id="$item->id"
                    :gambar="$item->photo_path ?? ''"
                    :kategori="ucfirst($item->category)"
                    :nama="$item->name"
                    :asal="$user->petaniProfile->farm_name ?? $user->name"
                    :harga="(int) $item->price"
                    satuan="kg"
                    :stok="$item->stock > 0 ? 'Tersedia' : 'Habis'"
                    :dataKategori="$item->category"
                />
            @endforeach
        </div>

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

    function tambahKeKeranjang(nama, harga) {
        const existing = keranjang.find(item => item.nama === nama);
        if (existing) {
            existing.qty += 1;
        } else {
            keranjang.push({ nama, harga, qty: 1 });
        }
        localStorage.setItem('keranjang', JSON.stringify(keranjang));
        updateBadge();

        const notif = document.createElement('div');
        notif.className = 'fixed bottom-6 right-6 bg-[#2D5A27] text-white text-sm px-5 py-3 rounded-xl shadow-lg z-50 flex items-center gap-2';
        notif.innerHTML = `<span>✓</span><span>${nama} ditambahkan ke keranjang</span>`;
        document.body.appendChild(notif);
        setTimeout(() => notif.remove(), 2500);
    }

    updateBadge();
</script>

@endsection