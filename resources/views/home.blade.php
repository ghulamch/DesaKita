@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- 1. Hero Section -->
<section class="relative h-screen min-h-[700px] flex items-center justify-center overflow-hidden bg-gray-900 border-b-8 border-emerald-500">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        @php
            $heroImg = \App\Models\SiteMeta::getVal('site_hero_image');
        @endphp
        <img src="{{ $heroImg ? (Str::startsWith($heroImg, 'http') ? $heroImg : asset('storage/'.$heroImg)) : 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2013&auto=format&fit=crop' }}" class="w-full h-full object-cover opacity-60 transform scale-105" alt="Pemandangan Desa" style="animation: pulse-slow 15s infinite alternate;" loading="eager">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-emerald-900/60 to-gray-900/30"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 w-full px-4 sm:px-8 lg:px-12 flex flex-col mx-auto max-w-[1600px] lg:flex-row items-center justify-between text-center lg:text-left pt-20">
        <div class="w-full max-w-4xl" data-aos="fade-up" data-aos-duration="1000">
            <div class="inline-flex items-center px-4 py-2 sm:px-5 sm:py-2.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-emerald-300 text-[10px] sm:text-sm font-black tracking-widest uppercase mb-6 sm:mb-8 shadow-2xl hover:scale-105 transition-transform hover:bg-white/20 cursor-default" data-aos="zoom-in" data-aos-delay="200">
                <span class="flex w-2 h-2 sm:w-3 sm:h-3 rounded-full bg-emerald-400 mr-2 sm:mr-3 shadow-[0_0_10px_#34d399] animate-ping"></span>
                Portal Resmi Terpadu
            </div>
            
            @php
                $term = \App\Models\SiteMeta::getVal('village_term', 'Desa');
                $displayTerm = ($term === 'Lainnya') ? \App\Models\SiteMeta::getVal('village_term_custom', 'Desa') : $term;
            @endphp
            <h1 class="text-3xl sm:text-6xl md:text-7xl lg:text-[5.5rem] font-extrabold text-white font-display leading-[1.1] mb-6 drop-shadow-2xl break-words" data-aos="fade-right" data-aos-delay="400">
                PEMERINTAH {{ strtoupper($displayTerm) }}<br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-teal-500 uppercase">
                    {{ \App\Models\SiteMeta::getVal('village_name', 'Digital Sejahtera') }}
                </span>
            </h1>
            
            <p class="mt-6 text-base sm:text-lg md:text-2xl text-emerald-50/90 font-light max-w-3xl mx-auto lg:mx-0 mb-12 drop-shadow" data-aos="fade-right" data-aos-delay="500">
                Pusat transparansi pemerintahan, kemudahan pelayanan administrasi, dan etalase digital pemberdayaan ekonomi warga.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 sm:gap-5" data-aos="fade-up" data-aos-delay="700">
                <a href="#warta" class="w-full sm:w-auto px-5 py-3 sm:px-10 sm:py-5 bg-gradient-to-r from-emerald-500 to-emerald-700 text-white font-bold rounded-2xl shadow-[0_0_30px_rgba(16,185,129,0.4)] hover:shadow-[0_0_40px_rgba(16,185,129,0.6)] hover:-translate-y-1 hover:scale-105 transition-all text-sm sm:text-lg flex items-center justify-center group">
                    <i class="bi bi-rocket-takeoff mr-2 sm:mr-3 text-lg sm:text-xl group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform"></i> Mulai Jelajah
                </a>
                <a href="/transparansi" class="w-full sm:w-auto px-5 py-3 sm:px-10 sm:py-5 bg-white/10 backdrop-blur-md text-white font-bold rounded-2xl border border-white/30 hover:bg-white/20 hover:-translate-y-1 transition-all text-sm sm:text-lg flex items-center justify-center group shadow-xl">
                    <i class="bi bi-wallet2 mr-2 sm:mr-3 text-lg sm:text-xl group-hover:rotate-12 transition-transform"></i> Info Anggaran
                </a>
            </div>
        </div>
        
        <!-- Interactive Floating Card -->
        <div class="hidden lg:block relative mt-16 lg:mt-0 xl:mr-16" data-aos="fade-left" data-aos-delay="900" data-aos-duration="1200">
            <div class="p-8 rounded-[2rem] border border-white/20 shadow-[-20px_20px_60px_rgba(0,0,0,0.5)] bg-slate-900/40 backdrop-blur-xl max-w-sm transform hover:-translate-y-4 hover:scale-105 transition-all duration-500 group relative z-20">
                <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-full blur-2xl opacity-70 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="flex items-center space-x-5 mb-6 relative z-10">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-400 to-blue-600 flex items-center justify-center text-white text-3xl shadow-[0_10px_20px_rgba(0,0,0,0.3)] group-hover:rotate-[15deg] group-hover:scale-110 transition-transform duration-500">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div>
                        <p class="text-emerald-300 text-xs font-black uppercase tracking-widest mb-1">Transparansi Dana</p>
                        <p class="text-white font-extrabold text-2xl font-display">Anggaran {{ date('Y') }}</p>
                    </div>
                </div>
                <a href="/transparansi" class="block text-center w-full py-4 bg-white/20 hover:bg-white/40 text-white rounded-xl font-bold transition-all relative z-10 border border-white/10 group-hover:border-white/30">
                    Lihat Laporan <i class="bi bi-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 2. Sambutan Kepala Desa -->
