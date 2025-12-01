@extends('layouts.admin')

@section('title', 'Edit Kategori - Admin')

@section('content')

    {{-- LOGIKA ROUTE KEMBALI --}}
    @php
        $backRoute = route('admin.categories.index');
        $ariaLabel = 'Kembali ke Daftar Kategori';
    @endphp

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            {{-- HEADER HALAMAN KUSTOM (Tombol Kembali) --}}
            <div class="mb-6 flex items-center gap-4 px-4 sm:px-0">
                {{-- Tombol Kembali --}}
                <a href="{{ $backRoute }}" 
                   class="group flex items-center justify-center w-10 h-10 bg-white border border-gray-200 rounded-full text-gray-500 hover:text-red-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 ease-in-out shadow-sm"
                   aria-label="{{ $ariaLabel }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-200 group-hover:-translate-x-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </a>
        
                <h1 class="text-2xl font-bold text-gray-800 leading-tight">Edit Kategori</h1>
            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT') 
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori</label>
                            {{-- Input dengan focus warna Merah --}}
                            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-500 transition" required placeholder="Contoh: Pakaian Pria" autofocus>
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-red-700 font-bold text-sm transition">Batal</a>
                            
                            {{-- Tombol Simpan warna Merah --}}
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition shadow-md">
                                Update Kategori
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection