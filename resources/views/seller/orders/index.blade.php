<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Daftar Pesanan Perlu Dikirim</h3>

                    @if($orderItems->isEmpty())
                        <p class="text-gray-500 text-center py-10">Belum ada pesanan masuk.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                                    <tr>
                                        <th class="py-3 px-4 text-left">Produk</th>
                                        <th class="py-3 px-4 text-left">Pembeli</th>
                                        <th class="py-3 px-4 text-center">Jumlah</th>
                                        <th class="py-3 px-4 text-center">Total Harga</th>
                                        <th class="py-3 px-4 text-center">Status Saat Ini</th>
                                        <th class="py-3 px-4 text-center">Update Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm">
                                    @foreach($orderItems as $item)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-4">
                                            <div class="font-bold">{{ $item->product->name }}</div>
                                            <div class="text-xs text-gray-500">Invoice: {{ $item->order->invoice_code }}</div>
                                        </td>
                                        <td class="py-3 px-4">
                                            {{ $item->order->user->name }}
                                            <div class="text-xs text-gray-500">{{ $item->order->user->email }}</div>
                                        </td>
                                        <td class="py-3 px-4 text-center">{{ $item->quantity }}</td>
                                        <td class="py-3 px-4 text-center font-bold text-green-600">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="px-2 py-1 rounded text-xs text-white font-bold
                                                {{ $item->status == 'pending' ? 'bg-yellow-500' : '' }}
                                                {{ $item->status == 'processing' ? 'bg-blue-500' : '' }}
                                                {{ $item->status == 'shipped' ? 'bg-purple-500' : '' }}
                                                {{ $item->status == 'delivered' ? 'bg-green-500' : '' }}
                                                {{ $item->status == 'cancelled' ? 'bg-red-500' : '' }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <form action="{{ route('seller.orders.update', $item->id) }}" method="POST" class="flex items-center gap-2 justify-center">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <select name="status" class="text-xs border-gray-300 rounded shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="processing" {{ $item->status == 'processing' ? 'selected' : '' }}>Proses</option>
                                                    <option value="shipped" {{ $item->status == 'shipped' ? 'selected' : '' }}>Kirim</option>
                                                    <option value="delivered" {{ $item->status == 'delivered' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="cancelled" {{ $item->status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                                </select>

                                                <button type="submit" class="bg-blue-600 text-white p-1 rounded hover:bg-blue-700" title="Simpan Status">
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