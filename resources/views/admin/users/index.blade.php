@extends('layouts.admin')

@section('title', 'Manajemen Pengguna - Admin')

@section('content')

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- TOMBOL KEMBALI KE DASHBOARD ADMIN (Desktop) --}}
            <div class="mb-4 hidden md:block">
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium 
                           rounded-md shadow-sm text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none 
                           focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard Admin
                </a>
            </div>

            {{-- Header Mobile (Tombol Kembali ditambahkan di sini untuk tampilan mobile) --}}
            <div class="md:hidden mb-6 px-4 sm:px-0 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h2>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 text-sm hover:text-blue-800 font-medium">
                    ← Kembali
                </a>
            </div>

            {{-- CONTAINER UTAMA (Sidebar dihapus) --}}
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100">
                
                {{-- 2. KONTEN UTAMA --}}
                <div class="w-full p-6 md:p-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6 hidden md:block">Manajemen Pengguna</h1>
                    
                    {{-- Notifikasi Sukses dan Error --}}
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4 shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="bg-white overflow-hidden p-0">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Daftar Pengguna (Buyer & Seller)</h3>
                        
                        {{-- Logika Tampilan Tabel Pengguna --}}
                        @if($users->isEmpty())
                            <div class="p-10 text-center bg-gray-50 border border-dashed border-gray-300 rounded-lg">
                                <p class="text-gray-500 italic font-medium">Tidak ada pengguna yang terdaftar saat ini.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto border border-gray-100 rounded-lg">
                                <table class="min-w-full bg-white text-sm">
                                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold tracking-wider">
                                        <tr>
                                            <th class="py-3 px-4 text-left">Nama</th>
                                            <th class="py-3 px-4 text-left">Email</th>
                                            <th class="py-3 px-4 text-center">Role</th>
                                            <th class="py-3 px-4 text-center">Status</th>
                                            <th class="py-3 px-4 text-center">Bergabung</th>
                                            <th class="py-3 px-4 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700 divide-y divide-gray-100">
                                        {{-- Gunakan $users yang dikirim dari controller --}}
                                        @foreach($users as $user)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="py-3 px-4 font-bold">{{ $user->name }}</td>
                                            <td class="py-3 px-4 text-gray-600">{{ $user->email }}</td>
                                            <td class="py-3 px-4 text-center">
                                                <span class="px-3 py-1 rounded-full text-xs font-bold text-white 
                                                    {{ $user->role == 'seller' ? 'bg-purple-600' : ($user->role == 'admin' ? 'bg-red-600' : 'bg-blue-600') }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <span class="px-3 py-1 rounded-full text-xs font-bold text-white 
                                                    {{ $user->status == 'approved' ? 'bg-green-500' : 
                                                         ($user->status == 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                                    {{ ucfirst($user->status) }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-center text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                                            <td class="py-3 px-4 text-center flex justify-center space-x-2">
                                                
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-xs underline transition">
                                                    Edit
                                                </a>

                                                @if (Auth::id() !== $user->id) 
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini beserta seluruh datanya? Tindakan ini BERBAHAYA dan tidak dapat dibatalkan!')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs underline transition">Hapus</button>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection