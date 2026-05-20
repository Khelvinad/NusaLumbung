@extends('layouts.app')

@section('title', 'Dashboard Petani - Nusa Lumbung')

@section('content')

{{-- Header --}}
<section class="bg-[#2D5A27] py-10">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-1">Dashboard Petani</h1>
        <p class="text-white/70 text-sm">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>
</section>

{{-- Stats Cards --}}
<section class="max-w-7xl mx-auto px-6 -mt-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-[#1A1C19]/50 mb-1">Total Produk</p>
            <p class="text-2xl font-bold text-[#2D5A27] font-mono">{{ $totalProduk }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-[#1A1C19]/50 mb-1">Total Order</p>
            <p class="text-2xl font-bold text-[#1A1C19] font-mono">{{ $totalOrder }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-[#1A1C19]/50 mb-1">Order Baru</p>
            <p class="text-2xl font-bold text-[#F2A65A] font-mono">{{ $orderBaru }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-[#1A1C19]/50 mb-1">Pendapatan</p>
            <p class="text-2xl font-bold text-[#7FB069] font-mono">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
    </div>
</section>

{{-- Quick Actions --}}
<section class="max-w-7xl mx-auto px-6 py-8">
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('petani.produk.index') }}"
            class="bg-[#2D5A27] text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-[#7FB069] transition">
            📦 Kelola Produk
        </a>
        <a href="{{ route('petani.produk.create') }}"
            class="bg-white border-2 border-[#2D5A27] text-[#2D5A27] text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-[#2D5A27] hover:text-white transition">
            + Tambah Produk
        </a>
        <a href="{{ route('petani.harvest-pools.index') }}"
            class="bg-white border-2 border-[#F2A65A] text-[#F2A65A] text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-[#F2A65A] hover:text-white transition">
            🌾 Pooling Panen
        </a>
    </div>

    {{-- Order Terbaru --}}
    <h2 class="text-lg font-bold text-[#1A1C19] mb-4">Order Terbaru</h2>
    @if($orderTerbaru->isEmpty())
        <div class="bg-white rounded-xl border border-gray-100 p-8 text-center">
            <p class="text-4xl mb-3">📋</p>
            <p class="text-[#1A1C19]/50 text-sm">Belum ada order masuk.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($orderTerbaru as $order)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-[#1A1C19] text-sm">
                            Order #{{ $order->id }} — {{ $order->pembeli->name ?? 'Pembeli' }}
                        </p>
                        <p class="text-xs text-[#1A1C19]/50 mt-0.5 mb-2">
                            {{ $order->created_at->diffForHumans() }}
                        </p>
                        <div class="text-xs text-[#1A1C19]/70 bg-gray-50 p-2 rounded border border-gray-100 mb-2">
                            <p><strong>No HP:</strong> {{ $order->pembeli->phone ?? '-' }}</p>
                            <p><strong>Alamat:</strong> {{ $order->pembeli->address ?? '-' }}</p>
                        </div>
                        <div class="mt-2 flex gap-2">
                            @if(($order->status->value ?? $order->status) === 'pending')
                                <form action="{{ route('petani.orders.confirm', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-[#2D5A27] text-white text-xs px-3 py-1 rounded hover:bg-[#7FB069] transition">Konfirmasi</button>
                                </form>
                            @elseif(($order->status->value ?? $order->status) === 'confirmed')
                                <form action="{{ route('petani.orders.update-status', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="shipped">
                                    <button type="submit" class="bg-[#F2A65A] text-white text-xs px-3 py-1 rounded hover:bg-[#e09448] transition">Kirim Barang</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-mono font-bold text-[#F2A65A]">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </span>
                        <x-order-status-badge :status="$order->status->value ?? $order->status" />
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

@endsection
