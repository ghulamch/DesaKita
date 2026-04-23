@extends('setup.layout')

@section('content')
<div class="space-y-8">
    <div class="flex items-center space-x-4 mb-6">
        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-black">2</div>
        <h2 class="text-xl font-black text-slate-800">Konfigurasi Database</h2>
    </div>

    @if(session('error'))
        <div class="p-4 bg-rose-50 text-rose-700 rounded-2xl text-xs font-bold border border-rose-100 flex items-center space-x-3">
            <i class="bi bi-x-circle-fill"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('setup.configure') }}" method="POST" class="space-y-5" x-data="{ db_type: 'mysql' }">
        @csrf
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Tipe Database</label>
            <select name="db_connection" x-model="db_type" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition font-bold text-slate-700">
                <option value="mysql">MySQL / MariaDB</option>
                <option value="pgsql">PostgreSQL</option>
                <option value="sqlite">SQLite</option>
                <option value="sqlsrv">Microsoft SQL Server</option>
            </select>
        </div>

        <template x-if="db_type !== 'sqlite'">
            <div class="space-y-5">
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">DB Host</label>
                        <input type="text" name="db_host" value="127.0.0.1" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition font-bold text-slate-700">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Port</label>
                        <input type="text" name="db_port" :value="db_type === 'pgsql' ? '5432' : '3306'" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition font-bold text-slate-700 text-center">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Username Database</label>
                    <input type="text" name="db_user" value="root" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition font-bold text-slate-700">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Password Database</label>
                    <input type="password" name="db_pass" placeholder="Boleh kosong..." class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition font-bold text-slate-700">
                </div>
            </div>
        </template>

        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1" x-text="db_type === 'sqlite' ? 'Path Database (Absolut)' : 'Nama Database'"></label>
            <input type="text" name="db_name" :placeholder="db_type === 'sqlite' ? '/var/www/database/database.sqlite' : 'laravel_desa'" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition font-bold text-slate-700">
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black uppercase tracking-widest flex items-center justify-center space-x-2 hover:bg-emerald-700 transition shadow-lg shadow-emerald-100 active:scale-95">
                <span>Tes Koneksi & Simpan</span>
                <i class="bi bi-database-fill-gear"></i>
            </button>
        </div>
    </form>
</div>
@endsection
