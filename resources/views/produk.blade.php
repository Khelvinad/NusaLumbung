@extends('layouts.app')

@section('title', 'Marketplace - Nusa Lumbung')

@section('content')

{{-- Header Marketplace --}}
<section class="bg-[#2D5A27] py-12">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2">Marketplace</h1>
        <p class="text-white/70">Produk segar langsung dari tangan petani Indonesia.</p>
    </div>
</section>

{{-- Filter Kategori --}}
<section class="max-w-7xl mx-auto px-6 py-8">
    <div class="flex items-center gap-3 flex-wrap">
        <button onclick="filterKategori('semua')" class="filter-btn px-5 py-2 rounded-full text-sm font-semibold border-2 border-[#2D5A27] bg-[#2D5A27] text-white transition">Semua</button>
        <button onclick="filterKategori('beras')" class="filter-btn px-5 py-2 rounded-full text-sm font-semibold border-2 border-gray-200 text-[#1A1C19]/60 hover:border-[#2D5A27] hover:text-[#2D5A27] transition">🌾 Beras</button>
        <button onclick="filterKategori('sayur')" class="filter-btn px-5 py-2 rounded-full text-sm font-semibold border-2 border-gray-200 text-[#1A1C19]/60 hover:border-[#2D5A27] hover:text-[#2D5A27] transition">🥬 Sayuran</button>
        <button onclick="filterKategori('buah')" class="filter-btn px-5 py-2 rounded-full text-sm font-semibold border-2 border-gray-200 text-[#1A1C19]/60 hover:border-[#2D5A27] hover:text-[#2D5A27] transition">🍎 Buah</button>
        <button onclick="filterKategori('kopi')" class="filter-btn px-5 py-2 rounded-full text-sm font-semibold border-2 border-gray-200 text-[#1A1C19]/60 hover:border-[#2D5A27] hover:text-[#2D5A27] transition">☕ Kopi</button>
        <button onclick="filterKategori('rempah')" class="filter-btn px-5 py-2 rounded-full text-sm font-semibold border-2 border-gray-200 text-[#1A1C19]/60 hover:border-[#2D5A27] hover:text-[#2D5A27] transition">🌶️ Rempah</button>
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
            <div class="bg-white/5 rounded-xl p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-white text-sm font-semibold">Jagung Manis</p>
                    <span class="text-xs text-[#F2A65A] font-mono">1.8/2 ton</span>
                </div>
                <div class="w-full bg-white/10 rounded-full h-2 mb-2">
                    <div class="bg-[#F2A65A] h-2 rounded-full" style="width: 90%"></div>
                </div>
                <p class="text-xs text-white/40">Butuh 200kg lagi · UMKM Berkah Jaya</p>
            </div>
            <div class="bg-white/5 rounded-xl p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-white text-sm font-semibold">Cabai Rawit</p>
                    <span class="text-xs text-[#F2A65A] font-mono">300/500 kg</span>
                </div>
                <div class="w-full bg-white/10 rounded-full h-2 mb-2">
                    <div class="bg-[#7FB069] h-2 rounded-full" style="width: 60%"></div>
                </div>
                <p class="text-xs text-white/40">Butuh 200kg lagi · Restoran Padang Sejati</p>
            </div>
            <div class="bg-white/5 rounded-xl p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-white text-sm font-semibold">Beras Organik</p>
                    <span class="text-xs text-[#F2A65A] font-mono">0.5/2 ton</span>
                </div>
                <div class="w-full bg-white/10 rounded-full h-2 mb-2">
                    <div class="bg-[#D32F2F] h-2 rounded-full" style="width: 25%"></div>
                </div>
                <p class="text-xs text-white/40">Butuh 1.5 ton lagi · Koperasi Tani Makmur</p>
            </div>
        </div>
    </div>
</section>

