@extends('layouts.app')

@section('title', 'Keranjang - Nusa Lumbung')

@section('content')

{{-- Header --}}
<section class="bg-[#2D5A27] py-12">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-3xl font-extrabold text-white mb-2">Keranjang Belanja</h1>
        <p class="text-white/70">Periksa pesanan kamu sebelum checkout.</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Daftar Item --}}
        <div class="w-full lg:w-2/3">
            <div id="keranjang-list" class="space-y-4">
                {{-- Diisi oleh JavaScript --}}
            </div>

            {{-- Keranjang Kosong --}}
            <div id="keranjang-kosong" class="hidden text-center py-20">
                <p class="text-6xl mb-4">🛒</p>
                <h3 class="text-xl font-bold text-[#1A1C19] mb-2">Keranjang Masih Kosong</h3>
                <p class="text-[#1A1C19]/60 mb-6">Yuk, tambahkan produk dari marketplace!</p>
                <a href="/produk" class="bg-[#2D5A27] text-white font-semibold px-8 py-3 rounded-lg hover:bg-[#7FB069] transition">
                    Ke Marketplace
                </a>
            </div>
        </div>

        {{-- Summary --}}
        <div class="w-full lg:w-1/3">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h3 class="font-bold text-[#1A1C19] text-lg mb-5">Ringkasan Pesanan</h3>

                <div class="space-y-3 mb-5">
                    <div class="flex justify-between text-sm text-[#1A1C19]/70">
                        <span>Total Item</span>
                        <span id="summary-item">0 item</span>
                    </div>
                    <div class="flex justify-between text-sm text-[#1A1C19]/70">
                        <span>Subtotal</span>
                        <span id="summary-subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-sm text-[#1A1C19]/70">
                        <span>Ongkir</span>
                        <span class="text-[#7FB069] font-semibold">Gratis</span>
                    </div>
                    <div class="border-t border-gray-100 pt-3 flex justify-between font-bold text-[#1A1C19]">
                        <span>Total</span>
                        <span id="summary-total" class="text-[#F2A65A] font-mono">Rp 0</span>
                    </div>
                </div>

                <button onclick="checkout()"
                    class="w-full bg-[#2D5A27] text-white font-semibold py-3 rounded-lg hover:bg-[#7FB069] transition mb-3">
                    Checkout Sekarang
                </button>
                <a href="/produk"
                    class="block text-center text-sm text-[#1A1C19]/60 hover:text-[#2D5A27] transition">
                    ← Lanjut Belanja
                </a>
            </div>
        </div>

    </div>
</section>

<script>
    let keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    function renderKeranjang() {
        const list = document.getElementById('keranjang-list');
        const kosong = document.getElementById('keranjang-kosong');

        if (keranjang.length === 0) {
            list.classList.add('hidden');
            kosong.classList.remove('hidden');
            updateSummary();
            return;
        }

        list.classList.remove('hidden');
        kosong.classList.add('hidden');

        list.innerHTML = keranjang.map((item, index) => `
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="w-16 h-16 bg-[#F9FBF9] rounded-xl flex items-center justify-center text-2xl shrink-0">
                    🌾
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-[#1A1C19]">${item.nama}</h4>
                    <p class="text-sm text-[#F2A65A] font-mono font-bold">${formatRupiah(item.harga)}</p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="kurangiQty(${index})"
                        class="w-8 h-8 rounded-full border-2 border-gray-200 flex items-center justify-center text-[#1A1C19] hover:border-[#2D5A27] hover:text-[#2D5A27] transition font-bold">
                        -
                    </button>
                    <span class="font-bold text-[#1A1C19] w-6 text-center">${item.qty}</span>
                    <button onclick="tambahQty(${index})"
                        class="w-8 h-8 rounded-full border-2 border-gray-200 flex items-center justify-center text-[#1A1C19] hover:border-[#2D5A27] hover:text-[#2D5A27] transition font-bold">
                        +
                    </button>
                </div>
                <div class="text-right shrink-0">
                    <p class="font-bold text-[#1A1C19] font-mono">${formatRupiah(item.harga * item.qty)}</p>
                    <button onclick="hapusItem(${index})"
                        class="text-xs text-[#D32F2F] hover:underline mt-1">
                        Hapus
                    </button>
                </div>
            </div>
        `).join('');

        updateSummary();
    }

    function updateSummary() {
        const totalItem = keranjang.reduce((sum, item) => sum + item.qty, 0);
        const subtotal = keranjang.reduce((sum, item) => sum + (item.harga * item.qty), 0);

        document.getElementById('summary-item').textContent = totalItem + ' item';
        document.getElementById('summary-subtotal').textContent = formatRupiah(subtotal);
        document.getElementById('summary-total').textContent = formatRupiah(subtotal);

        // Update badge navbar
        const badge = document.getElementById('cart-badge');
        if (badge) {
            if (totalItem > 0) {
                badge.textContent = totalItem;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    }

    function tambahQty(index) {
        keranjang[index].qty += 1;
        localStorage.setItem('keranjang', JSON.stringify(keranjang));
        renderKeranjang();
    }

    function kurangiQty(index) {
        if (keranjang[index].qty > 1) {
            keranjang[index].qty -= 1;
        } else {
            keranjang.splice(index, 1);
        }
        localStorage.setItem('keranjang', JSON.stringify(keranjang));
        renderKeranjang();
    }

    function hapusItem(index) {
        keranjang.splice(index, 1);
        localStorage.setItem('keranjang', JSON.stringify(keranjang));
        renderKeranjang();
    }

    function checkout() {
        if (keranjang.length === 0) {
            alert('Keranjang masih kosong!');
            return;
        }
        window.location.href = '/checkout';
    }

    renderKeranjang();
</script>

@endsection