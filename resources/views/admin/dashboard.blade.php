<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex overflow-hidden bg-white shadow-sm sm:rounded-lg">
                
                <div class="w-1/4 bg-gray-50 border-r border-gray-200 p-6 min-h-screen hidden md:block">
                    <h3 class="text-lg font-bold mb-4 text-gray-700">Menu Admin</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600' }}">
                                📊 Dashboard Overview
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition text-gray-600">
                                👥 User Management
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.seller.verification') }}" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition text-gray-600 flex justify-between items-center {{ request()->routeIs('admin.seller.verification') ? 'bg-blue-600 text-white' : '' }}">
                                🔐 Seller Verification
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.categories.index') }}" class="block p-2 rounded hover:bg-blue-500 hover:text-white transition text-gray-600 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white' : '' }}">
                                📦 Category Management
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="w-full md:w-3/4 p-6">
                    <h3 class="text-lg font-bold mb-4">Selamat Datang, Admin!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="bg-blue-100 p-4 rounded-lg shadow-sm border border-blue-200">
                            <p class="text-sm text-blue-600 font-bold">Total User</p>
                            <p class="text-2xl font-bold text-gray-800">120</p>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg shadow-sm border border-yellow-200">
                            <p class="text-sm text-yellow-600 font-bold">Pending Sellers</p>
                            <p class="text-2xl font-bold text-gray-800">5</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg shadow-sm border border-green-200">
                            <p class="text-sm text-green-600 font-bold">Total Transaksi</p>
                            <p class="text-2xl font-bold text-gray-800">Rp 45.2jt</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded border border-gray-200">
                        <p class="text-gray-600">Silakan pilih menu di samping untuk mengelola aplikasi.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>