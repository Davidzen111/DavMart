@extends('layouts.buyer')

@section('title', 'Riwayat Pesanan - DavMart')

@section('content')
    
    {{-- SECTION: WELCOME CARD --}}
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-200/50 rounded-2xl mb-8 border border-slate-100 mt-4">
        <div class="p-6 text-slate-900 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                {{-- Bulatan Profil (Inisial) --}}
                <div class="w-14 h-14 bg-slate-900 text-white rounded-full flex items-center justify-center text-xl font-extrabold uppercase shadow-md border-4 border-slate-100">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Halo, {{ Auth::user()->name }}! </h3>
                    <p class="text-sm text-slate-500">Selamat datang kembali di Dashboard.</p>
                </div>
            </div>
            <a href="{{ route('home') }}" class="bg-slate-900 text-white px-5 py-2.5 rounded-xl hover:bg-slate-800 transition font-bold text-sm shadow-lg shadow-slate-400/50 transform hover:-translate-y-0.5 flex items-center gap-2">
                Belanja Lagi
            </a>
        </div>
    </div>

    {{-- SECTION: STATISTIK RINGKAS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-lg flex items-center hover:shadow-xl transition">
            <div class="p-3 bg-slate-100 text-slate-700 rounded-full mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Total Pesanan</p>
                <p class="text-2xl font-bold text-slate-800">{{ $orders->count() }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-lg flex items-center hover:shadow-xl transition">
            <div class="p-3 bg-amber-100 text-amber-600 rounded-full mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Dalam Proses</p>
                <p class="text-2xl font-bold text-slate-800">
                    {{ $orders->whereIn('status', ['pending', 'processing', 'shipped'])->count() }}
                </p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-lg flex items-center hover:shadow-xl transition">
            <div class="p-3 bg-green-100 text-green-600 rounded-full mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Selesai</p>
                <p class="text-2xl font-bold text-slate-800">{{ $orders->where('status', 'completed')->count() }}</p>
            </div>
        </div>
    </div>

    {{-- SECTION: RIWAYAT PESANAN --}}
    <div class="bg-white overflow-hidden shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100">
        <div class="p-6 md:p-8">
            <h3 class="text-xl font-bold mb-8 text-slate-800 flex items-center">
                <span class="bg-amber-100 text-amber-600 p-1.5 rounded-lg mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </span>
                Riwayat Pesanan Terbaru
            </h3>

            @if($orders->isEmpty())
                <div class="text-center py-16 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 opacity-70">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <p class="text-slate-600 font-bold text-lg mb-4">Kamu belum pernah berbelanja.</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-2.5 bg-slate-900 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-slate-800 transition shadow-lg shadow-slate-400/50 transform hover:-translate-y-0.5">
                        Mulai Belanja Sekarang
                    </a>
                </div>
            @else
                <div class="overflow-x-auto border border-slate-200 rounded-xl shadow-md">
                    <table class="min-w-full text-sm text-left bg-white">
                        <thead class="bg-slate-100 text-slate-600 uppercase text-xs font-bold tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="py-3.5 px-6 rounded-tl-xl text-center w-16">No</th>
                                <th class="py-3.5 px-6">Tanggal</th>
                                <th class="py-3.5 px-6">Total</th>
                                <th class="py-3.5 px-6">Status</th>
                                <th class="py-3.5 px-6 rounded-tr-xl text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($orders->take(5) as $order)
                            <tr class="hover:bg-slate-50 transition">
                                
                                <td class="py-4 px-6 text-center font-semibold text-slate-700">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="py-4 px-6 text-slate-600">
                                    <div class="font-medium text-slate-800">{{ $order->created_at->format('d M Y') }}</div>
                                </td>

                                <td class="py-4 px-6 font-bold text-slate-900">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                
                                <td class="py-4 px-6">
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
                                            'delivered' => 'Selesai',
                                            'cancelled' => 'Batal',
                                            default => $order->status
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-amber-600 hover:border-amber-300 transition shadow-sm" title="Lihat Detail">
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