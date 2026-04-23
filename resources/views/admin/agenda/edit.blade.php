@extends(Auth::user()->isAparatur() ? 'layouts.apparatus' : 'layouts.admin')

@section('content')
<div class="p-0 md:p-4">
    <div class="px-4 py-8 md:px-0 md:py-4 max-w-3xl mx-auto">
        <div class="mb-10">
            <a href="{{ route('agendas.index') }}" class="text-emerald-600 font-bold flex items-center mb-4 hover:translate-x-1 transition-transform inline-flex">
                <i class="bi bi-arrow-left mr-2"></i> Kembali ke Daftar
            </a>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Agenda</h1>
            <p class="text-slate-500 font-medium mt-1">Perbarui informasi kegiatan pembangunan.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 p-8 sm:p-10">
            <form action="{{ route('agendas.update', $agenda) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-8">
                    <!-- Title -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Judul Kegiatan</label>
                        <input type="text" name="title" value="{{ old('title', $agenda->title) }}" required 
                               class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-medium">
                        @error('title') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Date -->
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Tanggal Pelaksanaan</label>
                            <input type="date" name="date" value="{{ old('date', $agenda->date) }}" required 
                                   class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-medium">
                            @error('date') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Lokasi / Tempat</label>
                            <input type="text" name="location" value="{{ old('location', $agenda->location) }}" 
                                   class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-medium">
                            @error('location') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Keterangan / Deskripsi</label>
                        <textarea name="description" rows="4" 
                                  class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-medium">{{ old('description', $agenda->description) }}</textarea>
                        @error('description') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full py-5 bg-emerald-600 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-700 transition shadow-xl shadow-emerald-600/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
