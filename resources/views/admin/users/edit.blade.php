@extends('layouts.admin')

@section('title', 'Edit Pengguna - Admin')

@section('content')

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tombol Kembali (Opsional, untuk UX yang lebih baik) --}}
            <div class="mb-4">
                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1">
                    &larr; Kembali ke Daftar Pengguna
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="mb-6 border-b pb-4">
                        <h2 class="font-bold text-2xl text-gray-800">
                            {{ __('Edit Pengguna') }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">Mengubah data untuk: <span class="font-semibold">{{ $user->name }}</span></p>
                    </div>

                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PATCH') {{-- Method PATCH digunakan untuk operasi Update --}}

                        {{-- Input Nama --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50 transition">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Input Email --}}
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50 transition">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Input Role --}}
                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50 transition">
                                <option value="buyer" @selected(old('role', $user->role) == 'buyer')>Buyer</option>
                                <option value="seller" @selected(old('role', $user->role) == 'seller')>Seller</option>
                                <option value="admin" @selected(old('role', $user->role) == 'admin')>Admin</option>
                            </select>
                            @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Input Status --}}
                        <div class="mb-8">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status Akun</label>
                            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50 transition">
                                <option value="approved" @selected(old('status', $user->status) == 'approved')>Approved (Aktif)</option>
                                <option value="pending" @selected(old('status', $user->status) == 'pending')>Pending (Menunggu)</option>
                                <option value="rejected" @selected(old('status', $user->status) == 'rejected')>Rejected (Ditolak/Nonaktif)</option>
                            </select>
                            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50 mr-3 transition text-sm font-medium">
                                Batal
                            </a>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition duration-150 text-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection