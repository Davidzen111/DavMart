@extends('layouts.admin')

@section('title', 'Manajemen Kategori - Admin')

@section('content')

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- TOMBOL KEMBALI KE DASHBOARD ADMIN (Desktop) --}}
            <div class="mb-4 hidden md:block">
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

            {{-- Header Mobile (Tombol Kembali ditambahkan di sini) --}}
            <div class="md:hidden mb-6 px-4 sm:px-0 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Manajemen Kategori</h2>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 text-sm hover:text-blue-800 font-medium">
                    ← Kembali
                </a>
            </div>

            {{-- CONTAINER UTAMA (Sidebar dihapus) --}}
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100">
                
                {{-- 2. KONTEN UTAMA --}}
                <div class="w-full p-6 md:p-8">
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="bg-white overflow-hidden p-0">
                        <div class="p-0 text-gray-900">
                            <div class="flex justify-between items-center mb-6 border-b pb-2">
                                {{-- Judul utama di desktop dipindahkan ke sini jika diperlukan, tapi dibiarkan di dalam konten untuk kerapihan --}}
                                <h3 class="text-2xl font-bold text-gray-800 hidden md:block">Daftar Kategori Produk</h3>
                                <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition shadow-md">
                                    + Tambah Kategori
                                </a>
                            </div>

                            <div class="overflow-x-auto border border-gray-100 rounded-lg">
                                <table class="min-w-full bg-white text-sm">
                                    <thead>
                                        <tr class="bg-gray-50 text-gray-600 uppercase text-xs font-bold tracking-wider">
                                            <th class="py-3 px-6 text-left" width="5%">No</th>
                                            <th class="py-3 px-6 text-left">Nama Kategori</th>
                                            <th class="py-3 px-6 text-left">Slug (URL)</th>
                                            <th class="py-3 px-6 text-center" width="20%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light divide-y divide-gray-100">
                                        @forelse($categories as $index => $category)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3 px-6 text-left font-medium">{{ $index + 1 }}</td>
                                            <td class="py-3 px-6 text-left font-bold">{{ $category->name }}</td>
                                            <td class="py-3 px-6 text-left italic text-gray-500">{{ $category->slug }}</td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex item-center justify-center gap-2">
                                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1.5 px-3 rounded text-xs font-bold transition shadow-sm">
                                                        Edit
                                                    </a>
                                                    
                                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-1.5 px-3 rounded text-xs font-bold transition shadow-sm">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="py-4 px-6 text-center text-gray-500 bg-gray-50">Belum ada kategori. Silakan tambah baru.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection