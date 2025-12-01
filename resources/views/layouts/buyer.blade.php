<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DavMart - Toko Online Terpercaya')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased flex flex-col min-h-screen">

    {{-- 1. HEADER / NAVIGASI BUYER --}}
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20 gap-2">
                
                {{-- KIRI: LOGO --}}
                <div class="flex items-center shrink-0">
                    <a href="{{ route('home') }}" class="text-3xl font-bold text-blue-600 flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="DavMart Logo" class="w-14 h-14 rounded-full object-cover border-2 border-blue-100 shadow-sm">
                        <span class="hidden sm:inline">DavMart</span><span class="sm:hidden">DM</span>
                    </a>
                </div>

                {{-- TENGAH: NAVIGASI MENU UTAMA (DESKTOP ONLY) --}}
                <div class="hidden lg:flex flex-grow justify-start ml-8 space-x-2 items-center">
                    <a href="{{ route('home') }}" class="py-2 px-3 text-sm font-medium rounded-md transition {{ request()->routeIs('home') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                        Beranda
                    </a>
                    
                    @auth
                        <a href="{{ route('cart.index') }}" class="py-2 px-3 text-sm font-medium rounded-md transition {{ request()->routeIs('cart.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            Keranjang
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="py-2 px-3 text-sm font-medium rounded-md transition {{ request()->routeIs('wishlist.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            Wishlist
                        </a>
                        <a href="{{ route('orders.index') }}" class="py-2 px-3 text-sm font-medium rounded-md transition {{ request()->routeIs('orders.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            Riwayat
                        </a>
                    @endauth
                </div>

                {{-- KANAN: USER PROFILE & ACTION (DESKTOP ONLY) --}}
                <div class="hidden lg:flex items-center gap-4 shrink-0">
                    @auth
                        {{-- Link Pengaturan Akun (Teks Biasa) --}}
                        <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">
                            Pengaturan Akun
                        </a>

                        {{-- Divider Tipis --}}
                        <div class="h-5 w-px bg-gray-300"></div>

                        {{-- Tombol Dashboard (Boxed Style - Mirip tombol Toko di Admin) --}}
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-1.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span>Dashboard</span>
                        </a>

                        {{-- Tombol Logout (Boxed Style) --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 text-sm font-bold text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-sm">
                                Log Out
                            </button>
                        </form>
                    @else
                        {{-- Jika Belum Login --}}
                        <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-600 hover:text-blue-600 transition">Beranda</a>
                        <a href="{{ route('login') }}" class="ml-2 px-4 py-2 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm">Masuk</a>
                    @endauth
                </div>

                {{-- TOMBOL BURGER (MOBILE ONLY) --}}
                <div class="lg:hidden flex items-center">
                    <button @click="open = ! open" class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- MOBILE MENU CONTENT (FLOATING BOX) --}}
        <div 
            :class="{'block': open, 'hidden': ! open}" 
            class="hidden lg:hidden absolute top-20 right-4 w-64 bg-white border border-gray-100 rounded-xl shadow-xl z-50 p-2"
        >
            {{-- Navigasi Utama --}}
            <div class="space-y-1 mb-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    Beranda
                </a>
                @auth
                    <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('cart.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        Keranjang Belanja
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('wishlist.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        Wishlist Saya
                    </a>
                    <a href="{{ route('orders.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('orders.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        Riwayat Pesanan
                    </a>
                @endauth
            </div>

            {{-- Mobile User & Actions --}}
            <div class="border-t border-gray-100 pt-2">
                @auth
                    <div class="space-y-1">
                        <div class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider">
                            Halo, {{ Auth::user()->name }}
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-blue-600">
                            Pengaturan Akun
                        </a>
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-blue-600">
                            Dashboard Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 transition">
                                Log Out
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-blue-600">Masuk</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 rounded-lg text-sm font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 mt-1">Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- 2. KONTEN UTAMA --}}
    <main class="flex-grow py-8 bg-gray-50">
        @if (isset($header))
            <header class="bg-white shadow mb-6">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    {{-- 3. FOOTER --}}
    <footer class="bg-white border-t border-gray-200 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} DavMart E-Commerce Project. All rights reserved.
        </div>
    </footer>

</body>
</html>