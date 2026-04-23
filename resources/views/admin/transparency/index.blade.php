@extends('layouts.admin')

@section('title', 'Manajemen Transparansi')

@section('content')
<div class="space-y-10" x-data="{ 
    showModal: false, 
    showSummaryModal: false,
    editMode: false, 
    item: { id: null, year: '{{ date('Y') }}', type: 'Pendapatan', category: '', amount: 0, planned_amount: 0, volume: '', satuan: 'PAKET', satuan_custom: '', output: '' },
    summaryItem: { year: '', pagu: 0, tahap1: 0, tahap2: 0, tahap3: 0 },
    
    // Helper untuk format rupiah (tampilan saja)
    formatRupiah(val) {
        if (!val && val !== 0) return '';
        let str = val.toString().replace(/[^0-9]/g, '');
        return str.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    },
    
    // Helper untuk parse kembali ke angka murni
    parseNumber(val) {
        if (!val) return 0;
        return parseInt(val.toString().replace(/[^0-9]/g, '')) || 0;
    }
}">
<div class="px-4 py-8 md:px-0 md:py-4">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6" data-aos="fade-down">
            <div>
                <h1 class="text-4xl font-extrabold text-slate-900 font-display tracking-tight mb-2">Transparansi Anggaran</h1>
                <p class="text-slate-500 text-lg">Kelola data APBDes dan sinkronisasi otomatis dari portal Jaga.id.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <button @click="showModal = true; editMode = false; item = { id: null, year: '{{ date('Y') }}', type: 'Pendapatan', category: '', amount: 0, planned_amount: 0, volume: '', satuan: 'PAKET', satuan_custom: '', output: '' }" class="w-12 h-12 md:w-auto md:h-auto px-0 md:px-6 py-0 md:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl shadow-lg shadow-emerald-100 transition-all flex items-center justify-center">
                    <i class="bi bi-plus-lg md:mr-2 text-xl md:text-base"></i> <span class="hidden md:inline">Tambah Data Manual</span>
                </button>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center shadow-sm animate-fade-in" data-aos="zoom-in">
            <i class="bi bi-check-circle-fill mr-3 text-xl"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-8 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl flex items-center shadow-sm animate-fade-in" data-aos="zoom-in">
            <i class="bi bi-exclamation-triangle-fill mr-3 text-xl"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Scraper & Stats -->
            <div class="space-y-8">
                <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-8" data-aos="fade-right" x-data="{ selectedYear: '{{ date('Y') }}' }">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl">
                                <i class="bi bi-robot"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-slate-900 font-display">Scraper Otomatis</h2>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.transparency.scrape') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2 tracking-widest">Pilih Tahun Anggaran</label>
                            <select name="year" x-model="selectedYear" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                                @for($y = date('Y'); $y >= 2022; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 px-6 rounded-2xl shadow-lg shadow-emerald-100 transition-all flex items-center justify-center group text-sm">
                            <i class="bi bi-cloud-download mr-3 group-hover:translate-y-1 transition-transform"></i>
                            Sinkronisasi
                        </button>
                    </form>
                </div>

                <div class="bg-slate-900 rounded-[2rem] shadow-xl shadow-slate-200 border border-slate-800 p-8 text-white" data-aos="fade-up">
                    <h3 class="text-lg font-bold mb-6 font-display opacity-90 tracking-wide uppercase">Ringkasan {{ date('Y') }}</h3>
                    <div class="space-y-6">
                        @php
                            $currentYear = date('Y');
                            $summaryJson = \App\Models\SiteMeta::getVal("budget_summary_{$currentYear}");
                            $summary = $summaryJson ? json_decode($summaryJson, true) : null;
                            $pagu = $summary['pagu'] ?? \App\Models\Budget::where('year', $currentYear)->where('type', 'Pendapatan')->sum('amount');
                            $cair = ($summary['tahap1'] ?? 0) + ($summary['tahap2'] ?? 0) + ($summary['tahap3'] ?? 0);
                            $belanja = \App\Models\Budget::where('year', $currentYear)->where('type', 'Belanja')->sum('amount');
                        @endphp
                        <div>
                            <p class="text-[9px] opacity-50 uppercase font-black tracking-[0.2em] mb-1 text-slate-400">Pagu Target</p>
                            <p class="text-xl font-black italic">Rp {{ number_format($pagu, 0, ',', '.') }}</p>
                        </div>
                        <div class="h-px bg-white/10"></div>
                        <div>
                            <p class="text-[9px] opacity-50 uppercase font-black tracking-[0.2em] mb-1 text-slate-400">Penyaluran (Cair)</p>
                            <p class="text-xl font-black text-blue-400">Rp {{ number_format($cair, 0, ',', '.') }}</p>
                        </div>
                        <div class="h-px bg-white/10"></div>
                        <div>
                            <p class="text-[9px] opacity-50 uppercase font-black tracking-[0.2em] mb-1 text-slate-400">Belanja (Realisasi)</p>
                            <p class="text-xl font-black text-emerald-400">Rp {{ number_format($belanja, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Data Tables -->
            <div class="lg:col-span-2 space-y-12">
                @forelse($budgetsByYear as $year => $items)
                <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden" data-aos="fade-left">
                    <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-slate-50/10">
                        <div class="flex items-center space-x-6">
                            <div class="w-16 h-16 bg-slate-900 rounded-3xl flex items-center justify-center text-white text-2xl font-black shadow-lg">
                                {{ $year }}
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900 font-display uppercase tracking-tight">TA {{ $year }}</h3>
                                <div class="flex items-center space-x-4 mt-1">
                                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                                        {{ $items->count() }} Kegiatan
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <button @click="showSummaryModal = true; summaryItem = { year: '{{ $year }}', pagu: {{ $summaries[$year]['pagu'] ?? 0 }}, tahap1: {{ $summaries[$year]['tahap1'] ?? 0 }}, tahap2: {{ $summaries[$year]['tahap2'] ?? 0 }}, tahap3: {{ $summaries[$year]['tahap3'] ?? 0 }} }" class="h-10 px-4 bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm flex items-center border border-emerald-100">
                                <i class="bi bi-sliders mr-2"></i> Edit Pagu
                            </button>
                            <form action="{{ route('admin.transparency.destroy-year', $year) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus seluruh data tahun {{ $year }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="h-10 px-5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm flex items-center border border-red-100">
                                    <i class="bi bi-trash mr-2"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-6">
                        @php
                            $sumCair = ($summaries[$year]['tahap1'] ?? 0) + ($summaries[$year]['tahap2'] ?? 0) + ($summaries[$year]['tahap3'] ?? 0);
                            $sumBelanja = $items->where('type', 'Belanja')->sum('amount');
                            $sumPagu = $summaries[$year]['pagu'] ?? 0;
                        @endphp
                        <div class="p-5 bg-white rounded-2xl border border-slate-100 shadow-sm text-slate-600">
                            <div class="text-[9px] font-black uppercase tracking-widest mb-1 opacity-50">Pagu Anggaran</div>
                            <div class="text-lg font-black italic">Rp {{ number_format($sumPagu, 0, ',', '.') }}</div>
                        </div>
                        <div class="p-5 bg-white rounded-2xl border border-slate-100 shadow-sm text-blue-600">
                            <div class="text-[9px] font-black uppercase tracking-widest mb-1 opacity-50">Tuntas Penyaluran</div>
                            <div class="text-lg font-black italic">Rp {{ number_format($sumCair, 0, ',', '.') }}</div>
                        </div>
                        <div class="p-5 bg-white rounded-2xl border border-emerald-100 shadow-sm text-emerald-600">
                            <div class="text-[9px] font-black uppercase tracking-widest mb-1 opacity-50">Tuntas Belanja</div>
                            <div class="text-lg font-black italic">Rp {{ number_format($sumBelanja, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-slate-50/10">
                                    <th class="px-8 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Detail & Output</th>
                                    <th class="px-8 py-4 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">Volume / Satuan</th>
                                    <th class="px-8 py-4 text-right text-[10px] font-bold text-slate-400 uppercase tracking-widest">Realisasi (Rp)</th>
                                    <th class="px-8 py-4 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-24">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($items as $b)
                                <tr class="hover:bg-slate-50/30 transition-all group">
                                    <td class="px-8 py-5">
                                        <div class="text-xs font-bold text-slate-800 leading-snug">{{ $b->category }}</div>
                                        <div class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-1">
                                            <i class="bi bi-arrow-return-right mr-1 opacity-50"></i>{{ $b->output ?: 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <div class="text-xs font-bold text-slate-900">{{ $b->volume ?: '-' }}</div>
                                        <div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ $b->satuan }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-right font-black text-slate-900 text-sm">
                                        Rp {{ number_format($b->amount, 0, ',', '.') }}
                                        <div class="text-[9px] leading-3 text-slate-400 font-bold uppercase tracking-widest">{{ $b->type }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <div class="flex items-center justify-center space-x-3">
                                            @php
                                                $predefinedUnits = ['PAKET', 'METER (M)', 'METER PERSEGI (M2)', 'UNIT', 'KALI', 'ORANG', 'ORANG/BULAN', 'HARI', 'KEGIATAN', 'LS (LUMP SUM)'];
                                                $isCustom = !in_array(strtoupper($b->satuan), $predefinedUnits);
                                            @endphp
                                            <button @click="showModal = true; editMode = true; item = { 
                                                    id: {{ $b->id }}, 
                                                    year: {{ $b->year }}, 
                                                    type: '{{ $b->type }}', 
                                                    category: '{{ addslashes($b->category) }}', 
                                                    amount: {{ $b->amount }}, 
                                                    planned_amount: {{ $b->planned_amount ?? 0 }}, 
                                                    volume: '{{ $b->volume }}', 
                                                    satuan: '{{ $isCustom ? 'LAINNYA' : strtoupper($b->satuan) }}', 
                                                    satuan_custom: '{{ $isCustom ? strtoupper($b->satuan) : '' }}',
                                                    output: '{{ addslashes($b->output) }}' 
                                                }" class="text-slate-400 hover:text-emerald-600 transition-colors">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('admin.transparency.destroy', $b->id) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Hapus item ini?')" class="text-slate-300 hover:text-red-500 transition-colors">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-20 text-center">
                    <i class="bi bi-folder-x text-5xl text-slate-200 mb-4 block"></i>
                    <p class="text-slate-400 text-sm">Data belum tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- MODAL: Tambah/Edit Anggaran -->
    <template x-teleport="body">
        <div x-show="showModal" class="fixed inset-0 z-[9999] overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal" x-transition.opacity @click="showModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div x-show="showModal" x-transition.scale.95 
                     class="inline-block w-full max-w-2xl overflow-hidden text-left align-bottom transition-all transform bg-white rounded-[2.5rem] shadow-2xl sm:my-8 sm:align-middle relative z-[10000]">
                    
                    <div class="bg-white p-8 sm:p-10">
                        <div class="flex justify-between items-center mb-8 border-b border-slate-100 pb-6">
                            <h3 class="text-2xl font-bold text-slate-900 font-display" x-text="editMode ? 'Edit Anggaran' : 'Tambah Anggaran Manual'"></h3>
                            <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                                <i class="bi bi-x-circle-fill text-2xl"></i>
                            </button>
                        </div>

                        <form :action="editMode ? '{{ route('admin.transparency.index') }}/' + item.id : '{{ route('admin.transparency.store') }}'" method="POST" class="space-y-6">
                            @csrf
                            <template x-if="editMode">
                                <input type="hidden" name="_method" value="PATCH">
                            </template>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Nama Kegiatan</label>
                                    <input type="text" name="category" x-model="item.category" class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 font-bold" required>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Tahun / Tipe</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="number" name="year" x-model="item.year" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 font-bold">
                                        <select name="type" x-model="item.type" class="w-full px-2 py-3 rounded-xl border border-slate-200 bg-slate-50 font-black uppercase text-[10px]">
                                            <option value="Pendapatan">Pendapatan</option>
                                            <option value="Belanja">Belanja</option>
                                            <option value="Pembiayaan">Pembiayaan</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Output</label>
                                    <input type="text" name="output" x-model="item.output" class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50 font-bold">
                                </div>

                                <div x-show="item.type !== 'Belanja'">
                                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Pagu (Target APBDes)</label>
                                    <div class="relative">
                                        <span class="absolute left-5 top-1/2 -translate-y-1/2 font-bold text-slate-400">Rp</span>
                                        <input type="text" 
                                               :value="formatRupiah(item.planned_amount)"
                                               @input="item.planned_amount = parseNumber($event.target.value); $event.target.value = formatRupiah(item.planned_amount)"
                                               class="w-full pl-12 pr-5 py-4 rounded-2xl border border-slate-200 bg-slate-50 font-black text-slate-900">
                                        <input type="hidden" name="planned_amount" x-model="item.planned_amount">
                                    </div>
                                </div>

                                <div :class="item.type === 'Belanja' ? 'md:col-span-2' : ''">
                                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2" x-text="item.type === 'Belanja' ? 'Total Realisasi Pembayaran' : 'Total Penyaluran'"></label>
                                    <div class="relative">
                                        <span class="absolute left-5 top-1/2 -translate-y-1/2 font-bold text-emerald-400 text-lg">Rp</span>
                                        <input type="text" 
                                               :value="formatRupiah(item.amount)"
                                               @input="item.amount = parseNumber($event.target.value); $event.target.value = formatRupiah(item.amount)"
                                               class="w-full pl-12 pr-5 py-4 rounded-2xl border border-emerald-200 bg-emerald-50 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 text-emerald-900 font-black text-xl shadow-inner outline-none transition-all" required>
                                        <input type="hidden" name="amount" x-model="item.amount">
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <div class="grid grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Volume</label>
                                            <input type="text" name="volume" x-model="item.volume" class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50 font-bold">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Satuan</label>
                                            <select x-model="item.satuan" class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50 font-bold uppercase transition-all">
                                                <option value="PAKET">PAKET</option>
                                                <option value="METER (M)">METER (M)</option>
                                                <option value="METER PERSEGI (M2)">METER PERSEGI (M2)</option>
                                                <option value="UNIT">UNIT</option>
                                                <option value="KALI">KALI</option>
                                                <option value="ORANG">ORANG</option>
                                                <option value="ORANG/BULAN">ORANG/BULAN</option>
                                                <option value="HARI">HARI</option>
                                                <option value="KEGIATAN">KEGIATAN</option>
                                                <option value="LS (LUMP SUM)">LS (LUMP SUM)</option>
                                                <option value="LAINNYA">LAINNYA (MANUAL)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="md:col-span-2" x-show="item.satuan === 'LAINNYA'" x-transition>
                                    <label class="block text-xs font-black text-emerald-600 uppercase tracking-widest mb-2">Ketik Satuan Custom</label>
                                    <input type="text" x-model="item.satuan_custom" @input="item.satuan_custom = $event.target.value.toUpperCase()" class="w-full px-5 py-4 rounded-2xl border border-emerald-200 bg-emerald-50 text-emerald-900 font-black uppercase shadow-inner outline-none">
                                </div>
                                <input type="hidden" name="satuan" :value="item.satuan === 'LAINNYA' ? item.satuan_custom : item.satuan">
                            </div>

                            <div class="mt-8">
                                <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-bold py-5 rounded-[1.5rem] shadow-2xl transition-all flex items-center justify-center">
                                    <i class="bi bi-check-lg mr-2 text-xl"></i>
                                    <span x-text="editMode ? 'Simpan Perubahan' : 'Rekam Data Anggaran'"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- MODAL: Edit Summary/Pagu -->
    <template x-teleport="body">
        <div x-show="showSummaryModal" class="fixed inset-0 z-[9999] overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showSummaryModal" x-transition.opacity @click="showSummaryModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div x-show="showSummaryModal" x-transition.scale.95 
                     class="inline-block w-full max-w-lg overflow-hidden text-left align-bottom transition-all transform bg-white rounded-[2.5rem] shadow-2xl sm:my-8 sm:align-middle relative z-[10000]">
                    <div class="bg-white p-8">
                        <h3 class="text-2xl font-bold text-slate-900 mb-8 border-b pb-4">Edit Pagu APBDes <span x-text="summaryItem.year"></span></h3>
                        <form action="{{ route('admin.transparency.update-summary') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="year" x-model="summaryItem.year">
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Total Pagu Setahun</label>
                                <div class="relative">
                                    <span class="absolute left-5 top-1/2 -translate-y-1/2 font-bold text-slate-400">Rp</span>
                                    <input type="text" 
                                           :value="formatRupiah(summaryItem.pagu)"
                                           @input="summaryItem.pagu = parseNumber($event.target.value); $event.target.value = formatRupiah(summaryItem.pagu)"
                                           class="w-full pl-12 pr-5 py-4 rounded-2xl border border-slate-200 bg-slate-50 font-bold outline-none">
                                    <input type="hidden" name="pagu" x-model="summaryItem.pagu">
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach(['tahap1', 'tahap2', 'tahap3'] as $t)
                                <div>
                                    <label class="block text-[8px] font-black uppercase text-slate-400 mb-1">Tahap {{ substr($t, -1) }}</label>
                                    <input type="number" name="{{ $t }}" x-model="summaryItem.{{ $t }}" class="w-full px-3 py-3 rounded-xl border border-slate-100 bg-slate-50 text-xs font-bold">
                                </div>
                                @endforeach
                            </div>
                            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-5 rounded-2xl shadow-xl transition-all">
                                Update Data Pagu
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </template>
    </div>
</div>
@endsection
