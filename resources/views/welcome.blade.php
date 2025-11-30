<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DavMart') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    {{-- ========================================================================================= --}}
    {{-- NAVIGASI UTAMA (HEADER) - LOGO DIPERBESAR SEDIKIT (w-14) --}}
    {{-- ========================================================================================= --}}
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Container: Tetap h-20 agar tidak terlalu sempit --}}
            <div class="flex justify-between items-center h-20 py-2">
                
                <div class="flex items-center shrink-0">
                    {{-- Font Brand: text-2xl --}}
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600 flex items-center gap-3">
                        {{-- Logo: Diubah dari w-12 menjadi w-14 (56px) --}}
                        <img src="{{ asset('images/logo.png') }}" alt="DavMart Logo" class="w-14 h-14 rounded-full object-cover border border-blue-100">
                        <span class="hidden sm:inline">DavMart</span><span class="sm:hidden">DM</span>
                    </a>
                </div>

                <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                    @auth
                        {{-- Icon Keranjang --}}
                        @if(Auth::user()->role === 'buyer')
                            <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-blue-600 transition">
                                {{-- Icon: w-6 h-6 --}}
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                    {{ Auth::user()->cart?->items->count() ?? 0 }}
                                </span>
                            </a>
                        @endif 

                        {{-- Dropdown Profil --}}
                        <div class="relative ml-1 sm:ml-3">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center gap-2 px-3 py-1.5 border border-gray-200 rounded-full text-gray-600 bg-white hover:text-blue-600 hover:border-blue-300 focus:outline-none transition duration-150">
                                        {{-- 1. Ikon Orang --}}
                                        <div class="bg-gray-100 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        
                                        {{-- 2. Nama User --}}
                                        <div class="text-sm font-medium hidden sm:block max-w-[100px] truncate">
                                            {{ Auth::user()->name }}
                                        </div>

                                        {{-- 3. Simbol Arah Bawah --}}
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('dashboard')">Profil Saya</x-dropdown-link>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-full transition shadow-sm">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    {{-- ========================================================================================= --}}

    <div class="relative bg-blue-800 text-white py-24 md:py-32 overflow-hidden" style="background-image: url('{{ asset('images/banner.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>
        <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">Temukan Barang Impianmu Disini</h1>
            <p class="text-blue-100 text-lg md:text-xl drop-shadow-md">Belanja mudah, aman, dan terpercaya hanya di DavMart.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-8 relative z-30">
        
        <form action="{{ route('home') }}" method="GET" class="flex flex-col md:flex-row gap-3 bg-white p-4 rounded-xl shadow-lg border border-gray-100">
            
            {{-- 1. Search Bar --}}
            <div class="relative flex-1 w-full z-0">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk impianmu..." 
                       class="w-full border border-gray-300 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-200 transition h-[42px] bg-gray-50 shadow-sm">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            
            <input type="hidden" name="category" value="{{ request('category') }}">
            
            <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap shrink-0 relative">
                
                {{-- 2. FILTER LANJUT (Dropdown) --}}
                <div class="relative">
                    <x-dropdown align="left" width="72">
                        <x-slot name="trigger">
                            <button type="button" class="h-[42px] flex items-center justify-center bg-gray-50 text-gray-700 px-6 rounded-lg border border-gray-300 hover:bg-gray-100 hover:border-blue-400 transition text-sm font-medium whitespace-nowrap shadow-sm group">
                                <svg class="w-4 h-4 mr-2 text-gray-500 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>
                                Filter Lanjut
                                <svg class="w-3 h-3 ml-2 -mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="p-4 space-y-4 bg-white" onclick="event.stopPropagation()">
                                
                                {{-- SORTIR HARGA --}}
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800 mb-2">Urutan Harga</h4>
                                    <select name="sort" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-blue-500 focus:border-blue-500 cursor-pointer bg-gray-50">
                                        <option value="">Paling Sesuai</option>
                                        <option value="price_asc" @selected(request('sort') == 'price_asc')>Termurah ke Termahal</option>
                                        <option value="price_desc" @selected(request('sort') == 'price_desc')>Termahal ke Termurah</option>
                                    </select>
                                </div>

                                {{-- FILTER RATING --}}
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800 mb-2">Filter Rating</h4>
                                    <select name="rating" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-blue-500 focus:border-blue-500 cursor-pointer bg-gray-50 text-yellow-500 font-bold">
                                        <option value="" class="text-gray-500 font-normal">Semua Bintang</option>
                                        <option value="5" @selected(request('rating') == '5')>★★★★★ (5 Bintang)</option>
                                        <option value="4" @selected(request('rating') == '4')>★★★★☆ (4 Bintang)</option>
                                        <option value="3" @selected(request('rating') == '3')>★★★☆☆ (3 Bintang)</option>
                                        <option value="2" @selected(request('rating') == '2')>★★☆☆☆ (2 Bintang)</option>
                                        <option value="1" @selected(request('rating') == '1')>★☆☆☆☆ (1 Bintang)</option>
                                    </select>
                                </div>

                                <button type="submit" class="w-full bg-blue-600 text-white text-sm font-bold py-2.5 rounded-lg hover:bg-blue-700 transition shadow-md">
                                    Terapkan
                                </button>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
                
                {{-- 3. Tombol Reset --}}
                <a href="{{ route('home') }}" class="h-[42px] px-4 rounded-lg border border-red-200 bg-white text-red-600 hover:bg-red-50 hover:border-red-300 transition text-sm font-medium shrink-0 flex items-center justify-center gap-1 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Reset
                </a>

            </div>
        </form>
    </div>

    {{-- ========================================================================================= --}}
    {{-- BAGIAN BARU: REKOMENDASI PRODUK (POPULER/RATING TINGGI) --}}
    {{-- ========================================================================================= --}}
    @if(isset($recommendedProducts) && $recommendedProducts->isNotEmpty())
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10">
        <div class="flex items-center gap-2 mb-6">
            <div class="p-2 bg-yellow-100 rounded-full text-yellow-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Produk Paling Diminati</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($recommendedProducts as $product)
            <div class="bg-white rounded-lg shadow-sm border border-yellow-200 hover:shadow-lg hover:border-yellow-400 transition duration-300 overflow-hidden group flex flex-col h-full relative">
                
                {{-- Label Rekomendasi --}}
                <div class="absolute top-0 right-0 z-20 bg-yellow-400 text-white text-[10px] font-bold px-2 py-1 rounded-bl-lg shadow-sm">
                    POPULER
                </div>

                <a href="{{ route('product.detail', $product->id) }}" class="flex-grow block">
                    <div class="relative h-40 md:h-48 bg-gray-100 overflow-hidden shrink-0">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 bg-gray-200">No Image</div>
                        @endif
                        <span class="absolute top-2 left-2 bg-black bg-opacity-50 text-white text-[10px] px-2 py-1 rounded pointer-events-none">
                            {{ $product->category->name }}
                        </span>
                    </div>

                    <div class="p-3 md:p-4">
                        <div class="flex items-center mb-1">
                            <div class="w-4 h-4 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[10px] font-bold mr-1 shrink-0">
                                {{ substr($product->store->name, 0, 1) }}
                            </div>
                            <span class="text-xs text-gray-500 truncate">{{ $product->store->name }}</span>
                        </div>

                        <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2 min-h-[40px]" title="{{ $product->name }}">
                            {{ $product->name }}
                        </h3>
                        
                        <div class="flex items-center mb-2">
                            <span class="text-yellow-400 text-sm">★</span>
                            <span class="text-xs text-gray-600 ml-1 font-medium">
                                {{ number_format($product->reviews->avg('rating'), 1) }} 
                                <span class="text-gray-400 font-normal">({{ $product->reviews->count() }})</span>
                            </span>
                        </div>

                        <p class="text-blue-600 font-bold text-base md:text-lg">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </a>

                <div class="p-3 md:p-4 pt-0 mt-auto">
                    <form action="{{ route('cart.add') }}" method="POST" class="flex gap-2"> 
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-lg border border-blue-600 text-blue-600 hover:bg-blue-50 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </button>
                        <button type="submit" class="flex-1 bg-blue-600 text-white text-sm font-bold py-2 rounded-lg hover:bg-blue-700 transition shadow-sm">
                            Beli
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        
        <hr class="mt-10 border-gray-200">
    </div>
    @endif
    {{-- ========================================================================================= --}}


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 relative z-0">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-800">Semua Produk</h2>
            
            <div class="w-full md:w-auto overflow-x-auto whitespace-nowrap pb-2 md:pb-0">
                <a href="{{ route('home', array_merge(request()->except(['category', 'page']))) }}" 
                   class="inline-block px-3 py-1 border rounded-full text-sm mr-2 transition 
                          {{ !request('category') ? 'bg-blue-600 border-blue-600 text-white font-medium' : 'bg-white border-gray-300 text-gray-600 hover:bg-blue-50 hover:border-blue-500' }}">
                    Semua Kategori
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('home', array_merge(request()->except(['category', 'page']), ['category' => $cat->id])) }}" 
                       class="inline-block px-3 py-1 border rounded-full text-sm mr-2 transition 
                              {{ request('category') == $cat->id ? 'bg-blue-600 border-blue-600 text-white font-medium' : 'bg-white border-gray-300 text-gray-600 hover:bg-blue-50 hover:border-blue-500' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
        
        @if($products->isEmpty())
            <div class="text-center py-20 bg-white rounded-lg border border-dashed border-gray-300">
                <p class="text-gray-500 text-lg">Belum ada produk yang ditemukan.</p>
                <a href="{{ route('home') }}" class="text-blue-600 hover:underline mt-4 inline-block">Lihat Semua Produk</a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition duration-300 overflow-hidden group flex flex-col h-full relative">
                    
                    <a href="{{ route('product.detail', $product->id) }}" class="flex-grow block">
                        <div class="relative h-40 md:h-48 bg-gray-100 overflow-hidden shrink-0">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400 bg-gray-200">
                                    No Image
                                </div>
                            @endif
                            
                            <span class="absolute top-2 left-2 bg-black bg-opacity-50 text-white text-[10px] px-2 py-1 rounded pointer-events-none">
                                {{ $product->category->name }}
                            </span>
                        </div>

                        <div class="p-3 md:p-4">
                            <div class="flex items-center mb-1">
                                <div class="w-4 h-4 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[10px] font-bold mr-1 shrink-0">
                                    {{ substr($product->store->name, 0, 1) }}
                                </div>
                                <span class="text-xs text-gray-500 truncate">{{ $product->store->name }}</span>
                            </div>

                            <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2 min-h-[40px]" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>
                            
                            <div class="flex items-center mb-2">
                                <span class="text-yellow-400 text-sm">★</span>
                                <span class="text-xs text-gray-600 ml-1 font-medium">
                                    {{ number_format($product->reviews->avg('rating'), 1) }} 
                                    <span class="text-gray-400 font-normal">({{ $product->reviews->count() }})</span>
                                </span>
                            </div>

                            <p class="text-blue-600 font-bold text-base md:text-lg">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </a>

                    <div class="p-3 md:p-4 pt-0 mt-auto">
                        <form action="{{ route('cart.add') }}" method="POST" class="flex gap-2"> 
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-lg border border-blue-600 text-blue-600 hover:bg-blue-50 transition" title="Tambah ke Keranjang">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </button>

                            <button type="submit" class="flex-1 bg-blue-600 text-white text-sm font-bold py-2 rounded-lg hover:bg-blue-700 transition shadow-sm">
                                Beli Sekarang
                            </button>
                        </form>
                    </div>

                </div>
                @endforeach
            </div>
            
        @endif

    </div>

    <footer class="bg-white border-t border-gray-200 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; 2025 DavMart E-Commerce Project. All rights reserved.
        </div>
    </footer>

</body>
</html>