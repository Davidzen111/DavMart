@extends('layouts.buyer')

@section('title', 'Detail Pesanan - DavMart')

@section('content')

    {{-- HEADER HALAMAN --}}
    <div class="mb-8 flex items-center gap-4 mt-4">
        {{-- Tombol Kembali --}}
        <a href="{{ route('orders.index') }}" 
            class="group flex items-center justify-center w-10 h-10 bg-white border border-slate-300 rounded-full text-slate-700 hover:text-amber-600 hover:bg-slate-50 hover:border-amber-400 transition-all duration-200 ease-in-out shadow-md"
            aria-label="Kembali ke Riwayat">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-200 group-hover:-translate-x-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </a>

        <div>
            <h2 class="text-2xl font-bold text-slate-800 leading-tight">
                {{ __('Detail Pesanan') }}
            </h2>
            <p class="text-sm text-slate-500 font-mono tracking-wide">
                #{{ $order->order_number ?? 'INV-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
            </p>
        </div>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- KONTEN UTAMA --}}
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100">
        
        {{-- BAGIAN ATAS: INFO UTAMA (Layout Diperbaiki) --}}
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            {{-- KIRI: Tanggal --}}
            <div>
                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider mb-0.5">Tanggal Order</p>
                <p class="font-bold text-slate-800 text-sm md:text-base">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
            
            {{-- KANAN: Status & Aksi --}}
            <div class="flex flex-wrap items-center gap-3">
                
                {{-- Tombol Batal (Hanya muncul jika pending) --}}
                @if($order->status == 'pending')
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                        @csrf
                        @method('PATCH')
                        {{-- STYLE TOMBOL DIPERBAIKI: Lebih kecil, outline halus, tidak mendominasi --}}
                        <button type="submit" class="group inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-300 text-slate-600 text-xs font-bold rounded-lg hover:border-red-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200 shadow-sm">
                            <svg class="w-3.5 h-3.5 transition-colors group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Batalkan
                        </button>
                    </form>
                @endif

                {{-- Status Badge --}}
                @php
                    $statusClass = match($order->status) {
                        'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                        'processing' => 'bg-sky-100 text-sky-700 border-sky-200',
                        'shipped' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                        'completed' => 'bg-green-100 text-green-700 border-green-200',
                        'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                        default => 'bg-slate-100 text-slate-700 border-slate-200'
                    };
                    $statusLabel = match($order->status) {
                        'pending' => 'Menunggu Pembayaran',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => strtoupper($order->status)
                    };
                @endphp
                <span class="px-3 py-1.5 rounded-lg text-xs font-bold border {{ $statusClass }} shadow-sm">
                    {{ $statusLabel }}
                </span>
            </div>
        </div>

        {{-- INFO RESI (Jika Ada) --}}
        @if($order->status === 'shipped' && $order->shipping_tracking_number)
            <div class="bg-indigo-50 px-6 py-3 border-b border-indigo-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    <span class="text-xs font-bold text-indigo-800 uppercase tracking-wide">Resi: {{ $order->shipping_tracking_number }}</span>
                </div>
                <a href="https://cekresi.com/?no={{ $order->shipping_tracking_number }}" target="_blank" class="text-xs text-indigo-600 font-bold hover:underline flex items-center gap-1">
                    Lacak <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            </div>
        @endif

        {{-- LIST PRODUK --}}
        <div class="p-6">
            <h3 class="font-bold text-slate-800 text-lg mb-5 flex items-center gap-2 pb-2 border-b border-slate-100">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Detail Barang
            </h3>

            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-white p-4 rounded-xl border border-slate-200 hover:border-amber-200 transition duration-200 shadow-sm">
                    
                    {{-- Info Produk --}}
                    <div class="flex items-center gap-4 mb-4 sm:mb-0">
                        <div class="w-16 h-16 bg-slate-100 rounded-lg overflow-hidden shrink-0 border border-slate-200">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-[10px] text-slate-400">No IMG</div>
                            @endif
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm leading-tight mb-1">
                                <a href="{{ route('product.detail', $item->product_id) }}" class="hover:text-amber-600 transition line-clamp-1">{{ $item->product->name ?? 'Produk Dihapus' }}</a>
                            </h4>
                            
                            @if($item->product && $item->product->store)
                            <div class="flex items-center gap-1.5 mb-1.5">
                                <div class="w-4 h-4 rounded-full bg-slate-100 flex items-center justify-center text-[8px] font-bold text-slate-600 border border-slate-200">
                                    {{ substr($item->product->store->name, 0, 1) }}
                                </div>
                                <p class="text-[10px] text-slate-500 font-medium">{{ $item->product->store->name }}</p>
                            </div>
                            @endif

                            <p class="text-xs text-slate-500">
                                {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Harga Total Item --}}
                    <div class="text-left sm:text-right pl-20 sm:pl-0">
                        <p class="font-bold text-slate-800 text-sm mb-2">
                            Rp {{ number_format(($item->price * $item->quantity), 0, ',', '.') }}
                        </p>

                        @if($order->status == 'completed')
                            <a href="{{ route('reviews.create', ['productId' => $item->product_id, 'orderId' => $order->id]) }}" 
                               class="inline-flex items-center gap-1 text-[10px] bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 font-bold py-1 px-2.5 rounded-lg transition">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Ulas
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- FOOTER: TOTAL PEMBAYARAN --}}
            <div class="mt-8 border-t border-slate-100 pt-6">
                <div class="w-full text-right"> 
                    <p class="text-slate-400 mb-1 text-xs uppercase tracking-wide font-bold">Total Pembayaran</p>
                    <h3 class="text-3xl font-extrabold text-amber-600">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </h3>
                    <p class="text-[10px] text-slate-400 mt-1">Sudah termasuk pajak & biaya layanan</p>
                </div>
            </div>
            
        </div>
    </div>

@endsection