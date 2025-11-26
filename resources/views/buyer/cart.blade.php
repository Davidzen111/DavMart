<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(!$cart || $cart->items->count() == 0)
                    <div class="text-center py-10">
                        <h3 class="text-lg text-gray-500 mb-4">Keranjang kamu masih kosong.</h3>
                        <a href="{{ route('home') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Mulai Belanja</a>
                    </div>
                @else
                    <table class="min-w-full bg-white border border-gray-200 mb-6">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left">Produk</th>
                                <th class="py-3 px-4 text-center">Jumlah</th>
                                <th class="py-3 px-4 text-right">Harga Satuan</th>
                                <th class="py-3 px-4 text-right">Subtotal</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach($cart->items as $item)
                            <tr class="border-b">
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-12 h-12 object-cover rounded mr-3">
                                        @endif
                                        <div>
                                            <p class="font-bold">{{ $item->product->name }}</p>
                                            <p class="text-xs text-gray-500">Toko: {{ $item->product->store->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    {{ $item->quantity }}
                                </td>
                                <td class="py-4 px-4 text-right">
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-4 text-right font-bold text-blue-600">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @php $grandTotal += $item->product->price * $item->quantity; @endphp
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex justify-between items-center bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <div>
                            <p class="text-gray-600">Total Pembayaran:</p>
                            <h3 class="text-3xl font-bold text-gray-800">Rp {{ number_format($grandTotal, 0, ',', '.') }}</h3>
                        </div>
                        
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow transition transform hover:scale-105" onclick="return confirm('Proses checkout sekarang?')">
                                Checkout Sekarang
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>