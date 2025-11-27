<x-guest-layout>
    <div class="text-center">
        <div class="flex justify-center mb-4">
            <div class="p-4 bg-red-100 rounded-full">
                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Pendaftaran Ditolak
        </h2>

        <p class="text-gray-600 mb-6">
            Mohon maaf, <strong>{{ Auth::user()->name }}</strong>.<br>
            Pengajuan toko Anda tidak disetujui oleh Administrator karena tidak memenuhi syarat ketentuan kami.
        </p>

        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg mb-8 text-sm text-yellow-800 text-left">
            <strong>Apa yang harus dilakukan?</strong>
            <ul class="list-disc ml-5 mt-1">
                <li>Anda tidak dapat mengakses dashboard Seller.</li>
                <li>Silakan hapus akun ini jika ingin mendaftar ulang dengan email yang sama.</li>
                <li>Atau hubungi Admin untuk informasi lebih lanjut.</li>
            </ul>
        </div>

        <div class="flex flex-col gap-3">
            <form action="{{ route('seller.account.destroy') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini secara permanen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition">
                    Hapus Akun & Daftar Ulang
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-gray-700 underline text-sm">
                    Keluar (Logout)
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>