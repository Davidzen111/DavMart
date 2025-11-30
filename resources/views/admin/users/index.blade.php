<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi Sukses dan Error --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Daftar Pengguna (Buyer & Seller)</h3>
                
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Nama</th>
                            <th class="py-3 px-4 text-left">Email</th>
                            <th class="py-3 px-4 text-center">Role</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Bergabung</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-bold">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-1 rounded text-xs font-bold text-white {{ $user->role == 'seller' ? 'bg-purple-500' : 'bg-blue-500' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-1 rounded text-xs font-bold text-white 
                                    {{ $user->status == 'approved' ? 'bg-green-500' : 
                                       ($user->status == 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-4 text-center flex justify-center space-x-2">
                                
                                {{-- TOMBOL EDIT --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-800 font-bold text-xs underline">
                                    Edit
                                </a>

                                {{-- TOMBOL HAPUS (Hanya jika bukan Admin yang sedang login) --}}
                                @if (Auth::id() !== $user->id) 
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini beserta seluruh datanya? TINDAKAN INI BERBAHAYA!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs underline">Hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>