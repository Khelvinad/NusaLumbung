<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-0">
    <img src="{{ asset('images/Logo1.png') }}" alt="Nusa Lumbung" class="h-12 -mt-3">
    <div class="leading-none -ml-1 -mt-0">
        <p class="font-bold text-[#2D5A27] text-lg leading-tight">Nusa</p>
        <p class="font-bold text-[#2D5A27] text-lg leading-tight">Lumbung</p>
    </div>
</a>

        {{-- Nav Links --}}
        <ul class="hidden md:flex items-center gap-8 text-sm font-medium text-[#1A1C19]">
            <li><a href="/" class="hover:text-[#2D5A27] transition">Beranda</a></li>
            <li><a href="/#produk" class="hover:text-[#2D5A27] transition">Produk</a></li>
            <li><a href="/#fitur" class="hover:text-[#2D5A27] transition">Fitur</a></li>
            <li><a href="/#komunitas" class="hover:text-[#2D5A27] transition">Komunitas</a></li>
            <li><a href="/#tentang" class="hover:text-[#2D5A27] transition">Tentang Kami</a></li>
            <li><a href="/#kerjasama" class="hover:text-[#2D5A27] transition">Kerja Sama</a></li>
        </ul>

        {{-- Icon Keranjang --}}
<a href="/keranjang" class="relative">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#1A1C19] hover:text-[#2D5A27] transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    <span id="cart-badge" class="absolute -top-2 -right-2 bg-[#F2A65A] text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center hidden">
        0
    </span>
</a>


        {{-- CTA Button --}}
        <a href="/register" class="bg-[#2D5A27] text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-[#7FB069] transition">
    Daftar Sekarang
</a>

    </div>
</nav>