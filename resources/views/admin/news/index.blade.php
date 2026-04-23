@extends(Auth::user()->isAparatur() ? 'layouts.apparatus' : 'layouts.admin')

@section('content')
<div class="p-0 md:p-4">
    <div class="px-4 py-8 md:px-0 md:py-4 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Berita {{ $villageTerm }}</h1>
            <p class="text-slate-500 font-medium mt-1">Publikasi informasi dan kegiatan terbaru untuk warga.</p>
        </div>
        <a href="{{ route('admin.news.create') }}" class="w-12 h-12 md:w-auto md:h-auto px-0 md:px-6 py-0 md:py-3 bg-emerald-600 text-white rounded-2xl font-bold hover:bg-emerald-700 transition shadow-lg shadow-emerald-600/20 flex items-center justify-center">
            <i class="bi bi-plus-lg md:mr-2 text-xl md:text-base"></i> <span class="hidden md:inline">Buat Berita</span>
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
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Berita</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Kategori</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Tanggal</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($news as $n)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-slate-100 flex-shrink-0">
                                        @if($n->image)
                                            <img src="{{ asset('storage/'.$n->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300"><i class="bi bi-image"></i></div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 line-clamp-1">{{ $n->title }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">{{ Str::limit(strip_tags($n->content), 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                                    {{ $n->category }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-sm font-medium text-slate-500">
                                {{ $n->created_at->format('d M Y') }}
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.news.edit', $n) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $n) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
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
                            <td colspan="4" class="px-8 py-20 text-center text-slate-400">
                                <i class="bi bi-newspaper text-5xl mb-4 block opacity-20"></i>
                                <p class="font-medium">Belum ada berita yang diterbitkan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($news->hasPages())
            <div class="px-8 py-5 bg-slate-50 border-t border-slate-100">
                {{ $news->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
