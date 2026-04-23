@php
    $siteLogo = \App\Models\SiteMeta::getVal('site_logo');
    $siteFavicon = \App\Models\SiteMeta::getVal('site_favicon');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ Auth::user()->isWarga() ? 'Portal Warga' : 'Admin Panel' }} | {{ $villageName }}</title>
    
    @if($siteFavicon)
        <link rel="icon" type="image/x-icon" href="{{ Str::startsWith($siteFavicon, 'http') ? $siteFavicon : asset('storage/'.$siteFavicon) }}">
    @endif

    <!-- Alpine.js & Tailwind -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Icons & Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #10b981; }

        .animate-bounce-in {
            animation: bounce-in 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes bounce-in {
            from { opacity: 0; transform: translateY(20px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 antialiased" x-data="{ sidebarOpen: true, mobileMenu: false }">

    <!-- Mobile Header -->
    <div class="lg:hidden bg-slate-900 text-white p-4 flex justify-between items-center sticky top-0 z-[60]">
        <div class="flex items-center space-x-3">
            @if($siteLogo)
                <img src="{{ Str::startsWith($siteLogo, 'http') ? $siteLogo : asset('storage/'.$siteLogo) }}" class="h-8 w-auto brightness-0 invert">
            @endif
            <span class="font-bold text-sm tracking-tight">{{ Auth::user()->isWarga() ? 'Warga' : 'Admin' }} {{ $villageName }}</span>
        </div>
        <button @click="mobileMenu = !mobileMenu" class="p-2 bg-slate-800 rounded-lg">
            <i class="bi" :class="mobileMenu ? 'bi-x-lg' : 'bi-list'"></i>
        </button>
    </div>

    <!-- Sidebar Overlay (Mobile) -->
    <div x-show="mobileMenu" @click="mobileMenu = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[70] lg:hidden" x-cloak></div>

    <!-- Main Sidebar -->
    <aside :class="mobileMenu ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" 
           class="fixed top-0 left-0 h-full lg:h-screen w-72 bg-slate-900 text-slate-400 z-[80] transition-transform duration-300 border-right border-slate-800 flex flex-col shadow-2xl lg:shadow-none overflow-hidden">
        
        <!-- Sidebar Header -->
        <div class="p-8 hidden lg:block">
            <div class="flex items-center space-x-3 mb-2">
                @if($siteLogo)
                    <img src="{{ Str::startsWith($siteLogo, 'http') ? $siteLogo : asset('storage/'.$siteLogo) }}" class="h-10 w-auto brightness-0 invert">
                @endif
                <div>
                    <h1 class="text-white text-lg font-black tracking-tight leading-none uppercase">{{ Auth::user()->isWarga() ? 'War' : 'Adm' }}<span class="text-emerald-500">{{ Auth::user()->isWarga() ? 'ga.' : 'in.' }}</span></h1>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-1">Sistem {{ $villageTerm }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-4 space-y-1.5 overflow-y-auto min-h-0 custom-scrollbar">
            <p class="px-4 text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] mb-4">Core Menu</p>
            
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-4 py-3 rounded-2xl transition-all group {{ Request::is('admin') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-grid-fill mr-4 text-xl {{ Request::is('admin') ? 'text-white' : 'text-slate-500 group-hover:text-emerald-400' }}"></i>
                <span class="font-bold text-sm tracking-wide">Dasbor Ringkasan</span>
            </a>

            <p class="px-4 text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] pt-6 mb-4">Administrasi Sistem</p>
            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center px-4 py-3 rounded-2xl transition-all group {{ Request::is('admin/users*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-people-fill mr-4 text-xl {{ Request::is('admin/users*') ? 'text-white' : 'text-slate-500 group-hover:text-emerald-400' }}"></i>
                <span class="font-bold text-sm tracking-wide">Manajemen User</span>
            </a>

            <a href="{{ route('apparatus.index') }}" 
               class="flex items-center px-4 py-3 rounded-2xl transition-all group {{ Request::is('admin/apparatus*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-person-workspace mr-4 text-xl {{ Request::is('admin/apparatus*') ? 'text-white' : 'text-slate-500 group-hover:text-emerald-400' }}"></i>
                <span class="font-bold text-sm tracking-wide">Aparatur {{ $villageTerm }}</span>
            </a>

            <a href="{{ route('admin.transparency.index') }}" 
               class="flex items-center px-4 py-3 rounded-2xl transition-all group {{ Request::is('admin/transparency*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-cash-stack mr-4 text-xl {{ Request::is('admin/transparency*') ? 'text-white' : 'text-slate-500 group-hover:text-emerald-400' }}"></i>
                <span class="font-bold text-sm tracking-wide">Transparansi Keuangan</span>
            </a>

            <a href="{{ route('admin.legal-products.index') }}" 
               class="flex items-center px-4 py-3 rounded-2xl transition-all group {{ Request::is('admin/legal-products*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-journal-check mr-4 text-xl {{ Request::is('admin/legal-products*') ? 'text-white' : 'text-slate-500 group-hover:text-emerald-400' }}"></i>
                <span class="font-bold text-sm tracking-wide">Produk Hukum</span>
            </a>

            <p class="px-4 text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] pt-6 mb-4">Konten & Agenda</p>
            
            <a href="{{ route('agendas.index') }}" 
               class="flex items-center px-4 py-3 rounded-2xl transition-all group {{ Request::is('admin/agendas*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-calendar-event-fill mr-4 text-xl {{ Request::is('admin/agendas*') ? 'text-white' : 'text-slate-500 group-hover:text-emerald-400' }}"></i>
                <span class="font-bold text-sm tracking-wide">Agenda {{ $villageTerm }}</span>
            </a>

            <a href="{{ route('admin.news.index') }}" 
               class="flex items-center px-4 py-3 rounded-2xl transition-all group {{ Request::is('admin/news*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-newspaper mr-4 text-xl {{ Request::is('admin/news*') ? 'text-white' : 'text-slate-500 group-hover:text-emerald-400' }}"></i>
                <span class="font-bold text-sm tracking-wide">Berita {{ $villageTerm }}</span>
            </a>

            <a href="{{ route('admin.marketplace.index') }}" 
               class="flex items-center px-4 py-3 rounded-2xl transition-all group {{ Request::is('admin/marketplace*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-shop mr-4 text-xl {{ Request::is('admin/marketplace*') ? 'text-white' : 'text-slate-500 group-hover:text-emerald-400' }}"></i>
                <span class="font-bold text-sm tracking-wide">Moderasi Lapak</span>
            </a>

            <p class="px-4 text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] pt-6 mb-4">Pengaturan</p>
            <a href="{{ route('admin.settings.index') }}" 
               class="flex items-center px-4 py-3 rounded-2xl transition-all group {{ Request::is('admin/settings*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-gear-fill mr-4 text-xl {{ Request::is('admin/settings*') ? 'text-white' : 'text-slate-500 group-hover:text-emerald-400' }}"></i>
                <span class="font-bold text-sm tracking-wide">Identitas {{ $villageTerm }}</span>
            </a>
        </nav>

        <!-- Sidebar Footer (Logout) -->
        <div class="p-4 bg-slate-950 border-t border-slate-800/50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3 rounded-2xl text-red-400 hover:bg-red-500/10 transition-all font-bold text-sm group">
                    <i class="bi bi-box-arrow-right mr-4 text-xl group-hover:translate-x-1 transition-transform"></i>
                    Keluar Sesi
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="lg:ml-72 min-h-screen flex flex-col">
        
        <!-- Top Header Navigation -->
        <header class="h-20 bg-white border-b border-slate-200 sticky top-0 z-[50] flex items-center justify-between px-8 hidden lg:flex shadow-sm">
            <div>
                <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center">
                    Dashboard <i class="bi bi-chevron-right mx-3 opacity-50"></i> <span class="text-slate-900">@yield('title', Auth::user()->isWarga() ? 'Portal Warga' : 'Admin Panel')</span>
                </h2>
            </div>
            
            <div class="flex items-center space-x-6">
                <!-- Live Preview Link -->
                <a href="/" target="_blank" class="flex items-center text-xs font-black text-emerald-600 uppercase tracking-widest hover:text-emerald-700 transition">
                    Lihat Situs <i class="bi bi-arrow-up-right ml-2"></i>
                </a>

                <div class="h-8 w-[1px] bg-slate-100"></div>

                <!-- User Profile -->
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-black text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mt-1">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="w-10 h-10 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 font-bold overflow-hidden shadow-sm">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/'.Auth::user()->photo) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Dynamic Content -->
        <div class="p-2 lg:p-8 flex-1">
            <!-- Breadcrumbs Success/Error Messages -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-3xl text-emerald-600 text-sm font-bold flex items-center justify-between animate-bounce-in">
                    <div class="flex items-center">
                        <i class="bi bi-check-circle-fill mr-3 text-lg"></i> {{ session('success') }}
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600"><i class="bi bi-x-lg"></i></button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                     class="mb-8 p-4 bg-red-50 border border-red-100 rounded-3xl text-red-600 text-sm font-bold flex items-center justify-between animate-bounce-in">
                    <div class="flex items-center">
                        <i class="bi bi-exclamation-triangle-fill mr-3 text-lg"></i> {{ session('error') }}
                    </div>
                    <button @click="show = false" class="text-red-400 hover:text-red-600"><i class="bi bi-x-lg"></i></button>
                </div>
            @endif

            @if($errors->any())
                <div x-data="{ show: true }" x-show="show"
                     class="mb-8 p-4 bg-amber-50 border border-amber-100 rounded-3xl text-amber-700 text-sm font-bold flex items-center justify-between animate-bounce-in">
                    <div class="flex items-center">
                        <i class="bi bi-info-circle-fill mr-3 text-lg"></i> {{ $errors->first() }}
                    </div>
                    <button @click="show = false" class="text-amber-400 hover:text-amber-600"><i class="bi bi-x-lg"></i></button>
                </div>
            @endif

            @yield('content')
        </div>

        <!-- Admin Footer -->
        <footer class="px-8 py-6 border-t border-slate-100 bg-white/50 text-[10px] font-bold text-slate-400 uppercase tracking-widest flex justify-between">
            <p>&copy; {{ date('Y') }} {{ $villageTerm }} {{ $villageName }}. All Rights Reserved.</p>        </footer>
    </main>

    @yield('scripts')
</body>
</html>
