@extends('layouts.admin')

@section('title', 'Manajemen Pengguna - Admin')

@section('content')

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-0 hidden md:block"> 
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium 
                           rounded-md shadow-sm text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none 
                           focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>

            {{-- HEADER MOBILE (Tombol Kembali & Judul) --}}
            <div class="md:hidden mb-6 px-4 sm:px-0 flex flex-col relative"> 
                
                <div class="w-full mb-2"> 
                    <a href="{{ route('admin.dashboard') }}" 
                        class="text-gray-600 text-sm hover:text-gray-800 font-medium z-10">
                        ← Kembali
                    </a>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-800 w-full text-center">Manajemen Pengguna</h2>
            </div>
            
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100">
                
                {{-- KONTEN UTAMA --}}
                <div class="w-full p-6 md:p-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6 hidden md:block">Manajemen Pengguna</h1>
                    
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

                                            <td class="py-3 px-4 text-center">
                                                <div class="flex items-center justify-center space-x-2">
                                                    
                                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                                         class="inline-flex items-center justify-center w-8 h-8 rounded-lg 
                                                                 bg-purple-100 text-purple-600 hover:bg-purple-200 
                                                                 transition duration-150 ease-in-out p-0 translate-y-[-1px]" 
                                                         title="Edit Pengguna">
                                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-9-4l9-9m-7 7l-2 2"></path>
                                                         </svg>
                                                     </a>
                                            
                                                     @if (Auth::id() !== $user->id) 
                                                     <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini beserta seluruh datanya? Tindakan ini BERBAHAYA dan tidak dapat dibatalkan!')">
                                                         @csrf
                                                         @method('DELETE')
                                                         <button type="submit" 
                                                                  class="inline-flex items-center justify-center w-8 h-8 rounded-lg 
                                                                          bg-red-100 text-red-600 hover:bg-red-200 
                                                                          transition duration-150 ease-in-out p-0 translate-y-[-1px]"
                                                                  title="Hapus Pengguna">
                                                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                              </svg>
                                                          </button>
                                                      </form>
                                                      @endif
                                                </div>
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