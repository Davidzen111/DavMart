<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>@yield('title', 'Admin Panel - DavMart')</title> 
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased flex flex-col min-h-screen">

    {{-- 1. HEADER / NAVIGASI ADMIN --}}
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20 gap-2">
                
                {{-- KIRI: LOGO (UKURAN ASLI / ORIGINAL) --}}
                <div class="flex items-center shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="text-3xl font-bold text-red-600 flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="DavMart Logo" class="w-14 h-14 rounded-full object-cover border-2 border-red-100 shadow-sm">
                        <span class="hidden sm:inline">DavMart</span><span class="sm:hidden">ADM</span>
                    </a>
                </div>

                {{-- TENGAH: NAVIGASI MENU UTAMA (DESKTOP) --}}
                <div class="hidden lg:flex flex-grow justify-start ml-8 space-x-2 items-center">
                    <a href="{{ route('admin.dashboard') }}" class="py-2 px-3 text-sm font-medium rounded-md transition {{ request()->routeIs('admin.dashboard') ? 'bg-red-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-red-600' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="py-2 px-3 text-sm font-medium rounded-md transition {{ request()->routeIs('admin.users.*') ? 'bg-red-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-red-600' }}">
                        Manajemen User
                    </a>
                    <a href="{{ route('admin.seller.verification') }}" class="py-2 px-3 text-sm font-medium rounded-md transition {{ request()->routeIs('admin.seller.verification') ? 'bg-red-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-red-600' }}">
                        Verifikasi Seller
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="py-2 px-3 text-sm font-medium rounded-md transition {{ request()->routeIs('admin.categories.*') ? 'bg-red-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-red-600' }}">
                        Kategori
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="py-2 px-3 text-sm font-medium rounded-md transition {{ request()->routeIs('admin.products.*') ? 'bg-red-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-red-600' }}">
                        Manajemen Produk
                    </a>
                </div>

                {{-- KANAN: MENU USER & AKSI --}}
                <div class="flex items-center gap-4 shrink-0">
                    
                    @auth
                        {{-- Desktop Group --}}
                        <div class="hidden lg:flex items-center gap-4">
                            
                            {{-- Link Akun Simple --}}
                            <a href="{{ route('admin.profile.edit') }}" class="text-sm font-medium text-gray-600 hover:text-red-600 transition">
                                Pengaturan Akun
                            </a>

                            {{-- Divider Tipis --}}
                            <div class="h-5 w-px bg-gray-300"></div>

                            {{-- Tombol Beranda Toko --}}
                            <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-1.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-red-600 transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                <span>Toko</span>
                            </a>

                            {{-- Tombol Log Out --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm">
                                    Log Out
                                </button>
                            </form>
                        </div>

                        {{-- Mobile Hamburger Button --}}
                        <div class="lg:hidden">
                            <button @click="open = ! open" class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @else
                        {{-- Tamu --}}
                        <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-600 hover:text-red-600 transition">Beranda</a>
                        <a href="{{ route('login') }}" class="ml-2 px-4 py-2 text-sm font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 transition shadow-sm">Login</a>
                    @endauth
                </div>
            </div>
        </div>

        {{-- 
            MOBILE MENU CONTENT (KOTAK KECIL / FLOATING BOX)
            Menggunakan 'absolute', 'top-20', 'right-4', dan 'w-64' agar terlihat rapi dan tidak full layar.
        --}}
        <div 
            :class="{'block': open, 'hidden': ! open}" 
            class="hidden lg:hidden absolute top-20 right-4 w-64 bg-white border border-gray-100 rounded-xl shadow-xl z-50 p-2"
        >
            {{-- Navigasi Utama --}}
            <div class="space-y-1 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Users</a>
                <a href="{{ route('admin.seller.verification') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.seller.verification') ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Verifikasi</a>
                <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.categories.*') ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Kategori</a>
                <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.products.*') ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Produk</a>
            </div>

            {{-- Mobile User & Actions --}}
            @auth
            <div class="border-t border-gray-100 pt-2">
                <div class="space-y-1">
                    <a href="{{ route('admin.profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-red-600">Pengaturan Akun</a>
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-red-600">Beranda</a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm font-bold text-red-600 bg-red-50 hover:bg-red-100 transition">Log Out</button>
                    </form>
                </div>
            </div>
            @endauth
        </div>

    </nav>

    {{-- 2. KONTEN UTAMA --}}
    <main class="flex-grow py-8 bg-gray-50">
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