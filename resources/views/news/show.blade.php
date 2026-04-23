@extends('layouts.app')

@php
    $term = \App\Models\SiteMeta::getVal('village_term', 'Desa');
    $villageTerm = ($term === 'Lainnya') ? \App\Models\SiteMeta::getVal('village_term_custom', 'Desa') : $term;
@endphp

@section('title', $news->title . ' | Warta ' . $villageTerm)

@section('content')
<!-- Hero Article -->
<div class="relative w-full h-[50vh] min-h-[400px] overflow-hidden bg-gray-900">
    @if($news->image)
        <img src="{{ asset('storage/'.$news->image) }}" class="w-full h-full object-cover opacity-60" alt="{{ $news->title }}" loading="lazy">
    @else
        <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2013&auto=format&fit=crop" class="w-full h-full object-cover opacity-60" alt="{{ $news->title }}" loading="lazy">
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
    
    <div class="absolute inset-0 flex flex-col justify-end pb-16">
        <div class="w-full px-4 sm:px-8 lg:px-12">
            <div data-aos="fade-up">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-emerald-600 text-white shadow-lg uppercase tracking-[0.2em] mb-6">
                    {{ $news->category }}
                </span>
                <h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold text-white font-display leading-[1.1] mb-6 drop-shadow-2xl max-w-5xl">
                    {{ $news->title }}
                </h1>
                <div class="flex items-center space-x-6 text-sm sm:text-base text-emerald-50/80 font-medium tracking-wide">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/20 backdrop-blur-md flex items-center justify-center mr-3 border border-emerald-400/30">
                            <i class="bi bi-person-fill text-emerald-300"></i>
                        </div>
                        <span>Admin Desa</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center mr-3 border border-white/20">
                            <i class="bi bi-calendar3 text-white"></i>
                        </div>
                        <span>{{ $news->created_at->translatedFormat('d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Article Content -->
<div class="w-full px-4 sm:px-8 lg:px-12 -mt-10 relative z-10 pb-24">
    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Main Content -->
        <div class="w-full lg:w-2/3">
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 p-8 sm:p-12 md:p-16 border border-slate-100 overflow-hidden relative" data-aos="fade-up" data-aos-delay="200">
                <!-- Content Decoration -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-[100px] -z-10 opacity-50"></div>
                
                <div class="prose prose-lg sm:prose-xl prose-emerald max-w-none text-slate-700 leading-relaxed font-light">
                    {!! $news->content !!}
                </div>
                
                <!-- Share & Back -->
                <div class="mt-16 pt-10 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <a href="/berita" class="inline-flex items-center text-sm font-black text-emerald-600 uppercase tracking-widest hover:gap-4 transition-all group">
                        <i class="bi bi-arrow-left mr-3 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Warta
                    </a>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Bagikan:</span>
                        <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . url()->current()) }}" target="_blank" class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                            <i class="bi bi-facebook"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="w-full lg:w-1/3 space-y-10">
            <!-- Information Card -->
            <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden" data-aos="fade-left" data-aos-delay="400">
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-emerald-500 rounded-full blur-[100px] opacity-20"></div>
                <h3 class="text-2xl font-black font-display mb-6 uppercase tracking-tight">Kanal <span class="text-emerald-400">Informasi.</span></h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-8">
                    Dapatkan informasi terverifikasi langsung dari kantor pelayanan pemerintah {{ strtolower($villageTerm) }}.
                </p>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4 p-4 bg-white/5 rounded-2xl border border-white/10">
                        <i class="bi bi-shield-check text-emerald-400 text-xl"></i>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Status</p>
                            <p class="text-sm font-bold">Informasi Resmi</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 p-4 bg-white/5 rounded-2xl border border-white/10">
                        <i class="bi bi-clock-history text-blue-400 text-xl"></i>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Masa Aktif</p>
                            <p class="text-sm font-bold">Terbit Selamanya</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other News Loop (Simulated for now, could be dynamic later) -->
            <div class="bg-white rounded-[2.5rem] border border-slate-100 p-10 shadow-sm" data-aos="fade-left" data-aos-delay="500">
                <h3 class="text-xl font-black text-slate-900 font-display mb-8 uppercase tracking-tight">Warta <span class="text-emerald-600">Lainnya.</span></h3>
                <div class="space-y-8">
                    @foreach(\App\Models\News::where('id', '!=', $news->id)->latest()->take(3)->get() as $other)
                    <a href="{{ route('news.show', $other) }}" class="flex items-center space-x-4 group">
                        <div class="w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0 bg-slate-100">
                            <img src="{{ $other->image ? asset('storage/'.$other->image) : 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2013&auto=format&fit=crop' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        </div>
                        <div>
                            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">{{ $other->category }}</span>
                            <h4 class="text-sm font-bold text-slate-900 line-clamp-2 mt-1 group-hover:text-emerald-600 transition-colors">{{ $other->title }}</h4>
                        </div>
                    </a>
                    @endforeach
                </div>
                <a href="/berita" class="w-full mt-10 py-4 bg-slate-50 rounded-2xl text-center text-sm font-bold text-slate-500 hover:bg-emerald-50 hover:text-emerald-700 transition-all border border-slate-100 block">
                    Lihat Semua Berita
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
