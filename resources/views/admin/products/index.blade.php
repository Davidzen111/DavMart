@extends('layouts.admin')

@section('title', 'Monitoring Produk - Admin')

@section('content')

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-0 hidden md:block">
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium 
                           rounded-md shadow-sm text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none 
                           focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard Admin
                </a>
            </div>

            {{-- HEADER MOBILE (Tombol Kembali & Judul) --}}
            <div class="md:hidden mb-6 px-4 sm:px-0 flex flex-col relative"> 
                
                <div class="w-full mb-2"> 
                    <a href="{{ route('admin.dashboard') }}" 
                        class="text-gray-600 text-sm hover:text-gray-800 font-medium z-10">
                        ← Kembali
                    </a>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-800 w-full text-center">Semua Produk (Monitoring)</h2>
            </div>

            {{-- CONTAINER UTAMA (Tabel Monitoring) --}}
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100">
                
                <div class="w-full p-6 md:p-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6 hidden md:block">Semua Produk (Monitoring)</h1>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="bg-white overflow-hidden p-0">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Daftar Semua Produk Penjual</h3>
                        
                        {{-- Tabel Produk --}}
                        <div class="overflow-x-auto border border-gray-100 rounded-lg">
                            <table class="min-w-full bg-white text-sm">
                                <thead class="bg-red-50 text-red-800 uppercase text-xs font-bold tracking-wider">
                                    <tr>
                                        <th class="py-3 px-4 text-left">Nama Produk</th>
                                        <th class="py-3 px-4 text-left">Toko Penjual</th>
                                        <th class="py-3 px-4 text-left">Harga</th>
                                        <th class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-gray-600">
                                    @foreach($products as $product)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-3 px-4 font-bold text-gray-800">{{ $product->name }}</td>
                                        <td class="py-3 px-4 text-sm">{{ $product->store->name }}</td>
                                        <td class="py-3 px-4 font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="py-3 px-4 text-center">
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini karena melanggar aturan?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-600 text-white px-3 py-1.5 rounded-full text-xs font-bold hover:bg-red-700 transition shadow-md hover:shadow-lg">
                                                    Hapus Paksa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection