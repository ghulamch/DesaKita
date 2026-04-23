@extends('layouts.app')

@php
    $term = \App\Models\SiteMeta::getVal('village_term', 'Desa');
    $villageTerm = ($term === 'Lainnya') ? \App\Models\SiteMeta::getVal('village_term_custom', 'Desa') : $term;
@endphp

@section('title', 'Sejarah ' . $villageTerm)

@section('content')
<div class="bg-emerald-700 pb-20 relative overflow-hidden">
    <div class="absolute inset-0 z-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
    
    <div class="w-full px-4 sm:px-8 lg:px-12 pt-16 relative z-10 text-center">
        <h1 class="text-4xl font-extrabold text-white tracking-tight font-display uppercase tracking-[0.1em]">Asal Usul & Sejarah</h1>
        <div class="mt-4 flex items-center justify-center space-x-4">
            <div class="h-[1px] w-12 bg-emerald-400"></div>
            <p class="text-emerald-100 font-bold uppercase tracking-widest text-xs">Menapak Jejak Warisan Leluhur</p>
            <div class="h-[1px] w-12 bg-emerald-400"></div>
        </div>
    </div>
</div>

<div class="w-full px-4 sm:px-8 lg:px-12 -mt-10 relative z-10 pb-24">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-[3rem] shadow-2xl shadow-emerald-900/10 border border-emerald-50 overflow-hidden" data-aos="fade-up">
            <!-- Header Image / Decoration -->
            <div class="h-48 bg-gradient-to-br from-emerald-50 to-teal-50 relative flex items-center justify-center overflow-hidden">
                <i class="bi bi-bank2 text-[10rem] text-emerald-100 absolute -bottom-10 rotate-12"></i>
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-20 h-20 bg-white rounded-3xl shadow-xl flex items-center justify-center text-emerald-600 mb-4 border border-emerald-50 transform -rotate-3 hover:rotate-0 transition-transform">
                        <i class="bi bi-clock-history text-4xl"></i>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-8 md:p-20">
                @php
                    $history = \App\Models\SiteMeta::getVal('village_history', '');
                @endphp

                @if($history)
                    <div class="prose prose-emerald prose-xl max-w-none text-slate-600 leading-relaxed font-light first-letter:text-7xl first-letter:font-black first-letter:text-emerald-600 first-letter:mr-4 first-letter:float-left">
                        {!! nl2br(e($history)) !!}
                    </div>
                @else
                    <div class="text-center py-20">
                        <div class="w-24 h-24 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-8 animate-pulse">
                            <i class="bi bi-journal-text text-5xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-2">Narasi Sejarah Sedang Disusun</h3>
                        <p class="text-slate-500 max-w-md mx-auto">Informasi mengenai sejarah dan asal-usul {{ strtolower($villageTerm) }} saat ini sedang dalam tahap pendokumentasian oleh tim admin.</p>
                        
                        <div class="mt-10 flex justify-center space-x-4">
                            <div class="w-2 h-2 rounded-full bg-emerald-200"></div>
                            <div class="w-2 h-2 rounded-full bg-emerald-300"></div>
                            <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer Quote/Info -->
            <div class="bg-slate-50 p-10 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-emerald-500 border border-slate-100">
                        <i class="bi bi-quote text-2xl"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest leading-tight">
                        "Bangsa yang besar adalah bangsa yang <br> mengenal sejarahnya."
                    </p>
                </div>
                <div class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] bg-emerald-50 px-4 py-2 rounded-lg border border-emerald-100">
                    Arsip Digital {{ $villageTerm }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
