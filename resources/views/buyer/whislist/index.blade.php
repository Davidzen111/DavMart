<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Keinginan (Wishlist)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($wishlists->isEmpty())
                <div class="text-center py-20 bg-white rounded-lg shadow-sm">
                    <p class="text-gray-500 text-lg">Belum ada barang favorit.</p>
                    <a href="{{ route('home') }}" class="text-blue-600 hover:underline mt-2 inline-block">Cari Barang</a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($wishlists as $item)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden relative group">
                        <!-- Hapus dari Wishlist (Tombol X Kecil) -->
                        <form action="{{ route('wishlist.toggle', $item->product->id) }}" method="POST" class="absolute top-2 right-2 z-10">
                            @csrf
                            <button type="submit" class="bg-white rounded-full p-1 shadow hover:bg-red-50 text-red-500" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </form>

                        <a href="{{ route('product.detail', $item->product->id) }}" class="block">
                            <div class="h-40 bg-gray-100 flex items-center justify-center overflow-hidden">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-gray-400 text-xs">No Image</span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-800 truncate">{{ $item->product->name }}</h3>
                                <p class="text-blue-600 font-bold mt-1">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $item->product->store->name }}</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>