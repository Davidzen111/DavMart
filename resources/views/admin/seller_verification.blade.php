@extends('layouts.admin')

@section('title', 'Verifikasi Seller - Admin')

@section('content')

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- TOMBOL KEMBALI KE DASHBOARD ADMIN (Desktop) --}}
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

            {{-- Header Mobile (Tombol Kembali & Judul) --}}
            <div class="md:hidden mb-6 px-4 sm:px-0 flex flex-col relative"> 

                <div class="w-full mb-2"> 
                    <a href="{{ route('admin.dashboard') }}" 
                        class="text-gray-600 text-sm hover:text-gray-800 font-medium z-10">
                        ← Kembali
                    </a>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-800 w-full text-center">Verifikasi Seller</h2>
            </div>

            {{-- CONTAINER UTAMA --}}
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100">
                
                <div class="w-full p-6 md:p-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6 hidden md:block">Verifikasi Seller Baru</h1>
                    
                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4 shadow-sm" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif

                    <div class="bg-white overflow-hidden p-0">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Daftar Seller Menunggu Persetujuan</h3>

                        @if($pendingSellers->isEmpty())
                            <div class="p-10 text-center bg-gray-50 border border-dashed border-gray-300 rounded-lg">
                                <p class="text-gray-500 italic font-medium">Tidak ada pendaftaran seller baru saat ini.</p>
                            </div>
                        @else
                            {{-- Tabel Daftar Seller Pending --}}
                            <div class="overflow-x-auto border border-gray-100 rounded-lg">
                                <table class="min-w-full bg-white text-sm">
                                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold tracking-wider">
                                        <tr>
                                            <th class="py-3 px-6 text-left">Nama</th>
                                            <th class="py-3 px-6 text-left">Email</th>
                                            <th class="py-3 px-6 text-center">Tanggal Daftar</th>
                                            <th class="py-3 px-6 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700 divide-y divide-gray-100">
                                        @foreach($pendingSellers as $seller)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-3 px-6 text-left whitespace-nowrap font-medium">{{ $seller->name }}</td>
                                            <td class="py-3 px-6 text-left text-gray-600">{{ $seller->email }}</td>
                                            <td class="py-3 px-6 text-center text-gray-600">{{ $seller->created_at->format('d M Y') }}</td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex item-center justify-center gap-2">
                                                    <form action="{{ route('admin.seller.approve', $seller->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded-full text-xs transform hover:scale-105 transition shadow-md">
                                                            Approve
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.seller.approve', $seller->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded-full text-xs transform hover:scale-105 transition shadow-md" onclick="return confirm('Yakin ingin menolak seller ini?')">
                                                            Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection