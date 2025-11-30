<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tulis Ulasan Produk') }} ✍️
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <div class="flex items-center gap-4 mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100">
                    <div class="w-20 h-20 bg-gray-200 rounded-md overflow-hidden flex-shrink-0">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 text-xs">No Img</div>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">{{ $product->name }}</h3>
                        <p class="text-blue-600 font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="mb-6" x-data="{ rating: 0, hoverRating: 0 }">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Rating Bintang (1-5)</label>
                        
                        <input type="hidden" name="rating" :value="rating" required>

                        <div class="flex items-center gap-1">
                            <template x-for="star in 5">
                                <button type="button" 
                                    @click="rating = star" 
                                    @mouseover="hoverRating = star" 
                                    @mouseleave="hoverRating = 0"
                                    class="focus:outline-none transition duration-150 transform hover:scale-110"
                                    :class="{
                                        'text-yellow-400': hoverRating >= star || (!hoverRating && rating >= star),
                                        'text-gray-300': hoverRating < star && (!hoverRating || rating < star)
                                    }">
                                    <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                </button>
                            </template>
                        </div>
                        <p class="text-sm text-gray-500 mt-2" x-text="rating > 0 ? rating + ' Bintang terpilih' : 'Klik bintang untuk menilai'"></p>
                    </div>
                    <div class="mb-6">
                        <label for="review" class="block text-gray-700 text-sm font-bold mb-2">Ceritakan Pengalamanmu</label>
                        <textarea 
                            name="review" 
                            id="review" 
                            rows="5" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            placeholder="Bagaimana kualitas barangnya? Apakah pengirimannya cepat?"
                            required></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                            Kirim Ulasan 🚀
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>