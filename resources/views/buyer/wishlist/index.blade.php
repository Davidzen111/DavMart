<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Keinginan (Wishlist)') }} ❤️
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($wishlists->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 text-center flex flex-col items-center justify-center min-h-[400px]">
                    <div class="text-6xl mb-4 animate-bounce">💔</div>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Wishlist Kosong</h3>
                    <p class="text-gray-500 mb-6">Kamu belum menyimpan barang favorit apapun.</p>
                    <a href="{{ route('home') }}" class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition shadow-lg hover:shadow-xl">
                        Cari Barang Sekarang
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($wishlists as $item)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden relative group hover:shadow-lg transition duration-300">
                        
                        <form action="{{ route('wishlist.toggle', $item->product->id) }}" method="POST" class="absolute top-2 right-2 z-20 opacity-0 group-hover:opacity-100 transition duration-300">
                            @csrf
                            <button type="submit" class="bg-white text-red-500 rounded-full p-2 shadow-md hover:bg-red-50 hover:scale-110 transition transform" title="Hapus dari Wishlist">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </form>
                        
                        <a href="{{ route('product.detail', $item->product->id) }}" class="block h-full flex flex-col">
                            <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden relative">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <span class="text-gray-400 text-sm">No Image</span>
                                @endif
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-5 transition duration-300"></div>
                            </div>

                            <div class="p-4 flex-grow flex flex-col justify-between">
                                <div>
                                    <h3 class="font-bold text-gray-800 text-sm leading-tight mb-2 line-clamp-2">{{ $item->product->name }}</h3>
                                    <p class="text-blue-600 font-bold text-lg">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                </div>
                                
                                <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100">
                                    <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-blue-600 shrink-0">
                                        {{ substr($item->product->store->name ?? 'S', 0, 1) }}
                                    </div>
                                    <p class="text-xs text-gray-500 truncate">{{ $item->product->store->name ?? 'Toko' }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>