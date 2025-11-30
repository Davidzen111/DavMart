<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - {{ config('app.name', 'DavMart') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- PERUBAHAN: h-16 diganti menjadi h-20 --}}
            <div class="flex justify-between items-center h-20 gap-2">
                
                <div class="flex items-center shrink-0">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600 flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="DavMart Logo" class="w-14 h-14 rounded-full object-cover border-2 border-blue-100 shadow-sm">
                        <span class="hidden sm:inline">DavMart</span><span class="sm:hidden">DM</span>
                    </a>
                </div>

                <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                    
                    {{-- Tombol Kembali ke Beranda --}}
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-blue-600 transition flex items-center gap-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="hidden sm:inline">Beranda</span>
                    </a>

                    {{-- Hamburger Menu Profil --}}
                    <div class="relative ml-1 sm:ml-3">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2 px-3 py-1.5 border border-gray-200 rounded-full text-gray-600 bg-white hover:text-blue-600 hover:border-blue-300 focus:outline-none transition duration-150">
                                    <div class="bg-gray-100 rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="text-sm font-medium hidden sm:block max-w-[100px] truncate">
                                        {{ Auth::user()->name }}
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                {{-- Menu Items --}}
                                <x-dropdown-link :href="route('profile.edit')">
                                    Manage Profile
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('cart.index')">
                                    Shopping Cart
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('orders.index')">
                                    Order History
                                </x-dropdown-link>
                                
                                <div class="border-t border-gray-100"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 border border-gray-100 mt-4">
                <div class="p-6 text-gray-900 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-4">
                        {{-- Bulatan Profil dengan Inisial --}}
                        <div class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold uppercase shadow-sm border-4 border-blue-50">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Halo, {{ Auth::user()->name }}! 👋</h3>
                            <p class="text-sm text-gray-500">Selamat datang kembali di Dashboard.</p>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition font-bold text-sm shadow-md flex items-center gap-2">
                        🛍️ Belanja Lagi
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center hover:shadow-md transition">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-full mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pesanan</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $orders->count() }}</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center hover:shadow-md transition">
                    <div class="p-3 bg-yellow-100 text-yellow-600 rounded-full mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Dalam Proses</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $orders->whereIn('status', ['pending', 'processing', 'shipped'])->count() }}
                        </p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center hover:shadow-md transition">
                    <div class="p-3 bg-green-100 text-green-600 rounded-full mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Selesai</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $orders->where('status', 'completed')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-6 text-gray-800 flex items-center">
                        <span class="bg-blue-100 text-blue-600 p-1.5 rounded mr-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </span>
                        Riwayat Pesanan Terbaru
                    </h3>

                    @if($orders->isEmpty())
                        <div class="text-center py-16 border-2 border-dashed border-gray-100 rounded-lg">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 opacity-50">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <p class="text-gray-500 font-medium mb-4">Kamu belum pernah berbelanja.</p>
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Mulai Belanja Sekarang
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left">
                                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold tracking-wider">
                                    <tr>
                                        <th class="py-4 px-6 rounded-tl-lg">Invoice</th>
                                        <th class="py-4 px-6">Tanggal</th>
                                        <th class="py-4 px-6">Total</th>
                                        <th class="py-4 px-6">Status</th>
                                        <th class="py-4 px-6 rounded-tr-lg text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($orders->take(5) as $order)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-4 px-6 font-bold text-blue-600">
                                            {{ $order->invoice_code }}
                                        </td>
                                        <td class="py-4 px-6 text-gray-600">
                                            {{ $order->created_at->format('d M Y') }}
                                        </td>
                                        <td class="py-4 px-6 font-bold text-gray-800">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="py-4 px-6">
                                            @php
                                                $statusClass = match($order->status) {
                                                    'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                                    'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                    'shipped' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                    'completed' => 'bg-green-100 text-green-700 border-green-200',
                                                    'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                                    default => 'bg-gray-100 text-gray-700'
                                                };
                                                $statusLabel = match($order->status) {
                                                    'pending' => 'Menunggu Bayar',
                                                    'processing' => 'Diproses',
                                                    'shipped' => 'Dikirim',
                                                    'completed' => 'Selesai',
                                                    'cancelled' => 'Batal',
                                                    default => $order->status
                                                };
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-300 transition shadow-sm" title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
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

    <footer class="bg-white border-t border-gray-200 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; 2025 DavMart E-Commerce Project. All rights reserved.
        </div>
    </footer>

</body>
</html>