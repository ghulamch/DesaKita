@extends('layouts.resident')

@section('content')
<div class="p-0 md:p-4">
    <div class="px-4 py-8 md:px-0 md:py-4 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Dagangan Saya</h1>
            <p class="text-slate-500 font-medium mt-1">Kelola produk yang Anda pasarkan di Marketplace {{ $villageTerm }}.</p>
        </div>
        <a href="{{ route('resident.products.create') }}" class="w-12 h-12 md:w-auto md:h-auto px-0 md:px-6 py-0 md:py-3 bg-emerald-600 text-white rounded-2xl font-bold hover:bg-emerald-700 transition shadow-lg shadow-emerald-600/20 flex items-center justify-center">
            <i class="bi bi-plus-lg md:mr-2 text-xl md:text-base"></i> <span class="hidden md:inline">Tambah Produk</span>
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
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Produk</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Harga</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($products as $p)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-slate-100 flex-shrink-0">
                                        @if($p->image)
                                            <img src="{{ asset('storage/'.$p->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300"><i class="bi bi-image"></i></div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 line-clamp-1">{{ $p->name }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">{{ $p->is_active ? 'Tayang ke Publik' : 'Disembunyikan' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-sm font-black text-emerald-600">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-8 py-6">
                                @if($p->is_active)
                                    <span class="flex items-center gap-2 text-[10px] font-black text-emerald-500 uppercase tracking-widest">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-ping"></span>
                                        Aktif di Pasar
                                    </span>
                                @else
                                    <span class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end space-x-2">
                                    <form action="{{ route('resident.products.toggle', $p) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="p-2 {{ $p->is_active ? 'bg-slate-100 text-slate-600' : 'bg-emerald-100 text-emerald-600' }} rounded-lg hover:opacity-80 transition" title="{{ $p->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="bi {{ $p->is_active ? 'bi-eye-slash-fill' : 'bi-eye-fill' }}"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('resident.products.edit', $p) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('resident.products.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus dagangan ini?')">
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
                                <i class="bi bi-box-seam text-5xl mb-4 block opacity-20"></i>
                                <p class="font-medium">Anda belum memiliki produk yang dipasarkan.</p>
                                <a href="{{ route('resident.products.create') }}" class="mt-4 inline-block text-emerald-600 font-bold hover:underline">Tambah dagangan sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div class="px-8 py-5 bg-slate-50 border-t border-slate-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
