@extends('layouts.app')

@php
    $term = \App\Models\SiteMeta::getVal('village_term', 'Desa');
    $villageTerm = ($term === 'Lainnya') ? \App\Models\SiteMeta::getVal('village_term_custom', 'Desa') : $term;
@endphp

@section('title', 'Berita ' . $villageTerm)

@section('content')
<!-- Header Page -->
<div class="bg-emerald-700 pb-32">
    <div class="w-full px-4 sm:px-8 lg:px-12 pt-16 text-center">
        <h1 class="text-4xl font-extrabold text-white tracking-tight font-display" data-aos="fade-down">Kabar & Warta {{ $villageTerm }}</h1>
        <p class="mt-4 max-w-2xl text-xl text-emerald-100 mx-auto" data-aos="fade-up" data-aos-delay="100">
            Informasi terbaru seputar kegiatan pemerintahan, pembangunan, dan pengumuman penting bagi warga.
        </p>
    </div>
</div>

<div class="w-full px-4 sm:px-8 lg:px-12 -mt-24 relative z-10 pb-20" x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 800)">
    
    <!-- Skeleton Loading Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" x-show="loading" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        @for($i = 0; $i < 9; $i++)
        <div class="flex flex-col bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden animate-pulse">
            <div class="flex-shrink-0 h-56 bg-slate-200"></div>
            <div class="flex-1 p-6 space-y-4">
                <div class="h-4 bg-slate-200 rounded w-1/4"></div>
                <div class="h-8 bg-slate-200 rounded w-full"></div>
                <div class="space-y-2">
                    <div class="h-4 bg-slate-200 rounded w-full"></div>
                    <div class="h-4 bg-slate-200 rounded w-5/6"></div>
                </div>
                <div class="h-10 bg-slate-100 rounded-xl w-1/2 mt-6"></div>
            </div>
        </div>
        @endfor
    </div>

    <!-- Actual Content Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" x-show="!loading" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        @foreach($news as $index => $item)
        <a href="{{ route('news.show', $item) }}" class="flex flex-col bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition duration-300 group hover:-translate-y-2">
            <div class="flex-shrink-0 h-56 relative bg-gray-100 overflow-hidden">
                @if($item->image)
                    <img class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700" src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}" loading="lazy">
                @else
                    <div class="flex items-center justify-center h-full text-gray-300 group-hover:scale-110 transition-transform duration-700">
                        <i class="bi bi-image text-5xl"></i>
                    </div>
                @endif
                <div class="absolute top-4 left-4">
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-semibold bg-white/90 backdrop-blur-md text-emerald-700 shadow-sm uppercase tracking-wider">
                        {{ $item->category }}
                    </span>
                </div>
            </div>
            <div class="flex-1 p-6 flex flex-col justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-2 font-medium">
                        <i class="bi bi-calendar3 text-emerald-500"></i>
                        <time datetime="{{ $item->created_at->format('Y-m-d') }}">{{ $item->created_at->format('d F Y') }}</time>
                    </div>
                    <div class="block mt-2">
                        <h3 class="text-xl font-bold text-gray-900 leading-tight mb-3 line-clamp-2 group-hover:text-emerald-600 transition-colors">
                            {{ $item->title }}
                        </h3>
                    </div>
                    <p class="text-sm text-gray-500 line-clamp-3 leading-relaxed">
                        {{ strip_tags($item->content) }}
                    </p>
                </div>
                <div class="mt-6 flex items-center">
                    <div class="text-emerald-600 font-bold group-hover:text-emerald-800 flex items-center transition">
                        Baca Selengkapnya
                        <i class="bi bi-arrow-right ml-2 text-sm group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    @if($news->hasPages())
    <div class="mt-16 flex justify-center" x-show="!loading" x-cloak>
        {{ $news->links() }}
    </div>
    @endif
</div>
@endsection
