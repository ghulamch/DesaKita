<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Agenda;
use App\Models\Apparatus;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews = News::latest()->take(5)->get();
        
        // Only show upcoming agendas (today or future), sorted by closest date
        $agendas = Agenda::where('date', '>=', now()->toDateString())
                         ->orderBy('date', 'asc')
                         ->take(4)
                         ->get();
                         
        $apparatus = Apparatus::orderBy('sort_order', 'asc')->get();
        $products = \App\Models\Product::latest()->take(5)->get();
        
        return view('home', compact('latestNews', 'agendas', 'apparatus', 'products'));
    }
}
