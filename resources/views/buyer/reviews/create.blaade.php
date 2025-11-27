<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beri Ulasan Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex items-center gap-4 mb-6 border-b pb-4">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-20 h-20 object-cover rounded">
                    @endif
                    <div>
                        <h3 class="font-bold text-lg">{{ $product->name }}</h3>
                        <p class="text-gray-500 text-sm">Bagaimana kualitas produk ini?</p>
                    </div>
                </div>

                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Rating Bintang (1-5)</label>
                        <div class="flex gap-4">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer" required>
                                    <span class="text-3xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400">★</span>
                                    <div class="text-xs text-center text-gray-500 mt-1">{{ $i }}</div>
                                </label>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Ulasan Kamu</label>
                        <textarea name="review" class="w-full border rounded px-3 py-2" rows="4" placeholder="Ceritakan kepuasanmu tentang produk ini..." required></textarea>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700 w-full">
                        Kirim Ulasan
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>