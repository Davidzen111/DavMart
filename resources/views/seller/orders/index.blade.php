@extends('layouts.seller')

@section('title', 'Pesanan Masuk')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Pesanan Masuk') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- TOMBOL KEMBALI KE DASHBOARD SELLER --}}
            <div class="mb-4 hidden md:block">
                <a href="{{ route('seller.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium 
                           rounded-md shadow-sm text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none 
                           focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard Seller
                </a>
            </div>

            {{-- Header Mobile (Tombol Kembali ditambahkan di sini untuk tampilan mobile) --}}
            <div class="md:hidden mb-6 px-4 sm:px-0 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Pesanan Masuk</h2>
                <a href="{{ route('seller.dashboard') }}" class="text-blue-600 text-sm hover:text-blue-800">
                    ← Kembali
                </a>
            </div>

            {{-- CONTAINER UTAMA (Sidebar dihapus, layout disesuaikan) --}}
            <div class="bg-white shadow-sm sm:rounded-lg min-h-screen border border-gray-100">
                
                {{-- KONTEN UTAMA --}}
                <div class="w-full p-6 md:p-8">
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-bold mb-4 text-gray-800">Daftar Pesanan Perlu Dikirim</h3>

                    @if($orderItems->isEmpty())
                        <div class="text-center py-20 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <p class="text-gray-500">Belum ada pesanan masuk saat ini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-gray-200 rounded-lg">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase">Produk</th>
                                        <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase">Pembeli</th>
                                        <th class="py-3 px-4 text-center text-xs font-bold text-gray-500 uppercase">Jml</th>
                                        <th class="py-3 px-4 text-center text-xs font-bold text-gray-500 uppercase">Total</th>
                                        <th class="py-3 px-4 text-center text-xs font-bold text-gray-500 uppercase">Update Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($orderItems as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4">
                                            <div class="font-bold text-gray-800 text-sm">{{ $item->product->name }}</div>
                                            <div class="text-xs text-gray-500">Inv: {{ $item->order->invoice_code }}</div>
                                        </td>
                                        <td class="py-3 px-4 text-sm">
                                            {{ $item->order->user->name }}
                                            <div class="text-xs text-gray-400">{{ $item->order->user->email }}</div>
                                        </td>
                                        <td class="py-3 px-4 text-center text-sm">{{ $item->quantity }}</td>
                                        <td class="py-3 px-4 text-center font-bold text-green-600 text-sm">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <form action="{{ route('seller.orders.update', $item->id) }}" method="POST" class="flex items-center gap-2 justify-center">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <select name="status" class="text-xs border-gray-300 rounded shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-1">
                                                    <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="processing" {{ $item->status == 'processing' ? 'selected' : '' }}>Proses</option>
                                                    <option value="shipped" {{ $item->status == 'shipped' ? 'selected' : '' }}>Kirim</option>
                                                    <option value="delivered" {{ $item->status == 'delivered' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="cancelled" {{ $item->status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                                </select>

                                                <button type="submit" class="bg-blue-600 text-white p-1.5 rounded hover:bg-blue-700 transition" title="Simpan Perubahan Status">
                                                    💾
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