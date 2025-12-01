@extends('layouts.buyer')

@section('title', 'Wishlist Saya - DavMart')

@section('content')

    {{-- LOGIKA PENENTUAN RUTE KEMBALI DINAMIS --}}
    @auth
        @php
            $backRoute = match (Auth::user()->role ?? 'buyer') {
                'admin' => route('admin.dashboard'),
                'seller' => route('seller.dashboard'),
                default => route('dashboard'), // Buyer/Default
            };
            $ariaLabel = match (Auth::user()->role ?? 'buyer') {
                'admin' => 'Kembali ke Dashboard Admin',
                'seller' => 'Kembali ke Dashboard Toko',
                default => 'Kembali ke Dashboard Saya',
            };
        @endphp
    @endauth

    {{-- HEADER HALAMAN DENGAN TOMBOL KEMBALI BULAT --}}
    <div class="mb-8 flex items-center gap-4 mt-4">
        
        {{-- TOMBOL KEMBALI (Menggunakan rute dinamis) --}}
        <a href="{{ $backRoute ?? route('home') }}" 
           class="group flex items-center justify-center w-10 h-10 bg-white border border-gray-200 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 ease-in-out shadow-sm"
           aria-label="{{ $ariaLabel ?? 'Kembali ke Beranda' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-200 group-hover:-translate-x-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </a>

        {{-- JUDUL HALAMAN --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-800 leading-tight flex items-center gap-2">
                {{ __('Daftar Keinginan') }} <span class="text-red-500 animate-pulse">❤️</span>
            </h2>
            <p class="text-sm text-gray-500">Barang impianmu tersimpan di sini.</p>
        </div>
    </div>

    {{-- PESAN SUKSES --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- LOGIKA TAMPILAN GRID --}}
    @if($wishlists->isEmpty())
        
        {{-- Tampilan Jika Kosong --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 text-center flex flex-col items-center justify-center min-h-[400px] border border-gray-100">
            <div class="text-6xl mb-4 opacity-50 grayscale">💔</div>
            <h3 class="text-xl font-bold text-gray-700 mb-2">Wishlist Kosong</h3>
            <p class="text-gray-500 mb-6">Kamu belum menyimpan barang favorit apapun.</p>
            <a href="{{ route('home') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-full hover:bg-blue-700 transition shadow-lg hover:shadow-xl font-medium">
                Cari Barang Sekarang
            </a>
        </div>

    @else
        
        {{-- Grid Produk --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($wishlists as $item)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden relative group hover:shadow-lg transition duration-300">
                
                {{-- Tombol Hapus (Sampah) - Muncul saat Hover --}}
                <form action="{{ route('wishlist.toggle', $item->product->id) }}" method="POST" class="absolute top-2 right-2 z-20 opacity-0 group-hover:opacity-100 transition duration-300">
                    @csrf
                    <button type="submit" class="bg-white text-red-500 rounded-full p-2 shadow-md hover:bg-red-50 hover:scale-110 transition transform" title="Hapus dari Wishlist">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
                
                <a href="{{ route('product.detail', $item->product->id) }}" class="block h-full flex flex-col">
                    {{-- Gambar Produk --}}
                    <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden relative">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="text-gray-400 text-sm flex flex-col items-center">
                                <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                No Image
                            </div>
                        @endif
                        {{-- Overlay Gelap saat Hover --}}
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-5 transition duration-300"></div>
                    </div>

                    {{-- Detail Produk --}}
                    <div class="p-4 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm leading-tight mb-2 line-clamp-2 min-h-[40px]">{{ $item->product->name }}</h3>
                            <p class="text-blue-600 font-bold text-lg">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100">
                            <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-blue-600 shrink-0">
                                {{ substr($item->product->store->name ?? 'S', 0, 1) }}
                            </div>
                            <p class="text-xs text-gray-500 truncate">{{ $item->product->store->name ?? 'Toko' }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    @endif

@endsection