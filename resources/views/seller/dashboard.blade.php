@extends('layouts.seller')

@section('title', 'Dashboard Toko')

@section('content')
<div class="py-8 bg-slate-50 min-h-screen"> 
    
    <div class="md:hidden mb-6 px-4">
        <h2 class="text-2xl font-bold text-slate-800">Dashboard Toko</h2>
    </div>

    {{-- CONTAINER UTAMA --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100 min-h-[80vh]">
            
            {{-- MAIN KONTEN DASHBOARD --}}
            <div class="w-full p-6 md:p-10">
                
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
                    {{-- ALERT SUCCESS --}}
                    <div class="bg-amber-50 border border-amber-300 text-amber-700 px-4 py-3 rounded-xl mb-8 text-sm shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif
                
                {{-- PROFIL TOKO --}}
                <div class="bg-slate-50 p-8 border border-slate-200 rounded-2xl mb-10 shadow-lg shadow-slate-100/50 text-center relative overflow-hidden">
                    <div class="relative z-10">
                        {{-- Logo/Inisial Toko --}}
                        <div class="mx-auto w-24 h-24 rounded-full bg-white border-4 border-slate-100 flex items-center justify-center text-slate-800 text-4xl font-extrabold mb-4 overflow-hidden shadow-xl">
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" class="w-full h-full object-cover" alt="Logo Toko">
                            @else
                                {{ substr($storeName, 0, 1) }}
                            @endif
                        </div>

                        {{-- Nama dan Email Penjual --}}
                        <h1 class="text-3xl font-extrabold text-slate-900 mb-1 tracking-tight">{{ $storeName }}</h1>
                        <p class="text-sm text-slate-500 mb-4">{{ $user->email }}</p>
                        
                        {{-- Deskripsi Toko --}}
                        @if($store->description)
                            <p class="text-slate-600 max-w-2xl mx-auto italic mb-6">"{{ $storeDescription }}"</p>
                        @endif
                        
                        {{-- Tombol Edit Profil Toko --}}
                        <a href="{{ route('seller.store.edit') }}" class="inline-flex items-center gap-2 px-6 py-2 rounded-full bg-white border border-slate-300 text-slate-800 text-sm font-semibold shadow-md hover:bg-amber-50 hover:border-amber-400 hover:text-amber-700 transition duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit Profil Toko
                        </a>
                    </div>
                </div>

                {{-- HEADER RINGKASAN KINERJA --}}
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-slate-800">Ringkasan Kinerja 📊</h3>
                    <span class="text-sm text-slate-500 bg-slate-100 px-3 py-1 rounded-full font-medium">{{ now()->format('d M Y') }}</span>
                </div>
                
                {{-- Kartu Ringkasan Statistik --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
                    
                    {{-- Card 1: Total Produk --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-lg hover:shadow-xl transition group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-slate-100 p-3 rounded-xl text-slate-600 group-hover:bg-slate-800 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase">Total Produk</span> 
                        </div>
                        <p class="text-3xl font-extrabold text-slate-800">{{ $store->products->count() ?? 0 }}</p>
                        <p class="text-xs text-slate-500 mt-1">Item aktif dijual</p>
                    </div>

                    {{-- Card 2: Pesanan Baru --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-lg hover:shadow-xl transition group relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-amber-100 p-3 rounded-xl text-amber-700 group-hover:bg-amber-700 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase">Pesanan Baru</span>
                        </div>
                        <p class="text-3xl font-extrabold text-slate-800">{{ $pendingOrdersCount }}</p>
                        <p class="text-xs text-slate-500 mt-1">Menunggu diproses</p>
                        @if($pendingOrdersCount > 0)
                            <span class="absolute top-6 right-6 w-3 h-3 bg-red-500 rounded-full animate-ping"></span>
                            <span class="absolute top-6 right-6 w-3 h-3 bg-red-500 rounded-full"></span>
                        @endif
                    </div>

                    {{-- Card 3: Total Pendapatan --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-lg hover:shadow-xl transition group">
                        <div class="flex items-center justify-start mb-6"> 
                            <div class="bg-green-100 p-3 rounded-xl text-green-700 group-hover:bg-green-700 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase ml-3">Pendapatan Bersih</span> 
                        </div>
                        <p class="text-2xl font-extrabold text-slate-800 truncate" title="Rp {{ number_format($income, 0, ',', '.') }}">
                            Rp {{ number_format($income, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-slate-500 mt-2">Total penjualan sukses</p> 
                    </div>
                </div>

                {{-- Area Call to Action (CTA): Tambah Produk --}}
                <div class="bg-white p-8 rounded-2xl border-2 border-dashed border-slate-300 text-center hover:border-amber-400 transition group shadow-lg mb-10 md:mb-16">
                    <div class="bg-slate-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300 border border-slate-200">
                        <svg class="w-8 h-8 text-slate-600 group-hover:text-amber-700 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    
                    @if($store->products->count() > 0)
                        <h3 class="text-lg font-bold text-slate-800">Kelola Produk Anda</h3>
                        <p class="text-slate-500 mb-6 text-sm max-w-md mx-auto">
                            Ingin menambah koleksi jualan? Tambahkan produk baru sekarang.
                        </p>
                    @else
                        <h3 class="text-lg font-bold text-slate-800">Toko Masih Kosong?</h3>
                        <p class="text-slate-500 mb-6 text-sm max-w-md mx-auto">
                            Yuk upload produk pertamamu sekarang agar pembeli bisa mulai berbelanja di tokomu.
                        </p>
                    @endif

                    <a href="{{ route('seller.products.create') }}" class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-8 rounded-xl shadow-xl shadow-slate-400/50 transform hover:-translate-y-0.5 transition duration-300">
                        Tambah Produk Baru
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection