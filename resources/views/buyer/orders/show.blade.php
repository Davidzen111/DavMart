<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesanan') }} #{{ $order->invoice_code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center border-b pb-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Order</p>
                        <p class="font-bold">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Status Pesanan</p>
                        <span class="px-3 py-1 rounded-full text-xs font-bold text-white
                            {{ $order->status == 'pending' ? 'bg-yellow-500' : '' }}
                            {{ $order->status == 'processing' ? 'bg-blue-500' : '' }}
                            {{ $order->status == 'shipped' ? 'bg-purple-500' : '' }}
                            {{ $order->status == 'completed' || $order->status == 'delivered' ? 'bg-green-500' : '' }}
                            {{ $order->status == 'cancelled' ? 'bg-red-500' : '' }}">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>
                </div>

                <h3 class="font-bold mb-4">Barang yang dibeli:</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg border">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gray-200 rounded overflow-hidden">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="flex items-center justify-center h-full text-xs text-gray-400">No IMG</span>
                                @endif
                            </div>
                            
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $item->product->name }}</h4>
                                <p class="text-xs text-gray-500">Toko: {{ $item->store->name }}</p>
                                <p class="text-sm">
                                    {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="font-bold text-blue-600 text-lg">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </p>

                            @if($order->status == 'completed' || $order->status == 'delivered')
                                <a href="{{ route('reviews.create', ['productId' => $item->product_id, 'orderId' => $order->id]) }}" 
                                class="mt-2 inline-block text-xs bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-1 px-3 rounded shadow transition">
                                    ★ Beri Ulasan
                                </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8 text-right border-t pt-4">
                    <p class="text-gray-600">Total Pembayaran:</p>
                    <h3 class="text-3xl font-bold text-gray-800">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </h3>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-gray-700 font-bold text-sm">
                        &larr; Kembali ke Riwayat
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>