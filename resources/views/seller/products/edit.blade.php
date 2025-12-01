@extends('layouts.seller')

@section('title', 'Edit Produk')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Produk') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            {{-- Tambahkan penanganan Error Validation --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    <p class="font-bold">Terjadi Kesalahan:</p>
                    <ul class="list-disc ml-5 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                
                <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') 
                    
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">Nama Produk</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror" required>
                        @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700 font-bold mb-2">Kategori</label>
                        <select id="category_id" name="category_id" class="w-full border rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="price" class="block text-gray-700 font-bold mb-2">Harga (Rp)</label>
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror" required min="0">
                            @error('price') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="stock" class="block text-gray-700 font-bold mb-2">Stok</label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500 @error('stock') border-red-500 @enderror" required min="0">
                            @error('stock') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                        <textarea id="description" name="description" class="w-full border rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror" rows="4" required>{{ old('description', $product->description) }}</textarea>
                        @error('description') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="image" class="block text-gray-700 font-bold mb-2">Gambar Produk</label>
                        
                        @if($product->image)
                            <div class="mb-2">
                                <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-32 h-32 object-cover rounded border border-gray-300" alt="Gambar Produk Saat Ini">
                            </div>
                        @endif

                        <input type="file" id="image" name="image" class="w-full border rounded px-3 py-2 @error('image') border-red-500 @enderror" accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                        @error('image') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('seller.products.index') }}" class="text-gray-500 hover:text-gray-700 font-bold transition duration-150 ease-in-out">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700 transition duration-150 ease-in-out shadow-md">
                            Update Produk
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection