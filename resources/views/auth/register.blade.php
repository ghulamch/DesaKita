@extends('layouts.auth')

@section('title', 'Pendaftaran Akun Warga')

@section('content')
<div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-16 h-16 bg-white border border-slate-100 rounded-[1.5rem] mb-6 shadow-sm">
        <i class="bi bi-person-plus-fill text-2xl text-emerald-600"></i>
    </div>
    <h1 class="text-4xl font-black text-slate-900 font-display tracking-tight mb-2 uppercase">Daf<span class="text-emerald-600">tar.</span></h1>
    <p class="text-slate-500 font-medium text-sm">Registrasi Akun Warga & UMKM</p>
</div>

<div class="lumina-card p-10 bg-white">
    <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
        @csrf

        @if($errors->any())
            <div class="p-4 bg-red-50 border border-red-100 rounded-2xl text-red-600 text-[11px] font-black uppercase tracking-wider flex items-center">
                <i class="bi bi-exclamation-octagon-fill mr-3 text-lg"></i> {{ $errors->first() }}
            </div>
        @endif

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-2.5 ml-1">Nama Lengkap Identitas</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <i class="bi bi-card-text text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                </div>
                <input type="text" name="name" required
                    class="lumina-input block w-full pl-12 pr-5 py-4 rounded-2xl text-sm"
                    placeholder="Masukan nama lengkap..." value="{{ old('name') }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-2.5 ml-1">E-Mail Sistem</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <i class="bi bi-envelope-fill text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                    </div>
                    <input type="email" name="email" required
                        class="lumina-input block w-full pl-12 pr-5 py-4 rounded-2xl text-sm"
                        placeholder="nama@email.com" value="{{ old('email') }}">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-2.5 ml-1">No. WhatsApp</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <i class="bi bi-whatsapp text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                    </div>
                    <input type="text" name="phone" required
                        class="lumina-input block w-full pl-12 pr-5 py-4 rounded-2xl text-sm"
                        placeholder="08123..." value="{{ old('phone') }}">
                </div>
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-2.5 ml-1">Kata Sandi Rahasia</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <i class="bi bi-key-fill text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                </div>
                <input type="password" name="password" required
                    class="lumina-input block w-full pl-12 pr-5 py-4 rounded-2xl text-sm"
                    placeholder="Min. 8 Karakter">
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-2.5 ml-1">Konfirmasi Kata Sandi</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <i class="bi bi-shield-check text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                </div>
                <input type="password" name="password_confirmation" required
                    class="lumina-input block w-full pl-12 pr-5 py-4 rounded-2xl text-sm"
                    placeholder="Ulangi sandi...">
            </div>
        </div>

        <button type="submit" 
            class="lumina-btn w-full py-4.5 text-white font-black rounded-2xl transition-all uppercase tracking-[0.2em] text-xs flex items-center justify-center gap-2">
            Buat Akun Sekarang <i class="bi bi-arrow-right-short text-xl"></i>
        </button>
    </form>

    <div class="mt-10 pt-10 border-t border-slate-50 text-center">
        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 transition-colors ml-1 border-b-2 border-emerald-600/20">Login Disini</a>
        </p>
    </div>
</div>

<div class="mt-8 text-center">
    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">© {{ date('Y') }} Desa {{ \App\Models\SiteMeta::getVal('village_name') }}</span>
</div>
@endsection
