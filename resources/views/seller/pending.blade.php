<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-50">
        <div class="w-full sm:max-w-md mt-6 px-6 py-10 bg-white shadow-xl shadow-slate-200/50 overflow-hidden rounded-2xl text-center border border-slate-100">
            
            {{-- Ikon Jam / Menunggu (Dibuat lebih menonjol dengan background) --}}
            <div class="mb-6 flex justify-center">
                <div class="p-5 bg-amber-100 rounded-full border-2 border-amber-200">
                    <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <h2 class="text-3xl font-extrabold text-slate-900 mb-3 tracking-tight">
                Pendaftaran Sedang Diproses
            </h2>

            <p class="text-slate-600 mb-8 leading-relaxed max-w-sm mx-auto">
                Halo! Terima kasih sudah mendaftar sebagai Seller. <br>
                Saat ini tim Admin kami sedang memverifikasi data toko Anda. Mohon tunggu 1x24 jam.
            </p>

            <div class="border-t border-slate-200 pt-6">
                <p class="text-sm text-slate-500 mb-4 font-semibold">Ingin cek lagi nanti?</p>
                
                {{-- Tombol Logout (Warna Slate-900, rounded-xl, Shadow Konsisten) --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                        class="w-full inline-flex justify-center items-center px-4 py-3 bg-slate-900 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wider 
                               hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900/50 transition ease-in-out duration-150 shadow-lg shadow-slate-400/50 transform hover:-translate-y-0.5">
                        Logout & Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>