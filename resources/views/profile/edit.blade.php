@extends('layouts.app')
@section('title', 'Edit Profil - Nusa Lumbung')
@section('content')

<section class="bg-[#2D5A27] py-10">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-1">Pengaturan Profil</h1>
        <p class="text-white/70 text-sm">Kelola informasi akun dan pengaturan keamanan Anda.</p>
    </div>
</section>

<div class="py-12 bg-[#F9FBF9] min-h-screen">
    <div class="max-w-4xl mx-auto px-6 space-y-8">
        
        {{-- Profile Info --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-6 md:p-8">
            <h2 class="text-lg font-bold text-[#1A1C19] mb-1">Informasi Profil</h2>
            <p class="text-sm text-[#1A1C19]/50 mb-6">Perbarui informasi nama dan email akun Anda.</p>
            
            <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
                @csrf
                @method('patch')

                <div>
                    <label for="name" class="block text-sm font-semibold text-[#1A1C19] mb-1">Nama</label>
                    <input id="name" name="name" type="text" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-[#1A1C19] mb-1">Email</label>
                    <input id="email" name="email" type="email" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-[#1A1C19] mb-1">No. HP / WhatsApp</label>
                    <input id="phone" name="phone" type="text" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition" value="{{ old('phone', $user->phone) }}" />
                    @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-[#1A1C19] mb-1">Alamat Lengkap</label>
                    <textarea id="address" name="address" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition">{{ old('address', $user->address) }}</textarea>
                    @error('address') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                @if($user->hasRole('petani'))
                    <hr class="border-gray-100 my-6">
                    <h3 class="text-md font-bold text-[#1A1C19] mb-2">Profil Lahan & Usaha Tani</h3>
                    
                    <div>
                        <label for="farm_name" class="block text-sm font-semibold text-[#1A1C19] mb-1">Nama Lahan / Kelompok Tani</label>
                        <input id="farm_name" name="farm_name" type="text" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition" value="{{ old('farm_name', optional($user->petaniProfile)->farm_name) }}" />
                        @error('farm_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-semibold text-[#1A1C19] mb-1">Lokasi Lahan (Kota/Kabupaten)</label>
                        <input id="location" name="location" type="text" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition" value="{{ old('location', optional($user->petaniProfile)->location) }}" />
                        @error('location') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="bio" class="block text-sm font-semibold text-[#1A1C19] mb-1">Deskripsi / Bio Lahan</label>
                        <textarea id="bio" name="bio" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition">{{ old('bio', optional($user->petaniProfile)->bio) }}</textarea>
                        @error('bio') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif

                <div class="flex items-center gap-4 pt-2">
                    <button type="submit" class="bg-[#2D5A27] text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-[#7FB069] transition">
                        Simpan Perubahan
                    </button>
                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-medium text-green-600">Berhasil disimpan.</p>
                    @endif
                </div>
            </form>
        </div>

        {{-- Update Password --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-6 md:p-8">
            <h2 class="text-lg font-bold text-[#1A1C19] mb-1">Ubah Password</h2>
            <p class="text-sm text-[#1A1C19]/50 mb-6">Pastikan akun Anda menggunakan password yang panjang dan aman.</p>
            
            <form method="post" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                @method('put')

                <div>
                    <label for="update_password_current_password" class="block text-sm font-semibold text-[#1A1C19] mb-1">Password Saat Ini</label>
                    <input id="update_password_current_password" name="current_password" type="password" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition" autocomplete="current-password" />
                    @error('current_password', 'updatePassword') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="update_password_password" class="block text-sm font-semibold text-[#1A1C19] mb-1">Password Baru</label>
                    <input id="update_password_password" name="password" type="password" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition" autocomplete="new-password" />
                    @error('password', 'updatePassword') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="update_password_password_confirmation" class="block text-sm font-semibold text-[#1A1C19] mb-1">Konfirmasi Password Baru</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#2D5A27] transition" autocomplete="new-password" />
                    @error('password_confirmation', 'updatePassword') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <button type="submit" class="bg-[#1A1C19] text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-gray-800 transition">
                        Simpan Password
                    </button>
                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-medium text-green-600">Password diperbarui.</p>
                    @endif
                </div>
            </form>
        </div>

        {{-- Delete Account --}}
        <div class="bg-red-50 border border-red-100 shadow-sm rounded-xl p-6 md:p-8">
            <h2 class="text-lg font-bold text-red-600 mb-1">Hapus Akun</h2>
            <p class="text-sm text-red-500/80 mb-6">Sekali akun dihapus, semua data dan riwayat pesanan akan terhapus secara permanen.</p>
            
            <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak bisa dibatalkan.')">
                @csrf
                @method('delete')
                
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-red-900 mb-1">Masukkan password Anda untuk konfirmasi</label>
                    <input id="password" name="password" type="password" class="w-full md:w-1/2 border border-red-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-red-500 transition" placeholder="Password" />
                    @error('password', 'userDeletion') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="bg-red-600 text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-red-700 transition">
                    Hapus Akun Permanen
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