{{-- Grid Produk --}}
<section class="max-w-7xl mx-auto px-6 pb-16">
    <div class="grid gap-5" style="grid-template-columns: repeat(4, minmax(0, 1fr));" id="grid-produk">

        {{-- Produk 1 --}}
        <div class="produk-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition" data-kategori="beras">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('images/beras.jpg') }}" alt="Beras" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                <span class="absolute top-3 left-3 bg-white text-[#2D5A27] text-xs font-semibold px-3 py-1 rounded-full shadow-sm">Beras</span>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-[#1A1C19] mb-1">Beras Organik Premium</h3>
                <p class="text-xs text-[#1A1C19]/50 mb-3">Petani Jawa Tengah · Panen Minggu Ini</p>
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[#F2A65A] font-bold font-mono">Rp 14.500 <span class="text-xs font-normal text-[#1A1C19]/50">/ kg</span></p>
                    <span class="text-xs bg-[#F9FBF9] text-[#7FB069] border border-[#7FB069] px-2 py-1 rounded-full">Tersedia</span>
                </div>
                <button onclick="tambahKeKeranjang('Beras Organik Premium', 14500)" class="w-full bg-[#2D5A27] text-white text-sm font-semibold py-2 rounded-lg hover:bg-[#7FB069] transition">+ Keranjang</button>
            </div>
        </div>

        {{-- Produk 2 --}}
        <div class="produk-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition" data-kategori="sayur">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('images/bayam.jpg') }}" alt="Bayam" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                <span class="absolute top-3 left-3 bg-white text-[#2D5A27] text-xs font-semibold px-3 py-1 rounded-full shadow-sm">Sayuran</span>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-[#1A1C19] mb-1">Bayam Hijau Segar</h3>
                <p class="text-xs text-[#1A1C19]/50 mb-3">Petani Jawa Barat · Dipetik Hari Ini</p>
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[#F2A65A] font-bold font-mono">Rp 5.000 <span class="text-xs font-normal text-[#1A1C19]/50">/ ikat</span></p>
                    <span class="text-xs bg-[#F9FBF9] text-[#7FB069] border border-[#7FB069] px-2 py-1 rounded-full">Tersedia</span>
                </div>
                <button onclick="tambahKeKeranjang('Bayam Hijau Segar', 5000)" class="w-full bg-[#2D5A27] text-white text-sm font-semibold py-2 rounded-lg hover:bg-[#7FB069] transition">+ Keranjang</button>
            </div>
        </div>

        {{-- Produk 3 --}}
        <div class="produk-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition" data-kategori="kopi">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('images/kopi.jpeg') }}" alt="Kopi" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                <span class="absolute top-3 left-3 bg-white text-[#2D5A27] text-xs font-semibold px-3 py-1 rounded-full shadow-sm">Kopi</span>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-[#1A1C19] mb-1">Kopi Arabika Gayo</h3>
                <p class="text-xs text-[#1A1C19]/50 mb-3">Petani Aceh · Roast Level Medium</p>
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[#F2A65A] font-bold font-mono">Rp 85.000 <span class="text-xs font-normal text-[#1A1C19]/50">/ kg</span></p>
                    <span class="text-xs bg-[#F9FBF9] text-[#7FB069] border border-[#7FB069] px-2 py-1 rounded-full">Tersedia</span>
                </div>
                <button onclick="tambahKeKeranjang('Kopi Arabika Gayo', 85000)" class="w-full bg-[#2D5A27] text-white text-sm font-semibold py-2 rounded-lg hover:bg-[#7FB069] transition">+ Keranjang</button>
            </div>
        </div>

        {{-- Produk 4 --}}
        <div class="produk-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition" data-kategori="rempah">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('images/cabai.jpg') }}" alt="Cabai" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                <span class="absolute top-3 left-3 bg-white text-[#2D5A27] text-xs font-semibold px-3 py-1 rounded-full shadow-sm">Rempah</span>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-[#1A1C19] mb-1">Cabai Merah Keriting</h3>
                <p class="text-xs text-[#1A1C19]/50 mb-3">Petani Jawa Timur · Segar Dipetik</p>
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[#F2A65A] font-bold font-mono">Rp 32.000 <span class="text-xs font-normal text-[#1A1C19]/50">/ kg</span></p>
                    <span class="text-xs bg-[#F9FBF9] text-[#7FB069] border border-[#7FB069] px-2 py-1 rounded-full">Tersedia</span>
                </div>
                <button onclick="tambahKeKeranjang('Cabai Merah Keriting', 32000)" class="w-full bg-[#2D5A27] text-white text-sm font-semibold py-2 rounded-lg hover:bg-[#7FB069] transition">+ Keranjang</button>
            </div>
        </div>

        {{-- Produk 5 --}}
        <div class="produk-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition" data-kategori="buah">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('images/mangga.jpg') }}" alt="Mangga" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                <span class="absolute top-3 left-3 bg-white text-[#2D5A27] text-xs font-semibold px-3 py-1 rounded-full shadow-sm">Buah</span>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-[#1A1C19] mb-1">Mangga Harum Manis</h3>
                <p class="text-xs text-[#1A1C19]/50 mb-3">Petani Probolinggo · Musim Panen</p>
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[#F2A65A] font-bold font-mono">Rp 18.000 <span class="text-xs font-normal text-[#1A1C19]/50">/ kg</span></p>
                    <span class="text-xs bg-[#F9FBF9] text-[#7FB069] border border-[#7FB069] px-2 py-1 rounded-full">Tersedia</span>
                </div>
                <button onclick="tambahKeKeranjang('Mangga Harum Manis', 18000)" class="w-full bg-[#2D5A27] text-white text-sm font-semibold py-2 rounded-lg hover:bg-[#7FB069] transition">+ Keranjang</button>
            </div>
        </div>

        {{-- Produk 6 --}}
        <div class="produk-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition" data-kategori="sayur">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('images/kentang.jpg') }}" alt="Kentang" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                <span class="absolute top-3 left-3 bg-white text-[#2D5A27] text-xs font-semibold px-3 py-1 rounded-full shadow-sm">Sayuran</span>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-[#1A1C19] mb-1">Kentang Granola</h3>
                <p class="text-xs text-[#1A1C19]/50 mb-3">Petani Dieng · Grade A</p>
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[#F2A65A] font-bold font-mono">Rp 12.000 <span class="text-xs font-normal text-[#1A1C19]/50">/ kg</span></p>
                    <span class="text-xs bg-[#F9FBF9] text-[#7FB069] border border-[#7FB069] px-2 py-1 rounded-full">Tersedia</span>
                </div>
                <button onclick="tambahKeKeranjang('Kentang Granola', 12000)" class="w-full bg-[#2D5A27] text-white text-sm font-semibold py-2 rounded-lg hover:bg-[#7FB069] transition">+ Keranjang</button>
            </div>
        </div>

        {{-- Produk 7 --}}
        <div class="produk-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition" data-kategori="buah">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('images/pisang.jpg') }}" alt="Pisang" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                <span class="absolute top-3 left-3 bg-white text-[#2D5A27] text-xs font-semibold px-3 py-1 rounded-full shadow-sm">Buah</span>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-[#1A1C19] mb-1">Pisang Kepok</h3>
                <p class="text-xs text-[#1A1C19]/50 mb-3">Petani Lampung · Siap Kirim</p>
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[#F2A65A] font-bold font-mono">Rp 8.000 <span class="text-xs font-normal text-[#1A1C19]/50">/ kg</span></p>
                    <span class="text-xs bg-[#F9FBF9] text-[#7FB069] border border-[#7FB069] px-2 py-1 rounded-full">Tersedia</span>
                </div>
                <button onclick="tambahKeKeranjang('Pisang Kepok', 8000)" class="w-full bg-[#2D5A27] text-white text-sm font-semibold py-2 rounded-lg hover:bg-[#7FB069] transition">+ Keranjang</button>
            </div>
        </div>

        {{-- Produk 8 --}}
        <div class="produk-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition" data-kategori="rempah">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('images/jahe.jpg') }}" alt="Jahe" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                <span class="absolute top-3 left-3 bg-white text-[#2D5A27] text-xs font-semibold px-3 py-1 rounded-full shadow-sm">Rempah</span>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-[#1A1C19] mb-1">Jahe Merah Organik</h3>
                <p class="text-xs text-[#1A1C19]/50 mb-3">Petani Wonogiri · Kering Sempurna</p>
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[#F2A65A] font-bold font-mono">Rp 45.000 <span class="text-xs font-normal text-[#1A1C19]/50">/ kg</span></p>
                    <span class="text-xs bg-[#F9FBF9] text-[#7FB069] border border-[#7FB069] px-2 py-1 rounded-full">Tersedia</span>
                </div>
                <button onclick="tambahKeKeranjang('Jahe Merah Organik', 45000)" class="w-full bg-[#2D5A27] text-white text-sm font-semibold py-2 rounded-lg hover:bg-[#7FB069] transition">+ Keranjang</button>
            </div>
        </div>

    </div>
</section>

<script>
    let keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];

    function updateBadge() {
        const badge = document.getElementById('cart-badge');
        if (!badge) return;
        const total = keranjang.reduce((sum, item) => sum + item.qty, 0);
        if (total > 0) {
            badge.textContent = total;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
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
        notif.className = 'fixed bottom-6 right-6 bg-[#2D5A27] text-white text-sm px-5 py-3 rounded-xl shadow-lg z-50';
        notif.textContent = `✓ ${nama} ditambahkan ke keranjang`;
        document.body.appendChild(notif);
        setTimeout(() => notif.remove(), 2500);
    }

    function filterKategori(kategori) {
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('bg-[#2D5A27]', 'text-white', 'border-[#2D5A27]');
            btn.classList.add('border-gray-200', 'text-[#1A1C19]/60');
        });
        event.target.classList.add('bg-[#2D5A27]', 'text-white', 'border-[#2D5A27]');
        event.target.classList.remove('border-gray-200', 'text-[#1A1C19]/60');

        document.querySelectorAll('.produk-card').forEach(card => {
            if (kategori === 'semua' || card.dataset.kategori === kategori) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    updateBadge();
</script>

@endsection