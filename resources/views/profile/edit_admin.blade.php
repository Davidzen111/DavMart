@extends('layouts.admin')

@section('title', 'Pengaturan Akun - Admin')

@section('content')

    {{-- WRAPPER KONTEN (Dibatasi lebarnya agar rapih untuk form) --}}
    <div class="max-w-3xl mx-auto space-y-6 pt-8">
        
        {{-- LOGIKA PENENTUAN RUTE KEMBALI DINAMIS --}}
        @auth
            @php
                // Menentukan rute kembali berdasarkan peran (role) pengguna yang sedang login
                $backRoute = match (Auth::user()->role) {
                    'admin' => route('admin.dashboard'),
                    'seller' => route('seller.dashboard'),
                    default => route('dashboard'), // Buyer/Default
                };
                $ariaLabel = match (Auth::user()->role) {
                    'admin' => 'Kembali ke Dashboard Admin',
                    'seller' => 'Kembali ke Dashboard Toko',
                    default => 'Kembali ke Dashboard Saya',
                };
            @endphp
        @endauth

        {{-- HEADER HALAMAN KUSTOM (Tombol Kembali Dinamis) --}}
        <div class="mb-8 flex items-center gap-4">
            {{-- Tombol Kembali Dinamis --}}
            <a href="{{ $backRoute ?? route('admin.dashboard') }}" 
               class="group flex items-center justify-center w-10 h-10 bg-white border border-gray-200 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 ease-in-out shadow-sm"
               aria-label="{{ $ariaLabel ?? 'Kembali' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-200 group-hover:-translate-x-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>

            <h1 class="text-3xl font-bold text-gray-800 leading-tight">Pengaturan Akun</h1>
        </div>
        
        {{-- 1. Form Informasi Profil --}}
        <div class="p-6 bg-white shadow-sm sm:rounded-xl border border-gray-100">
            <header>
                <h2 class="text-lg font-bold text-gray-800">Informasi Profil</h2>
                <p class="mt-1 text-sm text-gray-500">Perbarui informasi profil akun dan alamat email Anda.</p>
            </header>

            <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="bg-red-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-red-700 transition shadow-md hover:shadow-lg">
                        Simpan Perubahan
                    </button>

                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Tersimpan!
                        </p>
                    @endif
                </div>
            </form>
        </div>

        {{-- 2. Form Ganti Password --}}
        <div class="p-6 bg-white shadow-sm sm:rounded-xl border border-gray-100">
            <header>
                <h2 class="text-lg font-bold text-gray-800">Ganti Kata Sandi</h2>
                <p class="mt-1 text-sm text-gray-500">Pastikan akun Anda aman dengan menggunakan kata sandi yang kuat.</p>
            </header>

            <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('put')

                <div>
                    <x-input-label for="current_password" :value="__('Kata Sandi Saat Ini')" />
                    <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm" autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Kata Sandi Baru')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="bg-gray-800 text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-gray-900 transition shadow-md hover:shadow-lg">
                        Update Password
                    </button>

                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Berhasil Diubah!
                        </p>
                    @endif
                </div>
            </form>
        </div>

        {{-- 3. Hapus Akun --}}
        <div class="p-6 bg-white shadow-sm sm:rounded-xl border border-red-100">
            <header>
                <h2 class="text-lg font-bold text-red-600">Hapus Akun</h2>
                <p class="mt-1 text-sm text-gray-500">Setelah akun dihapus, semua data dan riwayat pesanan akan hilang permanen.</p>
            </header>

            <div class="mt-6">
                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="bg-red-50 text-red-600 border border-red-200 px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-red-600 hover:text-white transition shadow-sm">
                    Hapus Akun Saya
                </button>
            </div>

            {{-- Modal Konfirmasi Hapus --}}
            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')
                    <h2 class="text-lg font-bold text-gray-900">Apakah Anda yakin ingin menghapus akun?</h2>
                    <p class="mt-1 text-sm text-gray-600">Akun yang dihapus tidak dapat dikembalikan. Silakan masukkan password Anda untuk konfirmasi.</p>
                    <div class="mt-6">
                        <x-input-label for="password" value="Password" class="sr-only" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4 border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg" placeholder="Password Anda"/>
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                        <x-danger-button>Hapus Akun</x-danger-button>
                    </div>
                </form>
            </x-modal>
        </div>

    </div>

@endsection