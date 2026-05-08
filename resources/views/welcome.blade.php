@extends('layouts.app')

@section('title', 'Nusa Lumbung - Hubungkan Petani Langsung ke Anda')

@section('content')

    {{-- Hero Section --}}
    <section class="relative h-[500px] flex items-center justify-center text-center text-white"
        style="background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)), url('{{ asset('images/Beranda1.jpg') }}') center/cover no-repeat;">
        <div>
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6 max-w-2xl mx-auto">
                Nusa Lumbung: Hubungkan Petani Langsung ke Anda
            </h1>
            <a href="/produk" class="bg-white text-[#2D5A27] font-semibold px-8 py-3 rounded-lg hover:bg-[#F2A65A] hover:text-white transition">
    Jelajahi Produk
</a>
        </div>
    </section>

    {{-- Gallery Section --}}
<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- Card 1 --}}
        <div class="relative rounded-xl overflow-hidden cursor-pointer group h-64"
            onclick="openModal('modal1')">
            <img src="{{ asset('images/marketplace-langsung.jpg') }}"
                alt="Marketplace Langsung"
                class="w-full h-full object-cover object-center scale-110 group-hover:scale-125 transition duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <p class="absolute bottom-4 left-4 text-white font-bold text-lg">Marketplace Langsung</p>
        </div>

        {{-- Card 2 --}}
        <div class="relative rounded-xl overflow-hidden cursor-pointer group h-64"
            onclick="openModal('modal2')">
            <img src="{{ asset('images/transparasi-harga.jpeg') }}"
                alt="Transparansi Harga"
                class="w-full h-full object-cover object-[44%_center] group-hover:scale-105 transition duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
            <p class="absolute bottom-4 left-4 text-white font-bold text-lg">Transparansi Harga</p>
        </div>

        {{-- Card 3 --}}
        <div class="relative rounded-xl overflow-hidden cursor-pointer group h-64"
            onclick="openModal('modal3')">
            <img src="{{ asset('images/kolaborasi-petani.jpg') }}"
                alt="Forum Komunitas"
                class="w-full h-full object-cover object-[center_74%] group-hover:scale-105 transition duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <p class="absolute bottom-4 left-4 text-white font-bold text-lg">Forum Komunitas</p>
        </div>

    </div>
</section>

{{-- Modal 1 --}}
<div id="modal1" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 px-4"
    onclick="closeModal('modal1')">
    <div class="bg-white rounded-2xl max-w-2xl w-full overflow-hidden shadow-2xl"
        onclick="event.stopPropagation()">
        <img src="{{ asset('images/marketplace-langsung.jpg') }}"
    alt="Marketplace Langsung" class="w-full h-64 object-cover object-[center_15%]">
        <div class="p-6">
            <p class="text-[#F2A65A] font-semibold text-sm mb-1">"Memangkas Jarak, Menambah Berkah."</p>
            <h3 class="text-2xl font-bold text-[#2D5A27] mb-3">Marketplace Langsung</h3>
            <p class="text-[#1A1C19]/70 leading-relaxed">Hubungkan hasil panen Bapak dan Ibu Tani langsung ke tangan konsumen akhir dan pelaku UMKM tanpa melalui perantara yang panjang. Dengan sistem ini, pembeli mendapatkan produk yang jauh lebih segar dengan harga yang adil, sementara petani bisa menikmati hasil keringatnya secara lebih utuh dan maksimal.</p>
        </div>
        <div class="px-6 pb-6">
            <button onclick="closeModal('modal1')"
                class="bg-[#2D5A27] text-white px-6 py-2 rounded-lg hover:bg-[#7FB069] transition">Tutup</button>
        </div>
    </div>
</div>

{{-- Modal 2 --}}
<div id="modal2" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 px-4"
    onclick="closeModal('modal2')">
    <div class="bg-white rounded-2xl max-w-2xl w-full overflow-hidden shadow-2xl"
        onclick="event.stopPropagation()">
        <img src="{{ asset('images/transparasi-harga.jpeg') }}"
            alt="Transparansi Harga" class="w-full h-64 object-cover object-[center_70%]">
        <div class="p-6">
            <p class="text-[#F2A65A] font-semibold text-sm mb-1">"Pantau Harga, Ambil Kendali."</p>
            <h3 class="text-2xl font-bold text-[#2D5A27] mb-3">Transparansi Harga</h3>
            <p class="text-[#1A1C19]/70 leading-relaxed">Kami menyediakan akses terbuka ke data harga pasar komoditas secara aktual setiap harinya. Fitur ini hadir agar Bapak dan Ibu Tani memiliki pegangan informasi yang akurat dalam membandingkan tawaran di lapangan, sehingga tercipta kesepakatan jual-beli yang transparan, jujur, dan saling menguntungkan.</p>
        </div>
        <div class="px-6 pb-6">
            <button onclick="closeModal('modal2')"
                class="bg-[#2D5A27] text-white px-6 py-2 rounded-lg hover:bg-[#7FB069] transition">Tutup</button>
        </div>
    </div>
