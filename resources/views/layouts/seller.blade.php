<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>@yield('title', 'Seller Dashboard - DavMart')</title> 
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" /> 
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased flex flex-col min-h-screen">

    {{-- 1. HEADER / NAVIGASI SELLER --}}
    <nav x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20 gap-2">
                
                {{-- KIRI: LOGO --}}
                <div class="flex items-center shrink-0">
                    <a href="{{ route('seller.dashboard') }}" class="text-3xl font-bold text-slate-800 flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="DavMart Logo" class="w-10 h-10 md:w-12 md:h-12 rounded-lg md:rounded-xl object-cover shadow-sm ring-2 ring-slate-100 transition-transform">
                        <span class="hidden sm:inline">DavMart</span><span class="sm:hidden">DavMart</span>
                    </a>
                </div>

                {{-- TENGAH: NAVIGASI MENU TOKO (Desktop) --}}
                <div class="hidden lg:flex flex-grow justify-start ml-8 space-x-2 items-center">
                    <a href="{{ route('seller.dashboard') }}" class="py-2 px-3 text-sm font-semibold rounded-lg transition {{ request()->routeIs('seller.dashboard') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        Ringkasan
                    </a>
                    <a href="{{ route('seller.products.index') }}" class="py-2 px-3 text-sm font-semibold rounded-lg transition {{ request()->routeIs('seller.products.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        Produk Saya
                    </a>
                    <a href="{{ route('seller.orders.index') }}" class="py-2 px-3 text-sm font-semibold rounded-lg transition flex items-center gap-2 {{ request()->routeIs('seller.orders.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        Pesanan
                        @php
                            $newOrders = \App\Models\OrderItem::where('store_id', Auth::user()->store->id ?? 0)->where('status', 'pending')->count();
                        @endphp
                        @if($newOrders > 0)
                            <span class="bg-red-500 text-white text-[10px] px-1.5 rounded-full">{{ $newOrders }}</span>
                        @endif
                    </a>
                    <a href="{{ route('seller.store.edit') }}" class="py-2 px-3 text-sm font-semibold rounded-lg transition {{ request()->routeIs('seller.store.edit') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        Pengaturan Toko
                    </a>
                </div>

                {{-- KANAN: MENU USER & AKSI --}}
                <div class="flex items-center gap-4 shrink-0">
                    
                    @auth
                        {{-- Desktop Group --}}
                        <div class="hidden lg:flex items-center gap-4">

                            <a href="{{ route('profile.edit') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
                                Pengaturan Akun
                            </a>

                            <div class="h-5 w-px bg-slate-300"></div>

                            <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-1.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-amber-700 transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                <span>Beranda</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-amber-700 bg-amber-50 border border-amber-100 rounded-lg hover:bg-amber-100 transition shadow-sm">
                                    Log Out
                                </button>
                            </form>
                        </div>

                        <div class="lg:hidden">
                            <button @click="open = ! open" class="p-2 text-slate-500 rounded-lg hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @else
                        <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition">Beranda</a>
                        <a href="{{ route('login') }}" class="ml-2 px-4 py-2 text-sm font-bold text-white bg-slate-900 rounded-lg hover:bg-slate-800 transition shadow-sm">Login</a>
                    @endauth
                </div>
            </div>
        </div>

        {{-- MOBILE MENU CONTENT (Dropdown) --}}
        <div 
            :class="{'block': open, 'hidden': ! open}" 
            class="hidden lg:hidden absolute top-20 right-4 w-64 bg-white border border-slate-100 rounded-xl shadow-xl z-50 p-2"
        >

            <div class="space-y-1 mb-2">
                <a href="{{ route('seller.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('seller.dashboard') ? 'bg-amber-50 text-amber-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Ringkasan</a>
                <a href="{{ route('seller.products.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('seller.products.*') ? 'bg-amber-50 text-amber-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Produk Saya</a>
                <a href="{{ route('seller.orders.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold transition flex justify-between items-center {{ request()->routeIs('seller.orders.*') ? 'bg-amber-50 text-amber-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <span>Pesanan Masuk</span>
                    @if($newOrders > 0) <span class="bg-red-500 text-white text-[10px] px-1.5 rounded-full">{{ $newOrders }}</span> @endif
                </a>
                <a href="{{ route('seller.store.edit') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('seller.store.edit') ? 'bg-amber-50 text-amber-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Pengaturan Toko</a>
            </div>

            @auth
            <div class="border-t border-slate-100 pt-2">
                <div class="space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-slate-900">Pengaturan Akun</a>
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-slate-900">Beranda</a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 transition">Log Out</button>
                    </form>
                </div>
            </div>
            @endauth
        </div>

    </nav>

    {{-- 2. KONTEN UTAMA --}}
    <main class="flex-grow py-8 bg-slate-50"> 
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content') 
        </div>
    </main>

    {{-- 3. FOOTER --}}
    <footer class="bg-white border-t border-slate-200 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-slate-500 text-sm"> 
            &copy; {{ date('Y') }} DavMart E-Commerce Project. All rights reserved.
        </div>
    </footer>

</body>
</html>