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
            <x-pool-progress komoditas="Jagung Manis" :terkumpul="1800" :target="2000" satuan="kg" pembeli="UMKM Berkah Jaya" />
            <x-pool-progress komoditas="Cabai Rawit" :terkumpul="300" :target="500" satuan="kg" pembeli="Restoran Padang Sejati" />
            <x-pool-progress komoditas="Beras Organik" :terkumpul="500" :target="2000" satuan="kg" pembeli="Koperasi Tani Makmur" />
        </div>
    </div>
</section>

{{-- Grid Produk --}}
<section class="max-w-7xl mx-auto px-6 pb-16">
    <div class="grid gap-5" style="grid-template-columns: repeat(4, minmax(0, 1fr));" id="grid-produk">
        <x-product-card gambar="beras.jpg" kategori="Beras" nama="Beras Organik Premium" asal="Petani Jawa Tengah · Panen Minggu Ini" :harga="14500" satuan="kg" dataKategori="beras" />
        <x-product-card gambar="bayam.jpg" kategori="Sayuran" nama="Bayam Hijau Segar" asal="Petani Jawa Barat · Dipetik Hari Ini" :harga="5000" satuan="ikat" dataKategori="sayur" />
        <x-product-card gambar="kopi.jpeg" kategori="Kopi" nama="Kopi Arabika Gayo" asal="Petani Aceh · Roast Level Medium" :harga="85000" satuan="kg" dataKategori="kopi" />
        <x-product-card gambar="cabai.jpg" kategori="Rempah" nama="Cabai Merah Keriting" asal="Petani Jawa Timur · Segar Dipetik" :harga="32000" satuan="kg" dataKategori="rempah" />
        <x-product-card gambar="mangga.jpg" kategori="Buah" nama="Mangga Harum Manis" asal="Petani Probolinggo · Musim Panen" :harga="18000" satuan="kg" dataKategori="buah" />
        <x-product-card gambar="kentang.jpg" kategori="Sayuran" nama="Kentang Granola" asal="Petani Dieng · Grade A" :harga="12000" satuan="kg" dataKategori="sayur" />
        <x-product-card gambar="pisang.jpg" kategori="Buah" nama="Pisang Kepok" asal="Petani Lampung · Siap Kirim" :harga="8000" satuan="kg" dataKategori="buah" />
        <x-product-card gambar="jahe.jpg" kategori="Rempah" nama="Jahe Merah Organik" asal="Petani Wonogiri · Kering Sempurna" :harga="45000" satuan="kg" dataKategori="rempah" />
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