<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ResidentProductController extends Controller
{
    /**
     * Display a listing of products owned by the resident.
     */
    public function index()
    {
        $products = Product::where('user_id', Auth::id())->latest()->paginate(10)->onEachSide(1);
        return view('resident.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('resident.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'phone' => 'required|string|max:20',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['seller_name'] = Auth::user()->name;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('resident.products.index')->with('success', 'Produk Anda berhasil ditambahkan ke pasar.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }
        return view('resident.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'phone' => 'required|string|max:20',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['seller_name'] = Auth::user()->name; // Ensure it stays synced with user name if changed

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('resident.products.index')->with('success', 'Informasi dagangan Anda berhasil diperbarui.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('resident.products.index')->with('success', 'Dagangan Anda berhasil dihapus.');
    }

    /**
     * Toggle the active status of the product.
     */
    public function toggleStatus(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $product->update([
            'is_active' => !$product->is_active
        ]);

        $statusText = $product->is_active ? 'diaktifkan kembali' : 'dinonaktifkan sementara';
        return redirect()->back()->with('success', "Dagangan Anda berhasil $statusText.");
    }
}
