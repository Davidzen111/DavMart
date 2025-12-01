@extends('layouts.admin')

@section('title', 'Admin Dashboard - DavMart')

@section('content')

    <div class="bg-gray-50">
        <div class="max-w-7xl mx-auto">
            
            {{-- Header Mobile (ditingkatkan) --}}
            <div class="mb-6">
                <h2 class="text-3xl font-extrabold text-gray-800">Admin Dashboard 🚀</h2>
                <p class="text-gray-500 mt-1">Ringkasan cepat dan alat manajemen utama.</p>
            </div>

            {{-- KONTEN UTAMA (Dashboard) --}}
            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-100 p-6 md:p-8">
                
                <h3 class="text-xl font-bold mb-6 text-gray-800 border-b pb-3">Statistik Utama 👋</h3>
                
                {{-- STATISTIK CARDS (REAL DATA) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    
                    {{-- Card 1: Total User --}}
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-blue-200 hover:shadow-md transition duration-300">
                        <p class="text-sm text-blue-600 font-bold uppercase tracking-wide">Total User</p>
                        <p class="text-4xl font-extrabold text-gray-800 mt-2">{{ $totalUsers }}</p>
                        <span class="text-xs text-gray-500 block mt-1">Pengguna Terdaftar</span>
                    </div>
                    
                    {{-- Card 2: Pending Sellers --}}
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-yellow-200 hover:shadow-md transition duration-300">
                        <p class="text-sm text-yellow-600 font-bold uppercase tracking-wide">Pending Sellers</p>
                        <p class="text-4xl font-extrabold text-gray-800 mt-2">{{ $pendingSellers }}</p>
                        <a href="{{ route('admin.seller.verification') }}" class="text-xs text-yellow-500 hover:text-yellow-700 transition font-medium block mt-1">Cek Verifikasi &rarr;</a>
                    </div>
                    
                    {{-- Card 3: Total Transaksi --}}
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-green-200 hover:shadow-md transition duration-300">
                        <p class="text-sm text-green-600 font-bold uppercase tracking-wide">Total Pendapatan</p>
                        {{-- MENGGANTI RP 45.2JT DENGAN VARIABEL --}}
                        <p class="text-4xl font-extrabold text-gray-800 mt-2">{{ $totalIncome }}</p>
                        <span class="text-xs text-gray-500 block mt-1"></span>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <p class="text-gray-600">Gunakan menu navigasi di **header** untuk mengakses fitur manajemen utama seperti **Users, Verifikasi Seller, Kategori, dan Monitoring Produk**.</p>
                </div>
            </div>
            {{-- Akhir KONTEN UTAMA --}}

        </div>
    </div>

@endsection