<section class="py-24 bg-white overflow-hidden relative">
    <div class="absolute top-0 left-0 w-full h-full opacity-5 pointer-events-none" style="background-image: radial-gradient(#10b981 1px, transparent 1px); background-size: 40px 40px;"></div>
    <div class="w-full px-4 sm:px-8 lg:px-12 relative z-10">
        <div class="max-w-[1400px] mx-auto">
            <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-24">
                <div class="w-full lg:w-2/5" data-aos="fade-right">
                    <div class="relative">
                        <div class="absolute -top-6 -left-6 w-full h-full border-2 border-emerald-100 rounded-[3rem] -z-10 translate-x-4 translate-y-4"></div>
                        <div class="rounded-[2.5rem] overflow-hidden shadow-2xl aspect-[4/5] border-8 border-white bg-slate-100">
                            @php $kadesPhoto = \App\Models\SiteMeta::getVal('kades_photo'); @endphp
                            <img src="{{ $kadesPhoto ? (Str::startsWith($kadesPhoto, 'http') ? $kadesPhoto : asset('storage/'.$kadesPhoto)) : 'https://ui-avatars.com/api/?name=Kepala+Desa&background=10b981&color=fff&size=512' }}" class="w-full h-full object-cover" alt="Kepala Desa" loading="lazy">
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-3/5" data-aos="fade-left">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-emerald-50 text-emerald-700 text-xs font-black uppercase tracking-widest mb-6">Profil Pimpinan {{ $displayTerm }}</div>
                    <h2 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 font-display leading-tight mb-8">Sambutan Resmi<br/>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500 italic">Kepala {{ $displayTerm }} {{ Str::title(\App\Models\SiteMeta::getVal('village_name', 'Digital')) }}</span>
                    </h2>
                    <div class="space-y-6 text-sm sm:text-lg text-gray-600 leading-relaxed font-light">{!! nl2br(e(\App\Models\SiteMeta::getVal('kades_greeting', 'Selamat datang...'))) !!}</div>
                    <div class="mt-12 pt-8 border-t border-gray-100">
                        <p class="text-xl sm:text-2xl font-black text-gray-900 font-display tracking-tight uppercase">{{ \App\Models\SiteMeta::getVal('kades_name', 'Nama Kepala Desa') }}</p>
                        <p class="text-emerald-600 font-bold tracking-widest uppercase text-xs mt-1">Kepala {{ $displayTerm }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. Statistik Penduduk -->
<section class="py-16 bg-gray-50 border-t border-gray-100" x-data="{ 
    stats: [
        { label: 'Total Populasi', value: {{ (float)str_replace(',', '.', \App\Models\SiteMeta::getVal('total_population', 0)) }}, current: 0, icon: 'bi-people-fill', color: 'blue', unit: '', decimals: 0 },
        { label: 'Luas Wilayah', value: {{ (float)str_replace(',', '.', \App\Models\SiteMeta::getVal('village_area', 0)) }}, current: 0, icon: 'bi-map-fill', color: 'emerald', unit: 'Ha', decimals: 2 },
        { label: 'Keluarga (KK)', value: {{ (float)str_replace(',', '.', \App\Models\SiteMeta::getVal('total_families', 0)) }}, current: 0, icon: 'bi-house-door-fill', color: 'amber', unit: '', decimals: 0 },
        { label: 'RT / RW', value: '{{ \App\Models\SiteMeta::getVal('total_rt_rw') ?: '00/00' }}', current: '00/00', icon: 'bi-geo-alt-fill', color: 'purple', unit: '', isSplit: true }
    ],
    animate() {
        this.stats.forEach(s => {
            let duration = 2000;
            let startTime = null;

            if(s.isSplit) {
                let parts = s.value.split('/');
                let end1 = parseInt(parts[0]) || 0;
                let end2 = parseInt(parts[1]) || 0;
                const stepSplit = (timestamp) => {
                    if(!startTime) startTime = timestamp;
                    const progress = Math.min((timestamp - startTime) / duration, 1);
                    
                    // RT starts immediately
                    let c1 = Math.floor(progress * end1);
                    
                    // RW starts after 30% of individual progress
                    let progress2 = Math.max(0, (progress - 0.3) / 0.7);
                    let c2 = Math.floor(progress2 * end2);
                    
                    s.current = (c1 < 10 ? '0'+c1 : c1) + '/' + (c2 < 10 ? '0'+c2 : c2);
                    if(progress < 1) window.requestAnimationFrame(stepSplit);
                };
                window.requestAnimationFrame(stepSplit);
            } else {
                let end = s.value;
                const stepNormal = (timestamp) => {
                    if(!startTime) startTime = timestamp;
                    const progress = Math.min((timestamp - startTime) / duration, 1);
                    let currentVal = progress * end;
                    s.current = currentVal.toLocaleString('id-ID', { 
                        minimumFractionDigits: 0, 
                        maximumFractionDigits: s.decimals 
                    });
                    if(progress < 1) window.requestAnimationFrame(stepNormal);
                };
                window.requestAnimationFrame(stepNormal);
            }
        });
    },
    started: false
}" x-init="
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting && !started) {
                started = true;
                animate(); // Instant start
            }
        });
    }, { threshold: 0.2 });
    observer.observe($el);
