@extends('layouts.app')

@section('title', 'Visi & Misi Desa')

@section('content')
@php
    $term = \App\Models\SiteMeta::getVal('village_term', 'Desa');
    $villageTerm = ($term === 'Lainnya') ? \App\Models\SiteMeta::getVal('village_term_custom', 'Desa') : $term;
@endphp
<div class="bg-emerald-700 pb-20 relative overflow-hidden">
    <div class="absolute -top-10 -left-10 w-64 h-64 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
    <div class="absolute -bottom-10 -right-10 w-96 h-96 bg-emerald-800 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>

    <div class="w-full px-4 sm:px-8 lg:px-12 pt-16 relative z-10 text-center">
        <h1 class="text-4xl font-extrabold text-white tracking-tight font-display">Visi & Misi {{ $villageTerm }}</h1>
        <p class="mt-4 max-w-2xl text-xl text-emerald-100 mx-auto">
            Arah kebijakan dan cita-cita luhur pembangunan untuk mewujudkan {{ strtolower($villageTerm) }} yang mandiri dan sejahtera.
        </p>
    </div>
</div>

<div class="w-full px-4 sm:px-8 lg:px-12 -mt-10 relative z-10 pb-24">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Visi Box -->
        <div class="lg:col-span-5 bg-white rounded-[2.5rem] p-10 shadow-xl border border-emerald-50 relative overflow-hidden group" data-aos="fade-right">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-8 shadow-inner">
                    <i class="bi bi-rocket-takeoff-fill text-3xl"></i>
                </div>
                <h2 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em] mb-4">Visi Utama</h2>
                <div class="text-2xl sm:text-3xl font-bold text-slate-900 leading-tight font-display mb-6">
                    "{{ \App\Models\SiteMeta::getVal('village_vision', 'Mewujudkan '. $villageTerm .' yang Maju, Mandiri, Sejahtera, dan Berbudaya.') }}"
                </div>
                <p class="text-slate-500 italic">Membangun pondasi kokoh untuk generasi masa depan {{ strtolower($villageTerm) }} yang lebih cerah.</p>
            </div>
        </div>

        <!-- Misi Box -->
        <div class="lg:col-span-7 bg-slate-900 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden" data-aos="fade-left" data-aos-delay="200">
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-emerald-600/20 rounded-full -mb-32 -mr-32 blur-3xl"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white/10 text-emerald-400 rounded-2xl flex items-center justify-center mb-8 border border-white/10 backdrop-blur-sm">
                    <i class="bi bi-list-check text-3xl"></i>
                </div>
                <h2 class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] mb-8">Misi Strategis</h2>
                
                <div class="space-y-6">
                    @php
                        $misi = \App\Models\SiteMeta::getVal('village_mission', '');
                        $misiList = array_filter(explode("\n", str_replace("\r", "", $misi)));
                    @endphp

                    @forelse($misiList as $index => $item)
                        <div class="flex items-start group">
                            <div class="flex-shrink-0 w-10 h-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center font-black text-sm mr-4 shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition-transform">
                                {{ $index + 1 }}
                            </div>
                            <p class="text-lg text-emerald-50/90 leading-relaxed pt-1">{{ trim($item) }}</p>
                        </div>
                    @empty
                        <div class="flex items-center space-x-4 bg-white/5 p-6 rounded-2xl border border-white/10">
                            <i class="bi bi-info-circle text-emerald-400 text-2xl"></i>
                            <p class="text-emerald-100/60 text-sm">Data misi belum diinput oleh admin desa.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Content / Footer Info -->
    <div class="mt-12 text-center" data-aos="fade-up" data-aos-delay="400">
        <div class="inline-flex items-center px-6 py-3 bg-white rounded-full shadow-sm border border-slate-100">
            <span class="w-2 h-2 rounded-full bg-emerald-500 mr-3 animate-pulse"></span>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Ditetapkan melalui Musyawarah {{ $villageTerm }}</p>
        </div>
    </div>
</div>
@endsection
