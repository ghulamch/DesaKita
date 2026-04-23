@extends('setup.layout')

@section('content')
<div class="text-center space-y-8">
    <div class="w-24 h-24 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto shadow-inner">
        <i class="bi bi-check-lg text-5xl"></i>
    </div>
    
    <div class="space-y-4">
        <h2 class="text-3xl font-black text-slate-800 font-display uppercase tracking-widest">Instalasi Berhasil!</h2>
        <p class="text-slate-500 font-medium">Portal Desa Anda kini sudah siap digunakan. Semua tabel database telah dibangun dan akun admin Anda telah aktif.</p>
    </div>

    <div class="p-6 bg-amber-50 text-amber-800 rounded-[2rem] border border-amber-100 text-sm font-bold flex flex-col items-center space-y-3">
        <i class="bi bi-shield-lock-fill text-3xl"></i>
        <span>PENTING! Demi keamanan, sistem telah otomatis mengunci fitur instalasi ini. Anda tidak bisa lagi mengakses halaman setup kecuali file keamanan dihapus secara manual dari server.</span>
    </div>

    <div class="pt-6">
        <a href="/" class="w-full py-5 bg-emerald-600 text-white rounded-[2rem] font-black uppercase tracking-[0.2em] flex items-center justify-center space-x-3 hover:bg-emerald-700 transition shadow-xl shadow-emerald-100 active:scale-95 group">
            <span>Masuk ke Beranda Desa</span>
            <i class="bi bi-house-door-fill group-hover:-translate-y-1 transition-transform"></i>
        </a>
    </div>
</div>
@endsection
