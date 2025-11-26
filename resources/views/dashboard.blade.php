<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-gray-500">Selamat datang kembali di DavMart.</p>
                    </div>
                    <a href="{{ route('home') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-bold text-sm">
                        🛍️ Belanja Lagi
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-800 border-b pb-2">📦 Riwayat Pesanan Saya</h3>

                    @if($orders->isEmpty())
                        <div class="text-center py-10">
                            <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" class="w-20 h-20 mx-auto opacity-50 mb-4">
                            <p class="text-gray-500">Kamu belum pernah berbelanja.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                                    <tr>
                                        <th class="py-3 px-6 text-left">Invoice</th>
                                        <th class="py-3 px-6 text-left">Tanggal</th>
                                        <th class="py-3 px-6 text-center">Total Belanja</th>
                                        <th class="py-3 px-6 text-center">Status</th>
                                        <th class="py-3 px-6 text-center">Detail</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($orders as $order)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 text-left whitespace-nowrap font-bold text-blue-600">
                                            {{ $order->invoice_code }}
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            {{ $order->created_at->format('d M Y, H:i') }} WIB
                                        </td>
                                        <td class="py-3 px-6 text-center font-bold">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            @php
                                                $statusColor = match($order->status) {
                                                    'pending' => 'bg-yellow-200 text-yellow-800',
                                                    'processing' => 'bg-blue-200 text-blue-800',
                                                    'completed' => 'bg-green-200 text-green-800',
                                                    'cancelled' => 'bg-red-200 text-red-800',
                                                    default => 'bg-gray-200 text-gray-800'
                                                };
                                                $statusLabel = match($order->status) {
                                                    'pending' => 'Menunggu Bayar',
                                                    'processing' => 'Diproses',
                                                    'completed' => 'Selesai',
                                                    'cancelled' => 'Dibatalkan',
                                                    default => ucfirst($order->status)
                                                };
                                            @endphp
                                            <span class="{{ $statusColor }} py-1 px-3 rounded-full text-xs font-bold">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <button class="text-gray-500 hover:text-blue-600 font-bold text-xs underline">
                                                Lihat Item
                                            </button>
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