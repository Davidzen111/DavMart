<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="cartHandler()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
            @endif

            @if(!$cart || $cart->items->count() == 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center py-10">
                    <h3 class="text-lg text-gray-500 mb-4">Keranjang kamu masih kosong.</h3>
                    <a href="{{ route('home') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Mulai Belanja</a>
                </div>
            @else
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-xl font-bold mb-4 border-b pb-2">Pilih Item untuk Checkout</h3>
                        
                        <table class="min-w-full bg-white mb-6">
                            <thead>
                                <tr class="text-gray-600 uppercase text-xs leading-normal">
                                    <th class="py-3 px-2 text-left">Pilih</th>
                                    <th class="py-3 px-4 text-left">Produk</th>
                                    <th class="py-3 px-4 text-center">Jumlah</th>
                                    <th class="py-3 px-4 text-right">Harga</th>
                                    <th class="py-3 px-4 text-center">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                <tr class="border-b" x-bind:data-price="{{ $item->product->price }}" x-bind:data-quantity="{{ $item->quantity }}" x-bind:data-item-id="{{ $item->id }}">
                                    <td class="py-4 px-2 text-center">
                                        {{-- CHECKBOX PEMILIHAN --}}
                                        <input type="checkbox" 
                                               name="selected_items[]" 
                                               value="{{ $item->id }}" 
                                               @change="updateTotals()"
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                    </td>
                                    
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-12 h-12 object-cover rounded mr-3">
                                            @endif
                                            <div>
                                                <p class="font-bold">{{ $item->product->name }}</p>
                                                <p class="text-xs text-gray-500">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="py-4 px-4 text-center">
                                        {{-- FORM UPDATE JUMLAH --}}
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center justify-center space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            
                                            <input type="number" 
                                                   name="quantity" 
                                                   value="{{ $item->quantity }}" 
                                                   min="1" 
                                                   class="w-16 border rounded text-center text-sm" 
                                                   required 
                                                   x-on:change="this.form.submit()">
                                            
                                            {{-- Tombol submit tersembunyi, submit dilakukan via x-on:change di atas --}}
                                        </form>
                                    </td>
                                    
                                    <td class="py-4 px-4 text-right font-bold text-blue-600">
                                        Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                    </td>
                                    
                                    <td class="py-4 px-4 text-center">
                                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="lg:col-span-1" x-show="total > 0">
                        <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-200">
                            <h3 class="text-xl font-bold mb-4 border-b pb-2">Ringkasan Checkout</h3>
                            
                            <div class="flex justify-between mb-4">
                                <p class="text-gray-600">Total Item Dipilih:</p>
                                <p class="font-bold" x-text="formatRupiah(total)"></p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="font-bold text-gray-800">Grand Total:</p>
                                <h3 class="text-3xl font-extrabold text-blue-600" x-text="formatRupiah(total)"></h3>
                            </div>

                            {{-- FORM CHECKOUT UTAMA --}}
                            <form action="{{ route('checkout') }}" method="POST" x-ref="checkoutForm">
                                @csrf
                                
                                {{-- Input Tersembunyi untuk Item yang Dipilih --}}
                                <input type="hidden" name="selected_items_ids" :value="selectedIds.join(',')">
                                
                                <div class="mb-4 text-left">
                                    <label class="block text-gray-700 font-bold mb-2">Alamat Pengiriman</label>
                                    <textarea name="address" class="w-full border rounded px-3 py-2" rows="2" required placeholder="Jalan, Nomor Rumah, Kota, Kode Pos..."></textarea>
                                </div>

                                <button type="submit" 
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow transition transform hover:scale-[1.01]" 
                                        :disabled="selectedIds.length === 0"
                                        onclick="return confirm('Proses checkout untuk ' + selectedIds.length + ' item sekarang?')">
                                    Checkout (<span x-text="selectedIds.length">0</span> Item)
                                </button>
                            </form>
                        </div>
                    </div>
                    
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('cartHandler', () => ({
        total: 0,
        selectedIds: [],

        init() {
            // Jalankan update saat inisialisasi jika ada item yang sudah terpilih (walaupun biasanya tidak ada)
            this.$nextTick(() => this.updateTotals());
        },

        updateTotals() {
            this.total = 0;
            this.selectedIds = [];
            
            // Ambil semua checkbox yang dicentang
            const selectedCheckboxes = document.querySelectorAll('input[name="selected_items[]"]:checked');

            selectedCheckboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                
                // Ambil data dari atribut x-bind:data-
                const price = parseFloat(row.getAttribute('data-price'));
                const quantity = parseInt(row.getAttribute('data-quantity'));
                const itemId = row.getAttribute('data-item-id');

                if (!isNaN(price) && !isNaN(quantity)) {
                    this.total += price * quantity;
                    this.selectedIds.push(itemId);
                }
            });
            // Tampilkan/Sembunyikan kontainer checkout di Blade (x-show="total > 0")
        },

        // Fungsi format Rupiah untuk tampilan
        formatRupiah(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        }
    }));
});
</script>