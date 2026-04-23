<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalProduct;
use Illuminate\Http\Request;

class LegalProductController extends Controller
{
    public function index()
    {
        $legalProducts = LegalProduct::latest()->get();
        return view('admin.legal-products.index', compact('legalProducts'));
    }

    public function create()
    {
        $categories = ['Peraturan Desa (Perdes)', 'SK Kepala Desa', 'Peraturan Bersama Kades', 'Peraturan BPD', 'Lainnya'];
        return view('admin.legal-products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'link' => 'nullable|url'
        ]);

        $data['user_id'] = auth()->id();

        LegalProduct::create($data);
        return redirect()->route('admin.legal-products.index')->with('success', 'Produk Hukum berhasil ditambahkan.');
    }

    public function edit(LegalProduct $legalProduct)
    {
        $categories = ['Peraturan Desa (Perdes)', 'SK Kepala Desa', 'Peraturan Bersama Kades', 'Peraturan BPD', 'Lainnya'];
        return view('admin.legal-products.edit', compact('legalProduct', 'categories'));
    }

    public function update(Request $request, LegalProduct $legalProduct)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'link' => 'nullable|url'
        ]);

        $legalProduct->update($data);
        return redirect()->route('admin.legal-products.index')->with('success', 'Produk Hukum berhasil diubah.');
    }

    public function destroy(LegalProduct $legalProduct)
    {
        $legalProduct->delete();
        return redirect()->route('admin.legal-products.index')->with('success', 'Produk Hukum berhasil dihapus.');
    }
}
