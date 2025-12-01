@extends('layouts.seller')

@section('title', 'Produk Saya')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Produk Saya') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- TOMBOL KEMBALI KE DASHBOARD SELLER --}}
            <div class="mb-4">
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

            <div class="overflow-hidden bg-white shadow-lg sm:rounded-xl min-h-screen">

                <div class="w-full p-6 lg:p-8">

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">Daftar Produk Toko</h3>

                        <a href="{{ route('seller.products.create') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-md text-sm font-bold">
                            + Tambah Produk Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full table-auto bg-white border-collapse rounded-lg">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="py-3 px-4 text-center text-xs font-bold text-gray-600 uppercase w-12">No</th>
                                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase w-20">Gambar</th>
                                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase w-1/3">Info Produk</th>
                                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase w-28">Harga</th>
                                    <th class="py-3 px-4 text-center text-xs font-bold text-gray-600 uppercase w-16">Stok</th>
                                    <th class="py-3 px-4 text-center text-xs font-bold text-gray-600 uppercase w-40">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse($products as $product)
                                <tr class="hover:bg-gray-50 transition">
                                    
                                    <td class="py-3 px-4 text-center text-sm font-semibold text-gray-700">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="py-3 px-4">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                     class="w-14 h-14 object-cover rounded-md border shadow-sm"
                                                     alt="Gambar Produk">
                                        @else
                                            <div class="w-14 h-14 bg-gray-100 rounded-md flex items-center justify-center 
                                                         text-xs text-gray-400 border">
                                                No Pic
                                            </div>
                                        @endif
                                    </td>

                                    <td class="py-3 px-4">
                                        <p class="font-semibold text-gray-900 text-sm leading-tight">{{ $product->name }}</p>
                                        <span class="text-xs text-gray-600 bg-gray-200 px-2 py-1 rounded-md inline-block mt-1">
                                            {{ $product->category->name }}
                                        </span>
                                    </td>

                                    <td class="py-3 px-4 text-blue-700 font-extrabold text-sm">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>

                                    <td class="py-3 px-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold
                                            {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>

                                    <td class="py-3 px-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('seller.products.edit', $product->id) }}"
                                               class="text-blue-600 border border-blue-500 hover:bg-blue-600 hover:text-white 
                                                       px-3 py-1 rounded-md text-xs font-semibold transition shadow-sm">
                                                Edit
                                            </a>

                                            <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                            class="text-red-600 border border-red-500 hover:bg-red-600 hover:text-white 
                                                                   px-3 py-1 rounded-md text-xs font-semibold transition shadow-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-10 text-gray-500 text-sm">
                                        Belum ada produk. Klik tombol 
                                        <strong>+ Tambah Produk Baru</strong> 
                                        di atas untuk mulai berjualan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection