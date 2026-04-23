@extends(Auth::user()->isAparatur() ? 'layouts.apparatus' : 'layouts.admin')

@section('title', 'Beranda Utama')

@section('content')
<div class="space-y-10">
    <!-- Sophisticated Greeting Card -->
    <div class="relative bg-white rounded-[2.5rem] md:rounded-[3rem] px-6 py-10 md:p-14 shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden" data-aos="fade-down">
        <!-- Decoration Orbs -->
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-80 h-80 bg-emerald-500/5 rounded-full blur-[80px]"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-80 h-80 bg-blue-500/5 rounded-full blur-[80px]"></div>

        <div class="relative z-10">
            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-[10px] font-black tracking-widest uppercase mb-6">
                <span class="w-2 h-2 rounded-full bg-emerald-500 mr-3 animate-pulse"></span>
                System Core Active
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 font-display leading-tight mb-4">
                Sapaan Hangat, <span class="text-emerald-600">{{ Auth::user()->name }}</span>.
            </h1>
            <p class="text-slate-500 text-lg max-w-2xl font-medium">
                Sistem Informasi Desa siap melayani. Pantau statistik dan kelola data publik dengan efisiensi tinggi melalui panel kontrol terpadu.
            </p>
        </div>
    </div>

    <!-- Stats Overview Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
        <!-- News Stat -->
        <div class="bg-white rounded-[2.5rem] p-6 shadow-xl shadow-slate-200/40 border border-slate-100 group hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="100">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 shadow-inner group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500">
                    <i class="bi bi-newspaper text-xl"></i>
                </div>
                <span class="text-[9px] font-black text-emerald-500 bg-emerald-50 px-2.5 py-1 rounded-full uppercase tracking-widest">Warta</span>
            </div>
            <h3 class="text-3xl font-black text-slate-900 font-display mb-1 tracking-tighter">{{ $newsCount }}</h3>
            <p class="text-slate-500 text-[9px] font-black uppercase tracking-widest">Artikel Publik</p>
        </div>

        <!-- Apparatus Stat -->
        <div class="bg-white rounded-[2.5rem] p-6 shadow-xl shadow-slate-200/40 border border-slate-100 group hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="200">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shadow-inner group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                    <i class="bi bi-people text-xl"></i>
                </div>
                <span class="text-[9px] font-black text-blue-500 bg-blue-50 px-2.5 py-1 rounded-full uppercase tracking-widest">Staf</span>
            </div>
            <h3 class="text-3xl font-black text-slate-900 font-display mb-1 tracking-tighter">{{ $apparatusCount }}</h3>
            <p class="text-slate-500 text-[9px] font-black uppercase tracking-widest">Aparatur Desa</p>
        </div>

        @if(Auth::user()->isAdmin())
        <!-- Pagu Stat -->
        <div class="bg-white rounded-[2.5rem] p-6 shadow-xl shadow-slate-200/40 border border-slate-100 group hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="300">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 shadow-inner group-hover:bg-amber-600 group-hover:text-white transition-all duration-500">
                    <i class="bi bi-bank"></i>
                </div>
                <span class="text-[9px] font-black text-amber-500 bg-amber-50 px-2.5 py-1 rounded-full uppercase tracking-widest">Pagu</span>
            </div>
            <h3 class="text-xl font-black text-slate-900 font-display mb-1 tracking-tighter">Rp {{ number_format($totalPagu, 0, ',', '.') }}</h3>
            <p class="text-slate-500 text-[9px] font-black uppercase tracking-widest">Total Anggaran {{ $targetYear }}</p>
        </div>

        <!-- Penyaluran Stat -->
        <div class="bg-white rounded-[2.5rem] p-6 shadow-xl shadow-slate-200/40 border border-slate-100 group hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="400">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                    <i class="bi bi-wallet2"></i>
                </div>
                <span class="text-[9px] font-black text-indigo-500 bg-indigo-50 px-2.5 py-1 rounded-full uppercase tracking-widest">Cair</span>
            </div>
            <h3 class="text-xl font-black text-slate-900 font-display mb-1 tracking-tighter">Rp {{ number_format($totalDisbursed, 0, ',', '.') }}</h3>
            <p class="text-slate-500 text-[9px] font-black uppercase tracking-widest">Dana Tersalurkan (Pusat)</p>
        </div>

        <!-- Realisasi Stat -->
        <div class="bg-slate-900 rounded-[2.5rem] p-6 shadow-xl shadow-slate-900/20 border border-slate-800 group hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="500">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-400 shadow-inner group-hover:bg-emerald-500 group-hover:text-white transition-all duration-500">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <span class="text-[9px] font-black text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-full uppercase tracking-widest">Belanja</span>
            </div>
            <h3 class="text-xl font-black text-white font-display mb-1 tracking-tighter">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h3>
            <p class="text-slate-500 text-[9px] font-black uppercase tracking-widest">Serapan Lapangan (Kegiatan)</p>
        </div>
        @endif

        <!-- Marketplace Stat -->
        <div class="bg-white rounded-[2.5rem] p-6 shadow-xl shadow-slate-200/40 border border-slate-100 group hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="600">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 shadow-inner group-hover:bg-purple-600 group-hover:text-white transition-all duration-500">
                    <i class="bi bi-shop text-xl"></i>
                </div>
                <span class="text-[9px] font-black text-purple-500 bg-purple-50 px-2.5 py-1 rounded-full uppercase tracking-widest">UMKM</span>
            </div>
            <h3 class="text-3xl font-black text-slate-900 font-display mb-1 tracking-tighter">{{ $productCount }}</h3>
            <p class="text-slate-500 text-[9px] font-black uppercase tracking-widest">Produk Lokal</p>
        </div>
    </div>

    <!-- Quick Navigation Hub -->
    <div class="bg-white rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-14 shadow-2xl shadow-slate-200/30 border border-slate-100" data-aos="zoom-in">
        <div class="flex items-center justify-between mb-12 pb-8 border-b border-slate-50">
            <div>
                <h2 class="text-3xl font-black text-slate-900 font-display mb-2 uppercase">Navigasi <span class="text-emerald-600">Utama.</span></h2>
                <p class="text-slate-500 font-medium">Akses cepat ke seluruh fitur pengelolaan sistem digital.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Shared Action: Berita -->
            <a href="{{ route('admin.news.index') }}" class="group relative overflow-hidden bg-slate-50 rounded-3xl p-6 md:p-10 transition-all hover:bg-emerald-600 shadow-sm hover:shadow-2xl hover:shadow-emerald-200 border border-slate-100">
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center text-emerald-600 mb-8 group-hover:scale-110 transition-transform duration-500">
                        <i class="bi bi-pencil-square text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-black text-slate-900 mb-3 group-hover:text-white transition-colors">Warta Utama</h4>
                    <p class="text-slate-500 text-sm font-medium group-hover:text-emerald-50 transition-colors leading-relaxed">Publikasi warta dan kegiatan terbaru {{ strtolower($villageTerm) }}.</p>
                </div>
                <i class="bi bi-arrow-right-short absolute bottom-6 right-8 text-5xl text-slate-200 group-hover:text-emerald-300 group-hover:translate-x-2 transition-all"></i>
            </a>

            <!-- Shared Action: Agenda -->
            <a href="{{ route('agendas.index') }}" class="group relative overflow-hidden bg-slate-50 rounded-3xl p-6 md:p-10 transition-all hover:bg-amber-600 shadow-sm hover:shadow-2xl hover:shadow-amber-200 border border-slate-100">
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center text-amber-600 mb-8 group-hover:scale-110 transition-transform duration-500">
                        <i class="bi bi-calendar-check text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-black text-slate-900 mb-3 group-hover:text-white transition-colors">Agenda {{ $villageTerm }}</h4>
                    <p class="text-slate-500 text-sm font-medium group-hover:text-amber-50 transition-colors leading-relaxed">Kelola jadwal kegiatan dan rapat warga.</p>
                </div>
                <i class="bi bi-arrow-right-short absolute bottom-6 right-8 text-5xl text-slate-200 group-hover:text-amber-300 group-hover:translate-x-2 transition-all"></i>
            </a>

            <!-- Shared Action: Moderasi Lapak -->
            <a href="{{ route('admin.marketplace.index') }}" class="group relative overflow-hidden bg-slate-50 rounded-3xl p-6 md:p-10 transition-all hover:bg-purple-600 shadow-sm hover:shadow-2xl hover:shadow-purple-200 border border-slate-100">
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center text-purple-600 mb-8 group-hover:scale-110 transition-transform duration-500">
                        <i class="bi bi-shop text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-black text-slate-900 mb-3 group-hover:text-white transition-colors">Moderasi Lapak</h4>
                    <p class="text-slate-500 text-sm font-medium group-hover:text-purple-50 transition-colors leading-relaxed">Pantau ketaatan dagangan warga di pasar digital.</p>
                </div>
                <i class="bi bi-arrow-right-short absolute bottom-6 right-8 text-5xl text-slate-200 group-hover:text-purple-300 group-hover:translate-x-2 transition-all"></i>
            </a>

            @if(Auth::user()->isAdmin())
            <!-- Admin Only: Transparency -->
            <a href="{{ route('admin.transparency.index') }}" class="group relative overflow-hidden bg-slate-50 rounded-3xl p-6 md:p-10 transition-all hover:bg-slate-900 shadow-sm hover:shadow-2xl hover:shadow-slate-300 border border-slate-100 uppercase-no">
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center text-slate-900 mb-8 group-hover:scale-110 transition-transform duration-500">
                        <i class="bi bi-cash-stack text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-black text-slate-900 mb-3 group-hover:text-white transition-colors">Keuangan</h4>
                    <p class="text-slate-500 text-sm font-medium group-hover:text-slate-400 transition-colors leading-relaxed">Kelola APBDes &inkronisasi Realisasi.</p>
                </div>
                <i class="bi bi-arrow-right-short absolute bottom-6 right-8 text-5xl text-slate-200 group-hover:text-slate-500 group-hover:translate-x-2 transition-all"></i>
            </a>
            @endif
        </div>
    </div>
</div>
@endsection
