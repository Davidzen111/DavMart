<x-guest-layout>
    <div class="text-center p-6 md:p-8 bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100">
        
        {{-- Ikon penolakan --}}
        <div class="flex justify-center mb-6">
            <div class="p-5 bg-red-100 rounded-full border-2 border-red-200">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        </div>

        {{-- Judul Status --}}
        <h2 class="text-3xl font-extrabold text-slate-900 mb-3 tracking-tight">
            Pendaftaran Ditolak
        </h2>

        {{-- Pesan Utama Penolakan --}}
        <p class="text-slate-600 mb-6 max-w-sm mx-auto">
            Mohon maaf, {{ Auth::user()->name }}.<br>
            Pengajuan toko Anda tidak disetujui oleh Administrator karena tidak memenuhi syarat ketentuan kami.
        </p>

        {{-- KOTAK INFORMASI (Panduan langkah selanjutnya) --}}
        <div class="bg-amber-50 border border-amber-300 p-4 rounded-xl mb-8 text-sm text-amber-800 text-left shadow-sm">
            <strong class="text-slate-800">Apa yang harus dilakukan?</strong>
            <ul class="list-disc ml-5 mt-2 space-y-1 text-slate-700">
                <li>Anda tidak dapat mengakses dashboard Seller.</li>
                <li>Silakan <b>hapus akun ini</b> jika ingin mendaftar ulang dengan email yang sama.</li>
                <li>Atau hubungi Admin untuk informasi lebih lanjut.</li>
            </ul>
        </div>

        <div class="flex flex-col gap-3">
            
            {{-- TOMBOL UTAMA: Hapus Akun Seller --}}
            <form action="{{ route('seller.account.destroy') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini secara permanen? Tindakan ini tidak dapat dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl transition 
                           shadow-lg shadow-red-400/50 transform hover:-translate-y-0.5">
                    Hapus Akun & Daftar Ulang
                </button>
            </form>
            
            {{-- TOMBOL SEKUNDER: Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                    class="text-slate-500 hover:text-slate-800 underline text-sm font-semibold transition">
                    Keluar (Logout)
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>