<x-guest-layout>
    <div class="mb-6 text-sm text-slate-600 leading-relaxed">
        {{ __('Terima kasih sudah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan melalui email? Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkannya lagi.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-medium text-sm bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg shadow-sm">
            {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
        </div>
    @endif

    <div class="mt-6 flex items-center justify-between border-t border-slate-200 pt-6">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <button type="submit"
                    class="inline-flex items-center justify-center bg-slate-900 text-white font-bold py-3 px-6 rounded-xl hover:bg-slate-800 transition shadow-lg shadow-slate-400/50 transform hover:-translate-y-0.5">
                    {{ __('Kirim Ulang Email Verifikasi') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" 
                class="underline text-sm text-red-500 hover:text-red-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                {{ __('Keluar (Logout)') }}
            </button>
        </form>
    </div>
</x-guest-layout>