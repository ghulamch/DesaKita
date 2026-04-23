@extends('layouts.auth')

@section('title', 'Login Portal Resmi')

@section('content')
<div class="text-center mb-8">
    <h1 class="text-4xl font-black text-slate-900 font-display tracking-tight mb-2 uppercase">Masuk<span class="text-emerald-600"> Sistem</span></h1>
    <p class="text-slate-500 font-medium text-sm">Sistem Informasi Manajemen Terpadu Desa</p>
</div>

<div class="lumina-card p-10 bg-white">
    <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
        @csrf
        
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-600 text-[11px] font-black uppercase tracking-wider flex items-center">
                <i class="bi bi-check-circle-fill mr-3 text-lg"></i> {{ session('success') }}
            </div>
        @endif
        
        @if(session('info'))
            <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl text-blue-600 text-[11px] font-black uppercase tracking-wider flex items-center">
                <i class="bi bi-info-circle-fill mr-3 text-lg"></i> {{ session('info') }}
            </div>
        @endif
        @if($errors->any())
            <div class="p-4 bg-red-50 border border-red-100 rounded-2xl text-red-600 text-[11px] font-black uppercase tracking-wider flex items-center">
                <i class="bi bi-exclamation-octagon-fill mr-3 text-lg"></i> {{ $errors->first() }}
            </div>
        @endif

        @if(session('needs_activation'))
            <div class="p-5 bg-amber-50 border border-amber-100 rounded-2xl space-y-3">
                <div class="flex items-start">
                    <i class="bi bi-envelope-exclamation-fill text-amber-500 mr-3 text-lg"></i>
                    <p class="text-amber-800 text-[11px] font-bold leading-relaxed">
                        Akun Anda belum aktif. Silakan cek folder INBOX atau SPAM pada email Anda.
                    </p>
                </div>
                <form action="{{ route('register.resend') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('pending_email') }}">
                    <button type="submit" class="text-[10px] font-black text-amber-600 hover:text-amber-700 underline uppercase tracking-widest">
                        Belum menerima email? Kirim Ulang
                    </button>
                </form>
            </div>
        @endif

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-2.5 ml-1">Alamat E-Mail</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <i class="bi bi-person-fill text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                </div>
                <input type="email" name="email" required
                    class="lumina-input block w-full pl-12 pr-5 py-4 rounded-2xl text-sm"
                    placeholder="nama@email.com" value="{{ old('email') }}">
            </div>
        </div>

        <div>
            <div class="flex justify-between items-center mb-2.5 ml-1">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">Kata Sandi Keamanan</label>
                <a href="{{ route('password.request') }}" class="text-[10px] font-black text-emerald-600 hover:text-emerald-700 transition uppercase tracking-widest">Lupa?</a>
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <i class="bi bi-lock-fill text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                </div>
                <input type="password" name="password" required
                    class="lumina-input block w-full pl-12 pr-5 py-4 rounded-2xl text-sm"
                    placeholder="••••••••">
            </div>
        </div>

        <div class="flex items-center justify-between py-2">
            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <label for="remember" class="ml-2 text-[10px] font-black text-slate-500 uppercase tracking-widest cursor-pointer">Ingat saya di perangkat ini</label>
            </div>
        </div>

        <button type="submit" 
            class="lumina-btn w-full py-4.5 text-white font-black rounded-2xl transition-all uppercase tracking-[0.2em] text-xs flex items-center justify-center gap-2">
            Masuk ke Portal <i class="bi bi-chevron-right text-lg"></i>
        </button>
    </form>

    <div class="mt-10 pt-10 border-t border-slate-50 text-center">
        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            Belum memiliki akses? 
            <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-700 transition-colors ml-1 border-b-2 border-emerald-600/20">Daftar Warga</a>
        </p>
    </div>
</div>

<div class="mt-8 flex flex-col items-center justify-center gap-4">
    <div class="flex items-center gap-2 px-4 py-2 bg-slate-100 rounded-full text-[9px] font-black text-slate-500 uppercase tracking-widest border border-slate-200">
        <i class="bi bi-shield-check text-emerald-500"></i> Encrypted Connection
    </div>
    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">© {{ date('Y') }} Desa {{ \App\Models\SiteMeta::getVal('village_name') }}</span>
</div>
@endsection
