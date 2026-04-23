@extends('setup.layout')

@section('content')
<div class="space-y-8">
    <div class="flex items-center space-x-4 mb-6">
        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-black">3</div>
        <h2 class="text-xl font-black text-slate-800">Akun Administrator Pertama</h2>
    </div>

    <div class="p-4 bg-emerald-50 text-emerald-700 rounded-2xl text-[10px] font-bold border border-emerald-100 flex items-start space-x-3 uppercase tracking-wider">
        <i class="bi bi-info-circle-fill text-sm"></i>
        <span>Setelah Anda menekan tombol di bawah, sistem akan otomatis melakukan Migrasi Tabel Database sekaligus mendaftarkan akun Admin Anda. Mohon tunggu beberapa detik.</span>
    </div>

    @if(session('error'))
        <div class="p-4 bg-rose-50 text-rose-700 rounded-2xl text-xs font-bold border border-rose-100 flex items-center space-x-3">
            <i class="bi bi-x-circle-fill"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('setup.install') }}" method="POST" class="space-y-5">
        @csrf
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Nama Lengkap Admin</label>
            <input type="text" name="admin_name" value="{{ old('admin_name') }}" placeholder="Contoh: Admin Desa" class="w-full px-5 py-4 bg-slate-50 border {{ $errors->has('admin_name') ? 'border-rose-300' : 'border-slate-200' }} rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition font-bold text-slate-700">
            @error('admin_name') <p class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</p> @enderror
        </div>
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Alamat Email</label>
            <input type="email" name="admin_email" value="{{ old('admin_email') }}" placeholder="admin@desa.go.id" class="w-full px-5 py-4 bg-slate-50 border {{ $errors->has('admin_email') ? 'border-rose-300' : 'border-slate-200' }} rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition font-bold text-slate-700">
            @error('admin_email') <p class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</p> @enderror
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Password</label>
                <input type="password" name="admin_password" class="w-full px-5 py-4 bg-slate-50 border {{ $errors->has('admin_password') ? 'border-rose-300' : 'border-slate-200' }} rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition font-bold text-slate-700">
                @error('admin_password') <p class="text-rose-500 text-[10px] font-bold px-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Konfirmasi Password</label>
                <input type="password" name="admin_password_confirmation" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition font-bold text-slate-700">
            </div>
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black uppercase tracking-widest flex items-center justify-center space-x-2 hover:bg-emerald-700 transition shadow-lg shadow-emerald-100 active:scale-95">
                <span>Mulai Instalasi Sekarang</span>
                <i class="bi bi-gear-fill"></i>
            </button>
        </div>
    </form>
</div>
@endsection