</div>

{{-- Modal 3 --}}
<div id="modal3" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 px-4"
    onclick="closeModal('modal3')">
    <div class="bg-white rounded-2xl max-w-2xl w-full overflow-hidden shadow-2xl"
        onclick="event.stopPropagation()">
        <img src="{{ asset('images/kolaborasi-petani.jpg') }}"
    alt="Forum Komunitas" class="w-full h-64 object-cover object-[center_70%]">
        <div class="p-6">
            <p class="text-[#F2A65A] font-semibold text-sm mb-1">"Guyub Rukun, Maju Bersama."</p>
            <h3 class="text-2xl font-bold text-[#2D5A27] mb-3">Forum Komunitas</h3>
            <p class="text-[#1A1C19]/70 leading-relaxed">Ruang diskusi bagi seluruh sahabat tani untuk saling berbagi pengalaman, mulai dari tips pengolahan lahan, rekomendasi pupuk yang tepat, hingga cara jitu menangani hama secara organik. Di sini, kita tidak hanya bertukar pesan, tapi membangun kekuatan kolektif untuk memajukan pertanian Indonesia.</p>
        </div>
        <div class="px-6 pb-6">
            <button onclick="closeModal('modal3')"
                class="bg-[#2D5A27] text-white px-6 py-2 rounded-lg hover:bg-[#7FB069] transition">Tutup</button>
        </div>
    </div>
</div>

{{-- Modal Script --}}
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

    {{-- Statistik Section --}}
<section class="bg-[#2D5A27] py-16">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
        <div>
            <p class="text-4xl font-extrabold text-[#F2A65A]" data-target="1200">0</p>
            <p class="text-sm mt-2 text-white/70">Petani Bergabung</p>
        </div>
        <div>
            <p class="text-4xl font-extrabold text-[#F2A65A]" data-target="50">0</p>
            <p class="text-sm mt-2 text-white/70">Ton Panen Tersalurkan</p>
        </div>
        <div>
            <p class="text-4xl font-extrabold text-[#F2A65A]" data-target="320">0</p>
            <p class="text-sm mt-2 text-white/70">UMKM Terhubung</p>
        </div>
        <div>
            <p class="text-4xl font-extrabold text-[#F2A65A]" data-target="28">0</p>
            <p class="text-sm mt-2 text-white/70">Provinsi Terjangkau</p>
        </div>
    </div>
</section>

