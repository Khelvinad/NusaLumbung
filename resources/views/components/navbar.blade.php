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

        <div class="flex items-center gap-4">
            {{-- Notification Bell (authenticated users only) --}}
            @auth
            <div x-data="{ open: false, count: {{ auth()->user()->unreadNotifications()->count() }}, notifications: [] }" class="relative">
                <button @click="open = !open; if(open) { fetch('/api/notifications', { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content } }).then(r => r.json()).then(d => notifications = d.data || []) }" class="relative p-1 text-[#1A1C19] hover:text-[#2D5A27] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span x-show="count > 0" x-text="count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold min-w-[18px] h-[18px] rounded-full flex items-center justify-center px-1"></span>
                </button>

                {{-- Dropdown --}}
                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden z-50">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-800">Notifikasi</h3>
                        <button x-show="count > 0" @click="fetch('/api/notifications/read-all', { method: 'POST', headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content } }).then(() => { count = 0 })" class="text-xs text-[#2D5A27] hover:underline">
                            Tandai semua dibaca
                        </button>
                    </div>
                    <div class="max-h-72 overflow-y-auto divide-y divide-gray-50">
                        <template x-for="notif in notifications" :key="notif.id">
                            <div class="px-4 py-3 hover:bg-gray-50 transition cursor-pointer" :class="{ 'bg-green-50/50': !notif.read_at }">
                                <p class="text-sm font-medium text-gray-800" x-text="notif.data.title"></p>
                                <p class="text-xs text-gray-500 mt-0.5" x-text="notif.data.message"></p>
                                <p class="text-xs text-gray-400 mt-1" x-text="new Date(notif.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' })"></p>
                            </div>
                        </template>
                        <div x-show="notifications.length === 0" class="px-4 py-6 text-center text-sm text-gray-400">
                            Belum ada notifikasi
                        </div>
                    </div>
                </div>
            </div>
            @endauth

            {{-- Icon Keranjang --}}
<a href="/keranjang" class="relative">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#1A1C19] hover:text-[#2D5A27] transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    <span id="cart-badge" class="absolute -top-2 -right-2 bg-[#F2A65A] text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center hidden">
        0
    </span>
</a>

            {{-- CTA / Auth Buttons --}}
            @guest
                <a href="/register" class="bg-[#2D5A27] text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-[#7FB069] transition">
                    Daftar Sekarang
                </a>
            @else
                <a href="{{ auth()->user()->hasRole('petani') ? route('petani.dashboard') : route('home') }}" class="text-sm font-medium text-[#2D5A27] hover:underline">
                    {{ auth()->user()->name }}
                </a>
            @endguest
        </div>

    </div>
</nav>