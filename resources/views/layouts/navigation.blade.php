<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex shrink-0 items-center gap-6">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="group flex items-center gap-2">
                        {{-- Menggunakan styling logo DavMart yang konsisten --}}
                        <img src="{{ asset('images/logo.png') }}" alt="DavMart Logo" class="w-8 h-8 rounded-lg object-cover shadow-sm ring-2 ring-slate-100 transition-transform group-hover:scale-105">
                        <span class="text-xl font-bold text-slate-800 tracking-tight hidden md:inline">DavMart</span>
                    </a>
                </div>

                <div class="hidden sm:flex items-center space-x-2">
                    
                    <a href="{{ route('dashboard') }}" class="py-2 px-3 text-sm font-semibold rounded-lg transition {{ request()->routeIs('dashboard') && !request()->routeIs('orders.index') && !request()->routeIs('wishlist.index') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700' }}">
                        {{ __('Dashboard') }}
                    </a>

                    @if(Auth::user()->role === 'buyer')
                        
                        <a href="{{ route('orders.index') }}" class="py-2 px-3 text-sm font-semibold rounded-lg transition {{ request()->routeIs('orders.index') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700' }}">
                            {{ __('Riwayat Pesanan') }}
                        </a>

                        <a href="{{ route('wishlist.index') }}" class="py-2 px-3 text-sm font-semibold rounded-lg transition {{ request()->routeIs('wishlist.index') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700' }}">
                            {{ __('Wishlist ❤️') }}
                        </a>

                    @endif

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.users.index') }}" class="py-2 px-3 text-sm font-semibold rounded-lg transition {{ request()->routeIs('admin.users.index') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700' }}">
                            {{ __('Users') }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="hidden md:flex flex-1 items-center justify-center px-6">
                <form action="{{ route('home') }}" method="GET" class="w-full max-w-lg relative">
                    <input type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari produk impianmu di DavMart..." 
                            class="w-full rounded-full border border-slate-300 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-700 focus:border-amber-500 focus:ring-1 focus:ring-amber-200 transition shadow-sm">
                    
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </form>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-slate-200 rounded-full text-sm leading-4 font-medium text-slate-600 bg-white hover:text-slate-700 hover:bg-slate-50 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div class="font-semibold">{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-slate-700 hover:bg-slate-50">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        
                        @if(Auth::user()->role === 'admin')
                            <x-dropdown-link :href="route('admin.dashboard')" class="text-red-600 hover:bg-red-50">
                                Dashboard Admin
                            </x-dropdown-link>
                        @elseif(Auth::user()->role === 'seller')
                            <x-dropdown-link :href="route('seller.dashboard')" class="text-amber-700 hover:bg-amber-50">
                                Dashboard Toko
                            </x-dropdown-link>
                        @endif

                        <div class="border-t border-slate-100 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-500 hover:bg-red-50">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-200">
        
        <div class="p-4 border-b border-slate-100">
            <form action="{{ route('home') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Cari produk..." 
                    class="w-full rounded-lg border-slate-300 bg-slate-50 pl-10 focus:border-amber-500 focus:ring-amber-500 text-slate-800">
                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </form>
        </div>
        
        <div class="pt-2 pb-3 space-y-1">
            {{-- Dashboard Link --}}
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-700 hover:bg-slate-50">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role === 'buyer')
                {{-- Riwayat Pesanan --}}
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')" class="text-slate-700 hover:bg-slate-50">
                    {{ __('Riwayat Pesanan') }}
                </x-responsive-nav-link>
                
                {{-- Wishlist --}}
                <x-responsive-nav-link :href="route('wishlist.index')" :active="request()->routeIs('wishlist.index')" class="text-slate-700 hover:bg-slate-50">
                    {{ __('Wishlist ❤️') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')" class="text-red-600 hover:bg-red-50">
                    {{ __('Users (Admin)') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-slate-200">
            <div class="px-4">
                <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-slate-700 hover:bg-slate-50">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-500 hover:bg-red-50">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>