{{-- Testimoni Section --}}
<section class="max-w-7xl mx-auto px-6 py-16">
    <h2 class="text-2xl md:text-3xl font-bold text-[#1A1C19] text-center mb-2">
        Suara dari Sahabat Tani
    </h2>
    <p class="text-center text-[#1A1C19]/60 mb-10">Cerita nyata dari mereka yang sudah merasakan manfaatnya.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Testimoni 1 --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col gap-4">
            <div class="text-[#F2A65A] text-3xl">"</div>
            <p class="text-[#1A1C19]/70 text-sm leading-relaxed">
                Sejak pakai Nusa Lumbung, hasil panen saya langsung terjual tanpa harus ke pasar dulu. Pendapatan naik hampir dua kali lipat dalam tiga bulan pertama!
            </p>
            <div class="flex items-center gap-3 mt-auto pt-4 border-t border-gray-100">
                <div class="w-10 h-10 rounded-full bg-[#7FB069] flex items-center justify-center text-white font-bold text-sm">
                    BS
                </div>
                <div>
                    <p class="font-semibold text-[#1A1C19] text-sm">Bapak Suryanto</p>
                    <p class="text-xs text-[#1A1C19]/50">Petani Padi, Jawa Tengah</p>
                </div>
            </div>
        </div>

        {{-- Testimoni 2 --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col gap-4">
            <div class="text-[#F2A65A] text-3xl">"</div>
            <p class="text-[#1A1C19]/70 text-sm leading-relaxed">
                Fitur transparansi harga sangat membantu saya tahu harga pasar sebenarnya. Sekarang saya tidak mudah dibohongi tengkulak dan bisa tawar harga dengan percaya diri.
            </p>
            <div class="flex items-center gap-3 mt-auto pt-4 border-t border-gray-100">
                <div class="w-10 h-10 rounded-full bg-[#2D5A27] flex items-center justify-center text-white font-bold text-sm">
                    IW
                </div>
                <div>
                    <p class="font-semibold text-[#1A1C19] text-sm">Ibu Warsih</p>
                    <p class="text-xs text-[#1A1C19]/50">Petani Sayur, Jawa Barat</p>
                </div>
            </div>
        </div>

        {{-- Testimoni 3 --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col gap-4">
            <div class="text-[#F2A65A] text-3xl">"</div>
            <p class="text-[#1A1C19]/70 text-sm leading-relaxed">
                Forum komunitasnya luar biasa! Saya bisa tanya soal hama ke sesama petani dan langsung dapat jawaban. Rasanya punya teman seperjuangan dari seluruh Indonesia.
            </p>
            <div class="flex items-center gap-3 mt-auto pt-4 border-t border-gray-100">
                <div class="w-10 h-10 rounded-full bg-[#F2A65A] flex items-center justify-center text-white font-bold text-sm">
                    AR
                </div>
                <div>
                    <p class="font-semibold text-[#1A1C19] text-sm">Pak Arifin</p>
                    <p class="text-xs text-[#1A1C19]/50">Petani Kopi, Sumatera Selatan</p>
                </div>
            </div>
        </div>

    </div>
</section>

        {{-- Count Up Script --}}
        <script>
            const counters = document.querySelectorAll('[data-target]');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const target = +el.getAttribute('data-target');
                        const duration = 1500;
                        const step = target / (duration / 16);
                        let current = 0;

                        const update = () => {
                            current += step;
                            if (current < target) {
                                el.textContent = Math.ceil(current).toLocaleString();
                                requestAnimationFrame(update);
                            } else {
                                el.textContent = target.toLocaleString() + '+';
                            }
                        };

                        update();
                        observer.unobserve(el);
                    }
                });
            }, { threshold: 0.5 });

            counters.forEach(counter => observer.observe(counter));
        </script>

    {{-- Produk Unggulan Section --}}
<section id="produk" class="max-w-7xl mx-auto px-6 py-16">
    <div class="text-center mb-10">
        <h2 class="text-2xl md:text-3xl font-bold text-[#1A1C19] mb-2">Produk Unggulan</h2>
        <p class="text-[#1A1C19]/60">Komoditas terbaik langsung dari tangan petani Indonesia.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Card Beras --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('images/beras.jpg') }}"
                    alt="Beras" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                <span class="absolute top-3 left-3 bg-white text-[#2D5A27] text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                    Beras
                </span>
            </div>
            <div class="p-5">
                <h3 class="font-bold text-[#1A1C19] mb-1">Beras Organik Premium</h3>
                <p class="text-xs text-[#1A1C19]/50 mb-3">Petani Jawa Tengah · Panen Minggu Ini</p>
                <div class="flex items-center justify-between">
                    <p class="text-[#F2A65A] font-bold font-mono">Rp 14.500 <span class="text-xs font-normal text-[#1A1C19]/50">/ kg</span></p>
                    <span class="text-xs bg-[#F9FBF9] text-[#7FB069] border border-[#7FB069] px-2 py-1 rounded-full">Stok Tersedia</span>
                </div>
            </div>
        </div>

        {{-- Card Kopi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('images/kopi.jpeg') }}"
                    alt="Kopi" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                <span class="absolute top-3 left-3 bg-white text-[#2D5A27] text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                    Kopi
                </span>
            </div>
            <div class="p-5">
                <h3 class="font-bold text-[#1A1C19] mb-1">Kopi Arabika Gayo</h3>
                <p class="text-xs text-[#1A1C19]/50 mb-3">Petani Aceh · Roast Level Medium</p>
                <div class="flex items-center justify-between">
                    <p class="text-[#F2A65A] font-bold font-mono">Rp 85.000 <span class="text-xs font-normal text-[#1A1C19]/50">/ kg</span></p>
                    <span class="text-xs bg-[#F9FBF9] text-[#7FB069] border border-[#7FB069] px-2 py-1 rounded-full">Stok Tersedia</span>
                </div>
            </div>
        </div>

        {{-- Card Cabai --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('images/cabai.jpg') }}"
                    alt="Cabai" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                <span class="absolute top-3 left-3 bg-white text-[#2D5A27] text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                    Cabai
                </span>
            </div>
            <div class="p-5">
                <h3 class="font-bold text-[#1A1C19] mb-1">Cabai Merah Keriting</h3>
                <p class="text-xs text-[#1A1C19]/50 mb-3">Petani Jawa Timur · Segar Dipetik</p>
                <div class="flex items-center justify-between">
                    <p class="text-[#F2A65A] font-bold font-mono">Rp 32.000 <span class="text-xs font-normal text-[#1A1C19]/50">/ kg</span></p>
                    <span class="text-xs bg-[#F9FBF9] text-[#7FB069] border border-[#7FB069] px-2 py-1 rounded-full">Stok Tersedia</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Tombol ke Marketplace --}}
    <div class="text-center mt-10">
        <a href="/produk" class="inline-flex items-center gap-2 bg-[#2D5A27] text-white font-semibold px-8 py-3 rounded-lg hover:bg-[#7FB069] transition">
            Lihat Semua Produk
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>

