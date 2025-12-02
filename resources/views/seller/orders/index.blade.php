@extends('layouts.seller')

@section('title', 'Pesanan Masuk')

@section('header')
    <h2 class="font-bold text-xl text-slate-800 leading-tight">
        {{ __('Pesanan Masuk') }}
    </h2>
@endsection

@section('content')
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- TOMBOL KEMBALI KE DASHBOARD SELLER (Ikon Bulat Konsisten) --}}
            <div class="mb-6 flex justify-between items-center">
                {{-- Tombol Kembali Desktop --}}
                <a href="{{ route('seller.dashboard') }}"
                    class="inline-flex items-center justify-center w-10 h-10 p-2 border border-slate-300 text-slate-700 bg-white hover:bg-slate-100 focus:outline-none 
                            focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition duration-150 ease-in-out rounded-full shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
            </div>

            {{-- CONTAINER UTAMA --}}
            <div class="bg-white shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100 min-h-screen">
                
                {{-- KONTEN UTAMA --}}
                <div class="w-full p-6 md:p-8">
                    
                    {{-- ALERT SUCCESS --}}
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm shadow-sm">
                            Berhasil! {{ session('success') }}
                        </div>
                    @endif
                    
                    {{-- ALERT ERROR --}}
                    @if(session('error'))
                        <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm shadow-sm">
                            Gagal! {{ session('error') }}
                        </div>
                    @endif

                    <h3 class="text-2xl font-bold mb-6 text-slate-800">Daftar Pesanan Perlu Dikirim </h3>

                    @if($orderItems->isEmpty())
                        <div class="text-center py-20 bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <p class="text-slate-500 font-medium text-lg">Belum ada pesanan masuk saat ini.</p>
                            <p class="text-sm text-slate-400">Silakan cek lagi nanti.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-slate-200 rounded-xl shadow-md">
                            <table class="min-w-full bg-white">
                                {{-- Table Header --}}
                                <thead class="bg-slate-100 border-b border-slate-200">
                                    <tr>
                                        <th class="py-3.5 px-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Produk</th>
                                        <th class="py-3.5 px-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Pembeli</th>
                                        <th class="py-3.5 px-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Jml</th>
                                        <th class="py-3.5 px-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Total</th>
                                        <th class="py-3.5 px-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider w-[180px]">Update Status</th>
                                    </tr>
                                </thead>
                                {{-- Table Body --}}
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($orderItems as $item)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="py-3 px-4">
                                            <div class="font-semibold text-slate-800 text-sm">{{ $item->product->name }}</div>
                                            <div class="text-xs text-slate-500">Inv: <span class="font-medium text-slate-600">{{ $item->order->invoice_code }}</span></div>
                                        </td>
                                        <td class="py-3 px-4 text-sm">
                                            <div class="font-medium text-slate-700">{{ $item->order->user->name }}</div>
                                            <div class="text-xs text-slate-400">{{ $item->order->user->email }}</div>
                                        </td>
                                        <td class="py-3 px-4 text-center text-sm font-semibold text-slate-700">{{ $item->quantity }}</td>
                                        <td class="py-3 px-4 text-center font-extrabold text-green-700 text-sm">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <form action="{{ route('seller.orders.update', $item->id) }}" method="POST" class="flex items-center gap-2 justify-center">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <select name="status" class="text-xs border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500/50 py-1 px-2 text-slate-700">
                                                    <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="processing" {{ $item->status == 'processing' ? 'selected' : '' }}>Proses</option>
                                                    <option value="shipped" {{ $item->status == 'shipped' ? 'selected' : '' }}>Kirim</option>
                                                    <option value="delivered" {{ $item->status == 'delivered' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="cancelled" {{ $item->status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                                </select>

                                                <button type="submit" class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition shadow-md" title="Simpan Perubahan Status">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0V4a2 2 0 00-2-2l-3 4-2 2"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection