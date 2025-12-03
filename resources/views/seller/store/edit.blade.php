@extends('layouts.seller')

@section('title', 'Pengaturan Toko')

@section('header')
    <h2 class="font-bold text-xl text-slate-800 leading-tight">
        {{ __('Pengaturan Toko') }}
    </h2>
@endsection

@section('content')
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- TOMBOL KEMBALI KE DASHBOARD SELLER --}}
            <div class="mb-6">
                <a href="{{ route('seller.dashboard') }}"
                    class="inline-flex items-center justify-center w-10 h-10 p-2 border border-slate-300 text-slate-700 bg-white hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition duration-150 ease-in-out rounded-full shadow-md"
                    title="Kembali ke Dashboard">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
            </div>

            {{-- CARD UTAMA PENGATURAN --}}
            <div class="overflow-hidden bg-white shadow-xl shadow-slate-200/50 sm:rounded-2xl border border-slate-100">
                
                <div class="w-full p-8 md:p-10">

                    {{-- ALERT SUCCESS --}}
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm shadow-sm">
                            Berhasil! {{ session('success') }}
                        </div>
                    @endif

                    {{-- ALERT ERROR --}}
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

                    @php
                        $store = $store ?? Auth::user()->store ?? (object)[
                            'name' => '',
                            'description' => '',
                            'image' => ''
                        ];
                    @endphp

                    <div class="max-w-2xl">
                        <h3 class="text-2xl font-bold text-slate-800 mb-1">Informasi Dasar Toko </h3>
                        <p class="text-slate-500 text-sm mb-8">Perbarui nama, deskripsi, dan logo toko Anda.</p>

                        <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            {{-- NAMA TOKO --}}
                            <div class="mb-6">
                                <label for="store_name" class="block text-slate-700 font-semibold mb-2 text-sm">Nama Toko</label>
                                <input type="text" id="store_name" name="name"
                                        value="{{ old('name', $store->name) }}"
                                        class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 
                                        focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition 
                                        @error('name') border-red-500 @enderror"
                                        required>
                                @error('name')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- DESKRIPSI TOKO --}}
                            <div class="mb-6">
                                <label for="store_description" class="block text-slate-700 font-semibold mb-2 text-sm">Deskripsi Toko</label>
                                <textarea id="store_description" name="description" rows="4"
                                        class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 
                                        focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition 
                                        @error('description') border-red-500 @enderror">{{ old('description', $store->description) }}</textarea>
                                <p class="text-xs text-slate-500 mt-1">Ceritakan sedikit tentang apa yang Anda jual.</p>
                                @error('description')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- GAMBAR TOKO (Logo) --}}
                            <div class="mb-8 p-6 border border-slate-200 rounded-xl bg-slate-50 shadow-inner">
                                <label for="store_image" class="block text-slate-700 font-semibold mb-4 text-sm">Gambar Toko (Logo)</label>

                                {{-- GAMBAR SAAT INI & PREVIEW --}}
                                <div class="flex items-end gap-6 mb-4">
                                    {{-- Gambar Saat Ini --}}
                                    <div id="currentImageContainer" @if(!$store->image) class="hidden" @endif>
                                        @if($store->image)
                                            <p class="text-xs text-slate-500 mb-1">Gambar saat ini:</p>
                                            <img id="currentImage"
                                                    src="{{ asset('storage/' . $store->image) }}"
                                                    class="w-20 h-20 object-cover rounded-full border-4 border-white shadow-md"
                                                    alt="Logo Toko">
                                        @endif
                                    </div>

                                    {{-- PREVIEW GAMBAR BARU --}}
                                    <div id="previewContainer" class="hidden"> 
                                        <p id="previewLabel" class="text-xs text-blue-600 mb-1">Preview baru:</p>
                                        <img id="previewImage" 
                                                class="hidden w-20 h-20 object-cover rounded-full border-4 border-blue-400 shadow-lg"
                                                alt="Preview Logo">
                                    </div>
                                </div>
                                
                                {{-- INPUT GAMBAR --}}
                                <input type="file" id="store_image" name="image"
                                        class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-full 
                                        file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 
                                        hover:file:bg-blue-100 transition duration-300 @error('image') border-red-500 @enderror"
                                        accept="image/*" onchange="previewLogo(event)">

                                <p class="text-xs text-slate-500 mt-2">
                                    Unggah logo baru (Maks: 2MB). Kosongkan jika tidak ingin mengubah.
                                </p>

                                @error('image')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- TOMBOL SIMPAN --}}
                            <button type="submit"
                                    class="inline-flex items-center gap-2 bg-blue-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-700 
                                    transition shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0V4a2 2 0 00-2-2l-3 4-2 2"></path></svg>
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
            const currentImageContainer = document.getElementById('currentImageContainer');
            const previewContainer = document.getElementById('previewContainer');
            const preview = document.getElementById('previewImage');
            const previewLabel = document.getElementById('previewLabel');

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                previewContainer.classList.remove('hidden');

                previewLabel.classList.remove('hidden');
                if (currentImageContainer) {
                    currentImageContainer.classList.add('hidden'); 
                }

            } else {
                preview.classList.add('hidden');
                previewContainer.classList.add('hidden');
                previewLabel.classList.add('hidden');

                if (currentImageContainer && currentImageContainer.querySelector('img')) {
                    currentImageContainer.classList.remove('hidden'); 
                }
            }
        }
    </script>

@endsection