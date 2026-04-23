@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi')

@section('content')
<div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-16 h-16 bg-white border border-slate-100 rounded-[1.5rem] mb-6 shadow-sm">
        <i class="bi bi-key-fill text-2xl text-amber-500"></i>
    </div>
    <h1 class="text-4xl font-black text-slate-900 font-display tracking-tight mb-2 uppercase">L<span class="text-amber-500">upa.</span></h1>
    <p class="text-slate-500 font-medium text-sm">Pemulihan Akses Akun Sistem</p>
</div>

<div class="lumina-card p-10 bg-white">
    @if (session('status'))
        <div class="p-4 mb-6 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 text-xs font-bold flex items-center">
            <i class="bi bi-check-circle-fill mr-3 text-lg"></i> {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
        @csrf
        
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-2.5 ml-1">Alamat E-Mail Terdaftar</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <i class="bi bi-envelope-fill text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                </div>
                <input type="email" name="email" required
                    class="lumina-input block w-full pl-12 pr-5 py-4 rounded-2xl text-sm"
                    placeholder="nama@email.com" value="{{ old('email') }}">
            </div>
            @error('email')
                <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" 
            class="lumina-btn w-full py-4.5 text-white font-black rounded-2xl transition-all uppercase tracking-[0.2em] text-xs flex items-center justify-center gap-2">
            Kirim Link Reset <i class="bi bi-send-fill ml-1"></i>
        </button>
    </form>

    <div class="mt-10 pt-10 border-t border-slate-50 text-center">
        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            Ingat kata sandi Anda? 
            <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 transition-colors ml-1 border-b-2 border-emerald-600/20">Masuk Kembali</a>
        </p>
    </div>
</div>

<div class="mt-8 text-center">
    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">© {{ date('Y') }} Desa {{ \App\Models\SiteMeta::getVal('village_name') }}</span>
</div>
@endsection
