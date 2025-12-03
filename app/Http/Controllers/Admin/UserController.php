<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat mengedit akun Anda sendiri melalui daftar pengguna.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:buyer,seller,admin', 
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $user->update($validatedData);

        return redirect()->route('admin.users.index')->with('success', "Data {$user->name} berhasil diperbarui.");
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Administrator Anda sendiri.');
        }

        $userName = $user->name;
        $user->delete();

        return back()->with('success', "User ({$userName}) berhasil dihapus.");
    }
}