</section>

    {{-- Fitur Section --}}
<section id="fitur" class="py-16 bg-[#F9FBF9]">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-16">
            <h2 class="text-2xl md:text-3xl font-bold text-[#1A1C19] mb-2">Mengapa Nusa Lumbung?</h2>
            <p class="text-[#1A1C19]/60">Teknologi modern untuk pertanian Indonesia yang lebih berdaya.</p>
        </div>

        {{-- Fitur 1 - AI Rekomendasi Tanam --}}
        <div class="flex flex-col md:flex-row items-center gap-12 mb-20">
            <div class="w-full md:w-1/2">
                <img src="{{ asset('images/ai_pertanian.jpg') }}"
                    alt="AI Rekomendasi Tanam"
                    class="rounded-2xl shadow-md w-full h-72 object-cover">
            </div>
            <div class="w-full md:w-1/2">
                <span class="inline-block bg-[#F2A65A]/20 text-[#F2A65A] text-xs font-semibold px-3 py-1 rounded-full mb-4">
                    AI Powered
                </span>
                <h3 class="text-2xl font-bold text-[#1A1C19] mb-4">AI Rekomendasi Tanam</h3>
                <p class="text-[#1A1C19]/70 leading-relaxed mb-6">
                    Sistem kecerdasan buatan kami menganalisis kondisi lahan, cuaca lokal, dan tren pasar secara bersamaan. Hasilnya? Rekomendasi tanaman yang paling menguntungkan untuk musim tanam berikutnya — spesifik untuk lahan Bapak dan Ibu Tani.
                </p>
                <ul class="space-y-2 text-sm text-[#1A1C19]/70">
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs">✓</span>
                        Analisis cuaca real-time
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs">✓</span>
                        Prediksi harga panen
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs">✓</span>
                        Rekomendasi pupuk & pestisida
                    </li>
                </ul>
            </div>
        </div>

        {{-- Fitur 2 - Dashboard Transparansi Harga --}}
        <div class="flex flex-col md:flex-row-reverse items-center gap-12 mb-20">
            <div class="w-full md:w-1/2">
                <img src="{{ asset('images/transparasi.jpg') }}"
                    alt="Dashboard Transparansi Harga"
                    class="rounded-2xl shadow-md w-full h-72 object-cover">
            </div>
            <div class="w-full md:w-1/2">
                <span class="inline-block bg-[#2D5A27]/10 text-[#2D5A27] text-xs font-semibold px-3 py-1 rounded-full mb-4">
                    Transparansi
                </span>
                <h3 class="text-2xl font-bold text-[#1A1C19] mb-4">Dashboard Transparansi Harga</h3>
                <p class="text-[#1A1C19]/70 leading-relaxed mb-6">
                    Pantau pergerakan harga komoditas setiap hari langsung dari dashboard kami. Data diperbarui secara aktual dari berbagai pasar di seluruh Indonesia — sehingga tidak ada lagi informasi yang disembunyikan.
                </p>
                <ul class="space-y-2 text-sm text-[#1A1C19]/70">
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs">✓</span>
                        Data harga 50+ komoditas
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs">✓</span>
                        Grafik tren mingguan & bulanan
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs">✓</span>
                        Notifikasi lonjakan harga
                    </li>
                </ul>
            </div>
        </div>

        {{-- Fitur 3 - Sistem Logistik --}}
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="w-full md:w-1/2">
                <img src="{{ asset('images/gudang.jpg') }}"
                    alt="Sistem Logistik"
                    class="rounded-2xl shadow-md w-full h-72 object-cover">
            </div>
            <div class="w-full md:w-1/2">
                <span class="inline-block bg-[#F2A65A]/20 text-[#F2A65A] text-xs font-semibold px-3 py-1 rounded-full mb-4">
                    Logistik
                </span>
                <h3 class="text-2xl font-bold text-[#1A1C19] mb-4">Sistem Logistik Terintegrasi</h3>
                <p class="text-[#1A1C19]/70 leading-relaxed mb-6">
                    Dari lahan langsung ke pintu rumah Anda. Kami bermitra dengan jaringan logistik terpercaya yang memahami kebutuhan pengiriman produk pertanian — cepat, aman, dan tetap segar sampai tujuan.
                </p>
                <ul class="space-y-2 text-sm text-[#1A1C19]/70">
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs">✓</span>
                        Pengiriman same-day untuk area terdekat
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs">✓</span>
                        Tracking pengiriman real-time
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs">✓</span>
                        Kemasan khusus produk pertanian
                    </li>
                </ul>
            </div>
        </div>

    </div>
