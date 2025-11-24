<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    // Buyer dashboard (Profile/Order History)
    public function index() {
        return view('dashboard'); 
    }
}
