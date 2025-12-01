@extends('layouts.buyer')

@section('title', 'Riwayat Pesanan - DavMart')

@section('content')
    
    {{-- 
        CATATAN: 
        Tag <main> dan <div class="max-w-7xl"> sudah ada di Layout, 
        jadi kita langsung masuk ke konten intinya saja agar rapi.
    --}}

    {{-- SECTION: WELCOME CARD --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 border border-gray-100 mt-4">
        <div class="p-6 text-gray-900 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                {{-- Bulatan Profil --}}
                <div class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold uppercase shadow-sm border-4 border-blue-50">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-sm text-gray-500">Selamat datang kembali di Dashboard.</p>
                </div>
            </div>
            <a href="{{ route('home') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition font-bold text-sm shadow-md flex items-center gap-2">
                🛍️ Belanja Lagi
            </a>
        </div>
    </div>

    {{-- SECTION: STATISTIK --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        {{-- Card 1: Total Pesanan --}}
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center hover:shadow-md transition">
            <div class="p-3 bg-blue-100 text-blue-600 rounded-full mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pesanan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $orders->count() }}</p>
            </div>
        </div>

        {{-- Card 2: Dalam Proses --}}
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center hover:shadow-md transition">
            <div class="p-3 bg-yellow-100 text-yellow-600 rounded-full mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Dalam Proses</p>
                <p class="text-2xl font-bold text-gray-800">
                    {{ $orders->whereIn('status', ['pending', 'processing', 'shipped'])->count() }}
                </p>
            </div>
        </div>

        {{-- Card 3: Selesai --}}
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center hover:shadow-md transition">
            <div class="p-3 bg-green-100 text-green-600 rounded-full mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Selesai</p>
                <p class="text-2xl font-bold text-gray-800">{{ $orders->where('status', 'completed')->count() }}</p>
            </div>
        </div>
    </div>

    {{-- SECTION: RIWAYAT PESANAN --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
        <div class="p-6">
            <h3 class="text-lg font-bold mb-6 text-gray-800 flex items-center">
                <span class="bg-blue-100 text-blue-600 p-1.5 rounded mr-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </span>
                Riwayat Pesanan Terbaru
            </h3>

            @if($orders->isEmpty())
                <div class="text-center py-16 border-2 border-dashed border-gray-100 rounded-lg">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 opacity-50">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <p class="text-gray-500 font-medium mb-4">Kamu belum pernah berbelanja.</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                        Mulai Belanja Sekarang
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold tracking-wider">
                            <tr>
                                {{-- KOLOM NOMOR --}}
                                <th class="py-4 px-6 rounded-tl-lg text-center w-16">No</th>
                                <th class="py-4 px-6">Tanggal</th>
                                <th class="py-4 px-6">Total</th>
                                <th class="py-4 px-6">Status</th>
                                <th class="py-4 px-6 rounded-tr-lg text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($orders->take(5) as $order)
                            <tr class="hover:bg-gray-50 transition">
                                
                                {{-- ISI NOMOR URUT --}}
                                <td class="py-4 px-6 text-center font-bold text-gray-500">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- TANGGAL & INVOICE KECIL --}}
                                <td class="py-4 px-6 text-gray-600">
                                    <div class="font-medium">{{ $order->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-blue-500 font-mono mt-1">{{ $order->invoice_code ?? '#' . $order->id }}</div>
                                </td>

                                <td class="py-4 px-6 font-bold text-gray-800">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6">
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
                                            'pending' => 'Menunggu Bayar',
                                            'processing' => 'Diproses',
                                            'shipped' => 'Dikirim',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Batal',
                                            default => $order->status
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-300 transition shadow-sm" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection