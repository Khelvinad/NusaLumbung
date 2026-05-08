@extends('layouts.app')

@section('title', 'Daftar - Nusa Lumbung')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#F9FBF9] py-12 px-4">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-4xl w-full flex">

        {{-- Sisi Kiri - Foto --}}
        <div class="hidden md:block w-1/2 relative">
            <img src="{{ asset('images/register-bg.jpg') }}"
                alt="Pasar Tani" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-8">
                <p class="text-white font-semibold text-xl leading-snug">
                    "Bergabunglah dan Wujudkan Pertanian Indonesia yang Lebih Berdaya."
                </p>
            </div>
        </div>

        {{-- Sisi Kanan - Form --}}
        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">

            {{-- Logo --}}
            <div class="flex items-center gap-1 mb-6">
                <img src="{{ asset('images/Logo1.png') }}" alt="Nusa Lumbung" class="h-12 -mt-3">
                <div class="leading-none">
                    <p class="font-bold text-[#2D5A27] text-lg leading-tight">Nusa</p>
                    <p class="font-bold text-[#2D5A27] text-lg leading-tight">Lumbung</p>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-[#1A1C19] mb-6">Daftar Akun Baru</h2>

            <form action="#" method="POST" class="space-y-4">
                @csrf

                {{-- Nama Lengkap --}}
                <input type="text" name="name" placeholder="Nama Lengkap"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition">

                {{-- Email --}}
                <input type="email" name="email" placeholder="Email"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition">

                {{-- Nomor HP --}}
                <input type="tel" name="phone" placeholder="Nomor HP"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition">

                {{-- Role --}}
                <div>
                    <p class="text-sm text-[#1A1C19]/70 mb-2">Role:</p>
                    <div class="flex gap-6 text-sm">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="role" value="petani" checked class="accent-[#2D5A27]">
                            <span class="text-[#1A1C19]">Petani</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="role" value="pembeli" class="accent-[#2D5A27]">
                            <span class="text-[#1A1C19]">Pembeli</span>
                        </label>
                    </div>
                </div>

                {{-- Password --}}
                <div class="relative">
                    <input type="password" name="password" id="password-reg" placeholder="Password"
                        class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition pr-10">
                    <button type="button" onclick="togglePassword('password-reg', 'eye-reg')"
                        class="absolute right-3 top-3 text-gray-400 hover:text-[#2D5A27]">
                        <svg id="eye-reg" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password-confirm" placeholder="Konfirmasi Password"
                        class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition pr-10">
                    <button type="button" onclick="togglePassword('password-confirm', 'eye-confirm')"
                        class="absolute right-3 top-3 text-gray-400 hover:text-[#2D5A27]">
                        <svg id="eye-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

                {{-- Syarat & Ketentuan --}}
                <label class="flex items-center gap-2 text-sm text-[#1A1C19]/70 cursor-pointer">
                    <input type="checkbox" class="accent-[#2D5A27]">
                    Saya menyetujui <a href="#" class="text-[#2D5A27] hover:text-[#7FB069] transition">syarat & ketentuan</a>
                </label>

                {{-- Tombol Daftar --}}
                <button type="submit"
                    class="w-full bg-[#2D5A27] text-white font-semibold py-3 rounded-lg hover:bg-[#7FB069] transition">
                    Daftar
                </button>

            </form>

            <p class="text-center text-sm text-[#1A1C19]/60 mt-6">
                Sudah punya akun?
                <a href="/login" class="text-[#2D5A27] font-semibold hover:text-[#7FB069] transition">Masuk</a>
            </p>

        </div>
    </div>
</div>
@endsection