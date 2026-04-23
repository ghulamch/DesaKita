@extends('layouts.resident')

@section('content')
<div class="p-0 md:p-4">
    <div class="max-w-3xl mx-auto">
<div class="px-4 py-8 md:px-0 md:py-4">
            <a href="{{ route('resident.products.index') }}" class="text-emerald-600 font-bold flex items-center mb-4 hover:translate-x-1 transition-transform inline-flex">
                <i class="bi bi-arrow-left mr-2"></i> Kembali ke Produk Saya
            </a>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Dagangan</h1>
            <p class="text-slate-500 font-medium mt-1">Perbarui informasi produk Anda di marketplace.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 p-8 sm:p-10">
            <form action="{{ route('resident.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-8">
                    <!-- Product Name -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required 
                               class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-medium">
                        @error('name') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Price -->
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" required 
                                   class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-medium">
                            @error('price') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- WhatsApp -->
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Nomor WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone', $product->phone) }}" required 
                                   class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-medium">
                            @error('phone') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Deskripsi Produk</label>
                        <textarea name="description" rows="4" required 
                                  class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-medium">{{ old('description', $product->description) }}</textarea>
                        @error('description') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Image -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Foto Produk</label>
                        @if($product->image)
                            <div class="mb-4 w-32 h-32 rounded-lg overflow-hidden border border-slate-100">
                                <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*"
                               class="w-full px-6 py-3.5 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-medium file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        <p class="text-[10px] text-slate-400 mt-2 italic">Kosongkan jika tidak ingin mengubah foto.</p>
                        @error('image') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full py-5 bg-emerald-600 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-700 transition shadow-xl shadow-emerald-600/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
