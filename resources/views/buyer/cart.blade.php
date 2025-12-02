@extends('layouts.buyer')

@section('title', 'Keranjang Belanja - DavMart')

@section('content')
    {{-- LOGIKA PENENTUAN RUTE KEMBALI DINAMIS --}}
    @auth
        @php
            $backRoute = match (Auth::user()->role ?? 'buyer') {
                'admin' => route('admin.dashboard'),
                'seller' => route('seller.dashboard'),
                default => route('dashboard'),
            };
            $ariaLabel = match (Auth::user()->role ?? 'buyer') {
                'admin' => 'Kembali ke Dashboard Admin',
                'seller' => 'Kembali ke Dashboard Toko',
                default => 'Kembali ke Dashboard Saya',
            };
            // $defaultAddress = Auth::user()->address ?? ''; // Dihapus karena alamat dihapus dari form
        @endphp
    @endauth

    <div class="mb-8 flex items-center gap-4 mt-4">
        <a href="{{ $backRoute ?? route('home') }}" 
            class="group flex items-center justify-center w-10 h-10 bg-white border border-slate-300 rounded-full text-slate-700 hover:text-amber-600 hover:bg-slate-50 hover:border-amber-400 transition-all duration-200 ease-in-out shadow-md"
            aria-label="{{ $ariaLabel ?? 'Kembali ke Beranda' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 transition-transform duration-200 group-hover:-translate-x-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </a>

        <div>
            <h2 class="text-2xl font-bold text-slate-800 leading-tight">
                {{ __('Keranjang Belanja') }} 
            </h2>
        </div>
    </div>

    <div x-data="cartHandler()">
        
        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Berhasil! {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Gagal! {{ session('error') }}
            </div>
        @endif

        @if(!$cart || $cart->items->count() == 0)
            <div class="bg-white overflow-hidden shadow-xl shadow-slate-200/50 rounded-2xl p-10 text-center flex flex-col items-center justify-center min-h-[400px] border border-slate-100">
                <div class="text-6xl mb-4 opacity-50 grayscale text-slate-400">🛒</div>
                <h3 class="text-xl font-bold text-slate-700 mb-2">Keranjang kamu masih kosong</h3>
                <p class="text-slate-500 mb-6">Yuk isi dengan barang-barang impianmu!</p>
                <a href="{{ route('home') }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl hover:bg-slate-800 transition shadow-lg hover:shadow-xl font-bold transform hover:-translate-y-0.5">
                    Mulai Belanja
                </a>
            </div>
        @else
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- KOLOM KIRI --}}
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100">
                    <div class="p-6 md:p-8">
                        <h3 class="text-xl font-bold mb-4 border-b border-slate-100 pb-2 text-slate-800">Daftar Produk</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white mb-2">
                                <thead>
                                    <tr class="text-slate-600 uppercase text-xs leading-normal font-bold tracking-wider border-b border-slate-100">
                                        <th class="py-3 px-2 text-left">Pilih</th>
                                        <th class="py-3 px-4 text-left">Produk</th>
                                        <th class="py-3 px-4 text-center">Jumlah</th>
                                        <th class="py-3 px-4 text-right">Total</th>
                                        <th class="py-3 px-4 text-center">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody class="text-slate-700 text-sm divide-y divide-slate-100">
                                    @foreach($cart->items as $item)
                                    <tr class="hover:bg-slate-50 transition"
                                        data-price="{{ $item->product->price }}"
                                        data-quantity="{{ $item->quantity }}"
                                        data-item-id="{{ $item->id }}">
                                        
                                        <td class="py-4 px-2 text-center">
                                            <input type="checkbox" 
                                                    name="selected_items[]" 
                                                    value="{{ $item->id }}" 
                                                    @change="updateTotals()"
                                                    class="w-5 h-5 text-amber-600 bg-slate-100 border-slate-300 rounded focus:ring-amber-500 cursor-pointer">
                                        </td>
                                        
                                        <td class="py-4 px-4">
                                            <div class="flex items-center">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-14 h-14 object-cover rounded-lg border border-slate-200 mr-3 shadow-sm">
                                                @else
                                                    <div class="w-14 h-14 bg-slate-100 rounded-lg flex items-center justify-center text-xs text-slate-400 mr-3 border border-slate-200">No Img</div>
                                                @endif
                                                <div>
                                                    <a href="{{ route('product.detail', $item->product_id) }}" class="font-bold text-slate-800 hover:text-amber-600 line-clamp-1">
                                                        {{ $item->product->name }}
                                                    </a>
                                                    <p class="text-xs text-slate-500">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="py-4 px-4 text-center">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center justify-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" 
                                                        name="quantity" 
                                                        value="{{ $item->quantity }}" 
                                                        min="1" 
                                                        class="w-16 border-slate-300 rounded-lg text-center text-sm focus:border-amber-500 focus:ring focus:ring-amber-200/50 transition" 
                                                        required 
                                                        onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        
                                        <td class="py-4 px-4 text-right font-bold text-slate-900">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </td>
                                        
                                        <td class="py-4 px-4 text-center">
                                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-400 hover:text-red-600 transition tooltip">
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
                
                {{-- KOLOM KANAN --}}
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100 sticky top-24" x-show="total > 0" x-transition>
                        <h3 class="text-xl font-bold mb-4 border-b border-slate-100 pb-2 text-slate-800">Ringkasan Pesanan</h3>
                        
                        <div class="flex justify-between mb-2 text-sm text-slate-600">
                            <p>Total Item Dipilih:</p>
                            <p class="font-bold" x-text="selectedIds.length + ' Item'"></p>
                        </div>
                        
                        <div class="mb-6 mt-4 pt-4 border-t border-dashed border-slate-200">
                            <p class="text-slate-600 text-sm mb-1">Total Harga:</p>
                            <h3 class="text-3xl font-extrabold text-amber-600" x-text="formatRupiah(total)"></h3>
                            <p class="text-xs text-slate-400 mt-1">Sudah termasuk pajak & biaya layanan</p>
                        </div>

                        <form action="{{ route('checkout.process') }}" method="POST" x-ref="checkoutForm">
                            @csrf
                            
                            <input type="hidden" name="selected_items_ids" :value="selectedIds.join(',')">
                            
                            {{-- BAGIAN ALAMAT PENGIRIMAN DIHAPUS SEPENUHNYA --}}

                            <button type="submit" 
                                    class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-slate-400/50 transition transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center gap-2 mt-4" {{-- Tambah mt-4 agar tidak menempel ke div atas --}}
                                    :disabled="selectedIds.length === 0"
                                    onclick="return confirm('Proses pesanan sekarang?')">
                                <span>Checkout Sekarang</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                        
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-center text-amber-600 text-sm mt-4" x-show="total === 0" x-transition>
                            <p>Silakan centang produk di sebelah kiri untuk melanjutkan ke pembayaran.</p>
                        </div>
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
                document.querySelectorAll('input[name="selected_items[]"]').forEach(el => el.checked = false);
                this.updateTotals();
            },

            updateTotals() {
                this.total = 0;
                this.selectedIds = [];
                
                const selectedCheckboxes = document.querySelectorAll('input[name="selected_items[]"]:checked');

                selectedCheckboxes.forEach(checkbox => {
                    const row = checkbox.closest('tr');

                    // FIX PENTING: Mendapatkan quantity terbaru dari input sebelum refresh
                    const inputQty = row.querySelector('input[name="quantity"]');
                    if (inputQty) {
                        row.setAttribute('data-quantity', inputQty.value);
                    }

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