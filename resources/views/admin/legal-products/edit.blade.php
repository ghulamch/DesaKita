@extends('layouts.admin')

@section('title', 'Ubah Produk Hukum')

@section('content')
<div class="p-0 md:p-4">
    <div class="px-4 py-8 md:px-0 md:py-4 max-w-4xl mx-auto space-y-8">
        <div class="flex items-center justify-between" data-aos="fade-down">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 font-display tracking-tight mb-1">Ubah Produk Hukum</h1>
                <p class="text-slate-500">Sesuaikan data peraturan atau keputusan resmi desa.</p>
            </div>
            <a href="{{ route('admin.legal-products.index') }}" class="p-3 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center font-bold text-sm">
                <i class="bi bi-arrow-left mr-2"></i> Kembali
            </a>
        </div>

    <form action="{{ route('admin.legal-products.update', $legalProduct) }}" method="POST" class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-slate-200/50 border border-slate-100 space-y-8" data-aos="fade-up">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Judul Produk Hukum</label>
                <input type="text" name="title" value="{{ old('title', $legalProduct->title) }}" required placeholder="Contoh: Peraturan Desa No. 1 Tahun 2024 tentang APBDes"
                       class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-bold text-slate-800">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Kategori</label>
                <select name="category" required class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm appearance-none bg-white">
                    <option value="">Pilih Kategori...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ $product->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Link Dokumen (G-Drive / Link Langsung)</label>
                <div class="relative">
                    <i class="bi bi-link-45deg absolute left-5 top-4 text-emerald-500 text-xl"></i>
                    <input type="url" name="link" value="{{ old('link', $legalProduct->link) }}" placeholder="https://drive.google.com/..."
                           class="w-full pl-12 pr-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm">
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Deskripsi Singkat / Ringkasan</label>
            <textarea name="description" rows="4" placeholder="Jelaskan isi singkat dari produk hukum ini..."
                      class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm leading-relaxed">{{ old('description', $legalProduct->description) }}</textarea>
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full md:w-auto px-12 py-5 bg-emerald-600 text-white font-bold rounded-2xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:-translate-y-1 transition-all flex items-center justify-center">
                <i class="bi bi-check-circle-fill mr-3"></i> Perbarui Produk Hukum
            </button>
        </div>
    </form>
    </div>
</div>
@endsection
