@extends('layouts.app')

@php
    $term = \App\Models\SiteMeta::getVal('village_term', 'Desa');
    $villageTerm = ($term === 'Lainnya') ? \App\Models\SiteMeta::getVal('village_term_custom', 'Desa') : $term;
    $villageName = \App\Models\SiteMeta::getVal('village_name', 'Digital Sejahtera');
    
    $email = \App\Models\SiteMeta::getVal('office_email', 'pelayanan@' . strtolower($villageTerm) . '.go.id');
    $phone = \App\Models\SiteMeta::getVal('office_phone', '(021) 1234567');
    $address = \App\Models\SiteMeta::getVal('office_address', 'Jl. Raya Utama No. 1, Kecamatan Mandiri, Kabupaten Sejahtera');
    $hours = \App\Models\SiteMeta::getVal('office_hours', 'Senin - Jumat: 08:00 - 15:00');
    $mapUrl = \App\Models\SiteMeta::getVal('office_map_url');
    
    $facebook = \App\Models\SiteMeta::getVal('social_facebook');
    $instagram = \App\Models\SiteMeta::getVal('social_instagram');
    $youtube = \App\Models\SiteMeta::getVal('social_youtube');
    $tiktok = \App\Models\SiteMeta::getVal('social_tiktok');
@endphp

@section('title', 'Kontak Kami | ' . $villageTerm . ' ' . $villageName)

@section('content')
<!-- Contact Hero -->
<div class="relative bg-emerald-700 pt-32 pb-48 overflow-hidden">
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-500 rounded-full blur-[120px] opacity-20 -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-500 rounded-full blur-[120px] opacity-10 translate-y-1/2 -translate-x-1/4"></div>
    </div>
    
    <div class="w-full px-4 sm:px-8 lg:px-12 relative z-10 text-center">
        <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-emerald-100 text-xs font-black uppercase tracking-widest mb-8 animate-fade-in" data-aos="zoom-in">
            <span class="w-2 h-2 bg-emerald-400 rounded-full mr-3 animate-pulse shadow-[0_0_10px_#34d399]"></span>
            Hubungi Kami
        </div>
        <h1 class="text-4xl sm:text-6xl font-extrabold text-white font-display tracking-tight mb-6" data-aos="fade-up">
            Layanan Terpadu & <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-teal-200">Informasi.</span>
        </h1>
        <p class="max-w-2xl mx-auto text-emerald-50/80 text-lg sm:text-xl font-light leading-relaxed" data-aos="fade-up" data-aos-delay="100">
            Kami siap membantu kebutuhan administrasi dan memberikan informasi akurat seputar tata kelola pemerintahan {{ strtolower($villageTerm) }}.
        </p>
    </div>
</div>

<!-- Contact Info Grid -->
<div class="w-full px-4 sm:px-8 lg:px-12 -mt-24 relative z-20 pb-24">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Address Card -->
        <div class="bg-white rounded-[2.25rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col items-center text-center group hover:-translate-y-2 transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
            <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-500">
                <i class="bi bi-geo-alt"></i>
            </div>
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-3">Kantor {{ $villageTerm }}</h3>
            <p class="text-slate-700 font-bold leading-relaxed">{{ $address }}</p>
        </div>

        <!-- Phone Card -->
        <div class="bg-white rounded-[2.25rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col items-center text-center group hover:-translate-y-2 transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
            <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 text-2xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-500">
                <i class="bi bi-telephone"></i>
            </div>
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-3">Telepon / WA</h3>
            <p class="text-slate-700 font-bold leading-relaxed text-xl">{{ $phone }}</p>
            <a href="tel:{{ preg_replace('/[^0-9]/', '', $phone) }}" class="mt-4 text-xs font-black text-emerald-600 uppercase tracking-tighter hover:underline">Telepon Sekarang</a>
        </div>

        <!-- Email Card -->
        <div class="bg-white rounded-[2.25rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col items-center text-center group hover:-translate-y-2 transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
            <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 text-2xl mb-6 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-500">
                <i class="bi bi-envelope-at"></i>
            </div>
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-3">Email Resmi</h3>
            <p class="text-slate-700 font-bold leading-relaxed break-all">{{ $email }}</p>
        </div>

        <!-- Hours Card -->
        <div class="bg-white rounded-[2.25rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col items-center text-center group hover:-translate-y-2 transition-all duration-300" data-aos="fade-up" data-aos-delay="500">
            <div class="w-16 h-16 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 text-2xl mb-6 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-500">
                <i class="bi bi-clock"></i>
            </div>
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-3">Jam Layanan</h3>
            <p class="text-slate-700 font-bold leading-relaxed">{{ $hours }}</p>
        </div>
    </div>

    <!-- Map & Social Section -->
    <div class="mt-16 grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Follow Us -->
        <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden flex flex-col justify-between" data-aos="fade-left">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-emerald-500 rounded-full blur-[100px] opacity-20"></div>
            
            <div>
                <h3 class="text-3xl font-black font-display mb-6 tracking-tight">Koneksi <span class="text-emerald-400">Digital.</span></h3>
                <p class="text-slate-400 text-base leading-relaxed mb-10">
                    Ikuti perkembangan terbaru dan kegiatan pemerintah {{ strtolower($villageTerm) }} melalui kanal media sosial resmi kami.
                </p>
                
                <div class="grid grid-cols-2 gap-4">
                    @if($facebook)
                    <a href="{{ $facebook }}" target="_blank" class="p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 hover:border-emerald-500/50 transition-all group flex items-center space-x-3">
                        <i class="bi bi-facebook text-2xl text-blue-400"></i>
                        <span class="text-sm font-bold">Facebook</span>
                    </a>
                    @endif
                    @if($instagram)
                    <a href="{{ $instagram }}" target="_blank" class="p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 hover:border-emerald-500/50 transition-all group flex items-center space-x-3">
                        <i class="bi bi-instagram text-2xl text-pink-400 transition-transform group-hover:rotate-12"></i>
                        <span class="text-sm font-bold">Instagram</span>
                    </a>
                    @endif
                    @if($youtube)
                    <a href="{{ $youtube }}" target="_blank" class="p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 hover:border-emerald-500/50 transition-all group flex items-center space-x-3">
                        <i class="bi bi-youtube text-2xl text-red-500"></i>
                        <span class="text-sm font-bold">YouTube</span>
                    </a>
                    @endif
                    @if($tiktok)
                    <a href="{{ $tiktok }}" target="_blank" class="p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 hover:border-emerald-500/50 transition-all group flex items-center space-x-3">
                        <i class="bi bi-tiktok text-2xl text-white"></i>
                        <span class="text-sm font-bold">TikTok</span>
                    </a>
                    @endif
                </div>
            </div>

            <div class="mt-12 p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-3xl backdrop-blur-sm">
                <p class="text-xs font-black text-emerald-400 uppercase tracking-widest mb-2">Suara Warga</p>
                <p class="text-sm text-emerald-50/80 leading-relaxed italic">
                    "Transparansi adalah kunci pembangunan desa yang berkelanjutan."
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
