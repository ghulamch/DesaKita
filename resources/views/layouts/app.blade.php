@php
    $siteLogo = \App\Models\SiteMeta::getVal('site_logo');
    $siteFavicon = \App\Models\SiteMeta::getVal('site_favicon');
    $villageName = Str::title(\App\Models\SiteMeta::getVal('village_name', 'Digital Sejahtera'));
    $kabName = \App\Models\SiteMeta::getVal('regency_name', 'Kabupaten Terpadu');
    $villageTerm = \App\Models\SiteMeta::getVal('village_term', 'Desa');
    if($villageTerm === 'Lainnya') {
        $villageTerm = \App\Models\SiteMeta::getVal('village_term_custom', 'Desa');
    }

    $officeEmail = \App\Models\SiteMeta::getVal('office_email');
    $officePhone = \App\Models\SiteMeta::getVal('office_phone');
    $officeAddress = \App\Models\SiteMeta::getVal('office_address');
    $officeHours = \App\Models\SiteMeta::getVal('office_hours');

    $fbLink = \App\Models\SiteMeta::getVal('social_facebook', 'https://facebook.com');
    $igLink = \App\Models\SiteMeta::getVal('social_instagram', 'https://instagram.com');
    $ytLink = \App\Models\SiteMeta::getVal('social_youtube', 'https://youtube.com');
    $tkLink = \App\Models\SiteMeta::getVal('social_tiktok');
    
    $bmkgCode = \App\Models\SiteMeta::getVal('bmkg_code', '');
    $provCode = substr($bmkgCode, 0, 2);
    $timezone = 'Asia/Jakarta';
    $tzSuffix = 'WIB';

    $witaProv = ['51', '52', '53', '63', '64', '65', '71', '72', '73', '74', '75', '76'];
    $witPrefixes = ['81', '82', '91', '92', '93', '94', '95', '96'];
    
    if (in_array($provCode, $witaProv)) {
        $timezone = 'Asia/Makassar';
        $tzSuffix = 'WITA';
    } elseif (in_array($provCode, $witPrefixes) || (strlen($provCode) > 0 && $provCode[0] === '9')) {
        $timezone = 'Asia/Jayapura';
        $tzSuffix = 'WIT';
    }

    // Dynamic Menu Check
    $hasVisi = \App\Models\SiteMeta::getVal('village_vision');
    $hasMisi = \App\Models\SiteMeta::getVal('village_mission');
    $hasHistory = \App\Models\SiteMeta::getVal('village_history');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- SEO Meta Tags -->
    @php
        $siteDesc = \App\Models\SiteMeta::getVal('site_description', "Website Resmi Portal Informasi dan Pelayanan Publik $villageTerm $villageName, $kabName. Kelola berita, transparansi anggaran, dan marketplace UMKM desa.");
        $siteKeywords = \App\Models\SiteMeta::getVal('site_keywords', "$villageTerm $villageName, profil $villageTerm, berita desa, transparansi anggaran, marketplace umkm, $kabName");
    @endphp
    <meta name="description" content="{{ $siteDesc }}">
    <meta name="keywords" content="{{ $siteKeywords }}">
    <meta name="author" content="Pemerintah {{ $villageTerm }} {{ $villageName }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Sistem Informasi Desa') | Portal {{ $villageTerm }} {{ $villageName }}">
    <meta property="og:description" content="{{ $siteDesc }}">
    <meta property="og:image" content="{{ $siteLogo ? (Str::startsWith($siteLogo, 'http') ? $siteLogo : asset('storage/'.$siteLogo)) : asset('images/og-default.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Sistem Informasi Desa') | Portal {{ $villageTerm }} {{ $villageName }}">
    <meta property="twitter:description" content="{{ $siteDesc }}">
    <meta property="twitter:image" content="{{ $siteLogo ? (Str::startsWith($siteLogo, 'http') ? $siteLogo : asset('storage/'.$siteLogo)) : asset('images/og-default.jpg') }}">

    <!-- Theme Color for Mobile Browsers -->
    <meta name="theme-color" content="#059669">

    <title>@yield('title', 'Sistem Informasi Desa') | Portal {{ $villageTerm }} {{ $villageName }}</title>
    
    @if($siteFavicon)
        <link rel="icon" type="image/x-icon" href="{{ Str::startsWith($siteFavicon, 'http') ? $siteFavicon : asset('storage/'.$siteFavicon) }}">
    @endif

    <!-- JSON-LD Structured Data for Government Organization -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "GovernmentOrganization",
      "name": "{{ $villageTerm }} {{ $villageName }}",
      "url": "{{ url('/') }}",
      "logo": "{{ $siteLogo ? (Str::startsWith($siteLogo, 'http') ? $siteLogo : asset('storage/'.$siteLogo)) : '' }}",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "{{ $officeAddress }}",
        "addressLocality": "{{ $villageName }}",
        "addressRegion": "{{ $kabName }}",
        "email": "{{ $officeEmail }}",
        "telephone": "{{ $officePhone }}"
      },
      "sameAs": [
        "{{ $fbLink }}",
        "{{ $igLink }}",
        "{{ $ytLink }}"
      ]
    }
    </script>

    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Bootstrap Icons for iconography -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Outfit', sans-serif; }
        
        /* Glassmorphism utility */
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans min-h-screen flex flex-col">

    <!-- Professional Top Bar (Weather & Time - BMKG Proxy) -->
    <div class="bg-gray-900 border-b border-white/5 py-1.5 sm:py-2.5 overflow-hidden" 
         x-data="{ 
            time: '', 
            weather: { temp: '--', icon: 'bi-cloud', description: 'Memuat...', ws: '--', wd: '--', vs: '--' },
            updateTime() {
                const now = new Date();
                this.time = now.toLocaleTimeString('id-ID', { 
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit',
                    timeZone: '{{ $timezone }}'
                }) + ' {{ $tzSuffix }}';
            },
            async fetchWeather() {
                try {
                    // Use internal proxy to avoid CORS/SSL issues on mobile
                    const res = await fetch(`/api/weather?adm4={{ $bmkgCode }}`);
                    const data = await res.json();
                    
                    if(data.data && data.data[0] && data.data[0].cuaca) {
                        const forecast = data.data[0].cuaca[0][0];
                        this.weather.temp = forecast.t + '°C';
                        this.weather.description = forecast.weather_desc;
                        this.weather.ws = forecast.ws;
                        this.weather.wd = forecast.wd;
                        this.weather.vs = forecast.vs_text;
                        
                        const desc = forecast.weather_desc.toLowerCase();
                        if(desc.includes('cerah berawan')) this.weather.icon = 'bi-cloud-sun';
                        else if(desc.includes('cerah')) this.weather.icon = 'bi-brightness-high';
                        else if(desc.includes('hujan petir')) this.weather.icon = 'bi-cloud-lightning-rain';
                        else if(desc.includes('hujan')) this.weather.icon = 'bi-cloud-rain';
                        else if(desc.includes('berawan')) this.weather.icon = 'bi-cloud';
                        else if(desc.includes('kabut')) this.weather.icon = 'bi-cloud-fog';
                        else this.weather.icon = 'bi-cloud';
                    }
                } catch (e) { console.error('Weather Fetch Error:', e); }
            }
         }" 
         x-init="updateTime(); setInterval(() => updateTime(), 1000); fetchWeather();">
        <div class="w-full px-4 sm:px-8 lg:px-12 flex justify-between items-center">
            <div class="flex items-center space-x-3 sm:space-x-6">
                <!-- Status Live -->
                <div class="hidden sm:flex items-center text-[10px] font-black text-emerald-400 uppercase tracking-widest bg-white/5 px-3 py-1 rounded-full border border-white/10">
                    <span class="relative flex h-2 w-2 mr-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Live
                </div>
                <!-- Weather Info -->
                <div class="flex items-center text-[10px] font-bold text-gray-400">
                    <span class="hidden lg:flex items-center mr-4"><i class="bi bi-geo-alt-fill mr-1.5 text-emerald-500"></i>{{ $kabName }}</span>
                    <span class="flex items-center">
                        <i :class="'bi ' + weather.icon + ' mr-1.5 text-emerald-500 text-xs sm:text-sm'"></i> 
                        <span x-text="weather.temp" class="mr-1 text-white sm:text-gray-400 font-black sm:font-bold"></span>
                        <span x-text="weather.description" class="hidden sm:inline"></span>
                        
                        <!-- More Details (Desktop Only) -->
                        <span class="hidden xl:flex items-center ml-3">
                            <span class="mx-3 text-white/10">|</span>
                            <i class="bi bi-wind mr-1.5 text-emerald-500"></i> 
                            Angin: <span class="ml-1 text-white" x-text="weather.ws + ' km/j'"></span>
                            <span class="mx-3 text-white/10">|</span>
                            <i class="bi bi-compass mr-1.5 text-emerald-500"></i>
                            Arah: <span class="ml-1 text-white" x-text="weather.wd"></span>
                        </span>
                    </span>
                </div>
            </div>
            <!-- Time Display -->
            <div class="flex items-center text-[9px] sm:text-[10px] font-black text-white hover:text-emerald-400 transition-colors cursor-default">
                <i class="bi bi-clock-fill mr-1.5 text-emerald-500 hidden sm:inline"></i>
                <span x-text="time"></span>
            </div>
        </div>
    </div>

    <!-- Professional Corporate Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm" x-data="{ mobileMenuOpen: false }">
        <div class="w-full px-4 sm:px-8 lg:px-12">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center group">
                        @if($siteLogo)
                            <img src="{{ Str::startsWith($siteLogo, 'http') ? $siteLogo : asset('storage/'.$siteLogo) }}" alt="Logo {{ $villageName }}" class="h-10 w-auto mr-3 group-hover:scale-105 transition-transform">
                        @endif
                        <div class="flex flex-col">
                            <span class="text-emerald-700 font-bold text-xs sm:text-sm lg:text-xl uppercase tracking-wider leading-none">{{ $villageTerm }} {{ $villageName }}</span>
                            <span class="text-gray-500 font-medium text-[8px] sm:text-[10px] lg:text-xs">PEMERINTAH {{ $kabName }}</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex space-x-8 items-center text-sm font-medium">
                    <a href="/" class="text-gray-600 hover:text-emerald-600 transition tracking-wide {{ Request::is('/') ? 'text-emerald-600 border-b-2 border-emerald-500 pb-5 pt-5 -mb-[2px]' : 'py-5' }}">Beranda</a>
                    <!-- Profil Dropdown -->
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="flex items-center text-gray-600 hover:text-emerald-600 transition tracking-wide py-5 {{ Request::is('profil*') ? 'text-emerald-600 border-b-2 border-emerald-500 -mb-[2px]' : '' }}">
                            Profil Desa <i class="bi bi-chevron-down ml-1.5 text-[10px]"></i>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200" 
                             x-transition:enter-start="opacity-0 translate-y-1" 
                             x-transition:enter-end="opacity-100 translate-y-0" 
                             class="absolute left-0 mt-0 w-56 bg-white border border-gray-100 shadow-xl rounded-2xl py-2 z-50">
                            @if($hasHistory)
                                <a href="{{ route('profile.sejarah') }}" class="block px-6 py-3 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 transition font-medium">Sejarah Desa</a>
                            @endif
                            @if($hasVisi || $hasMisi)
                                <a href="{{ route('profile.visimisi') }}" class="block px-6 py-3 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 transition font-medium">Visi & Misi</a>
                            @endif
                            <a href="{{ route('profile.structure') }}" class="block px-6 py-3 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 transition font-medium">Struktur Organisasi</a>
                        </div>
                    </div>
                    <a href="/berita" class="text-gray-600 hover:text-emerald-600 transition tracking-wide {{ Request::is('berita*') ? 'text-emerald-600 border-b-2 border-emerald-500 pb-5 pt-5 -mb-[2px]' : 'py-5' }}">Berita Desa</a>
                    <a href="/transparansi" class="text-gray-600 hover:text-emerald-600 transition tracking-wide {{ Request::is('transparansi*') ? 'text-emerald-600 border-b-2 border-emerald-500 pb-5 pt-5 -mb-[2px]' : 'py-5' }}">Info Anggaran</a>
                    
                    

                    <a href="{{ route('profile.legal') }}" class="text-gray-600 hover:text-emerald-600 transition tracking-wide {{ Request::is('profil/produk-hukum*') ? 'text-emerald-600 border-b-2 border-emerald-500 pb-5 pt-5 -mb-[2px]' : 'py-5' }}">Produk Hukum</a>
                    <a href="/marketplace" class="text-gray-600 hover:text-emerald-600 transition tracking-wide {{ Request::is('marketplace*') ? 'text-emerald-600 border-b-2 border-emerald-500 pb-5 pt-5 -mb-[2px]' : 'py-5' }}">Pasar Desa</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-emerald-600 transition tracking-wide {{ Request::is('kontak*') ? 'text-emerald-600 border-b-2 border-emerald-500 pb-5 pt-5 -mb-[2px]' : 'py-5' }}">Kontak</a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <!-- Global Search Button -->
                    <button @click="$dispatch('open-search')" class="w-10 h-10 flex items-center justify-center rounded-xl text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 transition-all border border-transparent hover:border-emerald-100">
                        <i class="bi bi-search text-lg"></i>
                    </button>

                    <div class="hidden md:flex items-center">
                        @auth
                            <div class="relative" x-data="{ userMenu: false }" @mouseenter="userMenu = true" @mouseleave="userMenu = false">
                                <button class="flex items-center space-x-3 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 px-4 py-2.5 rounded-xl font-bold transition text-sm">
                                    <div class="w-6 h-6 bg-emerald-600 text-white rounded-full flex items-center justify-center">
                                        <i class="bi bi-person text-sm"></i>
                                    </div>
                                    <span>Menu User</span>
                                    <i class="bi bi-chevron-down text-[10px]"></i>
                                </button>
                                <div x-show="userMenu" 
                                     x-transition:enter="transition ease-out duration-200" 
                                     x-transition:enter-start="opacity-0 translate-y-1" 
                                     x-transition:enter-end="opacity-100 translate-y-0" 
                                     style="display: none;" 
                                     class="absolute right-0 mt-0 w-56 bg-white border border-gray-100 rounded-2xl shadow-xl py-3 z-50">
                                    <div class="px-5 py-2 mb-2 border-b border-gray-50">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Akses Akun</p>
                                    </div>
                                    <a href="{{ Auth::user()->isWarga() ? route('resident.dashboard') : route('admin.dashboard') }}" class="flex items-center px-5 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                        <i class="bi bi-speedometer2 mr-3 opacity-50"></i> 
                                        {{ Auth::user()->isWarga() ? 'Dasbor Warga' : 'Panel Admin' }}
                                    </a>
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.users.index') }}" class="flex items-center px-5 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition"><i class="bi bi-person-lock mr-3 opacity-50"></i> Manajemen User</a>
                                    @endif
                                    <div class="border-t border-gray-50 my-2"></div>
                                    <form method="POST" action="{{ route('logout') }}" class="block px-2">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 rounded-xl transition font-bold"><i class="bi bi-box-arrow-right mr-3"></i> Keluar Sistem</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center space-x-3">
                                <a href="/login" class="px-5 py-2.5 text-xs font-black uppercase tracking-widest text-emerald-700 hover:text-emerald-800 hover:bg-emerald-50 transition border border-emerald-100 rounded-xl">
                                    Masuk
                                </a>
                                <a href="/register" class="px-5 py-2.5 text-xs font-black uppercase tracking-widest text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-100 transition rounded-xl">
                                    Daftar
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" style="display: none;" class="md:hidden bg-white border-t border-gray-100">
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="/" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 transition {{ Request::is('/') ? 'bg-emerald-50 text-emerald-700' : '' }}">Beranda</a>
                <div x-data="{ open: false }" class="mt-1">
                    <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-3 rounded-xl text-base font-bold text-gray-900 hover:bg-emerald-50 transition {{ Request::is('profil*') && !Request::is('profil/produk-hukum*') ? 'bg-emerald-50 text-emerald-700' : '' }}">
                        <span>Profil Desa</span>
                        <i class="bi" :class="open ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                    </button>
                    <div x-show="open" x-cloak class="bg-gray-50/50 rounded-2xl mt-1 py-1 px-2 border border-gray-100">
                        @if($hasHistory)
                            <a href="{{ route('profile.sejarah') }}" class="block px-6 py-3 text-sm font-bold text-gray-600 hover:text-emerald-700 transition">Sejarah Desa</a>
                        @endif
                        @if($hasVisi || $hasMisi)
                            <a href="{{ route('profile.visimisi') }}" class="block px-6 py-3 text-sm font-bold text-gray-600 hover:text-emerald-700 transition">Visi & Misi</a>
                        @endif
                        <a href="{{ route('profile.structure') }}" class="block px-6 py-3 text-sm font-bold text-gray-600 hover:text-emerald-700 transition">Struktur Organisasi</a>
                    </div>
                </div>
                <a href="/berita" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 transition {{ Request::is('berita*') ? 'bg-emerald-50 text-emerald-700' : '' }}">Berita Desa</a>
                <a href="/transparansi" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-900 hover:text-emerald-700 hover:bg-emerald-50 transition {{ Request::is('transparansi*') ? 'bg-emerald-50 text-emerald-700' : '' }}">Info Anggaran</a>

                <a href="{{ route('profile.legal') }}" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-900 hover:text-emerald-700 hover:bg-emerald-50 transition {{ Request::is('profil/produk-hukum*') ? 'bg-emerald-50 text-emerald-700' : '' }}">Produk Hukum</a>
                <a href="/marketplace" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-900 hover:text-emerald-700 hover:bg-emerald-50 transition {{ Request::is('marketplace*') ? 'bg-emerald-50 text-emerald-700' : '' }}">Pasar Desa</a>
                <a href="{{ route('contact') }}" class="block px-4 py-3 rounded-xl text-base font-bold text-gray-900 hover:text-emerald-700 hover:bg-emerald-50 transition {{ Request::is('kontak*') ? 'bg-emerald-50 text-emerald-700' : '' }}">Kontak</a>
            </div>
                <!-- Auth Section Mobile -->
                <div class="px-4 py-6 border-t border-gray-100 mt-4 space-y-3">
                    @auth
                        <a href="{{ Auth::user()->isWarga() ? route('resident.dashboard') : route('admin.dashboard') }}" class="flex items-center justify-center space-x-2 w-full py-4 bg-emerald-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg shadow-emerald-200 transition active:scale-95">
                            <i class="bi bi-speedometer2"></i>
                            <span>{{ Auth::user()->isWarga() ? 'Dasbor Warga' : 'Panel Dasbor' }}</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="block">
                            @csrf
                            <button type="submit" class="flex items-center justify-center space-x-2 w-full py-3 bg-white text-rose-600 border border-rose-100 rounded-2xl font-bold text-xs uppercase tracking-wider transition active:scale-95">
                                <i class="bi bi-power"></i>
                                <span>Keluar Sistem</span>
                            </button>
                        </form>
                    @else
                        <a href="/login" class="flex items-center justify-center space-x-2 w-full py-4 bg-emerald-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg shadow-emerald-100 transition active:scale-95">
                            <i class="bi bi-box-arrow-in-right text-lg"></i>
                            <span>Masuk Portal</span>
                        </a>
                        <a href="/register" class="flex items-center justify-center space-x-2 w-full py-4 bg-white text-emerald-700 border-2 border-emerald-50 rounded-2xl font-black text-sm uppercase tracking-widest transition active:scale-95">
                            <i class="bi bi-person-plus text-lg"></i>
                            <span>Daftar Warga</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- GLOBAL SEARCH MODAL -->
    <div x-data="{ 
            open: false, 
            query: '', 
            results: [], 
            isSearching: false,
            async performSearch() {
                if (this.query.length < 2) {
                    this.results = [];
                    return;
                }
                this.isSearching = true;
                try {
                    const res = await fetch(`/api/search?q=${encodeURIComponent(this.query)}`);
                    this.results = await res.json();
                } catch (e) { console.error(e); }
                this.isSearching = false;
            }
         }" 
         @open-search.window="open = true; $nextTick(() => $refs.searchInput.focus())"
         @keydown.escape.window="open = false"
         @keydown.window.prevent.slash="open = true; $nextTick(() => $refs.searchInput.focus())"
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-[99999] flex flex-col items-center justify-start sm:pt-12" 
         role="dialog">
        
        <!-- Backdrop -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             @click="open = false"
             class="fixed inset-0 bg-slate-950/90 backdrop-blur-md"></div>

        <!-- Modal Content Container -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-500" 
             x-transition:enter-start="opacity-0 -translate-y-full" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="ease-in duration-300" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 -translate-y-full" 
             class="relative w-full max-w-5xl bg-white sm:rounded-[2rem] shadow-2xl overflow-hidden flex flex-col max-h-screen sm:max-h-[90vh]">
            
            <!-- Search Header -->
            <div class="p-6 sm:p-8 border-b border-gray-100 bg-white">
                <div class="flex items-center">
                    <div class="w-12 h-12 flex items-center justify-center text-emerald-600 bg-emerald-50 rounded-2xl mr-5">
                        <i class="bi bi-search text-2xl"></i>
                    </div>
                    <input type="text" 
                           x-ref="searchInput"
                           x-model="query" 
                           @input.debounce.300ms="performSearch()"
                           class="flex-grow bg-transparent border-none focus:ring-0 text-xl sm:text-3xl font-black text-gray-900 placeholder-gray-300 py-2 outline-none" 
                           placeholder="Ketik untuk mencari...">
                    
                    <button @click="open = false" class="ml-4 p-4 hover:bg-gray-100 rounded-2xl transition-colors text-gray-400">
                        <i class="bi bi-x-lg text-xl sm:text-2xl"></i>
                    </button>
                </div>
                <div x-show="isSearching" class="h-1 w-full bg-gray-50 mt-4 overflow-hidden rounded-full">
                    <div class="h-full bg-emerald-500 animate-[loading_1s_infinite]"></div>
                </div>
            </div>

            <!-- Content Area (Always White Background) -->
            <div class="flex-grow overflow-y-auto custom-scrollbar bg-white min-h-[300px]">
                
                <!-- Results State -->
                <div x-show="results.length > 0" class="p-6 sm:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="item in results" :key="item.url">
                            <a :href="item.url" class="flex items-center p-5 bg-gray-50 hover:bg-emerald-50 rounded-3xl border border-transparent hover:border-emerald-100 transition-all group">
                                <div class="w-14 h-14 bg-white border border-gray-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform shadow-sm">
                                    <i :class="item.type === 'Berita' ? 'bi-newspaper' : (item.type === 'Pasar Desa' ? 'bi-shop' : 'bi-file-earmark-text')"></i>
                                </div>
                                <div class="ml-5">
                                    <h4 class="text-sm font-black text-gray-900 group-hover:text-emerald-700 transition-colors" x-text="item.title"></h4>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1.5" x-text="item.category"></p>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>

                <!-- Empty State -->
                <div x-show="results.length === 0 && query.length >= 2 && !isSearching" class="py-24 text-center px-10">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i class="bi bi-search text-gray-300 text-4xl font-light"></i>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900">Maaf, hasil tidak ada.</h3>
                    <p class="text-gray-400 mt-3 font-medium">Coba gunakan kata kunci lain untuk <span class="text-emerald-600 font-bold" x-text="'\'' + query + '\''"></span></p>
                </div>

                <!-- Initial State (Popular Topics) -->
                <div x-show="query.length < 2 && !isSearching" class="p-8 sm:p-12">
                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.3em] mb-10 text-center">Topik Populer Desa</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                        @foreach(['Info Bansos', 'Laporan Keuangan', 'Syarat KTP', 'Pasar Desa'] as $tag)
                            <button @click="query = '{{ $tag }}'; performSearch()" class="py-6 px-4 bg-gray-50 border border-gray-100 rounded-[2rem] hover:bg-white hover:border-emerald-300 hover:shadow-xl hover:shadow-emerald-100/50 transition-all text-xs font-black text-gray-600 hover:text-emerald-700">
                                # {{ $tag }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Footer Toolbar -->
            <div class="p-6 bg-gray-50 border-t border-gray-100 hidden sm:flex justify-between items-center text-[10px] font-black text-gray-400 uppercase tracking-widest">
                <div class="flex space-x-8">
                    <span class="flex items-center"><i class="bi bi-arrow-return-left mr-2 text-emerald-500"></i> Pilih</span>
                    <span class="flex items-center"><i class="bi bi-x-lg mr-2 text-rose-500"></i> Tutup (ESC)</span>
                </div>
                <div class="text-emerald-600 italic opacity-50">Portal Desa Digital</div>
            </div>
        </div>

        <style>
            @keyframes loading {
                0% { transform: translateX(-100%); }
                100% { transform: translateX(100%); }
            }
        </style>
    </div>
    </div>

    <!-- Professional Footer -->
    <footer class="bg-gray-900 pt-16 pb-8 border-t border-gray-800 text-gray-300">
        <div class="w-full px-4 sm:px-8 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <!-- Brand Info -->
                <div>
                    <div class="flex items-center mb-6 py-1">
                        @if($siteLogo)
                            <img src="{{ Str::startsWith($siteLogo, 'http') ? $siteLogo : asset('storage/'.$siteLogo) }}" alt="Logo Footer" class="h-10 w-auto mr-3 brightness-0 invert opacity-80">
                        @endif
                        <h3 class="text-white text-xl font-bold">{{ strtoupper($villageTerm) }} {{ $villageName }}</h3>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        Website resmi pelayanan dan informasi masyarakat. Komitmen wujudkan {{ strtolower($villageTerm) }} yang transparan, maju, dan sejahtera.
                    </p>
                    <div class="flex space-x-4">
                        @if(\App\Models\SiteMeta::getVal('social_facebook'))
                            <a href="{{ $fbLink }}" target="_blank" class="text-gray-400 hover:text-emerald-400 hover:scale-110 transition-transform"><i class="bi bi-facebook text-lg"></i></a>
                        @endif
                        @if(\App\Models\SiteMeta::getVal('social_instagram'))
                            <a href="{{ $igLink }}" target="_blank" class="text-gray-400 hover:text-emerald-400 hover:scale-110 transition-transform"><i class="bi bi-instagram text-lg"></i></a>
                        @endif
                        @if(\App\Models\SiteMeta::getVal('social_youtube'))
                            <a href="{{ $ytLink }}" target="_blank" class="text-gray-400 hover:text-emerald-400 hover:scale-110 transition-transform"><i class="bi bi-youtube text-lg"></i></a>
                        @endif
                        @if(\App\Models\SiteMeta::getVal('social_tiktok'))
                            <a href="{{ $tkLink }}" target="_blank" class="text-gray-400 hover:text-emerald-400 hover:scale-110 transition-transform"><i class="bi bi-tiktok text-lg"></i></a>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4 tracking-wider uppercase text-sm">Informasi Publik</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="/berita" class="hover:text-emerald-400 transition-colors flex items-center group"><i class="bi bi-chevron-right text-[10px] mr-2 group-hover:translate-x-1 transition-transform"></i> Pengumuman & Berita</a></li>
                        <li><a href="/transparansi" class="hover:text-emerald-400 transition-colors flex items-center group"><i class="bi bi-chevron-right text-[10px] mr-2 group-hover:translate-x-1 transition-transform"></i> Laporan Keuangan</a></li>
                        <li><a href="/marketplace" class="hover:text-emerald-400 transition-colors flex items-center group"><i class="bi bi-chevron-right text-[10px] mr-2 group-hover:translate-x-1 transition-transform"></i> Lapak UMKM Warga</a></li>
                        <li><a href="/profil" class="hover:text-emerald-400 transition-colors flex items-center group"><i class="bi bi-chevron-right text-[10px] mr-2 group-hover:translate-x-1 transition-transform"></i> Visi Misi {{ $villageTerm }}</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white font-semibold mb-4 tracking-wider uppercase text-sm">Kontak Pelayanan</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start">
                            <i class="bi bi-geo-alt mt-1 mr-3 text-emerald-500"></i>
                            <span>{{ $officeAddress ?? 'Jl. Raya Protokol Desa No. 1, Kecamatan Mandiri, Kab. Sejahtera, Kode Pos 12345' }}</span>
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-telephone mt-0.5 mr-3 text-emerald-500"></i>
                            <span>{{ $officePhone ?? '(021) 555-0123' }}</span>
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-envelope mt-0.5 mr-3 text-emerald-500"></i>
                            <span class="italic">{{ $officeEmail ?? 'pemdes@desa.go.id' }}</span>
                        </li>
                    </ul>
                    <div class="mt-4 bg-gray-800 p-3 rounded-lg border border-gray-700 text-xs">
                        <span class="block text-gray-400 mb-1">Jam Operasional Pelayanan:</span>
                        <span class="font-medium text-white">{{ $officeHours ?? 'Senin - Jumat: 08:00 - 15:00 WIB' }}</span>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="pt-8 border-t border-gray-800 text-sm text-center text-gray-500 flex flex-col md:flex-row justify-between items-center">
                <p>&copy; {{ date('Y') }} {{ strtoupper($villageTerm) }} {{ $villageName }}. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Swiper.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- AOS JS Injection -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                once: true,
                offset: 50,
                duration: 800,
                easing: 'ease-out-cubic',
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
