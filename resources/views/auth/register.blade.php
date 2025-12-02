<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="space-y-2">
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-semibold text-sm mb-2" />
            <x-text-input id="name" 
                          class="block mt-1 w-full border-slate-300 focus:border-amber-600 focus:ring-amber-600 rounded-lg shadow-sm text-slate-800" 
                          type="text" 
                          name="name" 
                          :value="old('name')" 
                          required 
                          autofocus 
                          autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4 space-y-2">
            <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-semibold text-sm mb-2" />
            <x-text-input id="email" 
                          class="block mt-1 w-full border-slate-300 focus:border-amber-600 focus:ring-amber-600 rounded-lg shadow-sm text-slate-800" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4 space-y-2">
            <x-input-label for="role" :value="__('Daftar Sebagai')" class="text-slate-700 font-semibold text-sm mb-2" />
            <select id="role" name="role" 
                class="block mt-1 w-full border-slate-300 focus:border-amber-600 focus:ring-amber-600 rounded-lg shadow-sm text-slate-800">
                <option value="buyer" @selected(old('role') == 'buyer')>Pembeli (Buyer)</option>
                <option value="seller" @selected(old('role') == 'seller')>Penjual (Seller)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="mt-4 space-y-2">
            <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-semibold text-sm mb-2" />
            <x-text-input id="password" 
                          class="block mt-1 w-full border-slate-300 focus:border-amber-600 focus:ring-amber-600 rounded-lg shadow-sm text-slate-800" 
                          type="password" 
                          name="password" 
                          required 
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4 space-y-2">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-slate-700 font-semibold text-sm mb-2" />
            <x-text-input id="password_confirmation" 
                          class="block mt-1 w-full border-slate-300 focus:border-amber-600 focus:ring-amber-600 rounded-lg shadow-sm text-slate-800" 
                          type="password" 
                          name="password_confirmation" 
                          required 
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-slate-600 hover:text-amber-700 rounded-md transition" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <button type="submit"
                class="inline-flex items-center justify-center bg-slate-900 text-white font-bold py-3 px-6 rounded-xl hover:bg-slate-800 transition shadow-lg shadow-slate-400/50 transform hover:-translate-y-0.5">
                {{ __('Daftar') }}
            </button>
        </div>
    </form>
</x-guest-layout>