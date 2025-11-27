<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produk Saya') }}
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
                            <a href="{{ route('seller.products.index') }}" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition bg-blue-600 text-white">
                                🛍️ Produk Saya
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('seller.store.edit') }}" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition text-gray-600">
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

                <div class="w-full md:w-3/4 p-6">
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Daftar Produk Toko</h3>
                        
                        <a href="{{ route('seller.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition shadow-sm text-sm font-bold">
                            + Tambah Produk
                        </a>
                    </div>

                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase">Gambar</th>
                                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase">Info Produk</th>
                                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase">Harga</th>
                                    <th class="py-3 px-4 text-center text-xs font-bold text-gray-500 uppercase">Stok</th>
                                    <th class="py-3 px-4 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 w-20">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-16 h-16 object-cover rounded border">
                                        @else
                                            <div class="w-16 h-16 bg-gray-100 rounded flex items-center justify-center text-xs text-gray-400 border">No Pic</div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="font-bold text-gray-800 text-sm">{{ $product->name }}</p>
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">{{ $product->category->name }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-blue-600 font-bold text-sm">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="px-2 py-1 rounded text-xs text-white font-bold {{ $product->stock > 0 ? 'bg-green-500' : 'bg-red-500' }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('seller.products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700 font-bold text-xs">Edit</a>
                                            <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-10 text-gray-500">
                                        Belum ada produk. Klik tombol tambah di atas.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>