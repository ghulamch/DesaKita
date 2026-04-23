<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Budget;
use App\Models\Product;
use App\Models\SiteMeta;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function news()
    {
        $news = News::latest()->paginate(9);
        return view('news.index', compact('news'));
    }

    public function newsDetail(News $news)
    {
        return view('news.show', compact('news'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function transparency(Request $request)
    {
        // Get all available years from the database (Budget table)
        $budgetYears = Budget::distinct()->pluck('year')->toArray();
        
        // Also check if we have any summaries in SiteMeta for years that might not have rows yet (like 2026)
        $summaryYears = [];
        for ($y = date('Y'); $y >= 2022; $y--) {
            if (SiteMeta::getVal("budget_summary_{$y}")) {
                $summaryYears[] = (int) $y;
            }
        }

        $availableYears = collect(array_merge($budgetYears, $summaryYears))->unique()->sortDesc();
        
        // Default to request year, or latest year with data, or current year
        $selectedYear = $request->get('year', $availableYears->first() ?? date('Y'));

        $budgets = Budget::where('year', $selectedYear)->get();
        $belanjaItems = $budgets->where('type', 'Belanja');
        
        $summaryData = SiteMeta::getVal("budget_summary_{$selectedYear}");
        $summary = $summaryData ? json_decode($summaryData, true) : null;
        
        // Prioritize official totals from Jaga.id summary cards for card display
        $totalPendapatan = isset($summary['pagu']) && $summary['pagu'] > 0 
                           ? $summary['pagu'] 
                           : $budgets->where('type', 'Pendapatan')->sum('amount');
                           
        // Penyaluran: Money from Center (Official Income)
        $totalPenyaluran = isset($summary['official_income']) && $summary['official_income'] > 0 
                           ? $summary['official_income'] 
                           : 0;

        // Realisasi Belanja: Strictly sum of activities from database
        $totalBelanja = $belanjaItems->sum('amount');

        // Group by Sector (Bidang APBDes)
        $sectors = [
            '1' => ['label' => 'Penyelenggaraan Pemerintahan', 'amount' => 0],
            '2' => ['label' => 'Pembangunan Desa', 'amount' => 0],
            '3' => ['label' => 'Pembinaan Kemasyarakatan', 'amount' => 0],
            '4' => ['label' => 'Pemberdayaan Masyarakat', 'amount' => 0],
            '5' => ['label' => 'Penanggulangan Bencana/Darurat', 'amount' => 0],
        ];

        foreach ($belanjaItems as $item) {
            $prefix = substr($item->category, 0, 1);
            if (isset($sectors[$prefix])) {
                $sectors[$prefix]['amount'] += $item->amount;
            }
        }

        return view('transparency.index', compact('budgets', 'availableYears', 'selectedYear', 'totalPendapatan', 'totalBelanja', 'totalPenyaluran', 'summary', 'sectors'));
    }

    public function history()
    {
        return view('profile.history');
    }

    public function visimisi()
    {
        return view('profile.visimisi');
    }

    public function structure()
    {
        $apparatus = \App\Models\Apparatus::orderBy('sort_order', 'asc')->get();
        return view('profile.structure', compact('apparatus'));
    }

    public function legalProducts()
    {
        $products = \App\Models\LegalProduct::latest()->paginate(12);
        return view('legal.index', compact('products'));
    }

    public function marketplace()
    {
        $products = Product::where('is_active', true)->latest()->paginate(12);
        return view('marketplace.index', compact('products'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        if (!$query) return response()->json([]);

        $news = News::where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->latest()->take(5)->get()->map(function($item) {
                return [
                    'title' => $item->title,
                    'url' => route('news.show', $item),
                    'type' => 'Berita',
                    'category' => $item->category
                ];
            });

        $products = Product::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->latest()->take(5)->get()->map(function($item) {
                return [
                    'title' => $item->name,
                    'url' => route('marketplace.index') . '?search=' . urlencode($item->name),
                    'type' => 'Pasar Desa',
                    'category' => 'Produk UMKM'
                ];
            });

        $legal = \App\Models\LegalProduct::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->latest()->take(5)->get()->map(function($item) {
                return [
                    'title' => $item->title,
                    'url' => route('profile.legal'),
                    'type' => 'Produk Hukum',
                    'category' => $item->category ?: 'Dokumen'
                ];
            });

        return response()->json($news->concat($products)->concat($legal));
    }

    public function weatherProxy(Request $request)
    {
        $code = $request->get('adm4');
        if (!$code) return response()->json(['error' => 'Missing code'], 400);

        $url = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$code}";
        
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(10)->get($url);
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Fetch failed'], 500);
        }
    }
}
