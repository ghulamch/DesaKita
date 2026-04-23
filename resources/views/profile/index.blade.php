@extends('layouts.app')

@section('title', 'Profil Desa')

@section('content')
<div class="bg-emerald-700 pb-20 relative overflow-hidden">
    <div class="absolute -top-10 -left-10 w-64 h-64 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
    <div class="absolute -bottom-10 -right-10 w-96 h-96 bg-emerald-800 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>

    <div class="w-full px-4 sm:px-8 lg:px-12 pt-16 relative z-10 text-center">
        <h1 class="text-4xl font-extrabold text-white tracking-tight font-display">Profil Pemerintahan Desa</h1>
        <p class="mt-4 max-w-2xl text-xl text-emerald-100 mx-auto">
            Berkenalan lebih dekat dengan desa, sejarah kami, visi & misi pengabdian, serta struktur tata kelola.
        </p>
    </div>
</div>

<div class="w-full px-4 sm:px-8 lg:px-12 -mt-10 relative z-10 pb-20">
    <div class="bg-white/90 backdrop-blur-xl border border-white/40 shadow-xl rounded-3xl overflow-hidden flex flex-col md:flex-row" data-aos="fade-up">
        <!-- Foto Kades / Sambutan Pimpinan -->
        <div class="md:w-1/3 bg-gray-50 relative overflow-hidden flex flex-col items-center justify-center p-10 border-r border-gray-100">
            <!-- Pola hiasan -->
            <div class="absolute inset-0 z-0 opacity-20" style="background-image: radial-gradient(#10b981 1px, transparent 1px); background-size: 20px 20px;"></div>
            
            <div class="w-48 h-56 bg-white rounded-xl shadow-lg border-4 border-white overflow-hidden relative z-10 mb-6 transform rotate-2 hover:rotate-0 transition-transform duration-500" data-aos="zoom-in" data-aos-delay="300">
                <img src="{{ \App\Models\SiteMeta::getVal('kades_photo', 'https://i.pravatar.cc/300?u=kades') }}" class="w-full h-full object-cover" alt="Kepala Desa">
            </div>
            
            <div class="relative z-10 text-center">
                <h3 class="text-2xl font-bold text-gray-900 font-display">{{ \App\Models\SiteMeta::getVal('kades_name', 'Budi Santoso, S.T.') }}</h3>
                <p class="text-emerald-600 font-medium tracking-wide uppercase text-sm mt-1">Kepala Desa</p>
            </div>
        </div>

        <!-- Teks Sambutan Kades -->
        <div class="md:w-2/3 p-10 md:p-16 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 font-display border-b pb-4 border-emerald-100">Sambutan Kepala Desa</h2>
            <div class="prose prose-emerald max-w-none text-gray-600 text-lg leading-relaxed space-y-4">
                {!! \App\Models\SiteMeta::getVal('kades_greeting', '<p>Assalamu\'alaikum Warahmatullahi Wabarakatuh,</p><p>Selamat datang di portal resmi Pemerintahan Desa. Melalui media digital ini, kami berupaya mewujudkan transparansi tata kelola yang terpercaya serta pelayanan publik yang cepat untuk seluruh warga masyarakat.</p><p>Mari bahu-membahu membangun desa menuju kemandirian ekonomi dan penguatan sumber daya manusia melalui pemanfaatan teknologi.</p><p>Wassalamu\'alaikum Warahmatullahi Wabarakatuh.</p>') !!}
            </div>
        </div>
    </div>
    
    @php
        $vision = \App\Models\SiteMeta::getVal('village_vision');
        $mission = \App\Models\SiteMeta::getVal('village_mission');
    @endphp

    @if($vision || $mission)
    <div class="grid grid-cols-1 {{ $vision && $mission ? 'md:grid-cols-2' : '' }} gap-8 mt-12">
        <!-- Visi Desa -->
        @if($vision)
        <div class="bg-white/80 backdrop-blur-xl border border-white/50 rounded-3xl p-10 shadow-lg hover:-translate-y-2 transition-transform duration-300" data-aos="fade-right">
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                <i class="bi bi-eye text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4 font-display">Visi</h2>
            <div class="text-gray-600 text-lg leading-relaxed italic border-l-4 border-blue-500 pl-4 py-2 uppercase">
                "{{ $vision }}"
            </div>
        </div>
        @endif
        
        <!-- Misi Desa -->
        @if($mission)
        <div class="bg-white/80 backdrop-blur-xl border border-white/50 rounded-3xl p-10 shadow-lg hover:-translate-y-2 transition-transform duration-300" data-aos="fade-left" data-aos-delay="200">
            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                <i class="bi bi-bullseye text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4 font-display">Misi</h2>
            <div class="prose prose-emerald text-gray-600">
                {!! $mission !!}
            </div>
        </div>
        @endif
    </div>
    @endif
</div>
@endsection
