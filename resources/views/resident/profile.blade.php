@extends('layouts.resident')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="max-w-4xl mx-auto p-0 md:p-4">
    <div class="px-4 pt-8 pb-4 md:px-0 md:pt-0">
        <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Pengaturan Profil ⚙️</h1>
        <p class="text-slate-500 font-medium mt-1 text-sm">Kelola data pribadi dan keamanan akun Anda.</p>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <!-- Profile Info Card -->
        <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-5 md:p-10">
                <form action="{{ route('resident.profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="flex items-center gap-4 pb-6 border-b border-slate-50">
                        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-xl text-emerald-600 font-black shrink-0">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 leading-tight">{{ Auth::user()->name }}</h3>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mt-1">Warga Digital {{ $villageName }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                                   class="w-full px-5 py-3.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all font-bold text-slate-800 text-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nomor Telepon (WhatsApp)</label>
                            <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" 
                                   class="w-full px-5 py-3.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all font-bold text-slate-800 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                               class="w-full px-5 py-3.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all font-bold text-slate-800 text-sm" disabled>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 px-10 rounded-xl shadow-lg shadow-emerald-200 transition-all flex items-center justify-center uppercase tracking-widest text-xs">
                            <i class="bi bi-person-check-fill mr-3"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Card -->
        <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-5 md:p-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-xl">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Keamanan & Password</h3>
                </div>

                <form action="{{ route('resident.profile.password') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" 
                               class="w-full px-5 py-3.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all font-bold text-slate-800 text-sm">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kata Sandi Baru</label>
                            <input type="password" name="password" 
                                   class="w-full px-5 py-3.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all font-bold text-slate-800 text-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full px-5 py-3.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all font-bold text-slate-800 text-sm">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full md:w-auto bg-slate-900 hover:bg-black text-white font-black py-4 px-10 rounded-xl shadow-lg transition-all flex items-center justify-center uppercase tracking-widest text-xs">
                            <i class="bi bi-key-fill mr-3"></i> Perbarui Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
