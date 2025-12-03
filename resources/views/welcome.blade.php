<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{ config('app.name', 'DavMart') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-600">

    {{-- NAVIGATION BAR (Sticky & Backdrop Blur) --}}
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                
                <div class="flex items-center shrink-0">
                    <a href="{{ route('home') }}" class="group flex items-center gap-2 md:gap-3">
                        <div class="relative">
                            <img src="{{ asset('images/logo.png') }}" alt="DavMart" class="w-8 h-8 md:w-12 md:h-12 rounded-lg md:rounded-xl object-cover shadow-sm ring-2 ring-slate-100 transition-transform group-hover:scale-105">
                        </div>
                        <span class="text-xl md:text-2xl font-bold text-slate-800 tracking-tight hidden sm:block group-hover:text-amber-700 transition-colors">DavMart</span>
                        <span class="text-lg font-bold text-slate-900 sm:hidden">DavMart</span>
                    </a>
                </div>

                <div class="flex items-center gap-2 md:gap-4">
                    @auth
                        {{-- Dropdown Profil Pengguna (Desktop & Mobile) --}}
                        <div class="relative ml-1 md:ml-3">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center gap-2 md:gap-3 px-2 py-1.5 md:px-4 md:py-2 border border-transparent md:border-slate-200 rounded-full text-slate-600 bg-transparent md:bg-white hover:bg-slate-50 transition-all shadow-sm hover:shadow-md">
                                        <div class="text-sm font-semibold hidden md:block max-w-[120px] truncate text-slate-700">
                                            {{ Auth::user()->name }}
                                        </div>
                                        <div class="w-8 h-8 md:w-auto md:h-auto flex items-center justify-center bg-slate-100 md:bg-transparent rounded-full">
                                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    {{-- Link Dashboard berdasarkan Role --}}
                                    @if(Auth::user()->role === 'admin')
                                        <x-dropdown-link :href="route('admin.dashboard')">Dashboard Admin</x-dropdown-link>
                                    @elseif(Auth::user()->role === 'seller')
                                        <x-dropdown-link :href="route('seller.dashboard')">Toko Saya</x-dropdown-link>
                                    @else 
                                        <x-dropdown-link :href="route('dashboard')">Profil Saya</x-dropdown-link>
                                    @endif
                                    <div class="border-t border-slate-100"></div>
                                    {{-- Tombol Logout --}}
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500 hover:text-red-700">
                                            Log Out
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @else
                        {{-- Tombol Masuk/Daftar (Jika Belum Login) --}}
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="text-xs md:text-sm font-semibold text-slate-600 hover:text-slate-900 px-3 py-2 transition-colors">Masuk</a>
                            <a href="{{ route('register') }}" class="text-xs md:text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 px-4 md:px-6 py-2 md:py-2.5 rounded-full transition-all shadow-md hover:shadow-lg">Daftar</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION (Banner Utama) --}}
    <div class="relative bg-slate-900 text-white pt-16 pb-24 md:pt-28 md:pb-40 overflow-hidden">
        <div class="absolute inset-0 z-0">
               <img src="{{ asset('images/banner.jpg') }}" alt="Banner" class="w-full h-full object-cover opacity-40">
               <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/50 to-slate-900/20"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
            <h1 class="text-3xl md:text-6xl font-extrabold mb-4 md:mb-6 tracking-tight leading-tight drop-shadow-md">
                Temukan Barang <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-slate-100 to-amber-100">Impianmu</span>
            </h1>
            <p class="text-slate-300 text-sm md:text-xl font-medium max-w-xl md:max-w-2xl mx-auto mb-4 md:mb-8 leading-relaxed px-4 opacity-90">
                Platform belanja terpercaya dengan koleksi terlengkap, harga terbaik, dan pengalaman belanja yang aman.
            </p>
        </div>
    </div>

    {{-- SEARCH BAR AND FILTER (Kotak Pencarian Mengambang) --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-30">
        <form action="{{ route('home') }}" method="GET" class="bg-white p-3 md:p-4 rounded-2xl shadow-xl shadow-slate-200/40 border border-slate-100 flex flex-col md:flex-row gap-3">
            
            {{-- Input Pencarian Utama --}}
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Apa yang ingin kamu cari hari ini?" 
                        class="w-full bg-slate-50 border-0 text-slate-700 rounded-xl py-3 pl-11 pr-4 focus:ring-2 focus:ring-slate-900/10 focus:bg-white transition-all placeholder-slate-400 font-medium text-sm md:text-base">
            </div>
            
            <input type="hidden" name="category" value="{{ request('category') }}">
            
            <div class="flex items-center gap-2 w-full md:w-auto">
                <div class="relative w-full md:w-auto">
                    {{-- Dropdown Filter Lanjutan --}}
                     <x-dropdown align="right" width="full_mobile">
                        <x-slot name="trigger">
                            <button type="button" class="w-full md:w-auto h-[46px] md:h-[48px] px-4 md:px-6 inline-flex items-center justify-center bg-white border border-slate-200 hover:border-slate-400 hover:text-slate-900 rounded-xl text-sm font-bold text-slate-600 transition-all shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                Filter
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="p-4 space-y-4 min-w-[280px]">
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 block">Urutkan Harga</label>
                                    <select name="sort" class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm p-2.5 focus:border-slate-900 focus:ring-slate-900">
                                        <option value="">Paling Sesuai</option>
                                        <option value="price_asc" @selected(request('sort') == 'price_asc')>Termurah</option>
                                        <option value="price_desc" @selected(request('sort') == 'price_desc')>Termahal</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 block">Rating Produk</label>
                                    <select name="rating" class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm p-2.5 text-amber-600 font-bold focus:border-slate-900 focus:ring-slate-900">
                                        <option value="" class="text-slate-500 font-normal">Semua Rating</option>
                                        <option value="5" @selected(request('rating') == '5')>★★★★★ (5.0)</option>
                                        <option value="4" @selected(request('rating') == '4')>★★★★☆ (4.0+)</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-slate-900 text-white text-sm font-bold py-3 rounded-lg hover:bg-slate-800 transition-all shadow-md">Terapkan Filter</button>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                <a href="{{ route('home') }}" class="h-[46px] w-[46px] md:h-[48px] md:w-[48px] flex items-center justify-center rounded-xl border border-slate-200 text-slate-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all shrink-0 bg-white shadow-sm" title="Reset Filter">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            </div>
        </form>
    </div>

    {{-- PRODUCT LISTING SECTION (Daftar Produk) --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12 space-y-12">

        @if(isset($recommendedProducts) && $recommendedProducts->isNotEmpty())
        <section>
            {{-- Section Header: Pilihan Terbaik --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2.5 bg-amber-50 rounded-xl text-amber-600 border border-amber-100 shadow-sm shrink-0">
                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                </div>
                <div>
                    <h2 class="text-lg md:text-2xl font-bold text-slate-800">Pilihan Terbaik</h2>
                    <p class="text-xs md:text-sm text-slate-500 font-medium">Produk paling banyak diminati minggu ini</p>
                </div>
            </div>

            {{-- Recommended Product Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($recommendedProducts as $product)
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 overflow-hidden flex flex-col h-full relative">
                    
                    <div class="absolute top-3 right-3 z-20">
                           <span class="bg-amber-500/90 backdrop-blur text-white text-[9px] md:text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm">
                                POPULER
                            </span>
                    </div>

                    <a href="{{ route('product.detail', $product->id) }}" class="flex-grow block">
                        <div class="relative w-full aspect-square bg-slate-50 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="flex items-center justify-center h-full text-slate-300 bg-slate-50 text-xs font-medium">No Image</div>
                            @endif
                        </div>

                        <div class="p-4 space-y-2">
                            {{-- Store Name --}}
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-[9px] font-bold ring-1 ring-slate-200 shrink-0">
                                    {{ substr($product->store->name, 0, 1) }}
                                </div>
                                <span class="text-[10px] md:text-xs text-slate-500 truncate font-semibold">{{ $product->store->name }}</span>
                            </div>

                            {{-- Product Name --}}
                            <h3 class="font-bold text-slate-800 text-sm leading-snug line-clamp-2 min-h-[2.5rem] group-hover:text-amber-700 transition-colors" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>
                            
                            {{-- Price and Rating --}}
                            <div class="flex flex-col pt-1">
                                <p class="text-base md:text-lg font-bold text-slate-900">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                <div class="flex items-center gap-1 mt-1">
                                    <svg class="w-3 h-3 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="text-xs text-slate-600 font-bold">{{ number_format($product->reviews->avg('rating'), 1) }}</span>
                                    <span class="text-[10px] text-slate-400">({{ $product->reviews->count() }})</span>
                                </div>
                            </div>
                        </div>
                    </a>

                    {{-- Add to Cart Button --}}
                    <div class="px-4 pb-4 mt-auto">
                        <form action="{{ route('cart.add') }}" method="POST"> 
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs md:text-sm border border-transparent hover:bg-slate-800 transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2 group-btn">
                                <span class="hidden md:inline">Keranjang</span>
                                <span class="md:hidden">+ Keranjang</span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        <hr class="border-slate-200">
        @endif

        <section>
            {{-- Section Header: Eksplorasi & Category Filters --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
                <div>
                    <h2 class="text-lg md:text-2xl font-bold text-slate-800">Eksplorasi</h2>
                    <p class="text-xs md:text-sm text-slate-500 mt-1">Jelajahi semua kategori yang tersedia</p>
                </div>
                
                {{-- Category Filters (Horizontal Scroll) --}}
                <div class="w-full md:w-auto overflow-x-auto pb-2 no-scrollbar -mx-4 px-4 md:mx-0 md:px-0">
                    <div class="flex gap-2 w-max">
                        <a href="{{ route('home', array_merge(request()->except(['category', 'page']))) }}" 
                           class="px-4 py-1.5 rounded-full text-xs md:text-sm font-bold transition-all whitespace-nowrap border {{ !request('category') ? 'bg-slate-900 text-white border-slate-900 shadow-sm' : 'bg-white text-slate-500 border-slate-200 hover:border-slate-400 hover:text-slate-900' }}">
                            Semua
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('home', array_merge(request()->except(['category', 'page']), ['category' => $cat->id])) }}" 
                               class="px-4 py-1.5 rounded-full text-xs md:text-sm font-bold transition-all whitespace-nowrap border {{ request('category') == $cat->id ? 'bg-slate-900 text-white border-slate-900 shadow-sm' : 'bg-white text-slate-500 border-slate-200 hover:border-slate-400 hover:text-slate-900' }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            {{-- Main Product Grid --}}
            @if($products->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 md:py-20 bg-white rounded-3xl border border-dashed border-slate-200 text-center mx-4 md:mx-0">
                    <div class="bg-slate-50 p-4 rounded-full mb-3 md:mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-base md:text-lg font-bold text-slate-800">Produk Tidak Ditemukan</h3>
                    <p class="text-xs md:text-base text-slate-500 max-w-xs md:max-w-sm mt-1 mb-4">Coba gunakan kata kunci lain atau reset filter Anda.</p>
                    <a href="{{ route('home') }}" class="text-sm text-amber-600 font-bold hover:underline">Reset Pencarian</a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    @foreach($products as $product)
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 overflow-hidden flex flex-col h-full">
                        
                        <a href="{{ route('product.detail', $product->id) }}" class="flex-grow block">
                            <div class="relative w-full aspect-square bg-slate-50 overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="flex items-center justify-center h-full text-slate-300 bg-slate-50 text-xs font-medium">No Image</div>
                                @endif
                                <div class="absolute bottom-2 left-2">
                                    <span class="bg-white/90 backdrop-blur text-slate-600 text-[9px] md:text-[10px] font-bold px-2 py-0.5 rounded shadow-sm border border-slate-100">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-4 space-y-2">
                                {{-- Store Name --}}
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-wider truncate">{{ $product->store->name }}</span>
                                </div>

                                {{-- Product Name --}}
                                <h3 class="font-bold text-slate-800 text-xs md:text-sm leading-relaxed line-clamp-2 min-h-[2.5rem] group-hover:text-amber-700 transition-colors" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </h3>
                                
                                {{-- Rating --}}
                                <div class="flex items-center gap-1">
                                    <svg class="w-3 h-3 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="text-[10px] md:text-xs text-slate-500 font-bold">{{ number_format($product->reviews->avg('rating'), 1) }}</span>
                                </div>

                                {{-- Price --}}
                                <p class="text-slate-900 font-bold text-sm md:text-lg">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </a>

                        {{-- Add to Cart Button --}}
                        <div class="px-4 pb-4 mt-auto">
                            <form action="{{ route('cart.add') }}" method="POST"> 
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs md:text-sm hover:bg-slate-800 transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Keranjang
                                </button>
                            </form>
                        </div>

                    </div>
                    @endforeach
                </div>
            @endif
        </section>

    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 md:py-12 mt-8 md:mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h4 class="font-bold text-slate-800 text-base md:text-lg mb-2">DavMart</h4>
            <p class="text-slate-500 text-xs md:text-sm mb-6">Belanja nyaman, aman, dan penuh senyuman.</p>
            <div class="text-slate-400 text-[10px] md:text-xs">
                &copy; {{ date('Y') }} DavMart E-Commerce Project. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>