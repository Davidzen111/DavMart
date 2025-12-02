<x-guest-layout>
    <div class="mb-6 text-sm text-slate-600 leading-relaxed">
        {{ __('Lupa kata sandi Anda? Tenang saja. Cukup berikan alamat email Anda, dan kami akan mengirimkan tautan reset kata sandi melalui email yang memungkinkan Anda memilih kata sandi baru.') }}
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg shadow-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-semibold text-sm mb-2" />
            <x-text-input id="email" 
                          class="block w-full border-slate-300 focus:border-amber-600 focus:ring-amber-600 rounded-lg shadow-sm text-slate-800" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
                          autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit"
                class="inline-flex items-center justify-center bg-slate-900 text-white font-bold py-3 px-6 rounded-xl hover:bg-slate-800 transition shadow-lg shadow-slate-400/50 transform hover:-translate-y-0.5">
                {{ __('Kirim Tautan Reset Kata Sandi') }}
            </button>
        </div>
    </form>
</x-guest-layout>