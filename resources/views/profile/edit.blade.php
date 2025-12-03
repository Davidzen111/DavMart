@extends('layouts.buyer')

@section('title', 'Edit Profil - DavMart')

@section('content')
    <div class="py-8 bg-slate-50 min-h-screen"> 
        
        {{-- WRAPPER KONTEN --}}
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @auth
                @php
                    $user = Auth::user(); 
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

            <div class="mb-6 flex items-center gap-4">
                <a href="{{ $backRoute ?? route('home') }}" 
                    class="group flex items-center justify-center w-10 h-10 bg-white border border-slate-300 rounded-full text-slate-700 hover:text-slate-900 hover:bg-slate-50 hover:border-slate-400 transition-all duration-200 ease-in-out shadow-md"
                    aria-label="{{ $ariaLabel ?? 'Kembali ke Beranda' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-200 group-hover:-translate-x-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </a>

                <div>
                    <h2 class="text-2xl font-bold text-slate-800 leading-tight">
                        {{ __('Pengaturan Akun') }} 
                    </h2>
                </div>
            </div>

            {{-- 1. Form Informasi Profil --}}
            <div class="p-8 bg-white shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100">
                <header class="mb-6 border-b border-slate-100 pb-4">
                    <h2 class="text-xl font-bold text-slate-800">Informasi Profil</h2>
                    <p class="mt-1 text-sm text-slate-500">Perbarui informasi profil akun dan alamat email Anda.</p>
                </header>

                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    {{-- Input Nama --}}
                    <div>
                        <label for="name" class="block font-medium text-sm text-slate-700 font-semibold mb-2">{{ __('Nama Lengkap') }}</label>
                        <input id="name" name="name" type="text" 
                            class="mt-1 block w-full border-slate-300 focus:border-amber-600 focus:ring-amber-600 rounded-lg shadow-sm text-slate-800" 
                            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                        @error('name')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Email --}}
                    <div>
                        <label for="email" class="block font-medium text-sm text-slate-700 font-semibold mb-2">{{ __('Email') }}</label>
                        <input id="email" name="email" type="email" 
                            class="mt-1 block w-full border-slate-300 focus:border-amber-600 focus:ring-amber-600 rounded-lg shadow-sm text-slate-800" 
                            value="{{ old('email', $user->email) }}" required autocomplete="username" />
                        @error('email')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                        <button type="submit" 
                            class="inline-flex items-center justify-center bg-amber-600 text-white font-bold py-2.5 px-6 rounded-xl hover:bg-amber-700 transition shadow-lg shadow-amber-400/50 transform hover:-translate-y-0.5">
                            Simpan Perubahan

                        </button>
                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" 
                                class="text-sm text-green-600 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Tersimpan!
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            {{-- 2. Form Ganti Password --}}
            <div class="p-8 bg-white shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100">
                <header class="mb-6 border-b border-slate-100 pb-4">
                    <h2 class="text-xl font-bold text-slate-800">Ganti Kata Sandi</h2>
                    <p class="mt-1 text-sm text-slate-500">Pastikan akun Anda aman dengan menggunakan kata sandi yang kuat.</p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')

                    {{-- Input Kata Sandi Saat Ini --}}
                    <div>
                        <label for="current_password" class="block font-medium text-sm text-slate-700 font-semibold mb-2">{{ __('Kata Sandi Saat Ini') }}</label>
                        <input id="current_password" name="current_password" type="password" 
                            class="mt-1 block w-full border-slate-300 focus:border-amber-600 focus:ring-amber-600 rounded-lg shadow-sm text-slate-800" 
                            autocomplete="current-password" />
                        @error('current_password', 'updatePassword')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Kata Sandi Baru --}}
                    <div>
                        <label for="password" class="block font-medium text-sm text-slate-700 font-semibold mb-2">{{ __('Kata Sandi Baru') }}</label>
                        <input id="password" name="password" type="password" 
                            class="mt-1 block w-full border-slate-300 focus:border-amber-600 focus:ring-amber-600 rounded-lg shadow-sm text-slate-800" 
                            autocomplete="new-password" />
                        @error('password', 'updatePassword')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Kata Sandi Baru --}}
                    <div>
                        <label for="password_confirmation" class="block font-medium text-sm text-slate-700 font-semibold mb-2">{{ __('Konfirmasi Kata Sandi Baru') }}</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" 
                            class="mt-1 block w-full border-slate-300 focus:border-amber-600 focus:ring-amber-600 rounded-lg shadow-sm text-slate-800" 
                            autocomplete="new-password" />
                        @error('password_confirmation', 'updatePassword')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                        <button type="submit" 
                            class="inline-flex items-center justify-center bg-slate-900 text-white font-bold py-2.5 px-6 rounded-xl hover:bg-slate-800 transition shadow-lg shadow-slate-400/50 transform hover:-translate-y-0.5">
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
            <div class="p-8 bg-white shadow-xl shadow-slate-200/50 rounded-2xl border border-red-200/80">
                <header class="mb-6 border-b border-red-100 pb-4">
                    <h2 class="text-xl font-bold text-red-600">Hapus Akun</h2>
                    <p class="mt-1 text-sm text-slate-500">Setelah akun dihapus, semua data dan riwayat pesanan akan hilang permanen.</p>
                </header>

                <div class="mt-6">
                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" 
                        class="inline-flex items-center justify-center bg-red-50 text-red-600 border border-red-300 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-red-600 hover:text-white transition shadow-sm">
                        Hapus Akun Saya
                    </button>
                </div>

                <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                        @csrf
                        @method('delete')
                        <h2 class="text-xl font-bold text-slate-900">Apakah Anda yakin ingin menghapus akun?</h2>
                        <p class="mt-2 text-sm text-slate-600">Akun yang dihapus tidak dapat dikembalikan. Silakan masukkan password Anda untuk konfirmasi.</p>
                        
                        <div class="mt-6">
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" name="password" type="password" 
                                class="mt-1 block w-full border-slate-300 focus:border-red-500 focus:ring-red-500 rounded-lg"
                                placeholder="Password Anda"
                            />
                            @error('password', 'userDeletion')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mt-6 flex justify-end gap-3">
                            <x-secondary-button x-on:click="$dispatch('close')" 
                                class="border border-slate-300 bg-white hover:bg-slate-50 text-slate-600 font-semibold rounded-lg shadow-sm">
                                Batal
                            </x-secondary-button>
                            <x-danger-button 
                                class="bg-red-600 text-white hover:bg-red-700 font-bold rounded-lg shadow-sm">
                                Hapus Akun
                            </x-danger-button>
                        </div>
                    </form>
                </x-modal>
            </div>
            
        </div>
    </div>
@endsection