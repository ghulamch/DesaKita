<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apparatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApparatusController extends Controller
{
    public function index()
    {
        $apparatus = Apparatus::orderBy('sort_order', 'asc')->get();
        return view('admin.apparatus.index', compact('apparatus'));
    }

    public function create()
    {
        $allApparatus = Apparatus::all();
        return view('admin.apparatus.create', compact('allApparatus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'cropped_image' => 'nullable|string',
            'parent_id' => 'nullable|exists:apparatus,id',
            'connection_type' => 'required|in:komando,koordinasi'
        ]);

        if ($request->filled('cropped_image')) {
            $imageData = $request->input('cropped_image');
            $data['image'] = $this->saveBase64Image($imageData, 'apparatus');
        } elseif ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('apparatus', 'public');
        }

        $data['sort_order'] = Apparatus::max('sort_order') + 1;

        Apparatus::create($data);
        return redirect()->route('apparatus.index')->with('success', 'Data Aparatur berhasil ditambahkan.');
    }

    public function edit(Apparatus $apparatus)
    {
        $allApparatus = Apparatus::where('id', '!=', $apparatus->id)->get();
        return view('admin.apparatus.edit', compact('apparatus', 'allApparatus'));
    }

    public function update(Request $request, Apparatus $apparatus)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'cropped_image' => 'nullable|string',
            'parent_id' => 'nullable|exists:apparatus,id|different:id',
            'connection_type' => 'required|in:komando,koordinasi'
        ]);

        if ($request->filled('cropped_image')) {
            if ($apparatus->image) {
                Storage::disk('public')->delete($apparatus->image);
            }
            $imageData = $request->input('cropped_image');
            $data['image'] = $this->saveBase64Image($imageData, 'apparatus');
        } elseif ($request->hasFile('image')) {
            if ($apparatus->image) {
                Storage::disk('public')->delete($apparatus->image);
            }
            $data['image'] = $request->file('image')->store('apparatus', 'public');
        }

        $apparatus->update($data);
        return redirect()->route('apparatus.index')->with('success', 'Data Aparatur berhasil diubah.');
    }

    public function updateHierarchy(Request $request)
    {
        $id = $request->input('id');
        $parentId = $request->input('parent_id');
        $x = $request->input('x');
        $y = $request->input('y');

        $data = [];
        if ($request->has('parent_id')) $data['parent_id'] = $parentId;
        if ($request->has('x')) $data['x'] = $x;
        if ($request->has('y')) $data['y'] = $y;

        Apparatus::where('id', $id)->update($data);

        return response()->json(['status' => 'success']);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->input('order');
        foreach ($order as $index => $id) {
            Apparatus::where('id', $id)->update(['sort_order' => $index]);
        }
        return response()->json(['status' => 'success']);
    }

    private function saveBase64Image($base64String, $folder)
    {
        $image_parts = explode(";base64,", $base64String);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $filename = $folder . '/' . uniqid() . '.' . $image_type;
        
        Storage::disk('public')->put($filename, $image_base64);
        
        return $filename;
    }

    public function destroy(Apparatus $apparatus)
    {
        if ($apparatus->image) {
            Storage::disk('public')->delete($apparatus->image);
        }
        $apparatus->delete();
        return redirect()->route('apparatus.index')->with('success', 'Data Aparatur berhasil dihapus.');
    }
}
