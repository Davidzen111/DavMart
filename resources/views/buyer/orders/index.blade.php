<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($orders->isEmpty())
                        <div class="text-center py-10">
                            <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" class="w-20 h-20 mx-auto opacity-50 mb-4">
                            <h3 class="text-lg font-bold text-gray-500">Belum ada riwayat pesanan.</h3>
                            <a href="{{ route('home') }}" class="text-blue-600 hover:underline mt-2 inline-block">Mulai Belanja Sekarang</a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                                    <tr>
                                        <th class="py-3 px-6 text-left">Invoice</th>
                                        <th class="py-3 px-6 text-left">Tanggal</th>
                                        <th class="py-3 px-6 text-center">Total</th>
                                        <th class="py-3 px-6 text-center">Status</th>
                                        <th class="py-3 px-6 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($orders as $order)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            <span class="font-bold text-blue-600">{{ $order->invoice_code }}</span>
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            {{ $order->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="py-3 px-6 text-center font-bold">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            @php
                                                $statusClass = match($order->status) {
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'processing' => 'bg-blue-100 text-blue-800',
                                                    'shipped' => 'bg-purple-100 text-purple-800',
                                                    'completed' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="{{ $statusClass }} py-1 px-3 rounded-full text-xs font-bold uppercase">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <button class="text-gray-500 text-xs font-bold underline hover:text-blue-600">Detail</button>
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