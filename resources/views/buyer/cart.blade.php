@extends('layouts.buyer')

@section('title', 'Keranjang Belanja - DavMart')

@section('content')
    {{-- 
        CATATAN: 
        1. AlpineJS biasanya sudah ada di app.js (via Vite). 
           Jika belum jalan, uncomment script CDN di bawah ini.
    --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    {{-- LOGIKA PENENTUAN RUTE KEMBALI DINAMIS --}}
    @auth
        @php
            $backRoute = match (Auth::user()->role ?? 'buyer') {
                'admin' => route('admin.dashboard'),
                'seller' => route('seller.dashboard'),
                default => route('dashboard'), // Buyer/Default
            };
            $ariaLabel = match (Auth::user()->role ?? 'buyer') {
                'admin' => 'Kembali ke Dashboard Admin',
                'seller' => 'Kembali ke Dashboard Toko',
                default => 'Kembali ke Dashboard Saya',
            };
        @endphp
    @endauth

    {{-- HEADER HALAMAN (TOMBOL KEMBALI & JUDUL) --}}
    <div class="mb-8 flex items-center gap-4 mt-4">
        {{-- Tombol Kembali --}}
        <a href="{{ $backRoute ?? route('home') }}" 
           class="group flex items-center justify-center w-10 h-10 bg-white border border-gray-200 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 ease-in-out shadow-sm"
           aria-label="{{ $ariaLabel ?? 'Kembali ke Beranda' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-200 group-hover:-translate-x-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </a>

        <div>
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                {{ __('Keranjang Belanja') }} 🛒
            </h2>
        </div>
    </div>

    {{-- WRAPPER UTAMA DENGAN ALPINE JS --}}
    <div x-data="cartHandler()">
        
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- LOGIKA TAMPILAN KERANJANG --}}
        @if(!$cart || $cart->items->count() == 0)
            
            {{-- State Kosong --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 text-center flex flex-col items-center justify-center min-h-[400px] border border-gray-100">
                <div class="text-6xl mb-4 opacity-50 grayscale">🛒</div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Keranjang kamu masih kosong</h3>
                <p class="text-gray-500 mb-6">Yuk isi dengan barang-barang impianmu!</p>
                <a href="{{ route('home') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-full hover:bg-blue-700 transition shadow-lg hover:shadow-xl font-medium">
                    Mulai Belanja
                </a>
            </div>

        @else
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- KOLOM KIRI: DAFTAR BARANG --}}
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Daftar Produk</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white mb-2">
                                <thead>
                                    <tr class="text-gray-500 uppercase text-xs leading-normal font-semibold tracking-wider">
                                        <th class="py-3 px-2 text-left">Pilih</th>
                                        <th class="py-3 px-4 text-left">Produk</th>
                                        <th class="py-3 px-4 text-center">Jumlah</th>
                                        <th class="py-3 px-4 text-right">Total</th>
                                        <th class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700 text-sm">
                                    @foreach($cart->items as $item)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition last:border-0" 
                                        data-price="{{ $item->product->price }}" 
                                        data-quantity="{{ $item->quantity }}" 
                                        data-item-id="{{ $item->id }}">
                                        
                                        {{-- Checkbox --}}
                                        <td class="py-4 px-2 text-center">
                                            <input type="checkbox" 
                                                   name="selected_items[]" 
                                                   value="{{ $item->id }}" 
                                                   @change="updateTotals()"
                                                   class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                                        </td>
                                        
                                        {{-- Info Produk --}}
                                        <td class="py-4 px-4">
                                            <div class="flex items-center">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-14 h-14 object-cover rounded-lg border border-gray-200 mr-3">
                                                @else
                                                    <div class="w-14 h-14 bg-gray-100 rounded-lg flex items-center justify-center text-xs text-gray-400 mr-3 border border-gray-200">No Img</div>
                                                @endif
                                                <div>
                                                    <a href="{{ route('product.detail', $item->product_id) }}" class="font-bold text-gray-800 hover:text-blue-600 line-clamp-1">
                                                        {{ $item->product->name }}
                                                    </a>
                                                    <p class="text-xs text-gray-500">@ {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        {{-- Update Jumlah --}}
                                        <td class="py-4 px-4 text-center">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center justify-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" 
                                                       name="quantity" 
                                                       value="{{ $item->quantity }}" 
                                                       min="1" 
                                                       class="w-16 border-gray-300 rounded-md text-center text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition" 
                                                       required 
                                                       onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        
                                        {{-- Subtotal per Item --}}
                                        <td class="py-4 px-4 text-right font-bold text-gray-800">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </td>
                                        
                                        {{-- Hapus Item --}}
                                        <td class="py-4 px-4 text-center">
                                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500 transition tooltip" title="Hapus Item">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
                
                {{-- KOLOM KANAN: RINGKASAN & CHECKOUT --}}
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-100 sticky top-24" x-show="total > 0" x-transition>
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Ringkasan Pesanan</h3>
                        
                        <div class="flex justify-between mb-2 text-sm text-gray-600">
                            <p>Total Item Dipilih:</p>
                            <p class="font-bold" x-text="selectedIds.length + ' Item'"></p>
                        </div>
                        
                        <div class="mb-6 mt-4 pt-4 border-t border-dashed border-gray-200">
                            <p class="text-gray-600 text-sm mb-1">Total Harga:</p>
                            <h3 class="text-3xl font-bold text-blue-600" x-text="formatRupiah(total)"></h3>
                        </div>

                        {{-- FORM CHECKOUT --}}
                        <form action="{{ route('checkout.process') }}" method="POST" x-ref="checkoutForm">
                            @csrf
                            
                            {{-- Input Tersembunyi --}}
                            <input type="hidden" name="selected_items_ids" :value="selectedIds.join(',')">
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2 text-sm">Alamat Pengiriman</label>
                                <textarea name="address" 
                                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition text-sm" 
                                          rows="3" 
                                          required 
                                          placeholder="Jalan, Nomor Rumah, RT/RW, Kota..."></textarea>
                            </div>

                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center gap-2" 
                                    :disabled="selectedIds.length === 0"
                                    onclick="return confirm('Apakah alamat sudah benar? Proses pesanan sekarang?')">
                                <span>Checkout Sekarang</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                    </div>

                    {{-- Pesan jika belum ada yang dipilih --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center text-blue-600 text-sm mt-4" x-show="total === 0" x-transition>
                        <p>Silakan centang produk di sebelah kiri untuk melanjutkan ke pembayaran.</p>
                    </div>
                </div>
                
            </div>
        @endif

    </div>

    {{-- SCRIPT ALPINE.JS --}}
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('cartHandler', () => ({
            total: 0,
            selectedIds: [],

            init() {
                // Reset checkbox saat refresh
                document.querySelectorAll('input[name="selected_items[]"]').forEach(el => el.checked = false);
                this.updateTotals();
            },

            updateTotals() {
                this.total = 0;
                this.selectedIds = [];
                
                const selectedCheckboxes = document.querySelectorAll('input[name="selected_items[]"]:checked');

                selectedCheckboxes.forEach(checkbox => {
                    const row = checkbox.closest('tr');
                    const price = parseFloat(row.getAttribute('data-price'));
                    const quantity = parseInt(row.getAttribute('data-quantity'));
                    const itemId = row.getAttribute('data-item-id');

                    if (!isNaN(price) && !isNaN(quantity)) {
                        this.total += price * quantity;
                        this.selectedIds.push(itemId);
                    }
                });
            },

            formatRupiah(amount) {
                return 'Rp ' + amount.toLocaleString('id-ID');
            }
        }));
    });
    </script>
@endsection