</section>

    {{-- Komunitas Section --}}
<section id="komunitas" class="py-16">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-[#1A1C19] mb-2">Komunitas Sahabat Tani</h2>
            <p class="text-[#1A1C19]/60">Tempat berkumpul, belajar, dan berkembang bersama petani Indonesia.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Card Forum Diskusi --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="w-12 h-12 bg-[#2D5A27]/10 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2D5A27]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z" />
                    </svg>
                </div>
                <h3 class="font-bold text-[#1A1C19] text-lg mb-2">Forum Diskusi</h3>
                <p class="text-sm text-[#1A1C19]/60 leading-relaxed mb-5">
                    Tanyakan apapun tentang pertanian dan dapatkan jawaban dari sesama petani berpengalaman.
                </p>
                {{-- Preview Topik --}}
                <ul class="space-y-2 mb-5">
                    <li class="flex items-center gap-2 text-xs text-[#1A1C19]/70 bg-[#F9FBF9] px-3 py-2 rounded-lg">
                        <span class="w-2 h-2 rounded-full bg-[#D32F2F]"></span>
                        Cara mengatasi hama wereng organik
                    </li>
                    <li class="flex items-center gap-2 text-xs text-[#1A1C19]/70 bg-[#F9FBF9] px-3 py-2 rounded-lg">
                        <span class="w-2 h-2 rounded-full bg-[#7FB069]"></span>
                        Pupuk kompos vs pupuk kimia
                    </li>
                    <li class="flex items-center gap-2 text-xs text-[#1A1C19]/70 bg-[#F9FBF9] px-3 py-2 rounded-lg">
                        <span class="w-2 h-2 rounded-full bg-[#F2A65A]"></span>
                        Tips panen padi di musim hujan
                    </li>
                </ul>
                <a href="#" class="text-sm text-[#2D5A27] font-semibold hover:text-[#7FB069] transition">
                    Lihat semua diskusi →
                </a>
            </div>

            {{-- Card Tips & Trik Tani --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="w-12 h-12 bg-[#F2A65A]/10 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#F2A65A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.347.347a3.001 3.001 0 00-.952 1.379l-.416 1.664a1 1 0 01-.97.757H9.93a1 1 0 01-.97-.757l-.416-1.664a3 3 0 00-.952-1.379l-.347-.347z" />
                    </svg>
                </div>
                <h3 class="font-bold text-[#1A1C19] text-lg mb-2">Tips & Trik Tani</h3>
                <p class="text-sm text-[#1A1C19]/60 leading-relaxed mb-5">
                    Kumpulan panduan praktis dari para ahli pertanian untuk memaksimalkan hasil panen kamu.
                </p>
                <ul class="space-y-2 mb-5">
                    <li class="flex items-center gap-2 text-xs text-[#1A1C19]/70 bg-[#F9FBF9] px-3 py-2 rounded-lg">
                        <span class="w-2 h-2 rounded-full bg-[#F2A65A]"></span>
                        5 teknik irigasi hemat air
                    </li>
                    <li class="flex items-center gap-2 text-xs text-[#1A1C19]/70 bg-[#F9FBF9] px-3 py-2 rounded-lg">
                        <span class="w-2 h-2 rounded-full bg-[#F2A65A]"></span>
                        Cara membuat pestisida organik sendiri
                    </li>
                    <li class="flex items-center gap-2 text-xs text-[#1A1C19]/70 bg-[#F9FBF9] px-3 py-2 rounded-lg">
                        <span class="w-2 h-2 rounded-full bg-[#F2A65A]"></span>
                        Rotasi tanaman untuk tanah lebih subur
                    </li>
                </ul>
                <a href="#" class="text-sm text-[#F2A65A] font-semibold hover:text-[#2D5A27] transition">
                    Lihat semua tips →
                </a>
            </div>

            {{-- Card Berita Pertanian --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="w-12 h-12 bg-[#7FB069]/10 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#7FB069]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <h3 class="font-bold text-[#1A1C19] text-lg mb-2">Berita Pertanian</h3>
                <p class="text-sm text-[#1A1C19]/60 leading-relaxed mb-5">
                    Update terkini seputar kebijakan pemerintah, inovasi alat tani, dan tren pertanian Indonesia.
                </p>
                <ul class="space-y-2 mb-5">
                    <li class="flex items-center gap-2 text-xs text-[#1A1C19]/70 bg-[#F9FBF9] px-3 py-2 rounded-lg">
                        <span class="w-2 h-2 rounded-full bg-[#7FB069]"></span>
                        Subsidi pupuk 2025 resmi diperpanjang
                    </li>
                    <li class="flex items-center gap-2 text-xs text-[#1A1C19]/70 bg-[#F9FBF9] px-3 py-2 rounded-lg">
                        <span class="w-2 h-2 rounded-full bg-[#7FB069]"></span>
                        Drone pertanian kini bisa disewa petani
                    </li>
                    <li class="flex items-center gap-2 text-xs text-[#1A1C19]/70 bg-[#F9FBF9] px-3 py-2 rounded-lg">
                        <span class="w-2 h-2 rounded-full bg-[#7FB069]"></span>
                        Harga gabah naik 12% bulan ini
                    </li>
                </ul>
                <a href="#" class="text-sm text-[#7FB069] font-semibold hover:text-[#2D5A27] transition">
                    Lihat semua berita →
                </a>
            </div>

        </div>
    </div>
</section>

    {{-- Tentang Kami Section --}}
<section id="tentang" class="py-16 bg-[#F9FBF9]">
    <div class="max-w-7xl mx-auto px-6">

        {{-- Visi & Misi --}}
        <div class="text-center mb-16">
            <h2 class="text-2xl md:text-3xl font-bold text-[#1A1C19] mb-2">Tentang Nusa Lumbung</h2>
            <p class="text-[#1A1C19]/60 max-w-2xl mx-auto">Kami hadir untuk memutus rantai tengkulak dan mewujudkan kesejahteraan petani Indonesia.</p>
        </div>

        {{-- Visi Misi Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-20">
            <div class="bg-[#2D5A27] rounded-2xl p-8 text-white">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Visi</h3>
                <p class="text-white/80 leading-relaxed">
                    Menjadi platform agritech terpercaya yang menghubungkan setiap petani Indonesia langsung ke pasar, tanpa perantara yang merugikan — demi terciptanya ekosistem pertanian yang adil, transparan, dan berdaya saing global.
                </p>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
                <div class="w-12 h-12 bg-[#2D5A27]/10 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2D5A27]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-[#1A1C19] mb-3">Misi</h3>
                <ul class="space-y-3 text-[#1A1C19]/70 text-sm leading-relaxed">
                    <li class="flex items-start gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs mt-0.5 shrink-0">✓</span>
                        Membangun marketplace langsung antara petani dan konsumen tanpa perantara
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs mt-0.5 shrink-0">✓</span>
                        Menyediakan data harga komoditas yang transparan dan akurat setiap hari
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs mt-0.5 shrink-0">✓</span>
                        Memberdayakan petani dengan teknologi AI untuk keputusan tanam yang lebih cerdas
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs mt-0.5 shrink-0">✓</span>
                        Membangun komunitas tani yang solid dan saling mendukung
                    </li>
                </ul>
            </div>
        </div>

        {{-- Tim --}}
        <div class="text-center mb-10">
            <h3 class="text-2xl font-bold text-[#1A1C19] mb-2">Tim Nusa Lumbung</h3>
            <p class="text-[#1A1C19]/60">Dibangun oleh anak muda yang peduli pertanian Indonesia.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-20">

            {{-- Khelvin --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-md transition">
                <img src="{{ asset('images/kelpin.png') }}"
                    alt="Khelvin"
                    class="w-32 h-32 rounded-full object-cover object-top mx-auto mb-4 border-4 border-[#2D5A27]">
                <h4 class="font-bold text-[#1A1C19] text-lg">Khelvin</h4>
                <p class="text-sm text-[#F2A65A] font-medium mb-3">Co-Founder & Business Development</p>
                <p class="text-xs text-[#1A1C19]/60 leading-relaxed">
                    Visioner di balik model bisnis Nusa Lumbung. Memastikan platform ini aman, scalable, dan berdampak nyata bagi ekosistem pertanian Indonesia.
                </p>
            </div>

            {{-- Ozora --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-md transition">
                <div class="w-32 h-32 rounded-full bg-[#F2A65A] flex items-center justify-center text-white font-bold text-2xl mx-auto mb-4">
                    O
                </div>
                <h4 class="font-bold text-[#1A1C19] text-lg">Ozora</h4>
                <p class="text-sm text-[#F2A65A] font-medium mb-3">UI/UX & Frontend Developer</p>
                <p class="text-xs text-[#1A1C19]/60 leading-relaxed">
                    Arsitek tampilan Nusa Lumbung. Memastikan setiap halaman terasa intuitif, indah, dan mudah digunakan oleh petani maupun pembeli.
                </p>
            </div>

            {{-- Alif --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-md transition">
                <div class="w-32 h-32 rounded-full bg-[#7FB069] flex items-center justify-center text-white font-bold text-2xl mx-auto mb-4">
                    A
                </div>
                <h4 class="font-bold text-[#1A1C19] text-lg">Alif</h4>
                <p class="text-sm text-[#F2A65A] font-medium mb-3">Backend Engineer & AI Integration</p>
                <p class="text-xs text-[#1A1C19]/60 leading-relaxed">
                    Otak teknis di balik sistem Nusa Lumbung. Membangun infrastruktur backend yang kuat dan mengintegrasikan AI untuk rekomendasi tanam cerdas.
                </p>
            </div>

        </div>

        {{-- Kontak & Kantor --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Alamat --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="w-12 h-12 bg-[#2D5A27]/10 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2D5A27]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h4 class="font-bold text-[#1A1C19] mb-2">Kantor Operasional</h4>
                <p class="text-sm text-[#1A1C19]/70 leading-relaxed">
                    Jl. Veteran No.10-11, Ketawanggede,<br>
                    Kec. Lowokwaru, Kota Malang,<br>
                    Jawa Timur 65145
                </p>
            </div>

            {{-- Kontak --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="w-12 h-12 bg-[#F2A65A]/10 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#F2A65A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 7V5z" />
                    </svg>
                </div>
                <h4 class="font-bold text-[#1A1C19] mb-3">Hubungi Kami</h4>
                <ul class="space-y-2 text-sm text-[#1A1C19]/70">
                    <li class="flex items-center gap-2">
                        <span class="text-[#2D5A27] font-medium">Email:</span>
                        info@nusalumbung.id
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[#2D5A27] font-medium">Bantuan:</span>
                        +62 812 0000 1234
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[#2D5A27] font-medium">WhatsApp:</span>
                        +62 813 0000 5678
                    </li>
                </ul>
            </div>

        </div>

    </div>
</section>

    {{-- Kerja Sama Section --}}
<section id="kerjasama" class="py-16">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-[#1A1C19] mb-2">Kerja Sama</h2>
            <p class="text-[#1A1C19]/60 max-w-2xl mx-auto">Bergabunglah sebagai mitra strategis Nusa Lumbung dan tumbuh bersama ekosistem pertanian Indonesia.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Card UMKM --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col hover:shadow-md transition">
                <div class="w-14 h-14 bg-[#2D5A27]/10 rounded-2xl flex items-center justify-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#2D5A27]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-[#2D5A27] bg-[#2D5A27]/10 px-3 py-1 rounded-full w-fit mb-4">Program UMKM</span>
                <h3 class="font-bold text-[#1A1C19] text-xl mb-3">Langganan Bahan Baku Rutin</h3>
                <p class="text-sm text-[#1A1C19]/60 leading-relaxed mb-6">
                    UMKM kuliner dan pengolahan pangan kini bisa berlangganan pasokan bahan baku langsung dari petani dengan harga khusus, stok terjamin, dan pengiriman terjadwal setiap minggu.
                </p>
                <ul class="space-y-2 text-sm text-[#1A1C19]/70 mb-8">
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs shrink-0">✓</span>
                        Harga grosir langsung dari petani
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs shrink-0">✓</span>
                        Kontrak pasokan fleksibel
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#7FB069] flex items-center justify-center text-white text-xs shrink-0">✓</span>
                        Dashboard monitoring pesanan
                    </li>
                </ul>
                <a href="#" class="mt-auto w-full bg-[#2D5A27] text-white text-sm font-semibold py-3 rounded-lg hover:bg-[#7FB069] transition text-center">
                    Daftar sebagai UMKM Mitra
                </a>
            </div>

            {{-- Card Logistik --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col hover:shadow-md transition">
                <div class="w-14 h-14 bg-[#F2A65A]/10 rounded-2xl flex items-center justify-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#F2A65A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-[#F2A65A] bg-[#F2A65A]/10 px-3 py-1 rounded-full w-fit mb-4">Mitra Logistik</span>
                <h3 class="font-bold text-[#1A1C19] text-xl mb-3">Jadi Pengantar Resmi</h3>
                <p class="text-sm text-[#1A1C19]/60 leading-relaxed mb-6">
                    Punya kendaraan atau armada pengiriman? Daftarkan diri sebagai mitra kurir Nusa Lumbung dan dapatkan order pengiriman produk pertanian secara rutin dengan sistem komisi yang transparan.
                </p>
                <ul class="space-y-2 text-sm text-[#1A1C19]/70 mb-8">
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#F2A65A] flex items-center justify-center text-white text-xs shrink-0">✓</span>
                        Order masuk otomatis via aplikasi
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#F2A65A] flex items-center justify-center text-white text-xs shrink-0">✓</span>
                        Komisi kompetitif & dibayar mingguan
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#F2A65A] flex items-center justify-center text-white text-xs shrink-0">✓</span>
                        Rute pengiriman dioptimasi AI
                    </li>
                </ul>
                <a href="#" class="mt-auto w-full bg-[#F2A65A] text-white text-sm font-semibold py-3 rounded-lg hover:bg-[#2D5A27] transition text-center">
                    Daftar sebagai Mitra Kurir
                </a>
            </div>

            {{-- Card Investasi --}}
            <div class="bg-[#1A1C19] rounded-2xl p-8 flex flex-col hover:shadow-md transition">
                <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-[#F2A65A] bg-[#F2A65A]/20 px-3 py-1 rounded-full w-fit mb-4">Pendanaan & Investasi</span>
                <h3 class="font-bold text-white text-xl mb-3">Salurkan KUR Bersama Kami</h3>
                <p class="text-sm text-white/60 leading-relaxed mb-6">
                    Lembaga keuangan dan investor dapat memanfaatkan data transaksi platform kami untuk menyalurkan Kredit Usaha Rakyat secara tepat sasaran kepada petani yang telah terverifikasi.
                </p>
                <ul class="space-y-2 text-sm text-white/70 mb-8">
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#F2A65A] flex items-center justify-center text-white text-xs shrink-0">✓</span>
                        Data petani terverifikasi & transparan
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#F2A65A] flex items-center justify-center text-white text-xs shrink-0">✓</span>
                        Rekam jejak transaksi real-time
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-[#F2A65A] flex items-center justify-center text-white text-xs shrink-0">✓</span>
                        Kemitraan strategis jangka panjang
                    </li>
                </ul>
                <a href="#" class="mt-auto w-full bg-[#F2A65A] text-white text-sm font-semibold py-3 rounded-lg hover:bg-[#7FB069] transition text-center">
                    Hubungi Tim Kami
                </a>
            </div>

        </div>
    </div>
</section>

    {{-- CTA Section --}}
    <section class="bg-[#F0F4F0] py-16 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-[#1A1C19] mb-4">
            Lumbung Pintar di Genggaman Anda
        </h2>
        <p class="text-[#1A1C19]/70 max-w-xl mx-auto mb-8 leading-relaxed">
            Kini, langkah Bapak dan Ibu untuk memajukan hasil tani tak lagi terhalang. Lewat beragam fitur kami, Nusa Lumbung hadir menemani setiap tahap perjuangan di lahan Anda.
        </p>
        <a href="#" class="inline-block">
            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Get it on Google Play" class="h-14 mx-auto">
        </a>
    </section>

@endsection