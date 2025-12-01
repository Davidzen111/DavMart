@extends('layouts.seller')

@section('title', 'Tambah Produk Baru')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
        
        <a href="{{ request('source') == 'dashboard' ? route('seller.dashboard') : route('seller.products.index') }}" 
           class="text-sm text-gray-500 hover:text-gray-700 underline transition">
            &larr; Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Penanganan Error Validasi Laravel --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    <p class="font-bold">Terjadi Kesalahan Saat Menyimpan Data:</p>
                    <ul class="list-disc ml-5 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                
                <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="hidden" name="source" value="{{ request('source') }}">

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">Nama Produk</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" required placeholder="Contoh: Laptop Gaming Asus ROG">
                        @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700 font-bold mb-2">Kategori</label>
                        <select id="category_id" name="category_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="price" class="block text-gray-700 font-bold mb-2">Harga (Rp)</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('price') border-red-500 @enderror" required min="0" placeholder="150000">
                            @error('price') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="stock" class="block text-gray-700 font-bold mb-2">Stok</label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stock') border-red-500 @enderror" required min="0" placeholder="10">
                            @error('stock') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                        <textarea id="description" name="description" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror" rows="4" required placeholder="Jelaskan spesifikasi produk...">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="image" class="block text-gray-700 font-bold mb-2">Gambar Produk</label>
                        <input type="file" id="image" name="image" class="w-full border border-gray-300 rounded px-3 py-2 @error('image') border-red-500 @enderror" accept="image/*" required>
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB</p>
                        @error('image') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                        
                        <a href="{{ request('source') == 'dashboard' ? route('seller.dashboard') : route('seller.products.index') }}" 
                           class="text-gray-500 hover:text-gray-800 font-bold text-sm transition">
                            Batal
                        </a>

                        <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700 transition shadow-lg transform hover:scale-105">
                            Simpan Produk
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection