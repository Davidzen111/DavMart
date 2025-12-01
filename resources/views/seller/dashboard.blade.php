@extends('layouts.seller')

@section('title', 'Dashboard Toko')

@section('content')
<div class="py-6">
    
    {{-- Header Mobile (Opsional, karena sudah ada nav di atas) --}}
    <div class="md:hidden mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard Toko</h2>
    </div>

    {{-- CONTAINER UTAMA (Tanpa Sidebar) --}}
    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 min-h-screen">
        
        {{-- 2. MAIN KONTEN DASHBOARD --}}
        <div class="w-full p-6 md:p-10">
            
            {{-- Penanganan Variabel PHP dan Error/Success Message --}}
            @php
                $store = Auth::user()->store; 
                $storeName = $store->name ?? 'Nama Toko Belum Diatur';
                $storeDescription = $store->description ?? 'Deskripsi toko belum diisi.';
                $user = Auth::user();

                // Hitung Pendapatan
                $income = \App\Models\OrderItem::where('store_id', $store->id)
                                ->where('status', 'delivered') 
                                ->sum('subtotal');
                
                // Hitung Pesanan Pending (untuk badge view ini)
                $pendingOrdersCount = \App\Models\OrderItem::where('store_id', $store->id)->where('status', 'pending')->count();

                // Buat URL Gambar
                $imageUrl = $store->image ? asset('storage/' . $store->image) : null;
            @endphp

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-sm shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            
            {{-- Profil Toko di Tengah Atas Konten Utama --}}
            <div class="bg-gradient-to-b from-blue-50 to-white p-8 border border-blue-100 rounded-2xl mb-10 shadow-sm text-center relative overflow-hidden">
                <div class="relative z-10">
                    <div class="mx-auto w-24 h-24 rounded-full bg-white border-4 border-white flex items-center justify-center text-blue-600 text-4xl font-extrabold mb-4 overflow-hidden shadow-lg">
                        @if($imageUrl)
                            <img src="{{ $imageUrl }}" class="w-full h-full object-cover" alt="Logo Toko">
                        @else
                            {{ substr($storeName, 0, 1) }}
                        @endif
                    </div>

                    <h1 class="text-3xl font-extrabold text-gray-900 mb-1">{{ $storeName }}</h1>
                    <p class="text-sm text-gray-500 mb-4">{{ $user->email }}</p>
                    
                    @if($store->description)
                        <p class="text-gray-600 max-w-2xl mx-auto italic mb-6">"{{ $storeDescription }}"</p>
                    @endif
                    
                    <a href="{{ route('seller.store.edit') }}" class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-white border border-gray-200 text-blue-600 text-sm font-bold shadow-sm hover:bg-blue-50 hover:border-blue-200 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit Profil Toko
                    </a>
                </div>
            </div>
            {{-- END PROFIL TOKO --}}

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Ringkasan Kinerja 📊</h3>
                <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">{{ now()->format('d M Y') }}</span>
            </div>
            
            {{-- Kartu Ringkasan Statistik --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
                {{-- Card 1: Total Produk --}}
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-100 p-3 rounded-lg text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase">Produk</span>
                    </div>
                    <p class="text-3xl font-extrabold text-gray-800">{{ $store->products->count() ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">Item aktif dijual</p>
                </div>

                {{-- Card 2: Pesanan Baru --}}
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition group relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-100 p-3 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase">Pesanan Baru</span>
                    </div>
                    <p class="text-3xl font-extrabold text-gray-800">{{ $pendingOrdersCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">Menunggu diproses</p>
                    @if($pendingOrdersCount > 0)
                        <span class="absolute top-6 right-6 w-3 h-3 bg-red-500 rounded-full animate-ping"></span>
                        <span class="absolute top-6 right-6 w-3 h-3 bg-red-500 rounded-full"></span>
                    @endif
                </div>

                {{-- Card 3: Total Pendapatan --}}
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-100 p-3 rounded-lg text-green-600 group-hover:bg-green-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase">Pendapatan</span>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-800 truncate" title="Rp {{ number_format($income, 0, ',', '.') }}">
                        Rp {{ number_format($income, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Total penjualan sukses</p>
                </div>
            </div>

            {{-- Area Call to Action (CTA) --}}
            <div class="bg-white p-8 rounded-xl border-2 border-dashed border-gray-200 text-center hover:border-blue-300 transition group">
                <div class="bg-blue-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </div>
                
                @if($store->products->count() > 0)
                    <h3 class="text-lg font-bold text-gray-800">Kelola Produk Anda</h3>
                    <p class="text-gray-500 mb-6 text-sm max-w-md mx-auto">
                        Ingin menambah koleksi jualan? Tambahkan produk baru sekarang.
                    </p>
                @else
                    <h3 class="text-lg font-bold text-gray-800">Toko Masih Kosong?</h3>
                    <p class="text-gray-500 mb-6 text-sm max-w-md mx-auto">
                        Yuk upload produk pertamamu sekarang agar pembeli bisa mulai berbelanja di tokomu.
                    </p>
                @endif

                <a href="{{ route('seller.products.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-lg shadow-blue-200 transform hover:-translate-y-0.5 transition">
                    Tambah Produk Baru
                </a>
            </div>

        </div>
    </div>
</div>
@endsection