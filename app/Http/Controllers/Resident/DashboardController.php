<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the resident dashboard.
     */
    public function index()
    {
        $productCount = Product::where('user_id', Auth::id())->count();
        
        return view('resident.dashboard', compact('productCount'));
    }
}
