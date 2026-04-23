@extends('layouts.app')

@php
    $term = \App\Models\SiteMeta::getVal('village_term', 'Desa');
    $villageTerm = ($term === 'Lainnya') ? \App\Models\SiteMeta::getVal('village_term_custom', 'Desa') : $term;
@endphp

@section('title', 'Produk Hukum ' . $villageTerm)

@section('content')
<div class="bg-emerald-700 pb-24 relative overflow-hidden">
    <div class="absolute -top-10 -left-10 w-64 h-64 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
    <div class="absolute -bottom-10 -right-10 w-96 h-96 bg-emerald-800 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>

    <div class="w-full px-4 sm:px-8 lg:px-12 pt-16 relative z-10 text-center">
        <h1 class="text-4xl font-extrabold text-white tracking-tight font-display mb-4">Produk Hukum {{ $villageTerm }}</h1>
        <p class="mt-4 max-w-2xl text-xl text-emerald-100 mx-auto">
            Akses terbuka untuk transparansi regulasi. Temukan Peraturan {{ $villageTerm }}, SK Kepala {{ $villageTerm }}, dan dokumen hukum resmi lainnya.
        </p>
    </div>
</div>

<div class="w-full px-4 sm:px-8 lg:px-12 -mt-10 relative z-20 pb-32">
    <!-- Stats Banner -->
    <div class="bg-white rounded-[2rem] p-8 shadow-xl border border-emerald-50 mb-12 flex flex-col md:flex-row items-center justify-between gap-6" data-aos="fade-up">
        <div class="flex items-center space-x-4">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner">
                <i class="bi bi-journal-bookmark-fill text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">JDIH Digital</p>
                <h3 class="text-xl font-bold text-gray-900">Jaringan Dokumentasi & Informasi Hukum</h3>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="text-2xl font-black text-emerald-600 leading-none">{{ $products->total() }}</p>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Dokumen Terbit</p>
            </div>
            <div class="h-10 w-[1px] bg-slate-100 mx-4"></div>
            <div class="flex -space-x-2">
                <div class="w-10 h-10 rounded-full bg-blue-100 border-2 border-white flex items-center justify-center text-blue-600"><i class="bi bi-file-earmark-text"></i></div>
                <div class="w-10 h-10 rounded-full bg-emerald-100 border-2 border-white flex items-center justify-center text-emerald-600"><i class="bi bi-check-lg"></i></div>
            </div>
        </div>
    </div>

    <!-- Document Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
        @forelse($products as $index => $product)
            <div class="group relative bg-white border border-slate-100 rounded-[3rem] p-8 shadow-2xl shadow-slate-200/40 transition-all duration-700 hover:-translate-y-3 hover:shadow-emerald-900/10 flex flex-col h-full overflow-hidden" 
                 data-aos="fade-up" 
                 data-aos-delay="{{ 100 * ($index % 3) }}">
                
                <!-- Decoration Pattern -->
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-emerald-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700 blur-2xl"></div>

                <div class="relative z-10 flex flex-col h-full">
                    <div class="flex justify-between items-start mb-8">
                        <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center shadow-inner group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500">
                            <i class="bi bi-bank2 text-2xl"></i>
                        </div>
                        <div class="px-5 py-2 bg-emerald-50/50 backdrop-blur-sm text-emerald-700 text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl border border-emerald-100/50">
                            {{ $product->category }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 group-hover:text-emerald-500 transition-colors">Digital Archives</span>
                        <h3 class="text-2xl font-black text-slate-900 leading-tight group-hover:text-emerald-800 transition-colors font-display line-clamp-3">
                            {{ $product->title }}
                        </h3>
                    </div>
                    
                    <p class="text-slate-500 text-sm leading-relaxed mb-10 flex-1 line-clamp-4 font-medium">
                        {{ $product->description }}
                    </p>

                    <div class="pt-8 border-t border-slate-50 flex items-center justify-between mt-auto">
                        <div class="flex items-center space-x-3 text-slate-400">
                            <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-xs">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-tighter">
                                {{ $product->created_at->format('M Y') }}
                            </span>
                        </div>

                        @if($product->link)
                            <a href="{{ $product->link }}" target="_blank" class="px-6 py-3 bg-emerald-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg shadow-emerald-200 group-hover:shadow-slate-200">
                                <i class="bi bi-eye-fill mr-2"></i> Lihat
                            </a>
                        @else
                            <div class="px-6 py-3 bg-slate-100 text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-widest cursor-not-allowed">
                                No Link
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-32 text-center bg-white rounded-[4rem] border-2 border-dashed border-slate-100 shadow-inner">
                <div class="w-24 h-24 bg-slate-50 text-slate-300 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 animate-pulse">
                    <i class="bi bi-journal-x text-5xl"></i>
                </div>
                <h3 class="text-3xl font-black text-slate-900 mb-3 font-display">Belum Ada Produk Hukum</h3>
                <p class="text-slate-500 max-w-sm mx-auto font-medium">Informasi regulasi {{ strtolower($villageTerm) }} sedang dalam proses digitalisasi oleh tim administrasi desa.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="mt-16 bg-white p-6 rounded-[2rem] shadow-xl border border-slate-50 flex justify-center">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
