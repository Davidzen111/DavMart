<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seller Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex overflow-hidden bg-white shadow-sm sm:rounded-lg">
                
                <div class="w-1/4 bg-gray-50 border-r border-gray-200 p-6 min-h-screen hidden md:block">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->store->name ?? 'S', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-700">{{ Auth::user()->store->name ?? 'Nama Toko' }}</p>
                            <p class="text-xs text-green-600">● Online</p>
                        </div>
                    </div>

                    <h3 class="text-xs font-bold mb-2 text-gray-400 uppercase tracking-wider">Menu Toko</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('seller.dashboard') }}" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition {{ request()->routeIs('seller.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600' }}">
                                📊 Ringkasan Toko
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('seller.products.index') }}" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition text-gray-600">
                                🛍️ Produk Saya
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition text-gray-600">
                                🏬 Pengaturan Toko
                            </a>
                        </li>
                    </ul>

                    <h3 class="text-xs font-bold mb-2 mt-6 text-gray-400 uppercase tracking-wider">Transaksi</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('seller.orders.index') }}" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition text-gray-600 flex justify-between items-center">
                                📦 Pesanan Masuk
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">0</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="w-full md:w-3/4 p-6">
                    <h3 class="text-lg font-bold mb-4">Halo, {{ Auth::user()->name }}!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="bg-purple-100 p-4 rounded-lg shadow-sm border border-purple-200">
                            <p class="text-sm text-purple-600 font-bold">Total Produk</p>
                            <p class="text-2xl font-bold text-gray-800">
                                {{ Auth::user()->store->products->count() ?? 0 }}
                            </p>
                        </div>
                        <div class="bg-blue-100 p-4 rounded-lg shadow-sm border border-blue-200">
                            <p class="text-sm text-blue-600 font-bold">Pesanan Baru</p>
                            <p class="text-2xl font-bold text-gray-800">0</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg shadow-sm border border-green-200">
                            <p class="text-sm text-green-600 font-bold">Pendapatan</p>
                            <p class="text-2xl font-bold text-gray-800">Rp 0</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded border border-gray-200 text-center">
                        <img src="https://cdn-icons-png.flaticon.com/512/743/743131.png" alt="Product" class="w-24 h-24 mx-auto mb-4 opacity-50">
                        <h3 class="text-lg font-bold text-gray-700">Mulai Jualan Sekarang!</h3>
                        <p class="text-gray-500 mb-4">Kamu belum menambahkan produk baru minggu ini.</p>
                        <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition">
                            + Tambah Produk Baru
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>