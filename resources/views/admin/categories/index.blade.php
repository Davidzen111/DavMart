<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Daftar Kategori Produk</h3>
                        <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                            + Tambah Kategori
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left" width="5%">No</th>
                                    <th class="py-3 px-6 text-left">Nama Kategori</th>
                                    <th class="py-3 px-6 text-left">Slug (URL)</th>
                                    <th class="py-3 px-6 text-center" width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse($categories as $index => $category)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left">{{ $index + 1 }}</td>
                                    <td class="py-3 px-6 text-left font-bold">{{ $category->name }}</td>
                                    <td class="py-3 px-6 text-left italic text-gray-500">{{ $category->slug }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center gap-2">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white py-1 px-3 rounded text-xs font-bold transition">
                                                Edit
                                            </a>
                                            
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs font-bold transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-4 px-6 text-center text-gray-500">Belum ada kategori. Silakan tambah baru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>