@extends(Auth::user()->isAparatur() ? 'layouts.apparatus' : 'layouts.admin')

@section('content')
<div class="p-0 md:p-4">
    <div class="px-4 py-8 md:px-0 md:py-4 max-w-4xl mx-auto">
        <div class="mb-10">
            <a href="{{ route('admin.news.index') }}" class="text-emerald-600 font-bold flex items-center mb-4 hover:translate-x-1 transition-transform inline-flex">
                <i class="bi bi-arrow-left mr-2"></i> Kembali ke Daftar
            </a>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Buat Berita Baru</h1>
            <p class="text-slate-500 font-medium mt-1">Sampaikan informasi penting kepada seluruh warga.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 p-8 sm:p-10">
            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-8">
                    <!-- Title -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Judul Berita</label>
                        <input type="text" name="title" required 
                               class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-medium"
                               placeholder="Contoh: Peresmian Jembatan Desa">
                        @error('title') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Category -->
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Kategori</label>
                            <select name="category" required 
                                    class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-medium">
                                <option value="Pengumuman">Pengumuman</option>
                                <option value="Kegiatan">Kegiatan</option>
                                <option value="Pembangunan">Pembangunan</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Kesehatan">Kesehatan</option>
                            </select>
                            @error('category') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Image -->
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Gambar Sampul</label>
                            <input type="file" name="image" accept="image/*"
                                   class="w-full px-6 py-3.5 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-medium file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                            <p class="text-[10px] text-slate-400 mt-2 italic">Format: JPG, PNG. Maksimal 2MB.</p>
                            @error('image') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Content -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Konten / Isi Berita</label>
                        <textarea name="content" rows="10" required 
                                  class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-medium"
                                  placeholder="Tulis isi berita di sini..."></textarea>
                        @error('content') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full py-5 bg-emerald-600 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-700 transition shadow-xl shadow-emerald-600/20">
                            Terbitkan Berita
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
