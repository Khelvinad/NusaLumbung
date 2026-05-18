@extends('layouts.app')

@section('title', 'Notifikasi Anda - Nusa Lumbung')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-[#1A1C19]">Notifikasi Anda</h1>
        @if($notifications->count() > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-[#2D5A27] font-semibold hover:underline">Tandai Semua Dibaca</button>
            </form>
        @endif
    </div>

    @if($notifications->isEmpty())
        <div class="bg-white rounded-xl border border-gray-100 p-8 text-center shadow-sm">
            <p class="text-4xl mb-3">📭</p>
            <p class="text-[#1A1C19]/60 text-sm">Belum ada notifikasi baru untuk Anda.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($notifications as $notification)
                <div class="bg-white rounded-xl border {{ $notification->read_at ? 'border-gray-100 opacity-70' : 'border-[#2D5A27] shadow-sm' }} p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[#1A1C19] text-sm">{{ $notification->data['message'] ?? 'Pemberitahuan Baru' }}</p>
                            <p class="text-xs text-[#1A1C19]/50 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        @if(!$notification->read_at)
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs bg-gray-100 px-3 py-1 rounded-full hover:bg-gray-200 transition">Tandai Dibaca</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
