@extends('layouts.buyer')

@section('title', 'Riwayat Pesanan - DavMart')

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

    {{-- HEADER HALAMAN --}}
    <div class="mb-8 flex items-center gap-4 mt-4">
        
        {{-- TOMBOL KEMBALI --}}
        <a href="{{ $backRoute ?? route('home') }}" 
           class="group flex items-center justify-center w-10 h-10 bg-white border border-gray-200 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 ease-in-out shadow-sm"
           aria-label="{{ $ariaLabel ?? 'Kembali ke Beranda' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-200 group-hover:-translate-x-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </a>

        <div>
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                {{ __('Riwayat Pesanan Saya') }} 📦
            </h2>
        </div>
    </div>

    {{-- WRAPPER KONTEN --}}
    <div>
        
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- LOGIKA TAMPILAN PESANAN --}}
        @if($orders->isEmpty())
            
            {{-- State Kosong --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 text-center flex flex-col items-center justify-center min-h-[400px] border border-gray-100">
                <div class="text-6xl mb-4 opacity-50 grayscale">📄</div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum ada riwayat pesanan</h3>
                <p class="text-gray-500 mb-6">Kamu belum pernah melakukan transaksi apapun.</p>
                <a href="{{ route('home') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-full hover:bg-blue-700 transition shadow-lg hover:shadow-xl font-medium">
                    Mulai Belanja
                </a>
            </div>

        @else
            
            {{-- Tabel Pesanan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Daftar Transaksi</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white mb-2">
                            <thead>
                                <tr class="text-gray-500 uppercase text-xs leading-normal font-semibold tracking-wider border-b border-gray-200 bg-gray-50">
                                    <th class="py-3 px-6 text-center rounded-tl-lg w-16">No</th>
                                    <th class="py-3 px-6">Tanggal</th>
                                    <th class="py-3 px-6 text-center">Total</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                    <th class="py-3 px-6 text-center rounded-tr-lg">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm">
                                @foreach($orders->take(10) as $order)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition last:border-0">
                                    
                                    {{-- Nomor Urut --}}
                                    <td class="py-4 px-6 text-center font-bold text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- Tanggal & Invoice Kecil --}}
                                    <td class="py-4 px-6 text-gray-600">
                                        <div class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                        <div class="text-xs text-blue-500 font-mono mt-1">{{ $order->invoice_code }}</div>
                                    </td>

                                    {{-- Total --}}
                                    <td class="py-4 px-6 text-center font-bold text-gray-800">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>

                                    {{-- Status Badge --}}
                                    <td class="py-4 px-6 text-center">
                                        @php
                                            $statusClass = match($order->status) {
                                                'pending' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                                'processing' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                                'shipped' => 'bg-purple-100 text-purple-800 border border-purple-200',
                                                'completed' => 'bg-green-100 text-green-800 border border-green-200',
                                                'cancelled' => 'bg-red-100 text-red-800 border border-red-200',
                                                default => 'bg-gray-100 text-gray-800 border border-gray-200'
                                            };
                                            $statusLabel = match($order->status) {
                                                'pending' => 'Menunggu Bayar',
                                                'processing' => 'Diproses',
                                                'shipped' => 'Dikirim',
                                                'completed' => 'Selesai',
                                                'cancelled' => 'Batal',
                                                default => $order->status
                                            };
                                        @endphp
                                        <span class="{{ $statusClass }} py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide inline-block min-w-[80px]">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    {{-- Tombol Detail --}}
                                    <td class="py-4 px-6 text-center">
                                        <a href="{{ route('orders.show', $order->id) }}" 
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors duration-200 border border-blue-100 hover:border-blue-600" 
                                           title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        @endif
    </div>

@endsection