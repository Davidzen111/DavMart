{{-- 1. Gunakan Layout Buyer --}}
@extends('layouts.buyer')

{{-- 2. Set Judul Halaman --}}
@section('title', 'Detail Pesanan - DavMart')

{{-- 3. Isi Konten --}}
@section('content')

    {{-- HEADER HALAMAN --}}
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('orders.index') }}" 
           class="group flex items-center justify-center w-10 h-10 bg-white border border-gray-200 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 ease-in-out shadow-sm"
           aria-label="Kembali ke Riwayat">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-200 group-hover:-translate-x-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </a>

        <div>
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                {{ __('Detail Pesanan') }}
            </h2>
            {{-- PERBAIKAN NOMOR ORDER: Pakai ID jika order_number kosong --}}
            <p class="text-sm text-gray-500 font-mono tracking-wide">
                #{{ $order->order_number ?? 'INV-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
            </p>
        </div>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    @endif

    {{-- KONTEN UTAMA --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
        
        {{-- BAGIAN ATAS: STATUS & TANGGAL --}}
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Tanggal Order</p>
                <p class="font-bold text-gray-800">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
            
            <div class="text-left sm:text-right flex items-center gap-4">
                {{-- LOGIKA TOMBOL BATAL (Hanya muncul jika Pending) --}}
                @if($order->status == 'pending')
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Stok akan dikembalikan.');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 underline font-bold">
                            Batalkan Pesanan
                        </button>
                    </form>
                @endif

                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1 text-right">Status</p>
                    @php
                        $statusClass = match($order->status) {
                            'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                            'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'shipped' => 'bg-purple-100 text-purple-700 border-purple-200',
                            'completed' => 'bg-green-100 text-green-700 border-green-200',
                            'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                            default => 'bg-gray-100 text-gray-700'
                        };
                        $statusLabel = match($order->status) {
                            'pending' => 'Menunggu Pembayaran',
                            'processing' => 'Sedang Diproses',
                            'shipped' => 'Dalam Pengiriman',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                            default => strtoupper($order->status)
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <h3 class="font-bold text-gray-800 text-lg mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Barang yang dibeli
            </h3>

            {{-- LIST ITEM --}}
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition duration-200">
                    
                    {{-- Info Produk --}}
                    <div class="flex items-center gap-4 mb-4 sm:mb-0">
                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden shrink-0 border border-gray-200">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                            @else
                                <span class="flex items-center justify-center h-full text-xs text-gray-400 font-medium">No IMG</span>
                            @endif
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg leading-tight mb-1">
                                <a href="{{ route('product.detail', $item->product_id) }}" class="hover:text-blue-600 transition">{{ $item->product->name ?? 'Produk Dihapus' }}</a>
                            </h4>
                            
                            @if($item->product && $item->product->store)
                            <div class="flex items-center gap-1.5 mb-2">
                                <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center text-[10px] font-bold text-blue-600">
                                    {{ substr($item->product->store->name, 0, 1) }}
                                </div>
                                <p class="text-xs text-gray-500 font-medium">{{ $item->product->store->name }}</p>
                            </div>
                            @endif

                            <p class="text-sm text-gray-600 bg-gray-50 inline-block px-2 py-1 rounded">
                                {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Harga & Aksi --}}
                    <div class="text-left sm:text-right pl-24 sm:pl-0">
                        <p class="font-bold text-blue-600 text-lg mb-2">
                            Rp {{ number_format(($item->price * $item->quantity), 0, ',', '.') }}
                        </p>

                        @if($order->status == 'completed')
                            <a href="{{ route('reviews.create', ['productId' => $item->product_id, 'orderId' => $order->id]) }}" 
                               class="inline-flex items-center gap-1 text-xs bg-yellow-50 text-yellow-700 border border-yellow-200 hover:bg-yellow-100 hover:border-yellow-300 font-bold py-1.5 px-3 rounded-lg transition shadow-sm">
                                <svg class="w-3 h-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Beri Ulasan
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- BAGIAN BAWAH: TOTAL & ALAMAT --}}
            <div class="mt-8 flex flex-col md:flex-row justify-between items-start gap-8 border-t border-gray-100 pt-6">
                
                {{-- Alamat Pengiriman --}}
                <div class="w-full md:w-1/2">
                    <h4 class="font-bold text-gray-700 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Alamat Pengiriman
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg text-sm text-gray-600 leading-relaxed border border-gray-200">
                        {{ $order->shipping_address }}
                    </div>
                </div>

                {{-- Total Pembayaran --}}
                <div class="w-full md:w-1/2 md:text-right">
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wide font-bold">Total Pembayaran</p>
                    <h3 class="text-4xl font-extrabold text-blue-600">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">Sudah termasuk pajak & biaya layanan</p>
                </div>

            </div>
            
        </div>
    </div>

@endsection