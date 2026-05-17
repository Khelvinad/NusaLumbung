@props([
    'gambar' => '',
    'kategori' => '',
    'nama' => '',
    'asal' => '',
    'harga' => 0,
    'satuan' => 'kg',
    'stok' => 'Tersedia',
    'dataKategori' => ''
])

<div class="produk-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition" 
    data-kategori="{{ $dataKategori }}">
    <div class="relative h-48 overflow-hidden">
        <img src="{{ asset('images/' . $gambar) }}" 
            alt="{{ $nama }}" 
            class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
        <span class="absolute top-3 left-3 bg-white text-[#2D5A27] text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
            {{ $kategori }}
        </span>
    </div>
    <div class="p-4">
        <h3 class="font-bold text-[#1A1C19] mb-1">{{ $nama }}</h3>
        <p class="text-xs text-[#1A1C19]/50 mb-3">{{ $asal }}</p>
        <div class="flex items-center justify-between mb-3">
            <p class="text-[#F2A65A] font-bold font-mono">
                Rp {{ number_format($harga, 0, ',', '.') }}
                <span class="text-xs font-normal text-[#1A1C19]/50">/ {{ $satuan }}</span>
            </p>
            <x-order-status-badge :status="$stok" />
        </div>
        <button onclick="tambahKeKeranjang('{{ $nama }}', {{ $harga }})" 
            class="w-full bg-[#2D5A27] text-white text-sm font-semibold py-2 rounded-lg hover:bg-[#7FB069] transition">
            + Keranjang
        </button>
    </div>
</div>