<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $metas = SiteMeta::all()->pluck('meta_value', 'meta_key');
        return view('admin.settings.index', compact('metas'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', 'kades_photo']);
        
        foreach ($data as $key => $value) {
            SiteMeta::updateOrCreate(
                ['meta_key' => $key],
                ['meta_value' => $value]
            );
        }
        
        // Handle multiple file uploads
        $fileFields = ['kades_photo', 'site_logo', 'site_hero_image', 'site_favicon', 'village_org_chart'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('settings', 'public');
                SiteMeta::updateOrCreate(
                    ['meta_key' => $field],
                    ['meta_value' => $path]
                );
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan situs berhasil diperbarui!');
    }
}
