@extends(Auth::user()->isAparatur() ? 'layouts.apparatus' : 'layouts.admin')

@section('content')
<div class="p-0 md:p-4">
    <div class="px-4 py-8 md:px-0 md:py-4 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Agenda {{ $villageTerm }}</h1>
            <p class="text-slate-500 font-medium mt-1">Kelola jadwal kegiatan dan acara mendatang.</p>
        </div>
        <a href="{{ route('agendas.create') }}" class="w-12 h-12 md:w-auto md:h-auto px-0 md:px-6 py-0 md:py-3 bg-emerald-600 text-white rounded-2xl font-bold hover:bg-emerald-700 transition shadow-lg shadow-emerald-600/20 flex items-center justify-center">
            <i class="bi bi-plus-lg md:mr-2 text-xl md:text-base"></i> <span class="hidden md:inline">Tambah Agenda</span>
        </a>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center">
            <i class="bi bi-check-circle-fill mr-3"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Kegiatan</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Waktu & Lokasi</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($agendas as $agenda)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="font-bold text-slate-900">{{ $agenda->title }}</div>
                                <div class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $agenda->description }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center text-sm font-medium text-slate-700">
                                    <i class="bi bi-calendar3 mr-2 text-emerald-500"></i>
                                    {{ \Carbon\Carbon::parse($agenda->date)->format('d M Y') }}
                                </div>
                                <div class="flex items-center text-xs text-slate-400 mt-1">
                                    <i class="bi bi-geo-alt mr-2"></i>
                                    {{ $agenda->location ?? '-' }}
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('agendas.edit', $agenda) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('agendas.destroy', $agenda) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-8 py-20 text-center text-slate-400">
                                <i class="bi bi-calendar-x text-5xl mb-4 block opacity-20"></i>
                                <p class="font-medium">Belum ada agenda yang terdaftar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($agendas->hasPages())
            <div class="px-8 py-5 bg-slate-50 border-t border-slate-100">
                {{ $agendas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
