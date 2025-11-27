<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Toko') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex overflow-hidden bg-white shadow-sm sm:rounded-lg min-h-screen">
                
                <div class="w-1/4 bg-gray-50 border-r border-gray-200 p-6 hidden md:block">
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
                            <a href="{{ route('seller.dashboard') }}" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition text-gray-600">
                                📊 Ringkasan Toko
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('seller.products.index') }}" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition text-gray-600">
                                🛍️ Produk Saya
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('seller.store.edit') }}" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition bg-blue-600 text-white">
                                🏬 Pengaturan Toko
                            </a>
                        </li>
                    </ul>

                    <h3 class="text-xs font-bold mb-2 mt-6 text-gray-400 uppercase tracking-wider">Transaksi</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('seller.orders.index') }}" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition text-gray-600 flex justify-between items-center">
                                📦 Pesanan Masuk
                                @php
                                    $newOrders = \App\Models\OrderItem::where('store_id', Auth::user()->store->id)->where('status', 'pending')->count();
                                @endphp
                                @if($newOrders > 0)
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $newOrders }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="w-full md:w-3/4 p-8">
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="max-w-xl">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Informasi Toko</h3>
                        <p class="text-gray-500 text-sm mb-6">Perbarui nama dan deskripsi toko Anda agar lebih menarik.</p>

                        <form action="{{ route('seller.store.update') }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Nama Toko</label>
                                <input type="text" name="name" value="{{ old('name', $store->name) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 font-bold mb-2">Deskripsi Toko</label>
                                <textarea name="description" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $store->description) }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Ceritakan sedikit tentang apa yang Anda jual.</p>
                            </div>

                            <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700 transition">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>