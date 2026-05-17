@extends('layouts.app')

@section('title', 'Pesanan Saya - Nusa Lumbung')

@section('content')

<section class="bg-[#2D5A27] py-10">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-1">Pesanan Saya</h1>
        <p class="text-white/70 text-sm">Lacak dan kelola pesanan Anda.</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-6 py-8">
    @if($orders->isEmpty())
        <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-5xl mb-4">🛒</p>
            <h3 class="text-xl font-bold text-[#1A1C19] mb-2">Belum ada pesanan</h3>
            <p class="text-[#1A1C19]/50 text-sm mb-6">Mulai belanja produk segar langsung dari petani.</p>
            <a href="{{ route('produk.index') }}"
                class="bg-[#2D5A27] text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-[#7FB069] transition">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 md:p-6 flex flex-col md:flex-row gap-6 justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="font-bold text-[#1A1C19]">Order #{{ $order->id }}</span>
                            <span class="text-xs px-2 py-1 bg-gray-100 rounded-md font-medium text-gray-600">
                                {{ $order->created_at->format('d M Y') }}
                            </span>
                            <x-order-status-badge :status="$order->status->value ?? $order->status" />
                        </div>
                        <p class="text-sm text-[#1A1C19]/70 mb-4">
                            Petani: <span class="font-semibold">{{ $order->petani->name }}</span>
                        </p>
                        
                        <div class="space-y-2">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-3 text-sm">
                                    <div class="w-10 h-10 bg-gray-50 rounded border border-gray-100 overflow-hidden shrink-0">
                                        @if($item->product->photo_path)
                                            <img src="{{ asset('storage/' . $item->product->photo_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-lg">🌾</div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-[#1A1C19]">{{ $item->product->name }}</p>
                                        <p class="text-xs text-[#1A1C19]/50">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="flex flex-col md:items-end justify-between border-t md:border-t-0 pt-4 md:pt-0 mt-2 md:mt-0">
                        <div class="mb-4 md:text-right">
                            <p class="text-sm text-[#1A1C19]/50 mb-1">Total Belanja</p>
                            <p class="text-lg font-bold text-[#F2A65A]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                        
                        {{-- Aksi untuk pembeli, misalnya selesaikan pesanan jika sedang dikirim --}}
                        @if(($order->status->value ?? $order->status) === 'shipped')
                            <form action="{{ route('pembeli.orders.update-status', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="done">
                                <button type="submit" class="bg-[#2D5A27] text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-[#7FB069] transition w-full md:w-auto text-center">
                                    Pesanan Diterima
                                </button>
                            </form>
                        @elseif(($order->status->value ?? $order->status) === 'done')
                            @if($order->reviews->isEmpty())
                                <div class="mt-4 p-4 border border-gray-100 rounded-xl bg-[#F9FBF9]">
                                    <h4 class="text-sm font-bold text-[#1A1C19] mb-2">Beri Penilaian</h4>
                                    <form action="{{ route('pembeli.reviews.store', $order) }}" method="POST" class="space-y-3">
                                        @csrf
                                        <div>
                                            <select name="rating" required class="w-full text-sm border-gray-200 rounded-lg focus:border-[#2D5A27] focus:ring-0">
                                                <option value="">Pilih Bintang</option>
                                                <option value="5">⭐⭐⭐⭐⭐ (Sangat Baik)</option>
                                                <option value="4">⭐⭐⭐⭐ (Baik)</option>
                                                <option value="3">⭐⭐⭐ (Cukup)</option>
                                                <option value="2">⭐⭐ (Kurang)</option>
                                                <option value="1">⭐ (Buruk)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <textarea name="comment" rows="2" class="w-full text-sm border-gray-200 rounded-lg focus:border-[#2D5A27] focus:ring-0" placeholder="Tulis komentar..."></textarea>
                                        </div>
                                        <button type="submit" class="w-full bg-[#F2A65A] text-white text-xs font-bold py-2 rounded-lg hover:bg-[#e09448] transition">Kirim Review</button>
                                    </form>
                                </div>
                            @else
                                <div class="mt-4 p-3 border border-gray-100 rounded-xl bg-gray-50 flex flex-col gap-1">
                                    <p class="text-xs text-[#1A1C19]/50 font-semibold">Penilaian Anda:</p>
                                    <p class="text-sm">
                                        {{ str_repeat('⭐', $order->reviews->first()->rating) }}
                                    </p>
                                    @if($order->reviews->first()->comment)
                                        <p class="text-xs text-[#1A1C19] italic">"{{ $order->reviews->first()->comment }}"</p>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($orders, 'links') && $orders->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $orders->links() }}
            </div>
        @endif
    @endif
</section>

@endsection
