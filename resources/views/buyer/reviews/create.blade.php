<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Tulis Ulasan Produk') }} ✍️
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ALERT VALIDATION ERROR (Design Konsisten) --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg shadow-sm">
                    <p class="font-bold">Terjadi Kesalahan:</p>
                    <ul class="list-disc pl-5 mt-1 list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- CARD UTAMA FORM --}}
            <div class="bg-white overflow-hidden shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100 p-8 md:p-10">
                
                {{-- DETAIL PRODUK (Design Konsisten) --}}
                <div class="flex items-center gap-4 mb-8 p-4 bg-slate-50 rounded-xl border border-slate-200">
                    <div class="w-20 h-20 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0 border border-slate-200">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-slate-400 text-xs">No Img</div>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-slate-800">{{ $product->name }}</h3>
                        <p class="text-slate-900 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    {{-- RATING BINTANG --}}
                    <div class="mb-6" x-data="{ rating: 0, hoverRating: 0 }">
                        <label class="block text-slate-700 text-sm font-bold mb-2">Rating Bintang (1-5)</label>
                        
                        <input type="hidden" name="rating" :value="rating" required>

                        <div class="flex items-center gap-1">
                            <template x-for="star in 5">
                                <button type="button" 
                                    @click="rating = star" 
                                    @mouseover="hoverRating = star" 
                                    @mouseleave="hoverRating = 0"
                                    class="focus:outline-none transition duration-150 transform hover:scale-110"
                                    :class="{
                                        'text-amber-400': hoverRating >= star || (!hoverRating && rating >= star),
                                        'text-slate-300': hoverRating < star && (!hoverRating || rating < star)
                                    }">
                                    <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                </button>
                            </template>
                        </div>
                        <p class="text-sm text-slate-500 mt-2" x-text="rating > 0 ? rating + ' Bintang terpilih' : 'Klik bintang untuk menilai'"></p>
                    </div>
                    
                    {{-- DESKRIPSI ULASAN --}}
                    <div class="mb-6">
                        <label for="review" class="block text-slate-700 text-sm font-bold mb-2">Ceritakan Pengalamanmu</label>
                        <textarea 
                            name="review" 
                            id="review" 
                            rows="5" 
                            {{-- Styling Input Konsisten --}}
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-amber-600 focus:ring focus:ring-amber-200/50 text-slate-800"
                            placeholder="Bagaimana kualitas barangnya? Apakah pengirimannya cepat?"
                            required></textarea>
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ url()->previous() }}" class="px-6 py-2 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition shadow-sm">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-2 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 shadow-lg shadow-slate-400/50 transition transform hover:-translate-y-0.5">
                            Kirim Ulasan 🚀
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>