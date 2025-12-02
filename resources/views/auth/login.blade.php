<x-guest-layout>
    @if (session('status'))
        <div class="mb-4 font-medium text-sm bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg shadow-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-semibold text-sm mb-2" />
            <x-text-input id="email" 
                          class="block mt-1 w-full border-slate-300 focus:border-amber-600 focus:ring-amber-600 rounded-lg shadow-sm text-slate-800" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
                          autofocus 
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4 space-y-2">
            <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-semibold text-sm mb-2" />

            <x-text-input id="password" 
                          class="block mt-1 w-full border-slate-300 focus:border-amber-600 focus:ring-amber-600 rounded-lg shadow-sm text-slate-800"
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-amber-600 shadow-sm focus:ring-amber-500" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Ingat saya') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-slate-600 hover:text-amber-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition" href="{{ route('password.request') }}">
                    {{ __('Lupa kata sandi?') }}
                </a>
            @endif
            
            <button type="submit"
                class="inline-flex items-center justify-center bg-slate-900 text-white font-bold py-3 px-6 rounded-xl hover:bg-slate-800 transition shadow-lg shadow-slate-400/50 transform hover:-translate-y-0.5">
                {{ __('Masuk') }}
            </button>
        </div>

        {{-- Tambahan: Link Daftar --}}
        <div class="text-center mt-6 text-sm">
            <span class="text-slate-600">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="font-bold text-amber-600 hover:text-amber-700 transition">Daftar Sekarang</a>
        </div>
    </form>
</x-guest-layout>