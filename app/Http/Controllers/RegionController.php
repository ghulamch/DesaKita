<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RegionController extends Controller
{
    public function provinces()
    {
        $path = storage_path('app/data/wilayah/provinces.json');
        if (!File::exists($path)) return response()->json([]);
        
        $data = json_decode(File::get($path), true);
        return response()->json($data);
    }

    public function regencies(Request $request)
    {
        $provinceId = $request->province_id;
        $path = storage_path('app/data/wilayah/regencies.json');
        if (!File::exists($path)) return response()->json([]);
        
        $data = json_decode(File::get($path), true);
        
        if ($provinceId) {
            $data = array_values(array_filter($data, function($item) use ($provinceId) {
                return $item['province_id'] == $provinceId;
            }));
        }

        return response()->json($data);
    }

    public function districts(Request $request)
    {
        $regencyId = $request->regency_id;
        $path = storage_path('app/data/wilayah/districts.json');
        if (!File::exists($path)) return response()->json([]);
        
        $data = json_decode(File::get($path), true);
        
        if ($regencyId) {
            $data = array_values(array_filter($data, function($item) use ($regencyId) {
                return $item['regency_id'] == $regencyId;
            }));
        }

        return response()->json($data);
    }

    public function villages(Request $request)
    {
        $districtId = $request->district_id;
        $search = $request->search;
        $path = storage_path('app/data/wilayah/villages.json');
        
        if (!File::exists($path)) return response()->json([]);
        
        $data = json_decode(File::get($path), true);
        
        if ($districtId) {
            $data = array_values(array_filter($data, function($item) use ($districtId) {
                return $item['district_id'] == $districtId;
            }));
        }

        if ($search) {
            $data = array_values(array_filter($data, function($item) use ($search) {
                return str_contains(strtolower($item['name']), strtolower($search));
            }));
        }

        return response()->json(array_slice($data, 0, 100)); 
    }

    public function searchBmkg(Request $request)
    {
        // Increase memory for large JSON processing
        ini_set('memory_limit', '512M');

        $name = preg_replace('/[^a-z0-9]/', '', strtolower($request->name));
        $districtName = $request->district_name ? preg_replace('/[^a-z0-9]/', '', strtolower($request->district_name)) : null;
        $regencyId = $request->regency_id; // e.g. 3515
        
        if (!$name) return response()->json(['code' => null]);

        $path = storage_path('app/data/wilayah/wilayah.json');
        if (!File::exists($path)) return response()->json(['code' => null, 'error' => 'File not found']);

        $json = File::get($path);
        $data = json_decode($json, true);
        if (!$data || !isset($data['wilayah'])) return response()->json(['code' => null, 'error' => 'Invalid JSON']);

        $wilayah = $data['wilayah'];

        // Format regency_id to dotted prefix (e.g. 3515 -> 35.15)
        $regPrefix = null;
        if ($regencyId && strlen($regencyId) >= 4) {
            $regPrefix = substr($regencyId, 0, 2) . '.' . substr($regencyId, 2, 2);
        }

        // 1. Find District Code by Name and Regency Prefix
        $prefix = null;
        if ($districtName) {
            foreach ($wilayah as $item) {
                $checkDist = preg_replace('/[^a-z0-9]/', '', strtolower($item['nama']));
                if ($checkDist === $districtName && substr_count($item['kode'], '.') === 2) {
                    if ($regPrefix && !str_starts_with($item['kode'], $regPrefix)) {
                        continue;
                    }
                    $prefix = $item['kode'];
                    break;
                }
            }
        }

        // 2. Find Village Code under that District (or globally if no district match)
        foreach ($wilayah as $item) {
            $checkVill = preg_replace('/[^a-z0-9]/', '', strtolower($item['nama']));
            if ($checkVill === $name && substr_count($item['kode'], '.') === 3) {
                if ($prefix && !str_starts_with($item['kode'], $prefix)) {
                    continue;
                }
                return response()->json(['code' => $item['kode']]);
            }
        }

        return response()->json(['code' => null]);
    }
}
