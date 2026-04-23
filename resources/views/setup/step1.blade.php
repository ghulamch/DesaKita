@extends('setup.layout')

@section('content')
<div class="space-y-8">
    <div class="flex items-center space-x-4 mb-6">
        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-black">1</div>
        <h2 class="text-xl font-black text-slate-800">Persyaratan Sistem & Izin Folder</h2>
    </div>

    <!-- Requirements -->
    <div class="space-y-3">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Ekstensi PHP</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($requirements as $label => $met)
                <div class="flex items-center justify-between p-3 rounded-2xl {{ $met ? 'bg-emerald-50/50 border border-emerald-100/50' : 'bg-rose-50 border border-rose-100' }}">
                    <span class="text-xs font-bold {{ $met ? 'text-emerald-700' : 'text-rose-700' }}">{{ $label }}</span>
                    <i class="bi {{ $met ? 'bi-check-circle-fill text-emerald-500' : 'bi-x-circle-fill text-rose-500' }}"></i>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Permissions -->
    <div class="space-y-3">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Izin Tulis Folder (Writable)</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($permissions as $label => $met)
                <div class="flex items-center justify-between p-3 rounded-2xl {{ $met ? 'bg-emerald-50/50 border border-emerald-100/50' : 'bg-rose-50 border border-rose-100' }}">
                    <span class="text-xs font-bold {{ $met ? 'text-emerald-700' : 'text-rose-700' }}">{{ $label }}</span>
                    <i class="bi {{ $met ? 'bi-check-circle-fill text-emerald-500' : 'bi-x-circle-fill text-rose-500' }}"></i>
                </div>
            @endforeach
        </div>
    </div>

    <div class="pt-6 border-t border-slate-100">
        @if($allRequirementsMet && $allPermissionsMet)
            <a href="{{ route('setup.step2') }}" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black uppercase tracking-widest flex items-center justify-center space-x-2 hover:bg-emerald-700 transition shadow-lg shadow-emerald-100 active:scale-95">
                <span>Lanjutkan ke Pengaturan Database</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        @else
            <div class="p-4 bg-rose-50 text-rose-700 rounded-2xl text-xs font-bold flex items-center space-x-3">
                <i class="bi bi-exclamation-triangle-fill text-lg"></i>
                <span>Maaf, beberapa persyaratan belum terpenuhi. Silakan perbaiki konfigurasi server Anda dan segarkan halaman ini.</span>
            </div>
            <button onclick="window.location.reload()" class="w-full mt-4 py-4 bg-slate-200 text-slate-600 rounded-2xl font-black uppercase tracking-widest">
                Segarkan Halaman
            </button>
        @endif
    </div>
</div>
@endsection
