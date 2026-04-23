@extends('layouts.admin') 

@section('title', 'Manajemen User')

@section('content')
<div class="p-0 md:p-4">
    <div class="px-4 py-8 md:px-0 md:py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 font-display">Manajemen Pengguna.</h1>
            <p class="text-slate-500 font-medium">Kelola hak akses Admin, Aparatur, dan Akun Warga.</p>
        </div>
        <button onclick="document.getElementById('addUserModal').classList.remove('hidden')" 
            class="w-full md:w-auto px-6 py-4 bg-slate-900 text-white rounded-2xl font-bold flex items-center justify-center gap-3 hover:bg-slate-800 transition shadow-xl shadow-slate-200">
            <i class="bi bi-person-plus-fill text-xl"></i> <span>Tambah User Baru</span>
        </button>
    </div>

    <!-- Filter Roles -->
    <div class="flex flex-wrap items-center gap-3 mb-8">
        <a href="{{ route('admin.users.index') }}" 
           class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all {{ !request('role') ? 'bg-slate-900 text-white shadow-lg' : 'bg-white border border-slate-200 text-slate-500 hover:border-slate-300' }}">
            Semua Pengguna
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" 
           class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all {{ request('role') == 'admin' ? 'bg-amber-500 text-white shadow-lg shadow-amber-200' : 'bg-white border border-slate-200 text-slate-500 hover:border-slate-300' }}">
            Administrator
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'aparatur']) }}" 
           class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all {{ request('role') == 'aparatur' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-200' : 'bg-white border border-slate-200 text-slate-500 hover:border-slate-300' }}">
            Aparatur Desa
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'warga']) }}" 
           class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all {{ request('role') == 'warga' ? 'bg-blue-500 text-white shadow-lg shadow-blue-200' : 'bg-white border border-slate-200 text-slate-500 hover:border-slate-300' }}">
            Akun Warga
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 font-bold flex items-center gap-3">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl text-red-700 font-bold flex items-center gap-3">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Nama & Email</th>
                    <th class="px-8 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Role</th>
                    <th class="px-8 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">WhatsApp</th>
                    <th class="px-8 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                    <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-500 font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-slate-900">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-400 font-medium">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @php
                                $roleColors = [
                                    'admin' => 'bg-amber-100 text-amber-700 border-amber-200',
                                    'aparatur' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    'warga' => 'bg-blue-100 text-blue-700 border-blue-200',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border {{ $roleColors[$user->role] ?? 'bg-slate-100' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center text-xs font-bold text-slate-700">
                            {{ $user->phone ?: '-' }}
                        </td>
                        <td class="px-8 py-6 text-center">
                            @if($user->is_active)
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border bg-emerald-100 text-emerald-700 border-emerald-200">
                                    Aktif
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border bg-rose-100 text-rose-700 border-rose-200">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2">
                                @if($user->id !== Auth::id())
                                    <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST">
                                        @csrf
                                        <button class="w-10 h-10 rounded-xl {{ $user->is_active ? 'bg-amber-50 text-amber-500 hover:bg-amber-500 hover:text-white' : 'bg-emerald-50 text-emerald-500 hover:bg-emerald-500 hover:text-white' }} transition flex items-center justify-center" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="bi {{ $user->is_active ? 'bi-shield-fill-x' : 'bi-shield-fill-check' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition flex items-center justify-center">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Active Account</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah User -->
<div id="addUserModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-[3rem] w-full max-w-lg shadow-2xl overflow-hidden animate-[zoomIn_0.3s_ease-out]">
        <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="text-xl font-black text-slate-900 font-display">Tambah Akun Baru</h3>
            <button onclick="document.getElementById('addUserModal').classList.add('hidden')" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition shadow-sm">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 focus:border-emerald-500 outline-none transition text-sm font-medium" placeholder="Nama staf...">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Email Karyawan</label>
                <input type="email" name="email" required class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 focus:border-emerald-500 outline-none transition text-sm font-medium" placeholder="email@desa.go.id">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Role Akun</label>
                <select name="role" required class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 focus:border-emerald-500 outline-none transition text-sm font-black uppercase tracking-widest">
                    <option value="aparatur">Aparatur (Staf Konten)</option>
                    <option value="admin">Administrator (Full Akses)</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kata Sandi</label>
                <input type="password" name="password" required class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 focus:border-emerald-500 outline-none transition text-sm font-medium" placeholder="Min. 8 karakter">
            </div>
            <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-2xl shadow-xl shadow-emerald-500/20 transition-all uppercase tracking-widest text-sm">
                Buat Akun Sekarang
            </button>
        </form>
    </div>
</div>

</div>

<style>
    @keyframes zoomIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
@endsection
