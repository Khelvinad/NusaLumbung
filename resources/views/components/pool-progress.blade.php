@props([
    'komoditas' => '',
    'terkumpul' => 0,
    'target' => 0,
    'satuan' => 'kg',
    'pembeli' => ''
])

@php
    $persen = $target > 0 ? min(($terkumpul / $target) * 100, 100) : 0;
    $warna = $persen >= 80 ? 'bg-[#F2A65A]' : ($persen >= 50 ? 'bg-[#7FB069]' : 'bg-[#D32F2F]');
    $sisanya = $target - $terkumpul;
@endphp

<div class="bg-white/5 rounded-xl p-4">
    <div class="flex items-center justify-between mb-2">
        <p class="text-white text-sm font-semibold">{{ $komoditas }}</p>
        <span class="text-xs text-[#F2A65A] font-mono">
            {{ number_format($terkumpul, 0, ',', '.') }}/{{ number_format($target, 0, ',', '.') }} {{ $satuan }}
        </span>
    </div>
    <div class="w-full bg-white/10 rounded-full h-2 mb-2">
        <div class="{{ $warna }} h-2 rounded-full transition-all duration-500" style="width: {{ $persen }}%"></div>
    </div>
    <p class="text-xs text-white/40">
        Butuh {{ number_format($sisanya, 0, ',', '.') }}{{ $satuan }} lagi · {{ $pembeli }}
    </p>
</div>