@extends('layouts.seller')

@section('title', 'Produk Saya')

@section('header')
    <h2 class="font-bold text-xl text-slate-800 leading-tight">
        {{ __('Produk Saya') }}
    </h2>
@endsection

@section('content')
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- TOMBOL KEMBALI KE DASHBOARD SELLER (Simbol Ikon Konsisten) --}}
            <div class="mb-6">
                <a href="{{ route('seller.dashboard') }}"
                    class="inline-flex items-center justify-center w-10 h-10 p-2 border border-slate-300 text-slate-700 bg-white hover:bg-slate-100 focus:outline-none 
                            focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition duration-150 ease-in-out rounded-full shadow-md"
                    title="Kembali ke Dashboard">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
            </div>

            {{-- CARD UTAMA DAFTAR PRODUK (Shadow Konsisten) --}}
            <div class="overflow-hidden bg-white shadow-xl shadow-slate-200/50 sm:rounded-2xl border border-slate-100">

                <div class="w-full p-6 lg:p-8">

                    {{-- ALERT SUCCESS (Design Konsisten) --}}
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-8 text-sm shadow-sm">
                            Berhasil! {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-2xl font-bold text-slate-800">Daftar Produk Toko</h3>

                        {{-- Tombol Tambah Produk (Design Konsisten) --}}
                        <a href="{{ route('seller.products.create') }}"
                            class="inline-flex items-center gap-2 bg-slate-900 text-white px-5 py-2.5 rounded-xl hover:bg-slate-800 transition shadow-lg text-sm font-bold shadow-slate-400/50 transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Produk Baru
                        </a>
                    </div>

                    {{-- TABEL PRODUK (Rounded-xl, Shadow, Border Konsisten) --}}
                    <div class="overflow-x-auto border border-slate-200 rounded-xl shadow-md">
                        <table class="min-w-full table-auto bg-white border-collapse">
                            {{-- Table Header --}}
                            <thead class="bg-slate-100 border-b border-slate-200">
                                <tr>
                                    {{-- Padding diubah ke py-3.5 untuk sentuhan yang lebih elegan --}}
                                    <th class="py-3.5 px-4 text-center text-xs font-bold text-slate-600 uppercase w-12 tracking-wider">No</th>
                                    <th class="py-3.5 px-4 text-left text-xs font-bold text-slate-600 uppercase w-20 tracking-wider">Gambar</th>
                                    <th class="py-3.5 px-4 text-left text-xs font-bold text-slate-600 uppercase w-1/3 tracking-wider">Info Produk</th>
                                    <th class="py-3.5 px-4 text-left text-xs font-bold text-slate-600 uppercase w-28 tracking-wider">Harga</th>
                                    <th class="py-3.5 px-4 text-center text-xs font-bold text-slate-600 uppercase w-16 tracking-wider">Stok</th>
                                    <th class="py-3.5 px-4 text-center text-xs font-bold text-slate-600 uppercase w-40 tracking-wider">Aksi</th>
                                </tr>
                            </thead>

                            {{-- Table Body --}}
                            <tbody class="divide-y divide-slate-100">
                                @forelse($products as $product)
                                <tr class="hover:bg-slate-50 transition">
                                    
                                    {{-- Iteration Number --}}
                                    <td class="py-4 px-4 text-center text-sm font-semibold text-slate-700">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- Product Image + Preview --}}
                                    <td class="py-4 px-4 relative group">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                class="w-14 h-14 object-cover rounded-lg border border-slate-200 shadow-sm cursor-pointer"
                                                alt="Gambar Produk">

                                            {{-- Preview Besar Saat Hover --}}
                                            <div class="absolute left-16 top-1/2 -translate-y-1/2 hidden group-hover:block z-40">
                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                    class="w-40 h-40 object-cover rounded-xl border border-slate-300 shadow-xl bg-white">
                                            </div>

                                        @else
                                            <div class="w-14 h-14 bg-slate-100 rounded-lg flex items-center justify-center 
                                                        text-xs text-slate-400 border border-slate-200 font-medium">
                                                No Pic
                                            </div>
                                        @endif
                                    </td>


                                    {{-- Product Info --}}
                                    <td class="py-4 px-4">
                                        <p class="font-semibold text-slate-900 text-sm leading-snug">{{ $product->name }}</p>
                                        <span class="text-xs text-slate-600 bg-slate-100 px-2 py-0.5 rounded-lg inline-block mt-1 font-medium">
                                            {{ $product->category->name }}
                                        </span>
                                    </td>

                                    {{-- Price (Biru terang & tebal) --}}
                                    <td class="py-4 px-4 text-slate-600 font-extrabold text-sm">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </td>

                                    {{-- Stock Status (Pill Badge) --}}
                                    <td class="py-4 px-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold
                                            {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="py-4 px-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('seller.products.edit', $product->id) }}"
                                                class="text-blue-600 border border-blue-200 hover:bg-blue-600 hover:text-white 
                                                        px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                                                Edit
                                            </a>

                                            <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST"
                                                     onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 border border-red-200 hover:bg-red-600 hover:text-white 
                                                                px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-10 text-slate-500 text-sm">
                                        <p class="font-semibold text-slate-700 mb-2">Belum ada produk.</p>
                                        Klik tombol <strong>+ Tambah Produk Baru</strong> di atas untuk mulai berjualan.
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