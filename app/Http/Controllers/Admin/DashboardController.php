<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Budget;
use App\Models\Apparatus;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $newsCount = News::count();
        $apparatusCount = Apparatus::count();
        $productCount = Product::count();
        
        // Dynamic Budget Year Logic: Prioritize current year (2026) then available data
        $currentYear = date('Y');
        
        // Check if current year has data in Budget table OR SiteMeta summary
        $hasCurrentData = \App\Models\Budget::where('year', $currentYear)->exists() || 
                          \App\Models\SiteMeta::where('meta_key', "budget_summary_{$currentYear}")->exists();

        $targetYear = $hasCurrentData ? $currentYear : \App\Models\Budget::max('year');
        $targetYear = $targetYear ?? $currentYear; 

        // Attempt to get accurate summary from SiteMeta (Scraped from Jaga.id)
        $summaryJson = \App\Models\SiteMeta::getVal("budget_summary_{$targetYear}");
        if ($summaryJson) {
            $summary = json_decode($summaryJson, true);
            $totalPagu = $summary['pagu'] ?? 0;
            $totalDisbursed = ($summary['tahap1'] ?? 0) + ($summary['tahap2'] ?? 0) + ($summary['tahap3'] ?? 0);
        } else {
            // Fallback to manual sums if SiteMeta is missing
            $totalPagu = Budget::where('year', $targetYear)->where('type', 'Pendapatan')->sum('amount');
            $totalDisbursed = 0;
        }

        // Always calculate real expenditure from the activity table (as requested by user)
        $totalSpent = Budget::where('year', $targetYear)->where('type', 'Belanja')->sum('amount');
        
        return view('admin.dashboard', compact(
            'newsCount', 
            'apparatusCount', 
            'productCount',
            'totalPagu',
            'totalDisbursed',
            'totalSpent',
            'targetYear'
        ));
    }
}
