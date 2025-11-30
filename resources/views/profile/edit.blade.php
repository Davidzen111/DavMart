<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profil - {{ config('app.name', 'DavMart') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 gap-2">
                
                <div class="flex items-center shrink-0">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600 flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="DavMart Logo" class="w-10 h-10 rounded-full object-cover border-2 border-blue-100">
                        <span class="hidden sm:inline">DavMart</span><span class="sm:hidden">DM</span>
                    </a>
                </div>

                <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                    
                    {{-- Tombol Kembali ke Beranda --}}
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-blue-600 transition flex items-center gap-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="hidden sm:inline">Beranda</span>
                    </a>

                    {{-- Profil Menu --}}
                    <div class="relative ml-1 sm:ml-3">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2 px-3 py-1.5 border border-gray-200 rounded-full text-gray-600 bg-white hover:text-blue-600 hover:border-blue-300 focus:outline-none transition duration-150">
                                    <div class="bg-gray-100 rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="text-sm font-medium hidden sm:block max-w-[100px] truncate">
                                        {{ Auth::user()->name }}
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('dashboard')">Dashboard</x-dropdown-link>
                                <x-dropdown-link :href="route('cart.index')">Shopping Cart</x-dropdown-link>
                                <x-dropdown-link :href="route('orders.index')">Order History</x-dropdown-link>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Header Halaman --}}
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('dashboard') }}" class="p-2 bg-white rounded-full border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-300 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Pengaturan Akun</h2>
            </div>

            <div class="p-6 bg-white shadow-sm sm:rounded-xl border border-gray-100">
                <header>
                    <h2 class="text-lg font-bold text-gray-900">
                        Informasi Profil
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Perbarui informasi profil akun dan alamat email Anda.
                    </p>
                </header>

                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition">
                            Simpan Perubahan
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-green-600 font-medium"
                            >Simpan Berhasil!</p>
                        @endif
                    </div>
                </form>
            </div>

            <div class="p-6 bg-white shadow-sm sm:rounded-xl border border-gray-100">
                <header>
                    <h2 class="text-lg font-bold text-gray-900">
                        Ganti Kata Sandi
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Pastikan akun Anda aman dengan menggunakan kata sandi yang kuat.
                    </p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <x-input-label for="current_password" :value="__('Kata Sandi Saat Ini')" />
                        <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Kata Sandi Baru')" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition">
                            Update Password
                        </button>

                        @if (session('status') === 'password-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-green-600 font-medium"
                            >Berhasil Diubah!</p>
                        @endif
                    </div>
                </form>
            </div>

            <div class="p-6 bg-white shadow-sm sm:rounded-xl border border-red-100">
                <header>
                    <h2 class="text-lg font-bold text-red-600">
                        Hapus Akun
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Setelah akun dihapus, semua data dan riwayat pesanan akan hilang permanen.
                    </p>
                </header>

                <div class="mt-6">
                    <button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-700 transition"
                    >
                        Hapus Akun Saya
                    </button>
                </div>

                {{-- Modal Konfirmasi Hapus --}}
                <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                        @csrf
                        @method('delete')

                        <h2 class="text-lg font-bold text-gray-900">
                            Apakah Anda yakin ingin menghapus akun?
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Akun yang dihapus tidak dapat dikembalikan. Silakan masukkan password Anda untuk konfirmasi.
                        </p>

                        <div class="mt-6">
                            <x-input-label for="password" value="Password" class="sr-only" />
                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                class="mt-1 block w-3/4"
                                placeholder="Password"
                            />
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                Batal
                            </x-secondary-button>

                            <x-danger-button class="ms-3">
                                Hapus Akun
                            </x-danger-button>
                        </div>
                    </form>
                </x-modal>
            </div>

        </div>
    </div>

    <footer class="bg-white border-t border-gray-200 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; 2025 DavMart E-Commerce Project. All rights reserved.
        </div>
    </footer>

</body>
</html>