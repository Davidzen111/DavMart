<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg text-center">
            
            {{-- Ikon Jam / Menunggu --}}
            <div class="mb-4 flex justify-center">
                <svg class="w-16 h-16 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                Pendaftaran Sedang Diproses
            </h2>

            <p class="text-gray-600 mb-6">
                Halo! Terima kasih sudah mendaftar sebagai Seller. <br>
                Saat ini tim Admin kami sedang memverifikasi data toko Anda. Mohon tunggu 1x24 jam.
            </p>

            <div class="border-t border-gray-200 pt-4">
                <p class="text-sm text-gray-500 mb-4">Ingin cek lagi nanti?</p>
                
                {{-- Tombol Logout (PENTING: Agar user bisa keluar) --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Logout Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>