@props(['komoditas' => []])

<div class="bg-[#1A1C19] overflow-hidden py-3">
    <div class="flex animate-marquee whitespace-nowrap gap-8 px-6" id="ticker-content">
        @foreach($komoditas as $item)
        <span class="inline-flex items-center gap-2 text-sm">
            <span class="text-white/60">{{ $item['nama'] }}</span>
            <span class="text-[#F2A65A] font-mono font-bold">
                Rp {{ number_format($item['harga'], 0, ',', '.') }}
            </span>
            @if($item['naik'])
                <span class="text-[#7FB069] text-xs">▲ {{ $item['perubahan'] }}%</span>
            @else
                <span class="text-[#D32F2F] text-xs">▼ {{ $item['perubahan'] }}%</span>
            @endif
            <span class="text-white/20">|</span>
        </span>
        @endforeach
    </div>
</div>

<style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-marquee {
        animation: marquee 20s linear infinite;
        display: inline-flex;
        width: max-content;
    }
</style>