@extends('layouts.seller')

@section('title', 'Pengaturan Toko')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Pengaturan Toko') }}
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
                
                <div class="w-full p-8">

                    {{-- ALERT SUCCESS --}}
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- ALERT ERROR --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-sm">
                            <p class="font-bold">Terjadi Kesalahan Saat Menyimpan Data:</p>
                            <ul class="list-disc ml-5 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @php
                        $store = $store ?? Auth::user()->store ?? (object)[
                            'name' => '',
                            'description' => '',
                            'image' => ''
                        ];
                    @endphp

                    <div class="max-w-2xl">
                        <h3 class="text-xl font-bold text-gray-800 mb-1 border-b pb-2">Pengaturan Informasi Toko Anda</h3>
                        <p class="text-gray-500 text-sm mb-6">Perbarui nama, deskripsi, dan gambar (logo) toko Anda.</p>

                        <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            {{-- NAMA TOKO --}}
                            <div class="mb-4">
                                <label for="store_name" class="block text-gray-700 font-bold mb-2">Nama Toko</label>
                                <input type="text" id="store_name" name="name"
                                            value="{{ old('name', $store->name) }}"
                                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 
                                            focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                            required>
                                @error('name')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- DESKRIPSI TOKO --}}
                            <div class="mb-4">
                                <label for="store_description" class="block text-gray-700 font-bold mb-2">Deskripsi Toko</label>
                                <textarea id="store_description" name="description" rows="4"
                                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none 
                                            focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $store->description) }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Ceritakan sedikit tentang apa yang Anda jual.</p>
                                @error('description')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- GAMBAR TOKO --}}
                            <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                                <label for="store_image" class="block text-gray-700 font-bold mb-3">Gambar Toko (Logo)</label>

                                {{-- GAMBAR SAAT INI --}}
                                @if($store->image)
                                    <div class="mb-3">
                                        <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
                                        <img id="currentImage"
                                                    src="{{ asset('storage/' . $store->image) }}"
                                                    class="w-20 h-20 object-cover rounded-full border-4 border-white shadow-md"
                                                    alt="Logo Toko">
                                    </div>
                                @endif

                                {{-- PREVIEW GAMBAR BARU --}}
                                <div>
                                    <img id="previewImage" 
                                            class="hidden w-20 h-20 object-cover rounded-full border-2 border-blue-300 mb-3 shadow">
                                </div>

                                {{-- INPUT GAMBAR --}}
                                <input type="file" id="store_image" name="image"
                                            class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full 
                                            file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 
                                            hover:file:bg-blue-100 transition duration-300 @error('image') border-red-500 @enderror"
                                            accept="image/*" onchange="previewLogo(event)">

                                <p class="text-xs text-gray-500 mt-2">
                                    Unggah logo baru (Maks: 2MB). Kosongkan jika tidak ingin mengubah.
                                </p>

                                @error('image')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- TOMBOL SIMPAN --}}
                            <button type="submit"
                                        class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700 
                                        transition shadow-md">
                                Simpan Perubahan
                            </button>

                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>

    {{-- SCRIPT PREVIEW GAMBAR --}}
    <script>
        function previewLogo(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('previewImage');

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        }
    </script>

@endsection