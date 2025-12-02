@extends('layouts.seller')

@section('title', 'Tambah Produk Baru')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
        
        {{-- Tombol Kembali di Header DIHILANGKAN, dipindahkan ke Content --}}
    </div>
@endsection

@section('content')
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            {{-- TOMBOL KEMBALI KE DAFTAR PRODUK (Ikon Bulat Konsisten) --}}
            <div class="mb-6">
                <a href="{{ request('source') == 'dashboard' ? route('seller.dashboard') : route('seller.products.index') }}"
                    class="inline-flex items-center justify-center w-10 h-10 p-2 border border-slate-300 text-slate-700 bg-white hover:bg-slate-100 focus:outline-none 
                            focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition duration-150 ease-in-out rounded-full shadow-md"
                    title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
            </div>

            {{-- ALERT VALIDATION ERROR (Design Konsisten) --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm shadow-sm">
                    <p class="font-bold">Terjadi Kesalahan Saat Menyimpan Data:</p>
                    <ul class="list-disc ml-5 mt-1 list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- CARD UTAMA FORM (Shadow & Rounded Konsisten) --}}
            <div class="bg-white shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100 p-8 md:p-10">
                <h3 class="text-2xl font-bold text-slate-800 mb-8">Masukkan Detail Produk</h3>
                
                <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="hidden" name="source" value="{{ request('source') }}">

                    {{-- NAMA PRODUK (Input Konsisten) --}}
                    <div class="mb-6">
                        <label for="name" class="block text-slate-700 font-semibold mb-2 text-sm">Nama Produk</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                            class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 
                            focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition 
                            @error('name') border-red-500 @enderror" required placeholder="Contoh: Laptop Gaming Asus ROG">
                        @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- KATEGORI (Input Konsisten) --}}
                    <div class="mb-6">
                        <label for="category_id" class="block text-slate-700 font-semibold mb-2 text-sm">Kategori</label>
                        <select id="category_id" name="category_id" 
                            class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 
                            focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition 
                            @error('category_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- HARGA (Input Konsisten) --}}
                        <div>
                            <label for="price" class="block text-slate-700 font-semibold mb-2 text-sm">Harga (Rp)</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" 
                                class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 
                                focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition 
                                @error('price') border-red-500 @enderror" required min="0" placeholder="150000">
                            @error('price') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- STOK (Input Konsisten) --}}
                        <div>
                            <label for="stock" class="block text-slate-700 font-semibold mb-2 text-sm">Stok</label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock') }}" 
                                class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 
                                focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition 
                                @error('stock') border-red-500 @enderror" required min="0" placeholder="10">
                            @error('stock') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- DESKRIPSI (Input Konsisten) --}}
                    <div class="mb-6">
                        <label for="description" class="block text-slate-700 font-semibold mb-2 text-sm">Deskripsi</label>
                        <textarea id="description" name="description" 
                            class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 
                            focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition 
                            @error('description') border-red-500 @enderror" rows="4" required placeholder="Jelaskan spesifikasi produk...">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- GAMBAR PRODUK (Background & Input File Konsisten) --}}
                    <div class="mb-8 p-6 border border-slate-200 rounded-xl bg-slate-50 shadow-inner">
                        <label for="image" class="block text-slate-700 font-semibold mb-3 text-sm">Gambar Produk</label>
                        <input type="file" id="image" name="image" 
                            class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-full 
                            file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 
                            hover:file:bg-blue-100 transition duration-300 @error('image') border-red-500 @enderror" 
                            accept="image/*" required>
                        <p class="text-xs text-slate-500 mt-2">Format: JPG, PNG. Max: 2MB</p>
                        @error('image') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- TOMBOL AKSI (Garis, Spacing, dan Tombol Konsisten) --}}
                    <div class="flex items-center justify-between gap-4 pt-4 border-t border-slate-100">
                        <a href="{{ request('source') == 'dashboard' ? route('seller.dashboard') : route('seller.products.index') }}" 
                            class="text-slate-500 hover:text-red-600 font-bold transition duration-300">
                            Batal
                        </a>

                        <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 bg-blue-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-700 
                            transition shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0V4a2 2 0 00-2-2l-3 4-2 2"></path></svg>
                            Simpan Produk
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection