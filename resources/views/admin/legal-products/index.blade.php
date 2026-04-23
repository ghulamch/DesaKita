@extends('layouts.admin')

@section('title', 'Manajemen Produk Hukum')

@section('content')
<div class="p-0 md:p-4">
    <div class="px-4 py-8 md:px-0 md:py-4 flex flex-col md:flex-row md:items-center justify-between gap-4" data-aos="fade-down">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 font-display tracking-tight mb-2">Produk Hukum</h1>
            <p class="text-slate-500 text-lg">Kelola peraturan desa, SK kepala desa, dan dokumen legal lainnya.</p>
        </div>
        <a href="{{ route('admin.legal-products.create') }}" class="w-12 h-12 md:w-auto md:h-auto px-0 md:px-8 py-0 md:py-4 bg-emerald-600 text-white font-bold rounded-2xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:-translate-y-1 transition-all flex items-center justify-center">
            <i class="bi bi-plus-lg md:mr-2 text-xl md:text-base"></i> <span class="hidden md:inline">Tambah Produk Hukum</span>
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl flex items-center shadow-sm" data-aos="zoom-in">
            <i class="bi bi-check-circle-fill mr-3 text-xl"></i>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden" data-aos="fade-up">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Judul & Deskripsi</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kategori</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Link Dokumen</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($legalProducts as $product)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="max-w-md">
                                    <p class="text-slate-900 font-bold text-lg mb-1 group-hover:text-emerald-600 transition-colors">{{ $product->title }}</p>
                                    <p class="text-slate-500 text-sm line-clamp-1">{{ $product->description }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase rounded-lg border border-emerald-100">
                                    {{ $product->category }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                @if($product->link)
                                    <a href="{{ $product->link }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 font-bold text-sm flex items-center">
                                        <i class="bi bi-link-45deg mr-1 text-lg"></i> Buka Dokumen
                                    </a>
                                @else
                                    <span class="text-slate-300 text-sm italic">Tidak ada link</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.legal-products.edit', $product) }}" class="p-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.legal-products.destroy', $product) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk hukum ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="max-w-xs mx-auto">
                                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <i class="bi bi-journal-x text-3xl"></i>
                                    </div>
                                    <p class="text-slate-900 font-bold">Belum Ada Data</p>
                                    <p class="text-slate-400 text-sm mt-1">Silakan tambahkan produk hukum pertama desa Anda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
@endsection
