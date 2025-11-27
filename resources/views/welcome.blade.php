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

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                        🛍️ DavMart
                    </a>
                </div>

                <div class="hidden md:flex items-center flex-1 mx-10">
                    <form action="{{ route('home') }}" method="GET" class="w-full relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk impianmu..." 
                               class="w-full border border-gray-300 rounded-full py-2 px-4 pl-10 focus:outline-none focus:border-blue-500">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        @if(Auth::user()->role === 'buyer')
                            <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold px-1.5 rounded-full">
                                    {{ Auth::user()->cart?->items->count() ?? 0 }}
                                </span>
                            </a>
                        @endif

                        <div class="relative ml-3">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div>Hi, {{ Auth::user()->name }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    @if(Auth::user()->role === 'admin')
                                        <x-dropdown-link :href="route('admin.dashboard')">Admin Dashboard</x-dropdown-link>
                                    @elseif(Auth::user()->role === 'seller')
                                        <x-dropdown-link :href="route('seller.dashboard')">Seller Dashboard</x-dropdown-link>
                                    @else
                                        <x-dropdown-link :href="route('dashboard')">Profil Saya</x-dropdown-link>
                                        <x-dropdown-link :href="route('orders.index')">Riwayat Pesanan</x-dropdown-link>
                                    @endif

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
                        <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full transition">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-blue-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Temukan Barang Impianmu Disini</h1>
            <p class="text-blue-100 text-lg mb-6">Belanja mudah, aman, dan terpercaya hanya di DavMart.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="flex justify-between items-end mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Rekomendasi Produk</h2>
            <div class="hidden md:block">
                @foreach($categories as $cat)
                    <a href="#" class="inline-block px-3 py-1 bg-white border border-gray-300 rounded-full text-sm text-gray-600 hover:bg-blue-50 hover:border-blue-500 mr-2 mb-2">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-20 bg-white rounded-lg border border-dashed border-gray-300">
                <p class="text-gray-500 text-lg">Belum ada produk yang ditemukan.</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition duration-300 overflow-hidden group">
                    
                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        <a href="{{ route('product.detail', $product->id) }}" class="block w-full h-full">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400 bg-gray-200">
                                    No Image
                                </div>
                            @endif
                        </a>
                        
                        <span class="absolute top-2 left-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded pointer-events-none">
                            {{ $product->category->name }}
                        </span>
                    </div>

                    <div class="p-4">
                        <div class="flex items-center mb-1">
                            <div class="w-4 h-4 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[10px] font-bold mr-1">
                                {{ substr($product->store->name, 0, 1) }}
                            </div>
                            <span class="text-xs text-gray-500 truncate">{{ $product->store->name }}</span>
                        </div>

                        <h3 class="font-bold text-gray-800 text-sm mb-1 truncate" title="{{ $product->name }}">
                            <a href="{{ route('product.detail', $product->id) }}" class="hover:text-blue-600 transition">
                                {{ $product->name }}
                            </a>
                        </h3>
                        
                        <div class="flex items-center mb-3">
                            <span class="text-yellow-400 text-sm">★</span>
                            <span class="text-xs text-gray-600 ml-1 font-medium">
                                {{ number_format($product->reviews->avg('rating'), 1) }} 
                                <span class="text-gray-400 font-normal">({{ $product->reviews->count() }})</span>
                            </span>
                        </div>

                        <p class="text-blue-600 font-bold text-lg mb-4">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        <form action="{{ route('cart.add') }}" method="POST"> 
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="w-full bg-blue-600 text-white text-sm font-bold py-2 rounded hover:bg-blue-700 transition flex justify-center items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                + Keranjang
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