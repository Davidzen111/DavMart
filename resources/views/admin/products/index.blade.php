<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Semua Produk (Monitoring)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Daftar Semua Produk Penjual</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-red-50 text-red-900">
                            <tr>
                                <th class="py-3 px-4 text-left">Nama Produk</th>
                                <th class="py-3 px-4 text-left">Toko Penjual</th>
                                <th class="py-3 px-4 text-left">Harga</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 font-bold">{{ $product->name }}</td>
                                <td class="py-3 px-4 text-sm">{{ $product->store->name }}</td>
                                <td class="py-3 px-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-center">
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini karena melanggar aturan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-700">
                                            Hapus Paksa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>