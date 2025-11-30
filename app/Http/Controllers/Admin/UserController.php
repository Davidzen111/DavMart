<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna kecuali Admin yang sedang login.
     */
    public function index()
    {
        // Ambil semua user KECUALI yang sedang login (role apapun)
        $users = User::where('id', '!=', Auth::id())->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk mengedit pengguna
     */
    public function edit(User $user)
    {
        // Cek keamanan: Admin tidak boleh mengedit akunnya sendiri melalui form ini
        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat mengedit akun Anda sendiri melalui daftar pengguna.');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memproses dan menyimpan perubahan data pengguna
     */
    public function update(Request $request, User $user)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // Email harus unik, kecuali untuk user yang sedang diedit
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:buyer,seller,admin', 
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // 2. Update Data
        $user->update($validatedData);

        return redirect()->route('admin.users.index')->with('success', "Data {$user->name} berhasil diperbarui.");
    }


    /**
     * Menghapus pengguna.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // 🚨 KEAMANAN KRITIS: Cegah Admin menghapus akunnya sendiri
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Administrator Anda sendiri.');
        }

        $userName = $user->name;
        $user->delete();

        return back()->with('success', "User ({$userName}) berhasil dihapus.");
    }
}