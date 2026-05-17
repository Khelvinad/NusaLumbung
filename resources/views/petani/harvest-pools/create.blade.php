@extends('layouts.app')

@section('title', 'Buat Pooling Panen - Nusa Lumbung')

@section('content')
<section class="max-w-3xl mx-auto px-6 py-12">
    <div class="mb-8">
        <a href="{{ route('petani.harvest-pools.index') }}" class="text-sm text-[#1A1C19]/60 hover:text-[#2D5A27] transition">← Kembali ke Daftar Pooling</a>
        <h1 class="text-2xl font-bold text-[#1A1C19] mt-2">Buat Pooling Panen</h1>
        <p class="text-sm text-[#1A1C19]/60">Isi detail pooling panen yang ingin Anda mulai.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-6 md:p-8 shadow-sm">
        <form action="{{ route('petani.harvest-pools.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="commodity_name" class="block text-sm font-semibold text-[#1A1C19] mb-1">Nama Komoditas</label>
                <input type="text" id="commodity_name" name="commodity_name" value="{{ old('commodity_name') }}"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition"
                    placeholder="Contoh: Jagung Manis Super">
                @error('commodity_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="target_qty" class="block text-sm font-semibold text-[#1A1C19] mb-1">Target Kuantitas (kg)</label>
                <input type="number" id="target_qty" name="target_qty" value="{{ old('target_qty') }}" min="1"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition"
                    placeholder="Contoh: 1000">
                @error('target_qty') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="deadline" class="block text-sm font-semibold text-[#1A1C19] mb-1">Tenggat Waktu</label>
                <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition">
                @error('deadline') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-[#2D5A27] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#7FB069] transition">
                    Buat Pooling
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
