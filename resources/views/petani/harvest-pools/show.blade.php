@extends('layouts.app')

@section('title', $harvestPool->commodity_name . ' - Pooling Panen')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-12">
    <div class="mb-6">
        <a href="{{ route('petani.harvest-pools.index') }}" class="text-sm text-[#1A1C19]/60 hover:text-[#2D5A27] transition">← Kembali ke Daftar Pooling</a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-[#1A1C19] mb-2">{{ $harvestPool->commodity_name }}</h1>
                    <p class="text-sm text-[#1A1C19]/60">Dibuat oleh: {{ $harvestPool->creator->name }}</p>
                </div>
                <span class="inline-block px-4 py-1.5 bg-gray-100 text-[#1A1C19] text-sm font-semibold rounded-full">
                    {{ $harvestPool->status->value ?? $harvestPool->status }}
                </span>
            </div>

            <div class="w-full bg-gray-100 rounded-full h-3 mb-3">
                @php
                    $percent = min(100, ($harvestPool->current_qty / $harvestPool->target_qty) * 100);
                @endphp
                <div class="bg-[#F2A65A] h-3 rounded-full" style="width: {{ $percent }}%"></div>
            </div>
            
            <div class="flex items-center justify-between text-sm">
                <p class="font-semibold text-[#1A1C19]">Terkumpul: {{ number_format($harvestPool->current_qty) }} kg</p>
                <p class="text-[#1A1C19]/60">Target: {{ number_format($harvestPool->target_qty) }} kg</p>
            </div>
            
            <p class="text-xs text-red-500 font-semibold mt-4">
                Tenggat Waktu: {{ \Carbon\Carbon::parse($harvestPool->deadline)->format('d F Y') }}
            </p>
        </div>

        <div class="p-8 bg-[#F9FBF9]">
            <h2 class="text-lg font-bold text-[#1A1C19] mb-4">Anggota Pooling</h2>
            
            @if($harvestPool->members->isEmpty())
                <p class="text-sm text-[#1A1C19]/60">Belum ada anggota yang bergabung.</p>
            @else
                <ul class="space-y-3">
                    @foreach($harvestPool->members as $member)
                        <li class="flex items-center justify-between bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                            <span class="font-semibold text-[#1A1C19]">{{ $member->user->name }}</span>
                            <span class="text-[#F2A65A] font-mono font-bold">+{{ number_format($member->qty) }} kg</span>
                        </li>
                    @endforeach
                </ul>
            @endif

            @if($harvestPool->status === \App\Enums\HarvestPoolStatus::Open && $harvestPool->deadline >= now()->toDateString())
                @if(!$harvestPool->members->contains('user_id', auth()->id()))
                    <form action="{{ route('petani.harvest-pools.join', $harvestPool) }}" method="POST" class="mt-8 bg-white p-6 rounded-xl border border-gray-100">
                        @csrf
                        <h3 class="font-bold text-[#1A1C19] mb-3">Gabung ke Pooling Ini</h3>
                        <div class="flex flex-col md:flex-row gap-3 items-end">
                            <div class="flex-1 w-full">
                                <label for="qty" class="block text-sm font-semibold text-[#1A1C19] mb-1">Jumlah Kontribusi (kg)</label>
                                <input type="number" id="qty" name="qty" required min="1" max="{{ $harvestPool->target_qty - $harvestPool->current_qty }}"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-[#2D5A27] transition"
                                    placeholder="Maks: {{ $harvestPool->target_qty - $harvestPool->current_qty }}">
                            </div>
                            <button type="submit" class="w-full md:w-auto bg-[#2D5A27] text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-[#7FB069] transition">
                                Gabung
                            </button>
                        </div>
                        @error('qty') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </form>
                @else
                    <div class="mt-8 bg-[#2D5A27]/10 text-[#2D5A27] p-4 rounded-xl text-center font-semibold text-sm">
                        Anda sudah berkontribusi dalam pooling ini.
                    </div>
                @endif
            @else
                <div class="mt-8 bg-gray-100 text-gray-500 p-4 rounded-xl text-center font-semibold text-sm">
                    Pooling ini sudah tidak dapat diikuti ({{ $harvestPool->status->value ?? $harvestPool->status }}).
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