">
    <div class="w-full px-4 sm:px-8 lg:px-12">
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4 max-w-7xl mx-auto">
            <template x-for="(stat, index) in stats" :key="index">
                <div data-aos="zoom-in" :data-aos-delay="index * 100" class="bg-white shadow-xl shadow-gray-200/50 rounded-3xl border border-gray-100 p-8 flex flex-col items-center text-center hover:-translate-y-2 transition-all group">
                    <div :class="'p-5 rounded-2xl mb-6 transition-colors ' + (
                        stat.color === 'blue' ? 'bg-blue-50 text-blue-600 group-hover:bg-blue-600' :
                        stat.color === 'emerald' ? 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600' :
                        stat.color === 'amber' ? 'bg-amber-50 text-amber-600 group-hover:bg-amber-600' :
                        'bg-purple-50 text-purple-600 group-hover:bg-purple-600'
                    ) + ' group-hover:text-white'">
                        <i :class="'bi ' + stat.icon + ' text-3xl'"></i>
                    </div>
                    <dt class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-2" x-text="stat.label"></dt>
                    <dd class="text-2xl sm:text-4xl font-black text-gray-900 font-display flex items-baseline">
                        <span x-text="stat.isSplit ? stat.current : stat.current.toLocaleString('id-ID')"></span>
                        <span x-show="stat.unit" class="text-lg font-bold ml-1 text-emerald-600" x-text="stat.unit"></span>
                    </dd>
                </div>
            </template>
        </div>
    </div>
