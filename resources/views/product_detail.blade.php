<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{ $product->name }} - {{ config('app.name', 'DavMart') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-600">

    {{-- NAVIGATION BAR (Bagian navigasi utama) --}}
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
                        {{-- Dropdown Profil Pengguna --}}
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
                                    <div class="px-4 py-2 text-xs font-bold text-slate-800 border-b border-slate-100 md:hidden">
                                        Hi, {{ Auth::user()->name }}
                                    </div>
                                    @if(Auth::user()->role === 'admin')
                                        <x-dropdown-link :href="route('admin.dashboard')">Dashboard Admin</x-dropdown-link>
                                    @elseif(Auth::user()->role === 'seller')
                                        <x-dropdown-link :href="route('seller.dashboard')">Toko Saya</x-dropdown-link>
                                    @else 
                                        <x-dropdown-link :href="route('dashboard')">Profil Saya</x-dropdown-link>
                                    @endif
                                    <div class="border-t border-slate-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500">
                                            Log Out
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="text-xs md:text-sm font-semibold text-slate-600 hover:text-slate-900 px-3 py-2 transition-colors">Masuk</a>
                            <a href="{{ route('register') }}" class="text-xs md:text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 px-4 md:px-6 py-2 md:py-2.5 rounded-full transition-all shadow-md hover:shadow-lg">Daftar</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- PRODUCT DETAIL CONTENT (Konten Utama Halaman) --}}
    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-6 md:mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center text-slate-500 hover:text-amber-600 font-medium transition-all group">
                    <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center mr-2 group-hover:border-amber-400 group-hover:bg-amber-50 transition-all shadow-md">
                        <svg class="w-5 h-5 group-hover:-translate-x-0.5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </div>
                </a>
            </div>

            {{-- PRODUCT INFO CARD (Gambar + Detail Produk) --}}
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8 mb-8">

                {{-- PRODUCT IMAGE --}}
                <div class="bg-slate-50 rounded-xl overflow-hidden h-80 md:h-96 flex items-center justify-center border border-slate-100 relative group">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105" alt="{{ $product->name }}">
                    @else
                        <div class="flex flex-col items-center gap-2 text-slate-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-sm font-medium">No Image</span>
                        </div>
                    @endif
                </div>

                {{-- PRODUCT DETAILS --}}
                <div class="flex flex-col">
                    <div class="mb-4">
                        {{-- Kategori Produk --}}
                        <span class="inline-block bg-slate-100 text-slate-600 border border-slate-200 text-[10px] md:text-xs font-bold px-2.5 py-1 rounded-md uppercase tracking-wider mb-2">
                            {{ $product->category->name }}
                        </span>
                        {{-- Nama Produk --}}
                        <h1 class="text-2xl md:text-4xl font-bold text-slate-900 leading-tight">{{ $product->name }}</h1>
                    </div>

                    {{-- Rating, Jumlah Ulasan, dan Stok --}}
                    <div class="flex items-center gap-2 mb-6">
                        <div class="flex text-amber-500 text-lg">★</div>
                        <span class="font-bold text-slate-800 text-lg">{{ number_format($ratingAvg ?? 0, 1) }}</span>
                        <span class="text-slate-400 text-sm">({{ $ratingCount ?? 0 }} Ulasan)</span>
                        <span class="text-slate-300 mx-2">|</span>
                        <span class="text-slate-500 text-sm">Stok: <span class="font-bold text-slate-800">{{ $product->stock }}</span></span>
                    </div>

                    {{-- Harga Produk --}}
                    <div class="mb-8 p-3 bg-slate-100 rounded-lg inline-block border border-slate-200">
                        <p class="text-3xl md:text-4xl font-extrabold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>

                    {{-- Store Info (Informasi Toko Penjual) --}}
                    <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-100 mb-8">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white text-slate-700 flex items-center justify-center font-bold text-lg border border-slate-200 shadow-sm">
                            {{ substr($product->store->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wide font-bold">Dijual oleh</p>
                            <p class="font-bold text-slate-800 text-base">{{ $product->store->name }}</p>
                        </div>
                    </div>
                    
                    {{-- PRODUCT DESCRIPTION (Deskripsi) --}}
                    <div class="mb-8">
                        <h4 class="text-lg font-bold text-slate-800 mb-3 border-b border-slate-100 pb-1">Deskripsi Produk</h4>
                        <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-wrap">{{ $product->description }}</p>
                    </div>


                    {{-- ACTION BUTTONS (Keranjang / Wishlist / Login) --}}
                    <div class="mt-auto pt-4 border-t border-slate-100">
                        @auth
                            @if(Auth::user()->role === 'buyer')
                                <div class="flex flex-col gap-3">
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3.5 rounded-xl hover:bg-slate-800 transition-all shadow-lg flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                            Masukkan Keranjang
                                        </button>
                                    </form>

                                    {{-- Tombol Wishlist --}}
                                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full font-bold py-3 rounded-xl transition-colors flex items-center justify-center gap-2
                                            @if (isset($isWishlisted) && $isWishlisted)
                                                bg-red-50 border border-red-300 text-red-600 hover:bg-red-100 shadow-sm
                                            @else
                                                bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 hover:border-slate-400
                                            @endif
                                            ">
                                            <svg class="w-5 h-5 transition-colors"
                                                fill="{{ (isset($isWishlisted) && $isWishlisted) ? 'currentColor' : 'none' }}" 
                                                stroke="{{ (isset($isWishlisted) && $isWishlisted) ? 'none' : 'currentColor' }}" 
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            <span class="text-sm md:text-base">
                                                @if (isset($isWishlisted) && $isWishlisted)
                                                    Tersimpan di Favorit
                                                @else
                                                    Simpan ke Favorit
                                                @endif
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            @else
                                {{-- Pesan jika bukan role Buyer --}}
                                <div class="p-4 bg-slate-100 rounded-xl text-center border border-slate-200">
                                    <p class="text-slate-500 font-medium">Anda login sebagai {{ Auth::user()->role }}. Login sebagai Buyer untuk membeli.</p>
                                </div>
                            @endif
                        @else
                            {{-- Tombol Login (Jika Belum Login) --}}
                            <a href="{{ route('login') }}" class="block text-center w-full bg-slate-900 text-white font-bold py-3.5 rounded-xl hover:bg-slate-800 shadow-lg transition">
                                Login untuk Membeli
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            
            {{-- REVIEWS/ULASAN SECTION (Bagian Ulasan Pembeli) --}}
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 p-6 md:p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl md:text-2xl font-bold text-slate-800">Ulasan Pembeli</h3>
                    <span class="px-4 py-1.5 bg-slate-100 text-slate-600 rounded-full text-xs font-bold border border-slate-200">
                        {{ $product->reviews->count() }} Ulasan
                    </span>
                </div>

                @if($product->reviews->isEmpty())
                    <div class="text-center py-16 border border-dashed border-slate-200 rounded-2xl bg-slate-50">
                        <div class="text-5xl mb-4 opacity-30 grayscale">💬</div>
                        <p class="text-slate-600 font-bold text-lg">Belum ada ulasan</p>
                        <p class="text-slate-400 text-sm">Produk ini belum memiliki ulasan dari pembeli.</p>
                    </div>
                @else
                    {{-- Daftar Ulasan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($product->reviews as $review)
                        <div class="bg-white rounded-xl border border-slate-100 p-5 hover:border-slate-300 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-sm font-bold text-slate-600 border border-slate-200 shadow-sm">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-slate-800">{{ $review->user->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wide">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                {{-- Rating Bintang --}}
                                <div class="flex bg-amber-50 px-2 py-1 rounded-lg border border-amber-100">
                                    <div class="flex text-amber-500 text-xs">
                                        @for($i=0; $i < $review->rating; $i++) ★ @endfor
                                        @for($i=$review->rating; $i < 5; $i++) <span class="text-slate-200">★</span> @endfor
                                    </div>
                                </div>
                            </div>

                            <div class="relative">
                                <span class="absolute top-0 left-0 text-3xl text-slate-200 font-serif -mt-2 -ml-1">“</span>
                                <p class="text-slate-600 text-sm leading-relaxed px-4 italic relative z-10">
                                    {{ $review->review }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- FOOTER (Hak Cipta dan Info) --}}
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