<x-guest-layout>
    <div class="mb-6 text-sm text-slate-600 leading-relaxed">
        {{ __('Ini adalah area aplikasi yang aman. Harap konfirmasi kata sandi Anda sebelum melanjutkan.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="space-y-2">
            <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-semibold text-sm mb-2" />

            <x-text-input id="password" class="block w-full border-slate-300 focus:border-amber-600 focus:ring-amber-600 rounded-lg shadow-sm text-slate-800"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" 
                class="inline-flex items-center justify-center bg-slate-900 text-white font-bold py-2.5 px-6 rounded-xl hover:bg-slate-800 transition shadow-lg shadow-slate-400/50 transform hover:-translate-y-0.5">
                {{ __('Konfirmasi') }}
            </button>
        </div>
    </form>
</x-guest-layout>