</section>

<!-- 4. Kabar Pembangunan (Berita) -->
<section id="warta" class="py-16 bg-white">
    <div class="w-full px-4 sm:px-8 lg:px-12">
        <div class="flex justify-between items-end mb-12" data-aos="fade-right">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900">Kabar Pembangunan</h2>
                <p class="mt-2 text-lg text-gray-500">Berita dan pengumuman terbaru dari pelayanan pemerintahan {{ strtolower($displayTerm) }}.</p>
            </div>
            <a href="/berita" class="hidden sm:flex items-center text-emerald-600 hover:text-emerald-700 font-bold transition group hover:scale-105">Lihat Semua Warta <i class="bi bi-arrow-right ml-2 text-sm group-hover:translate-x-2 transition-transform"></i></a>
        </div>
        <div class="swiper news-swiper pb-12 overflow-hidden">
            <div class="swiper-wrapper">
                @foreach($latestNews as $news)
                <div class="swiper-slide h-auto">
                    <a href="{{ route('news.show', $news) }}" class="flex flex-col bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group h-full">
                        <div class="flex-shrink-0 overflow-hidden">
                            <img class="h-56 w-full object-cover group-hover:scale-110 transition-transform duration-700" src="{{ $news->image ? asset('storage/'.$news->image) : 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2013&auto=format&fit=crop' }}" alt="Berita" loading="lazy">
                        </div>
                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 inline-block px-3 py-1 rounded-full">{{ $news->category }}</p>
                                <p class="text-2xl font-bold text-gray-900 mt-4 line-clamp-2 group-hover:text-emerald-600 transition-colors">{{ $news->title }}</p>
                            </div>
                            <div class="mt-6 text-sm text-gray-500 font-medium">{{ $news->created_at->format('d M Y') }} &middot; Admin Desa</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="flex justify-center items-center mt-12 space-x-6">
                <div class="news-prev w-12 h-12 rounded-full border-2 border-emerald-100 flex items-center justify-center text-emerald-600 hover:bg-emerald-600 hover:text-white cursor-pointer transition-all shadow-sm"><i class="bi bi-chevron-left text-xl"></i></div>
                <div class="swiper-pagination news-pagination !relative !bottom-0 !w-auto"></div>
                <div class="news-next w-12 h-12 rounded-full border-2 border-emerald-100 flex items-center justify-center text-emerald-600 hover:bg-emerald-600 hover:text-white cursor-pointer transition-all shadow-sm"><i class="bi bi-chevron-right text-xl"></i></div>
            </div>
        </div>
    </div>
</section>

