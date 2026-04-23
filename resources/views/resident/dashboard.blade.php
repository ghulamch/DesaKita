@extends('layouts.resident')

@section('content')
<div class="p-0 md:p-4">
<div class="px-4 py-8 md:px-0 md:py-4">
    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h1>
    <p class="text-slate-500 font-medium mt-1">Selamat datang di Dasbor Warga {{ $villageTerm }}. Kelola dagangan Anda di sini.</p>
</div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Stats Card: Products -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-200 group transition-all hover:-translate-y-2">
            <div class="flex items-center justify-between mb-8">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-500 group-hover:text-white transition-all">
                    <i class="bi bi-box-seam"></i>
                </div>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-100 italic">Live on Market</span>
            </div>
            <h3 class="text-4xl font-black text-slate-900 leading-none mb-2">{{ $productCount }}</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Produk Saya</p>
            
            <a href="{{ route('resident.products.index') }}" class="mt-8 flex items-center text-sm font-bold text-emerald-600 hover:text-emerald-700 transition">
                Kelola Dagangan <i class="bi bi-arrow-right ml-2"></i>
            </a>
        </div>

        <!-- Quick Action: Add Product -->
        <a href="{{ route('resident.products.create') }}" class="bg-emerald-600 rounded-[2.5rem] p-8 shadow-xl shadow-emerald-600/20 text-white group hover:scale-[1.02] transition-all flex flex-col justify-between">
            <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center text-2xl mb-8">
                <i class="bi bi-plus-lg"></i>
            </div>
            <div>
                <h3 class="text-xl font-black mb-2">Pasarkan Produk Baru</h3>
                <p class="text-emerald-100 text-sm font-medium opacity-80 leading-relaxed mb-6">Mulai jualan di Marketplace {{ $villageTerm }} hari ini.</p>
                <div class="flex items-center text-sm font-black uppercase tracking-widest">
                    Mulai Sekarang <i class="bi bi-chevron-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </div>
        </a>

        <!-- Info Card: Tips -->
        <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden">
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center text-2xl text-emerald-400 mb-8">
                    <i class="bi bi-lightning-charge"></i>
                </div>
                <h3 class="text-xl font-black mb-4 tracking-tight">Tips Jualan</h3>
                <ul class="space-y-3 text-xs text-slate-400 font-medium">
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check2-circle text-emerald-500 mt-0.5"></i>
                        <span>Gunakan foto produk yang jelas dan menarik.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check2-circle text-emerald-500 mt-0.5"></i>
                        <span>Pastikan nomor WhatsApp aktif untuk pembeli.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check2-circle text-emerald-500 mt-0.5"></i>
                        <span>Tentukan harga yang kompetitif.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
