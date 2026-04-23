@extends('layouts.app')

@php
    $term = \App\Models\SiteMeta::getVal('village_term', 'Desa');
    $villageTerm = ($term === 'Lainnya') ? \App\Models\SiteMeta::getVal('village_term_custom', 'Desa') : $term;
@endphp

@section('title', 'Pasar ' . $villageTerm)

@section('content')
<div class="bg-gray-50 pb-20" x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 800)">
    <div class="bg-emerald-700 py-16 relative overflow-hidden">
        <!-- Glass decoration -->
        <div class="absolute -top-10 -right-10 w-64 h-64 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
        <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-emerald-800 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
        
        <div class="w-full px-4 sm:px-8 lg:px-12 relative z-10 text-center">
            <h1 class="text-4xl font-extrabold text-white tracking-tight font-display mb-4" data-aos="fade-down">Lapak Warga {{ $villageTerm }}</h1>
            <p class="text-xl text-emerald-100 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                Pusat ekonomi kreatif warga. Beli produk lokal berkualitas langsung dari WhatsApp penjual tanpa perantara!
            </p>
        </div>
    </div>

    <div class="w-full px-4 sm:px-8 lg:px-12 mt-12">
        <!-- Skeleton Loading Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8" x-show="loading" x-transition:leave="transition ease-in duration-300">
            @for($i = 0; $i < 8; $i++)
            <div class="bg-white rounded-[2rem] shadow-lg border border-gray-100 overflow-hidden animate-pulse">
                <div class="aspect-[4/3] bg-slate-200"></div>
                <div class="p-5 space-y-4">
                    <div class="h-6 bg-slate-200 rounded w-3/4"></div>
                    <div class="h-4 bg-slate-200 rounded w-1/2"></div>
                    <div class="h-10 bg-slate-100 rounded-xl w-full mt-4"></div>
                </div>
            </div>
            @endfor
        </div>

        <!-- Actual Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8" x-show="!loading" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            @forelse($products as $index => $product)
            <div class="bg-white rounded-[2rem] shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col group relative border border-gray-100">
                <!-- Ratio 4:3 with Auto Crop (object-cover) -->
                <div class="aspect-[4/3] relative overflow-hidden bg-emerald-50">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                             alt="{{ $product->name }}"
                             loading="lazy">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-emerald-200 border-2 border-dashed border-emerald-100/50 m-2 rounded-2xl">
                            <i class="bi bi-shop text-4xl mb-2"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest">No Image</span>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-xl border border-emerald-100">
                        <p class="text-emerald-700 font-black text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1 leading-tight group-hover:text-emerald-600 transition-colors">{{ $product->name }}</h3>
                        <div class="flex items-center text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <i class="bi bi-person-circle mr-2 text-emerald-500"></i> {{ $product->seller_name }}
                        </div>
                    </div>
                    
                    <p class="text-xs text-gray-500 line-clamp-2 mb-6 leading-relaxed flex-1">
                        {{ $product->description ?: 'Tidak ada deskripsi produk.' }}
                    </p>

                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->phone) }}?text=Halo%20{{ urlencode($product->seller_name) }},%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->name) }}%20(Rp%20{{ number_format($product->price,0,',','.') }})%20yang%20dijual%20di%20Website%20Lapak%20{{ urlencode($villageTerm) }}." 
                       target="_blank"
                       class="w-full flex items-center justify-center space-x-3 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-bold transition-all shadow-xl shadow-emerald-100 group-hover:shadow-emerald-200 group-hover:-translate-y-1">
                        <i class="bi bi-whatsapp text-lg"></i>
                        <span>Pesan via WA</span>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-24 text-center bg-white rounded-[3rem] border border-dashed border-gray-200">
                <i class="bi bi-basket text-6xl text-gray-200 mb-4 block"></i>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Lapak Masih Kosong</h3>
                <p class="text-gray-500">Belum ada produk warga yang dipajang di etalase.</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-16 flex justify-center" x-show="!loading" x-cloak>
            @if(method_exists($products, 'links'))
                {{ $products->links() }}
            @endif
        </div>
        
        <!-- Registration Banner -->
        <div class="mt-24 bg-slate-900 rounded-[3rem] p-10 md:p-16 text-white shadow-2xl relative overflow-hidden" data-aos="zoom-in" data-aos-offset="-100">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-emerald-500 rounded-full blur-[120px] opacity-20"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between text-center md:text-left">
                <div class="mb-8 md:mb-0 md:mr-10 max-w-2xl">
                    <h2 class="text-3xl sm:text-4xl font-extrabold mb-4 font-display">Ingin Jualan di Lapak Desa?</h2>
                    <p class="text-slate-400 text-lg leading-relaxed">Punya produk unggulan? Daftarkan usaha Anda sekarang untuk menjangkau pasar yang lebih luas secara gratis!</p>
                </div>
                <a href="/login" class="bg-emerald-500 hover:bg-emerald-600 text-white px-10 py-5 rounded-2xl font-black text-lg transition-all shadow-2xl shadow-emerald-900/50 hover:scale-105 whitespace-nowrap">
                    Buka Lapak Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