<!-- 5. Prakiraan Cuaca BMKG Detail -->
<section class="py-16 bg-white overflow-hidden relative" x-data="{ 
        forecasts: [], 
        loading: true,
        async fetchDetailedWeather() {
            try {
                const res = await fetch('https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={{ \App\Models\SiteMeta::getVal("bmkg_code", "35.15.14.2007") }}');
                const data = await res.json();
                this.forecasts = data.data[0].cuaca[0].slice(0, 4);
                this.loading = false;
            } catch (e) { console.error(e); }
        },
        getIcon(desc) {
            desc = desc.toLowerCase();
            if(desc.includes('cerah berawan')) return 'bi-cloud-sun';
            if(desc.includes('cerah')) return 'bi-brightness-high';
            if(desc.includes('hujan petir')) return 'bi-cloud-lightning-rain';
            if(desc.includes('hujan')) return 'bi-cloud-rain';
            if(desc.includes('berawan')) return 'bi-cloud';
            if(desc.includes('kabut')) return 'bi-cloud-fog';
            return 'bi-cloud';
        }
    }" x-init="fetchDetailedWeather()">
    <div class="w-full px-4 sm:px-8 lg:px-12 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12">
            <div data-aos="fade-right">
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-widest mb-4"><i class="bi bi-broadcast mr-2"></i> Data Resmi BMKG</div>
                <h2 class="text-3xl font-extrabold text-gray-900 font-display">Prakiraan Cuaca Lokal</h2>
                <p class="mt-2 text-lg text-gray-500">Informasi cuaca 24 jam ke depan untuk wilayah {{ $displayTerm }}.</p>
            </div>
            <div class="mt-4 md:mt-0 text-[10px] text-gray-400 opacity-60 italic" data-aos="fade-left">* Sumber data: BMKG</div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <template x-if="loading"><template x-for="i in 4"><div class="bg-gray-50 rounded-3xl p-8 animate-pulse border border-gray-100 flex flex-col items-center"><div class="w-16 h-16 bg-gray-200 rounded-full mb-6"></div><div class="w-24 h-4 bg-gray-200 rounded mb-4"></div><div class="w-16 h-8 bg-gray-200 rounded"></div></div></template></template>
            <template x-if="!loading">
                <template x-for="(item, index) in forecasts" :key="index">
                    <div class="group bg-white rounded-3xl p-8 shadow-sm hover:shadow-2xl border border-gray-100 transition-all duration-500 hover:-translate-y-2 flex flex-col items-center text-center relative overflow-hidden" data-aos="fade-up" :data-aos-delay="index * 100">
                        <i :class="'bi ' + getIcon(item.weather_desc) + ' absolute -right-4 -bottom-4 text-8xl opacity-[0.03] group-hover:scale-125 transition-all outline-none'"></i>
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6" x-text="new Date(item.local_datetime).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})"></div>
                        <div :class="'w-20 h-20 rounded-[2rem] bg-gradient-to-br flex items-center justify-center text-4xl text-white mb-6 shadow-xl ' + (item.t > 30 ? 'from-amber-400 to-orange-500 shadow-orange-100' : 'from-emerald-400 to-teal-500 shadow-emerald-100')"><i :class="'bi ' + getIcon(item.weather_desc)"></i></div>
                        <div class="text-4xl font-black text-gray-900 font-display mb-1" x-text="item.t + '°'"></div>
                        <div class="text-xs font-bold text-gray-600 uppercase tracking-widest mb-6" x-text="item.weather_desc"></div>
                        <div class="w-full pt-6 border-t border-gray-50 grid grid-cols-2 gap-4">
                            <div class="text-left"><p class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Lembap</p><p class="text-sm font-bold text-gray-900" x-text="item.hu + '%'"></p></div>
                            <div class="text-right"><p class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Angin</p><p class="text-sm font-bold text-gray-900" x-text="item.ws + ' km/h'"></p></div>
                        </div>
                    </div>
                </template>
            </template>
        </div>
    </div>
</section>

