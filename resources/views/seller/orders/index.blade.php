<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan Masuk') }}
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
                            <a href="{{ route('seller.store.edit') }}" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition text-gray-600">
                                🏬 Pengaturan Toko
                            </a>
                        </li>
                    </ul>

                    <h3 class="text-xs font-bold mb-2 mt-6 text-gray-400 uppercase tracking-wider">Transaksi</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('seller.orders.index') }}" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition bg-blue-600 text-white flex justify-between items-center">
                                <span>📦 Pesanan Masuk</span>
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

                    <h3 class="text-lg font-bold mb-4 text-gray-800">Daftar Pesanan Perlu Dikirim</h3>

                    @if($orderItems->isEmpty())
                        <div class="text-center py-20 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <p class="text-gray-500">Belum ada pesanan masuk saat ini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-gray-200 rounded-lg">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase">Produk</th>
                                        <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase">Pembeli</th>
                                        <th class="py-3 px-4 text-center text-xs font-bold text-gray-500 uppercase">Jml</th>
                                        <th class="py-3 px-4 text-center text-xs font-bold text-gray-500 uppercase">Total</th>
                                        <th class="py-3 px-4 text-center text-xs font-bold text-gray-500 uppercase">Update Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($orderItems as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4">
                                            <div class="font-bold text-gray-800 text-sm">{{ $item->product->name }}</div>
                                            <div class="text-xs text-gray-500">Inv: {{ $item->order->invoice_code }}</div>
                                        </td>
                                        <td class="py-3 px-4 text-sm">
                                            {{ $item->order->user->name }}
                                            <div class="text-xs text-gray-400">{{ $item->order->user->email }}</div>
                                        </td>
                                        <td class="py-3 px-4 text-center text-sm">{{ $item->quantity }}</td>
                                        <td class="py-3 px-4 text-center font-bold text-green-600 text-sm">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <form action="{{ route('seller.orders.update', $item->id) }}" method="POST" class="flex items-center gap-2 justify-center">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <select name="status" class="text-xs border-gray-300 rounded shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-1">
                                                    <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="processing" {{ $item->status == 'processing' ? 'selected' : '' }}>Proses</option>
                                                    <option value="shipped" {{ $item->status == 'shipped' ? 'selected' : '' }}>Kirim</option>
                                                    <option value="delivered" {{ $item->status == 'delivered' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="cancelled" {{ $item->status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                                </select>

                                                <button type="submit" class="bg-blue-600 text-white p-1.5 rounded hover:bg-blue-700 transition" title="Simpan">
                                                    💾
                                                </button>
                                            </form>
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
</x-app-layout>