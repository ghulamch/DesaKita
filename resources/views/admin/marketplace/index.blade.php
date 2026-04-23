@extends(Auth::user()->isAparatur() ? 'layouts.apparatus' : 'layouts.admin')

@section('content')
<div class="p-0 md:p-4">
    <div class="px-4 py-8 md:px-0 md:py-4">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Moderasi Lapak</h1>
        <p class="text-slate-500 font-medium mt-1">Pantau dan kelola produk yang dijual oleh warga di marketplace.</p>
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
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Penjual</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Harga</th>
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
                                        <div class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">ID: #{{ $p->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="font-bold text-slate-700 text-sm">{{ $p->seller_name }}</div>
                                <div class="text-xs text-slate-400 mt-1"><i class="bi bi-whatsapp"></i> {{ $p->phone }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-sm font-black text-emerald-600">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <form action="{{ route('admin.marketplace.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus dagangan ini karena melanggar aturan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-500 hover:text-white transition-all text-xs font-bold flex items-center ml-auto">
                                        <i class="bi bi-trash mr-2"></i> Take Down
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center text-slate-400">
                                <i class="bi bi-shop text-5xl mb-4 block opacity-20"></i>
                                <p class="font-medium">Belum ada dagangan warga di marketplace.</p>
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
