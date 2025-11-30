<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - DavMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">🛍️ DavMart</a>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Masuk</a>
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-bold">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-600 hover:text-blue-600 font-medium transition group">
                    <div class="w-8 h-8 rounded-full bg-white border border-gray-300 flex items-center justify-center mr-2 group-hover:border-blue-600 group-hover:bg-blue-50 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </div>
                    Kembali
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-8 p-8 mb-8">
                <div class="bg-gray-100 rounded-lg overflow-hidden h-96 flex items-center justify-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-contain">
                    @else
                        <span class="text-gray-400">No Image</span>
                    @endif
                </div>

                <div>
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded uppercase">
                                {{ $product->category->name }}
                            </span>
                            <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $product->name }}</h1>
                            
                            <div class="flex items-center mt-2">
                                <span class="text-yellow-400 text-xl">★</span>
                                <span class="font-bold text-gray-700 ml-1">{{ number_format($ratingAvg, 1) }}</span>
                                <span class="text-gray-500 text-sm ml-1">({{ $ratingCount }} Ulasan)</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <p class="text-4xl font-bold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-gray-500 mt-1">Stok Tersedia: {{ $product->stock }}</p>
                    </div>

                    <div class="mt-6 border-t border-b py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600">
                                {{ substr($product->store->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Dijual oleh:</p>
                                <p class="font-bold text-gray-800">{{ $product->store->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="font-bold text-gray-800 mb-2">Deskripsi Produk</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <div class="mt-8">
                        @auth
                            @if(Auth::user()->role === 'buyer')
                                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="text-gray-500 hover:text-red-500 font-bold text-sm flex items-center gap-2">
                                        ❤️ Simpan ke Favorit
                                    </button>
                                </form>
                            @endif

                            @if(Auth::user()->role === 'buyer')
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition shadow-lg mt-4">
                                        + Masukkan Keranjang
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-3 rounded-lg cursor-not-allowed mt-4">
                                    Login sebagai Buyer untuk membeli
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block text-center w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition shadow-lg mt-4">
                                Login untuk Membeli
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Ulasan Pembeli</h3>

                @if($product->reviews->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500 italic">Belum ada ulasan untuk produk ini.</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($product->reviews as $review)
                        <div class="border-b border-gray-100 pb-6 last:border-0">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-gray-800">{{ $review->user->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex text-yellow-400 text-sm">
                                    @for($i=0; $i < $review->rating; $i++) ★ @endfor
                                    @for($i=$review->rating; $i < 5; $i++) <span class="text-gray-300">★</span> @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed bg-gray-50 p-3 rounded">
                                "{{ $review->review }}"
                            </p>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

</body>
</html>