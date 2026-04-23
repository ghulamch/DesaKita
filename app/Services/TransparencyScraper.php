<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\Budget;
use App\Models\SiteMeta;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Spatie\Browsershot\Browsershot;

class TransparencyScraper
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
            ],
            'timeout' => 15,
            'verify' => false,
        ]);
    }

    /**
     * Logic: Auto-scrape from Jaga.id using Browsershot (Headless Chrome)
     * Strategy: Download to local file -> Parse -> Cleanup
     */
    public function scrape($year = null)
    {
        $year = $year ?? date('Y');
        $villageName = SiteMeta::getVal('village_name');
        
        if (!$villageName) {
            throw new \Exception('Nama Desa belum dikonfigurasi di pengaturan.');
        }

        // 1. Lookup code from index
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
        
        if (!$villageId) {
            throw new \Exception("Gagal menemukan kode wilayah untuk desa '{$villageName}'.");
        }

        $cleanId = str_replace('.', '', $villageId);
        $url = "https://jaga.id/pelayanan-publik/desa/{$cleanId}/" . urlencode($villageName) . "?year={$year}";

        // Define temporary storage path
        $tempDir = storage_path('app/transparency');
        if (!file_exists($tempDir)) mkdir($tempDir, 0755, true);
        $tempFile = $tempDir . '/jaga_dump_' . $year . '.html';

        try {
            Log::info("Starting Scraping for: " . $url . " (Year: {$year})");

            $getContent = function($timeout = 180) use ($url) {
                return Browsershot::url($url)
                    ->setNodeBinary('C:\Program Files\nodejs\node.exe')
                    ->setNpmBinary('C:\Program Files\nodejs\npm.cmd')
                    ->userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36')
                    ->windowSize(1920, 1080)
                    ->addChromiumArguments([
                        'disable-blink-features=AutomationControlled',
                        'no-sandbox',
                        'disable-setuid-sandbox',
                        'disable-web-security',
                        'disable-features=IsolateOrigins,site-per-process',
                        'disable-infobars',
                    ])
                    ->delay(10000) // Fixed wait for JS rendering, much more reliable than NetworkIdle for chatty sites
                    ->timeout($timeout)
                    ->bodyHtml();
            };

            $html = $getContent(180);
            Log::info("Scraper Attempt 1 HTML Length: " . strlen($html));

            file_put_contents($tempFile, $html);
            $data = $this->parseFromHtml($html, $year);

            // SMART RETRY: If we got 0 activities and the summary is empty, Jaga.id might have served a "shadow" page.
            $summary = json_decode(SiteMeta::getVal("budget_summary_{$year}"), true);
            if (empty($data) && (isset($summary['pagu']) && $summary['pagu'] == 0)) {
                Log::warning("Scrape Attempt 1 yielded empty summary. Retrying with longer wait...");
                sleep(5); // Give it a breather
                $html = $getContent(240); // Attempt 2 with longer total timeout
                Log::info("Scraper Attempt 2 HTML Length: " . strlen($html));
                file_put_contents($tempFile, $html);
                $data = $this->parseFromHtml($html, $year);
            }

            // Cleanup
            if (file_exists($tempFile)) unlink($tempFile);

            return $data;

        } catch (\Exception $e) {
            // Cleanup on error too
            if (file_exists($tempFile)) unlink($tempFile);
            
            Log::error('Download-First Scraping failed for ' . $villageName . ': ' . $e->getMessage());
            throw new \Exception('Gagal mengunduh atau memproses data: ' . $e->getMessage());
        }
    }

    /**
     * Logic: Parse from HTML content (Pasted from Jaga.id or fetched via Browsershot)
     */
    public function parseFromHtml($html, $year = null)
    {
        $year = $year ?? date('Y');
        $crawler = new Crawler($html);
        
        // 1. Scrape Top-Level Summary (Global Text Search Strategy)
        $summary = [
            'pagu' => 0,
            'tahap1' => 0,
            'tahap2' => 0,
            'tahap3' => 0,
            'official_income' => 0,
            'official_expense' => 0,
        ];

        // Clean up text for easier searching
        $bodyText = str_replace(['Created with Highcharts 8.2.2'], '', $crawler->text());
        
        // Helper to extract numbers following multiple labels (synonyms)
        $extractFromLabels = function($labels, $text) {
            foreach ($labels as $label) {
                // Regex improvement: 
                // 1. Label
                // 2. Anything (non-greedy)
                // 3. Optional Rp/IDR
                // 4. The number (at least 6 digits for budget stability)
                // 5. Negative lookahead to ensure it's NOT followed by population units (jiwa, orang, penduduk)
                $pattern = '/' . preg_quote($label, '/') . '.*?(?:Rp\.?|IDR)?\s*([\d\.,]{6,})(?!\s*(?:jiwa|orang|penduduk))/is';
                
                if (preg_match($pattern, $text, $matches)) {
                    $cleaned = (int) preg_replace('/[^0-9]/', '', $matches[1]);
                    // Village budgets are typically > 100k. 
                    // Numbers like 12.940 are almost certainly population.
                    if ($cleaned > 100000) return $cleaned; 
                }
            }
            return 0;
        };

        // Pagu / Budget Synonyms
        $summary['pagu'] = $extractFromLabels(['Nilai Anggaran', 'Anggaran', 'Pagu Anggaran', 'Total Anggaran'], $bodyText);
        
        // REFINEMENT: If still 0, try to find the number that is physically AFTER the label "Nilai Anggaran"
        if ($summary['pagu'] == 0) {
            foreach (['Nilai Anggaran', 'Anggaran'] as $searchLabel) {
                $pos = stripos($bodyText, $searchLabel);
                if ($pos !== false) {
                    $afterText = substr($bodyText, $pos);
                    // Find the first number with at least 5 digits in the text that follows the label
                    if (preg_match('/(?:Rp\.?|IDR)?\s*([\d\.,]{6,})/i', $afterText, $matches)) {
                        $summary['pagu'] = (int) preg_replace('/[^0-9]/', '', $matches[1]);
                        if ($summary['pagu'] > 0) break;
                    }
                }
            }
        }

        if ($summary['pagu'] == 0) {
            Log::info("Pagu detection failed. Body text sample: " . substr($bodyText, 0, 2000));
        }
        
        // Income / Disbursement Synonyms
        $summary['official_income'] = $extractFromLabels(['Tersalurkan', 'Penyaluran', 'Total Penyaluran', 'Realisasi Penyaluran'], $bodyText);
        
        // Stages
        $summary['tahap1'] = $extractFromLabels(['Tahap 1'], $bodyText);
        $summary['tahap2'] = $extractFromLabels(['Tahap 2'], $bodyText);
        $summary['tahap3'] = $extractFromLabels(['Tahap 3'], $bodyText);
        
        // Belanja Desa Synonyms
        $summary['official_expense'] = $summary['official_income'] ?: $extractFromLabels(['Belanja Desa', 'Total Belanja', 'Realisasi Belanja'], $bodyText);

        // FALLBACK: If global text search failed, check individual .q-card blocks
        if ($summary['pagu'] == 0 || $summary['official_income'] == 0) {
            $nodes = $crawler->filter('.q-card, .q-item, div[class*="summary"]');
            foreach ($nodes as $domNode) {
                $node = new Crawler($domNode);
                $text = $node->text();
                $val = (int) preg_replace('/[^0-9]/', '', $text);
                if ($val <= 0) continue;

                $t = strtolower($text);
                if ($summary['pagu'] == 0 && (str_contains($t, 'pagu') || str_contains($t, 'anggaran'))) $summary['pagu'] = $val;
                if ($summary['official_income'] == 0 && (str_contains($t, 'salur') || str_contains($t, 'pendapatan'))) $summary['official_income'] = $val;
                if ($summary['tahap1'] == 0 && str_contains($t, 'tahap 1')) $summary['tahap1'] = $val;
                if ($summary['tahap2'] == 0 && str_contains($t, 'tahap 2')) $summary['tahap2'] = $val;
            }
        }

        Log::info("Extracted Summary Update: " . json_encode($summary));

        // Save summary to SiteMeta for easy access in view
        SiteMeta::setVal("budget_summary_{$year}", json_encode($summary));

        // 1.5 Scrape Global Village Stats (Area & Population) if visible
        $extractMetric = function($labels, $text) {
            foreach ($labels as $label) {
                $pattern = '/' . preg_quote($label, '/') . '.*?\s*([\d\.,]+)/is';
                if (preg_match($pattern, $text, $matches)) {
                    return preg_replace('/[^0-9\.]/', '', str_replace(',', '.', $matches[1]));
                }
            }
            return null;
        };

        $luas = $extractMetric(['Luas Wilayah'], $bodyText);
        $pop = $extractMetric(['Jumlah Penduduk', 'Total Penduduk', 'Populasi'], $bodyText);

        if ($luas) SiteMeta::setVal('village_area', $luas);
        if ($pop) SiteMeta::setVal('total_population', (int)$pop);

        // 2. Scrape Table Rows
        // We look for a table that has at least 7 columns to ensure it's the activity table
        $tables = $crawler->filter('table');
        $processed = [];

        foreach ($tables as $tableDom) {
            $tableNode = new Crawler($tableDom);
            $rows = $tableNode->filter('tbody tr');
            
            // If the table has rows, let's check if it's the right one (Activity Table has many columns)
            foreach ($rows as $rowDom) {
                $node = new Crawler($rowDom);
                $cols = $node->filter('td');
                
                // Real activity tables have 7-8 columns. Heritage/Legend tables usually have 2-3.
                if ($cols->count() >= 7) {
                    $category = trim($cols->eq(1)->text());
                    $volume = trim($cols->eq(2)->text());
                    $satuan = trim($cols->eq(3)->text());
                    $output = trim($cols->eq(4)->text());
                    $keterangan = $cols->count() >= 8 ? trim($cols->eq(5)->text()) : '';
                    
                    $plannedAmount = 0;
                    $realizedAmount = 0;

                    // Mapping logic based on column count
                    if ($cols->count() >= 8) {
                        $plannedAmount = (int) preg_replace('/[^0-9]/', '', $cols->eq(6)->text());
                        $realizedAmount = (int) preg_replace('/[^0-9]/', '', $cols->eq(7)->text());
                    } else {
                        $realizedAmount = (int) preg_replace('/[^0-9]/', '', $cols->eq(6)->text());
                    }
                    
                    if (($realizedAmount > 0 || $plannedAmount > 0) && !empty($category)) {
                        $processed[] = [
                            'year' => $year,
                            'type' => 'Belanja',
                            'category' => $category,
                            'amount' => $realizedAmount,
                            'planned_amount' => $plannedAmount,
                            'volume' => $volume,
                            'satuan' => $satuan,
                            'output' => $output,
                            'keterangan' => $keterangan,
                        ];
                    }
                }
            }
        }

        Log::info("Total activities processed from tables: " . count($processed));
        return $processed;
    }
}
