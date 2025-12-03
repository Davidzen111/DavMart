<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Order; 
use Illuminate\Support\Facades\DB; 

class AdminController extends Controller
{
    public function index() {
        $totalUsers = User::where('role', '!=', 'admin')->count();

        $pendingSellers = User::where('role', 'seller')
                              ->where('status', 'pending')
                              ->count();

        $totalIncomeValue = Order::where('status', 'completed')->sum('total_price');

        $formattedIncome = 'Rp ' . number_format($totalIncomeValue, 0, ',', '.');
        
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'pendingSellers' => $pendingSellers,
            'totalIncome' => $formattedIncome, 
        ]);
    }

    public function sellerVerification() {
        $pendingSellers = User::where('role', 'seller')
                             ->where('status', 'pending')
                             ->get();
        
        return view('admin.seller_verification', compact('pendingSellers'));
    }

    public function approveSeller(Request $request, $id) {
        $user = User::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $user->status = $request->status;
        $user->save();

        return redirect()->route('admin.seller.verification')
                         ->with('success', 'Status Seller berhasil diperbarui!');
    }
}