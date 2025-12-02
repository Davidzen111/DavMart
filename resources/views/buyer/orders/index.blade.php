@extends('layouts.buyer')

@section('title', 'Riwayat Pesanan - DavMart')

@section('content')

    {{-- HEADER HALAMAN --}}
    <div class="mb-8 flex items-center gap-4 mt-4">
        
        {{-- TOMBOL KEMBALI (Ikon Bulat Konsisten) --}}
        <a href="{{ $backRoute ?? route('home') }}" 
            class="group flex items-center justify-center w-10 h-10 bg-white border border-slate-300 rounded-full text-slate-700 hover:text-amber-600 hover:bg-slate-50 hover:border-amber-400 transition-all duration-200 ease-in-out shadow-md"
            aria-label="{{ $ariaLabel ?? 'Kembali ke Beranda' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-200 group-hover:-translate-x-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </a>

        <div>
            <h2 class="text-2xl font-bold text-slate-800 leading-tight">
                {{ __('Riwayat Pesanan Saya') }} 
            </h2>
        </div>
    </div>

    {{-- WRAPPER KONTEN --}}
    <div>
        
        {{-- Flash Messages (Design Konsisten) --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Berhasil! {{ session('success') }}
            </div>
        @endif

        {{-- LOGIKA TAMPILAN PESANAN --}}
        @if($orders->isEmpty())
            
            {{-- State Kosong (Design Konsisten) --}}
            <div class="bg-white overflow-hidden shadow-xl shadow-slate-200/50 rounded-2xl p-10 text-center flex flex-col items-center justify-center min-h-[400px] border border-slate-100">
                <div class="text-6xl mb-4 opacity-50 grayscale text-slate-400">📄</div>
                <h3 class="text-xl font-bold text-slate-700 mb-2">Belum ada riwayat pesanan</h3>
                <p class="text-slate-500 mb-6">Kamu belum pernah melakukan transaksi apapun.</p>
                <a href="{{ route('home') }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl hover:bg-slate-800 transition shadow-lg hover:shadow-xl font-bold transform hover:-translate-y-0.5">
                    Mulai Belanja
                </a>
            </div>

        @else
            
            {{-- Tabel Pesanan --}}
            <div class="bg-white overflow-hidden shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100">
                <div class="p-6 md:p-8">
                    <h3 class="text-xl font-bold mb-4 border-b border-slate-100 pb-2 text-slate-800">Daftar Transaksi</h3>

                    <div class="overflow-x-auto border border-slate-200 rounded-xl shadow-md">
                        <table class="min-w-full bg-white mb-2">
                            {{-- Table Header --}}
                            <thead class="bg-slate-100 text-slate-600 uppercase text-xs leading-normal font-bold tracking-wider border-b border-slate-200">
                                <tr>
                                    <th class="py-3.5 px-6 text-center rounded-tl-xl w-16">No</th>
                                    <th class="py-3.5 px-6">Tanggal</th>
                                    <th class="py-3.5 px-6 text-center">Total</th>
                                    <th class="py-3.5 px-6 text-center">Status</th>
                                    <th class="py-3.5 px-6 text-center rounded-tr-xl">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-slate-700 text-sm divide-y divide-slate-100">
                                @foreach($orders->take(10) as $order)
                                <tr class="hover:bg-slate-50 transition">
                                    
                                    {{-- Nomor Urut --}}
                                    <td class="py-4 px-6 text-center font-semibold text-slate-700">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- Tanggal & Invoice Kecil --}}
                                    <td class="py-4 px-6 text-slate-600">
                                        <div class="font-medium text-slate-800">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                        {{-- Warna invoice/order number menggunakan Amber --}}
                                        <div class="text-xs text-amber-600 font-mono mt-1">{{ $order->invoice_code }}</div>
                                    </td>

                                    {{-- Total --}}
                                    <td class="py-4 px-6 text-center font-bold text-slate-900">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>

                                    {{-- Status Badge --}}
                                    <td class="py-4 px-6 text-center">
                                        @php
                                            $statusClass = match($order->status) {
                                                'pending' => 'bg-amber-100 text-amber-700 border-amber-300',
                                                'processing' => 'bg-sky-100 text-sky-700 border-sky-300',
                                                'shipped' => 'bg-indigo-100 text-indigo-700 border-indigo-300',
                                                'completed' => 'bg-green-100 text-green-700 border-green-300',
                                                'cancelled' => 'bg-red-100 text-red-700 border-red-300',
                                                default => 'bg-slate-100 text-slate-700 border-slate-300'
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

                                    {{-- Tombol Detail (Konsisten) --}}
                                    <td class="py-4 px-6 text-center">
                                        <a href="{{ route('orders.show', $order->id) }}" 
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-amber-600 hover:border-amber-300 transition-colors duration-200 shadow-sm" 
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