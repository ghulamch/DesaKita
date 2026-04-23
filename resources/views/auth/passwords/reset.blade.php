@extends('layouts.auth')

@section('title', 'Atur Ulang Kata Sandi')

@section('content')
<div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-16 h-16 bg-white border border-slate-100 rounded-[1.5rem] mb-6 shadow-sm">
        <i class="bi bi-shield-lock-fill text-2xl text-emerald-600"></i>
    </div>
    <h1 class="text-4xl font-black text-slate-900 font-display tracking-tight mb-2 uppercase">Re<span class="text-emerald-600">set.</span></h1>
    <p class="text-slate-500 font-medium text-sm">Perbarui Kata Sandi Akun Anda</p>
</div>

<div class="lumina-card p-10 bg-white">
    <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-2.5 ml-1">Konfirmasi Alamat E-Mail</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <i class="bi bi-envelope-fill text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                </div>
                <input type="email" name="email" required
                    class="lumina-input block w-full pl-12 pr-5 py-4 rounded-2xl text-sm"
                    placeholder="nama@email.com" value="{{ $email ?? old('email') }}">
            </div>
            @error('email')
                <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-2.5 ml-1">Kata Sandi Baru</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <i class="bi bi-key-fill text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                </div>
                <input type="password" name="password" required
                    class="lumina-input block w-full pl-12 pr-5 py-4 rounded-2xl text-sm"
                    placeholder="Min. 8 Karakter">
            </div>
            @error('password')
                <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-2.5 ml-1">Ulangi Kata Sandi Baru</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <i class="bi bi-shield-check text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                </div>
                <input type="password" name="password_confirmation" required
                    class="lumina-input block w-full pl-12 pr-5 py-4 rounded-2xl text-sm"
                    placeholder="Konfirmasi sandi baru...">
            </div>
        </div>

        <button type="submit" 
            class="lumina-btn w-full py-4.5 text-white font-black rounded-2xl transition-all uppercase tracking-[0.2em] text-xs flex items-center justify-center gap-2">
            Perbarui Kata Sandi <i class="bi bi-check2-circle text-lg"></i>
        </button>
    </form>
</div>

<div class="mt-8 text-center">
    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">© {{ date('Y') }} Desa {{ \App\Models\SiteMeta::getVal('village_name') }}</span>
</div>
@endsection
