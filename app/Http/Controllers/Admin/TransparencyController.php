<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Services\TransparencyScraper;
use Illuminate\Http\Request;

class TransparencyController extends Controller
{
    public function index()
    {
        $budgets = Budget::orderBy('year', 'desc')->orderBy('category')->get();
        $budgetsByYear = $budgets->groupBy('year');
        
        // Find all years that have either budget records OR official summaries
        $budgetYears = Budget::distinct()->pluck('year')->toArray();
        $summaryYears = [];
        for ($y = date('Y') + 1; $y >= 2022; $y--) {
            if (\App\Models\SiteMeta::getVal("budget_summary_{$y}")) {
                $summaryYears[] = (int) $y;
            }
        }
        
        $years = collect(array_merge($budgetYears, $summaryYears))->unique()->sortDesc();
        if ($years->isEmpty()) $years = collect([date('Y')]);

        // Ensure budgetsByYear has an entry for every year found in summaries
        foreach ($years as $yr) {
            if (!isset($budgetsByYear[$yr])) {
                $budgetsByYear[$yr] = collect([]);
            }
        }
        $budgetsByYear = $budgetsByYear->sortKeysDesc();

        $villageName = \App\Models\SiteMeta::getVal('village_name');
        
        // Lookup correct code from wilayah.json
        $path = storage_path('app/data/wilayah/wilayah.json');
        $villageId = '';
        if (file_exists($path)) {
            $jsonData = json_decode(file_get_contents($path), true);
            $wilayah = $jsonData['wilayah'] ?? [];
            foreach ($wilayah as $item) {
                if (isset($item['nama']) && strtolower($item['nama']) === strtolower($villageName)) {
                    $villageId = $item['kode'];
                    break;
                }
            }
        }
        
        $cleanId = str_replace('.', '', $villageId);

        // Fetch official summaries for each year
        $summaries = [];
        foreach ($years as $y) {
            $data = \App\Models\SiteMeta::getVal("budget_summary_{$y}");
            if ($data) {
                $summaries[$y] = json_decode($data, true);
            }
        }

        return view('admin.transparency.index', compact('budgets', 'budgetsByYear', 'years', 'villageId', 'villageName', 'cleanId', 'summaries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer',
            'type' => 'required|in:Pendapatan,Belanja,Pembiayaan',
            'category' => 'required|string',
            'amount' => 'required|numeric',
            'planned_amount' => 'nullable|numeric',
            'volume' => 'nullable|string',
            'satuan' => 'nullable|string',
            'output' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        Budget::create($validated);

        return redirect()->route('admin.transparency.index')->with('success', 'Data anggaran berhasil ditambahkan.');
    }

    public function update(Request $request, Budget $transparency)
    {
        $validated = $request->validate([
            'year' => 'required|integer',
            'type' => 'required|in:Pendapatan,Belanja,Pembiayaan',
            'category' => 'required|string',
            'amount' => 'required|numeric',
            'planned_amount' => 'nullable|numeric',
            'volume' => 'nullable|string',
            'satuan' => 'nullable|string',
            'output' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $transparency->update($validated);

        return redirect()->route('admin.transparency.index')->with('success', 'Data anggaran berhasil diperbarui.');
    }

    public function destroy(Budget $transparency)
    {
        $transparency->delete();
        return redirect()->route('admin.transparency.index')->with('success', 'Data anggaran berhasil dihapus.');
    }

    public function scrape(Request $request, TransparencyScraper $scraper)
    {
        $year = $request->input('year', date('Y'));

        try {
            $data = $scraper->scrape($year);
            $summaryData = \App\Models\SiteMeta::getVal("budget_summary_{$year}");
            $hasSummary = false;
            
            if ($summaryData) {
                $summary = json_decode($summaryData, true);
                // Success if we have Pagu OR Income OR Tahap1 data
                $hasSummary = ($summary['pagu'] ?? 0) > 0 || ($summary['official_income'] ?? 0) > 0 || ($summary['tahap1'] ?? 0) > 0;
            }

            if (!empty($data) || $hasSummary) {
                // Delete existing for this year
                Budget::where('year', $year)->delete();

                foreach ($data as $item) {
                    Budget::create($item);
                }

                $msg = !empty($data) 
                    ? "Berhasil menyinkronkan " . count($data) . " data rincian untuk tahun {$year}."
                    : "Berhasil menyinkronkan ringkasan anggaran untuk tahun {$year} (Rincian belum tersedia di Jaga.id).";

                return redirect()->route('admin.transparency.index')->with('success', $msg);
            }

            return redirect()->route('admin.transparency.index')->with('error', 'Tidak ada data rincian maupun ringkasan yang ditemukan untuk tahun tersebut.');

        } catch (\Exception $e) {
            return redirect()->route('admin.transparency.index')->with('error', $e->getMessage());
        }
    }

    public function importHtml(Request $request, TransparencyScraper $scraper)
    {
        $request->validate([
            'html_content' => 'required|string',
            'year' => 'required|integer',
        ]);

        $year = $request->year;

        try {
            $data = $scraper->parseFromHtml($request->html_content, $year);

            if (!empty($data)) {
                // Delete existing for this year (overwrite)
                Budget::where('year', $year)->delete();

                foreach ($data as $item) {
                    Budget::create($item);
                }

                return redirect()->route('admin.transparency.index')->with('success', "Berhasil mengimpor " . count($data) . " kegiatan dari HTML Jaga.id untuk tahun {$year}.");
            }

            return redirect()->route('admin.transparency.index')->with('error', 'Gagal memproses HTML. Pastikan Anda menyalin kode tabel (tbody) yang benar dari Jaga.id.');

        } catch (\Exception $e) {
            return redirect()->route('admin.transparency.index')->with('error', 'Error Parsing: ' . $e->getMessage());
        }
    }

    public function destroyByYear($year)
    {
        // Delete activity records
        Budget::where('year', $year)->delete();

        // Delete summary metadata (Dashboard stats)
        \App\Models\SiteMeta::where('meta_key', "budget_summary_{$year}")->delete();

        return redirect()->route('admin.transparency.index')->with('success', "Seluruh data anggaran dan ringkasan tahun {$year} berhasil dihapus.");
    }
    public function updateSummary(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer',
            'pagu' => 'required|numeric|min:0',
            'tahap1' => 'nullable|numeric|min:0',
            'tahap2' => 'nullable|numeric|min:0',
            'tahap3' => 'nullable|numeric|min:0',
        ]);

        $summary = [
            'pagu' => (float) $validated['pagu'],
            'tahap1' => (float) ($validated['tahap1'] ?? 0),
            'tahap2' => (float) ($validated['tahap2'] ?? 0),
            'tahap3' => (float) ($validated['tahap3'] ?? 0),
        ];

        // Derived totals
        $summary['official_income'] = $summary['tahap1'] + $summary['tahap2'] + $summary['tahap3'];
        $summary['official_expense'] = $summary['official_income']; // Default assumption for official status

        \App\Models\SiteMeta::setVal("budget_summary_{$validated['year']}", json_encode($summary));

        return redirect()->route('admin.transparency.index')->with('success', "Ringkasan anggaran tahun {$validated['year']} berhasil diperbarui.");
    }
}
