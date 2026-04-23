<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of all products for moderation.
     */
    public function index()
    {
        $products = Product::with('user')->latest()->paginate(10);
        return view('admin.marketplace.index', compact('products'));
    }

    /**
     * Remove a violating product from the marketplace.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.marketplace.index')->with('success', 'Dagangan warga berhasil dihapus karena melanggar aturan.');
    }
}
