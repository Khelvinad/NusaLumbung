<footer class="bg-[#2D5A27] text-white mt-20">
    <div class="max-w-7xl mx-auto px-6 py-12">

        <div class="flex flex-col md:flex-row justify-between gap-10">

            {{-- Brand --}}
            <div class="max-w-xs">
                <a href="/" class="flex items-center gap-1 mb-4">
                    <img src="{{ asset('images/Logo1.png') }}" alt="Nusa Lumbung" class="h-12 -mt-3">
                    <div class="leading-none">
                        <p class="font-bold text-white text-lg leading-tight">Nusa</p>
                        <p class="font-bold text-white text-lg leading-tight">Lumbung</p>
                    </div>
                </a>
                <p class="text-sm text-white/70 leading-relaxed">
                    Menghubungkan petani langsung ke konsumen. Platform agritech modern untuk Indonesia.
                </p>
            </div>

            {{-- Links --}}
            <div class="grid grid-cols-3 gap-8 text-sm">
                <div>
                    <h4 class="font-semibold mb-3 text-[#F2A65A]">Platform</h4>
                    <ul class="space-y-2 text-white/70">
                        <li><a href="/" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('produk.index') }}" class="hover:text-white transition">Produk</a></li>
                        <li><a href="/#fitur" class="hover:text-white transition">Fitur</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-3 text-[#F2A65A]">Komunitas</h4>
                    <ul class="space-y-2 text-white/70">
                        <li><a href="/#komunitas" class="hover:text-white transition">Forum</a></li>
                        <li><a href="/#kerjasama" class="hover:text-white transition">Kerja Sama</a></li>
                        <li><a href="/#tentang" class="hover:text-white transition">Tentang Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-3 text-[#F2A65A]">Kontak</h4>
                    <ul class="space-y-2 text-white/70">
                        <li>info@nusalumbung.id</li>
                        <li>+62 812 3456 7890</li>
                    </ul>
                </div>
            </div>

        </div>

        {{-- Bottom --}}
        <div class="border-t border-white/20 mt-10 pt-6 text-center text-sm text-white/50">
            © {{ date('Y') }} Nusa Lumbung. All rights reserved.
        </div>

    </div>
</footer>