<!-- 6. Agenda Mendatang -->
<section class="py-16 bg-gray-50 border-t border-gray-100 relative overflow-hidden">
    <div class="w-full px-4 sm:px-8 lg:px-12">
        <h2 class="text-3xl font-extrabold text-gray-900 font-display" data-aos="fade-right">Agenda Mendatang</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">
            @forelse($agendas as $agenda)
            <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl border border-gray-100 transition-all hover:-translate-y-2 group" data-aos="fade-up">
                <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex flex-col items-center justify-center text-emerald-600 mb-6 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                    <span class="text-[10px] font-bold uppercase tracking-wider">{{ \Carbon\Carbon::parse($agenda->date)->format('M') }}</span>
                    <span class="text-2xl font-black font-display leading-none">{{ \Carbon\Carbon::parse($agenda->date)->format('d') }}</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 font-display group-hover:text-emerald-600 transition-colors">{{ $agenda->title }}</h3>
                <p class="text-sm text-gray-500 line-clamp-2"><i class="bi bi-geo-alt mr-1"></i> {{ $agenda->location }}</p>
            </div>
            @empty <div class="col-span-full p-8 text-center text-gray-500 italic">Belum ada agenda kegiatan.</div> @endforelse
        </div>
    </div>
</section>

<!-- 7. Etalase Ekonomi Warga -->
<section class="py-16 bg-white relative overflow-hidden">
    <div class="w-full px-4 sm:px-8 lg:px-12">
        <div class="flex justify-between items-end mb-12" data-aos="fade-right">
            <div><h2 class="text-3xl font-extrabold text-gray-900 font-display">Pasar Desa & UMKM</h2><p class="mt-2 text-lg text-gray-500">Dukung perekonomian lokal masyarakat.</p></div>
            <a href="/marketplace" class="hidden sm:flex items-center text-emerald-600 font-bold group">Lapak Desa <i class="bi bi-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i></a>
        </div>
        <div class="swiper product-swiper pb-12 overflow-hidden">
            <div class="swiper-wrapper">
                @foreach($products as $product)
                <div class="swiper-slide h-auto">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all hover:-translate-y-2 group h-full p-2">
                        <div class="h-48 relative overflow-hidden bg-gray-100 rounded-2xl">
                            <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=1500&auto=format&fit=crop' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Produk">
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1.5 rounded-xl text-emerald-700 text-xs font-black">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="p-5 flex flex-col h-[140px] justify-between">
                            <div><h3 class="text-lg font-bold text-gray-900 font-display truncate">{{ $product->name }}</h3><p class="text-sm text-gray-500 truncate mb-2"><i class="bi bi-shop text-emerald-500 mr-1"></i> {{ $product->seller_name }}</p></div>
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $product->phone) }}" target="_blank" class="block w-full py-2.5 bg-emerald-50 group-hover:bg-emerald-600 text-emerald-700 group-hover:text-white text-center text-sm font-bold rounded-xl transition-all"><i class="bi bi-whatsapp mr-1"></i> Hubungi</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="flex justify-center mt-10"><div class="swiper-pagination product-pagination !relative !w-auto"></div></div>
        </div>
    </div>
</section>

