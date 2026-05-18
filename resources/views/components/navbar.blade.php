<nav class="bg-white shadow-sm sticky top-0 z-50" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-0">
            <img src="{{ asset('images/Logo1.png') }}" alt="Nusa Lumbung" class="h-12 -mt-3">
            <div class="leading-none -ml-1 -mt-0">
                <p class="font-bold text-[#2D5A27] text-lg leading-tight">Nusa</p>
                <p class="font-bold text-[#2D5A27] text-lg leading-tight">Lumbung</p>
            </div>
        </a>

        {{-- Nav Links (desktop) --}}
        <ul class="hidden md:flex items-center gap-8 text-sm font-medium text-[#1A1C19]">
            <li><a href="/" class="hover:text-[#2D5A27] transition">Beranda</a></li>
            <li><a href="{{ route('produk.index') }}" class="hover:text-[#2D5A27] transition">Produk</a></li>
            <li><a href="/#fitur" class="hover:text-[#2D5A27] transition">Fitur</a></li>
            <li><a href="/#komunitas" class="hover:text-[#2D5A27] transition">Komunitas</a></li>
            <li><a href="/#tentang" class="hover:text-[#2D5A27] transition">Tentang Kami</a></li>
            <li><a href="/#kerjasama" class="hover:text-[#2D5A27] transition">Kerja Sama</a></li>
        </ul>

        <div class="flex items-center gap-4">

            {{-- Notification Bell (authenticated users only) --}}
            @auth
            <div x-data="notificationBell()" class="relative">
                <button @click="toggle()" class="relative p-1 text-[#1A1C19] hover:text-[#2D5A27] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span x-show="count > 0" x-text="count"
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold min-w-[18px] h-[18px] rounded-full flex items-center justify-center px-1"></span>
                </button>

                {{-- Dropdown --}}
                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden z-50">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-800">Notifikasi</h3>
                        <button x-show="count > 0" @click="markAllRead()" class="text-xs text-[#2D5A27] hover:underline">
                            Tandai semua dibaca
                        </button>
                    </div>
                    <div class="max-h-72 overflow-y-auto divide-y divide-gray-50">
                        <template x-for="notif in notifications" :key="notif.id">
                            <div class="px-4 py-3 hover:bg-gray-50 transition cursor-pointer"
                                :class="{ 'bg-green-50/50': !notif.read_at }">
                                <p class="text-sm font-medium text-gray-800" x-text="notif.data?.title || 'Notifikasi'"></p>
                                <p class="text-xs text-gray-500 mt-0.5" x-text="notif.data?.message || ''"></p>
                                <p class="text-xs text-gray-400 mt-1"
                                    x-text="new Date(notif.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' })"></p>
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
            <a href="{{ route('keranjang') }}" class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#1A1C19] hover:text-[#2D5A27] transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span id="cart-badge" class="absolute -top-2 -right-2 bg-[#F2A65A] text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center hidden">
                    0
                </span>
            </a>

            {{-- Auth Buttons / User Dropdown --}}
            @guest
                <a href="{{ route('login') }}" class="text-sm font-medium text-[#2D5A27] hover:text-[#7FB069] transition hidden sm:block">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="bg-[#2D5A27] text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-[#7FB069] transition">
                    Daftar Sekarang
                </a>
            @else
                {{-- User Dropdown --}}
                <div x-data="{ userOpen: false }" class="relative">
                    <button @click="userOpen = !userOpen"
                        class="flex items-center gap-2 text-sm font-medium text-[#2D5A27] hover:text-[#7FB069] transition">
                        <div class="w-8 h-8 rounded-full bg-[#2D5A27]/10 flex items-center justify-center text-xs font-bold text-[#2D5A27]">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="userOpen" @click.away="userOpen = false" x-transition
                        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50 py-1">

                        {{-- Dashboard (petani only) --}}
                        @if(auth()->user()->hasRole('petani'))
                            <a href="{{ route('petani.dashboard') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                Dashboard Petani
                            </a>
                        @endif

                        {{-- Orders (pembeli) --}}
                        @if(auth()->user()->hasRole('pembeli'))
                            <a href="{{ route('pembeli.orders.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Pesanan Saya
                            </a>
                        @endif

                        {{-- Profile --}}
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Edit Profil
                        </a>

                        <div class="border-t border-gray-100 my-1"></div>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}" onsubmit="localStorage.removeItem('keranjang')">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition w-full">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @endguest

            {{-- Mobile Hamburger --}}
            <button @click="mobileOpen = !mobileOpen" class="md:hidden p-1 text-[#1A1C19]">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen" x-transition class="md:hidden bg-white border-t border-gray-100 px-6 py-4 space-y-3">
        <a href="/" class="block text-sm font-medium text-[#1A1C19] hover:text-[#2D5A27]">Beranda</a>
        <a href="{{ route('produk.index') }}" class="block text-sm font-medium text-[#1A1C19] hover:text-[#2D5A27]">Produk</a>
        <a href="/#fitur" class="block text-sm font-medium text-[#1A1C19] hover:text-[#2D5A27]">Fitur</a>
        <a href="/#komunitas" class="block text-sm font-medium text-[#1A1C19] hover:text-[#2D5A27]">Komunitas</a>
        <a href="/#tentang" class="block text-sm font-medium text-[#1A1C19] hover:text-[#2D5A27]">Tentang Kami</a>
        <a href="/#kerjasama" class="block text-sm font-medium text-[#1A1C19] hover:text-[#2D5A27]">Kerja Sama</a>
        @guest
            <div class="pt-3 border-t border-gray-100 flex gap-3">
                <a href="{{ route('login') }}" class="text-sm font-medium text-[#2D5A27]">Masuk</a>
                <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-[#2D5A27] px-4 py-2 rounded-lg">Daftar</a>
            </div>
        @endguest
    </div>
</nav>

@auth
<script>
function notificationBell() {
    return {
        open: false,
        count: {{ auth()->user()->unreadNotifications()->count() }},
        notifications: [],

        toggle() {
            this.open = !this.open;
            if (this.open) this.fetchNotifications();
        },

        async fetchNotifications() {
            try {
                const res = await fetch('{{ route("notifications.index") }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content
                    },
                    credentials: 'same-origin'
                });
                if (res.ok) {
                    const data = await res.json();
                    this.notifications = data.data || [];
                }
            } catch (e) {
                console.error('Failed to fetch notifications:', e);
            }
        },

        async markAllRead() {
            try {
                await fetch('{{ route("notifications.read-all") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content
                    },
                    credentials: 'same-origin'
                });
                this.count = 0;
                this.notifications = this.notifications.map(n => ({...n, read_at: new Date().toISOString()}));
            } catch (e) {
                console.error('Failed to mark all read:', e);
            }
        }
    };
}
</script>
@endauth