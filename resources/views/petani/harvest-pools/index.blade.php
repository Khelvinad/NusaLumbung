@extends('layouts.app')

@section('title', 'Pooling Panen - Nusa Lumbung')

@section('content')
<section class="bg-[#2D5A27] py-10">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-1">Pooling Panen</h1>
        <p class="text-white/70 text-sm">Gabung panen dengan petani lain untuk penuhi target pesanan besar.</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-[#1A1C19]">Daftar Pooling Aktif</h2>
        <a href="{{ route('petani.harvest-pools.create') }}"
            class="bg-[#F2A65A] text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-[#e09448] transition">
            + Buat Pool Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($pools->isEmpty())
        <div class="bg-white rounded-xl border border-gray-100 p-8 text-center">
            <p class="text-4xl mb-3">🌾</p>
            <p class="text-[#1A1C19]/50 text-sm mb-4">Belum ada pooling panen yang aktif saat ini.</p>
            <a href="{{ route('petani.harvest-pools.create') }}" class="text-[#2D5A27] font-semibold hover:underline">Mulai yang pertama!</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($pools as $pool)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition flex flex-col">
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 bg-gray-100 text-[#1A1C19] text-xs font-semibold rounded-full mb-2">
                            {{ $pool->status->value ?? $pool->status }}
                        </span>
                        <h3 class="text-lg font-bold text-[#1A1C19]">{{ $pool->commodity_name }}</h3>
                        <p class="text-xs text-[#1A1C19]/50">Terkumpul: {{ number_format($pool->current_qty) }} / {{ number_format($pool->target_qty) }} kg</p>
                    </div>

                    <div class="w-full bg-gray-100 rounded-full h-2 mb-4">
                        @php
                            $percent = min(100, ($pool->current_qty / $pool->target_qty) * 100);
                        @endphp
                        <div class="bg-[#F2A65A] h-2 rounded-full" style="width: {{ $percent }}%"></div>
                    </div>

                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                        <p class="text-xs text-[#1A1C19]/50">Tenggat: {{ \Carbon\Carbon::parse($pool->deadline)->format('d M Y') }}</p>
                        <a href="{{ route('petani.harvest-pools.show', $pool) }}" class="text-sm font-semibold text-[#2D5A27] hover:text-[#7FB069]">Detail →</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $pools->links() }}
        </div>
    @endif
</section>
@endsection