<!-- 8. Aparatur Pemerintahan -->
<section class="py-16 bg-gray-50 relative overflow-hidden">
    <div class="w-full px-4 sm:px-8 lg:px-12">
        <div class="flex justify-between items-end mb-12" data-aos="fade-right">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 font-display">Aparatur Pemerintahan</h2>
                <p class="mt-2 text-lg text-gray-500">Mengenal lebih dekat para pelayan masyarakat.</p>
            </div>
            <div class="hidden sm:flex items-center space-x-3">
                <div class="apparatus-prev w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 cursor-pointer transition-all"><i class="bi bi-chevron-left"></i></div>
                <div class="apparatus-next w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 cursor-pointer transition-all"><i class="bi bi-chevron-right"></i></div>
            </div>
        </div>
        
        <div class="swiper apparatus-swiper pb-12 overflow-hidden">
            <div class="swiper-wrapper">
                @foreach($apparatus as $staff)
                <div class="swiper-slide h-auto">
                    <div class="bg-white p-6 rounded-[2.5rem] border border-gray-100 hover:shadow-2xl transition-all duration-500 text-center group h-full">
                        <div class="aspect-[4/5] overflow-hidden rounded-[2rem] mb-6 shadow-sm ring-4 ring-gray-100 group-hover:ring-emerald-50 transition-all duration-500">
                            <img src="{{ $staff->image ? asset('storage/'.$staff->image) : 'https://i.pravatar.cc/300?u='.$staff->name }}" 
                                 class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-700" 
                                 alt="{{ $staff->name }}">
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 font-display truncate">{{ $staff->name }}</h3>
                        <p class="text-xs font-black text-emerald-600 mt-2 uppercase tracking-[0.2em] bg-emerald-50 inline-block px-5 py-2 rounded-full border border-emerald-100">{{ $staff->role }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="flex justify-center mt-8 sm:hidden">
                <div class="swiper-pagination apparatus-pagination !relative !w-auto"></div>
            </div>
        </div>
    </div>
</section>

<!-- 9. Peta Desa -->
<section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="w-full px-4 sm:px-8 lg:px-12">
        <div class="text-center mb-10" data-aos="fade-up">
            <h2 class="text-3xl font-extrabold text-gray-900 font-display">Peta Wilayah Administratif</h2>
            <p class="mt-3 text-lg text-gray-500">Kenali wilayah, infrastruktur, dan tata letak {{ $displayTerm }} kami.</p>
        </div>
        <div class="bg-white rounded-[3rem] overflow-hidden shadow-2xl border-8 border-white h-[500px] relative group" data-aos="zoom-in">
            @php $mapUrl = \App\Models\SiteMeta::getVal('village_map_url', 'Pademonegoro'); if(!Str::startsWith($mapUrl, 'http')) $mapUrl = 'https://maps.google.com/maps?q='.urlencode($mapUrl).'&t=&z=14&ie=UTF8&iwloc=&output=embed'; @endphp
            <iframe src="{{ $mapUrl }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

<!-- 10. CTA / Pengaduan -->
<section class="bg-emerald-700 py-16">
    <div class="w-full px-4 sm:px-8 lg:px-12 lg:flex lg:items-center lg:justify-between text-white">
        <div data-aos="fade-right"><h2 class="text-3xl font-extrabold sm:text-5xl font-display">Butuh Layanan?</h2><p class="text-emerald-200 mt-2 text-xl font-bold italic">Layanan administrasi cepat di kantor {{ $displayTerm }}.</p></div>
        <div class="mt-8 flex flex-col sm:flex-row gap-4" data-aos="zoom-in">
            @php $selfService = \App\Models\SiteMeta::getVal('self_service_link'); @endphp
            @if($selfService)<a href="{{ $selfService }}" target="_blank" class="px-8 py-4 bg-white text-emerald-700 font-bold rounded-2xl hover:bg-emerald-50 transition shadow-xl">Layanan Mandiri</a>@endif
            <a href="{{ route('contact') }}" class="px-8 py-4 bg-emerald-800 border border-emerald-500 font-bold rounded-2xl hover:bg-emerald-900 transition shadow-xl">Hubungi Kami</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.news-swiper', { slidesPerView: 1, spaceBetween: 24, loop: true, autoplay: { delay: 5000 }, pagination: { el: '.news-pagination', clickable: true }, navigation: { nextEl: '.news-next', prevEl: '.news-prev' }, breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } } });
        new Swiper('.product-swiper', { slidesPerView: 1, spaceBetween: 24, loop: true, autoplay: { delay: 4000 }, pagination: { el: '.product-pagination', clickable: true }, breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 5 } } });
        new Swiper('.apparatus-swiper', { 
            slidesPerView: 1, 
            spaceBetween: 24, 
            loop: true, 
            autoplay: { delay: 3000, disableOnInteraction: false }, 
            pagination: { el: '.apparatus-pagination', clickable: true }, 
            navigation: { nextEl: '.apparatus-next', prevEl: '.apparatus-prev' }, 
            breakpoints: { 
                640: { slidesPerView: 2 }, 
                1024: { slidesPerView: 4 } 
            } 
        });
    });
</script>
@endsection
