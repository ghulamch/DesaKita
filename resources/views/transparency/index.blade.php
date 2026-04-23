@extends('layouts.app')

@php
    $term = \App\Models\SiteMeta::getVal('village_term', 'Desa');
    $villageTerm = ($term === 'Lainnya') ? \App\Models\SiteMeta::getVal('village_term_custom', 'Desa') : $term;
@endphp

@section('title', 'Transparansi Anggaran ' . $villageTerm)

@section('content')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="bg-emerald-700 pb-52 relative overflow-hidden">
    <!-- Abstract Background Pattern -->
    <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 100 C 20 80, 50 100, 70 80 S 100 80, 100 100 Z" fill="white"></path>
        </svg>
    </div>

    <div class="w-full px-4 sm:px-8 lg:px-12 pt-16 text-center relative z-10">
        <!-- Year Selector (Premium Breadcrumb) -->
        <div class="mb-12 flex flex-wrap items-center justify-center gap-4" data-aos="fade-down">
            @foreach($availableYears as $year)
                <a href="{{ route('transparency.index', ['year' => $year]) }}" 
                   class="px-6 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] transition-all duration-500 
                   {{ $selectedYear == $year 
                      ? 'bg-white text-emerald-700 shadow-2xl shadow-emerald-900/40 scale-110 -translate-y-1' 
                      : 'bg-emerald-600/40 text-emerald-100 hover:bg-emerald-500 hover:text-white border border-white/10' }}">
                    <i class="bi bi-calendar3 mr-2"></i> TA {{ $year }}
                </a>
            @endforeach
        </div>

        <h1 class="text-3xl sm:text-5xl md:text-6xl font-black text-white tracking-tight font-display mb-6" data-aos="fade-up" data-aos-delay="100">
            Transparansi <span class="text-emerald-300">Dana {{ $villageTerm }}.</span>
        </h1>
        <p class="max-w-2xl text-base sm:text-xl text-emerald-50/80 mx-auto font-medium leading-relaxed" data-aos="fade-up" data-aos-delay="200">
            Komitmen akuntabilitas publik untuk {{ $villageTerm }} Sejahtera. Pantau realisasi anggaran dan rincian pembangunan secara terbuka.
        </p>
    </div>
</div>

<div class="w-full px-4 sm:px-8 lg:px-12 -mt-32 relative z-20 pb-32">
    
    <!-- 1. KEY ANALYTICS BENTO -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Revenue Card (Lumina Light) -->
        <div class="bg-white rounded-[2.5rem] sm:rounded-[3.5rem] p-6 sm:p-10 shadow-[0_20px_50px_rgba(16,185,129,0.1)] border border-emerald-50 flex flex-col justify-between group transition-all duration-500 hover:-translate-y-2 relative overflow-hidden" data-aos="fade-right">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-50 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-700"></div>
            
            <div class="relative z-10 flex items-center gap-6 mb-12">
                <div class="w-16 h-16 bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-2xl shadow-xl shadow-emerald-600/30">
                    <i class="bi bi-bank2"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em] mb-1">Pagu Anggaran</p>
                    <p class="text-xs font-bold text-slate-400">Total Pendapatan {{ $selectedYear }}</p>
                </div>
            </div>

            <div class="relative z-10">
                <h2 class="text-2xl sm:text-4xl md:text-5xl font-black text-slate-900 leading-none tracking-tighter break-words">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </h2>
                <div class="mt-6 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Verified Official Data</span>
                </div>
            </div>
        </div>

        <!-- Composition Pie Chart Card (Minimalist) -->
        <div class="bg-white rounded-[3.5rem] p-10 shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-50 lg:col-span-1 flex flex-col justify-center relative overflow-hidden" data-aos="zoom-in" data-aos-delay="200">
            <div class="relative w-full aspect-square flex items-center justify-center">
                <canvas id="budgetCompositionChart"></canvas>
                <div class="absolute text-center pointer-events-none">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none mb-2">Penyerapan</p>
                    <p class="text-4xl font-black text-slate-900 font-display">{{ round(($totalBelanja / ($totalPendapatan ?: 1)) * 100, 1) }}<span class="text-lg text-emerald-500">%</span></p>
                </div>
            </div>
            <p class="text-center mt-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Rasio Belanja / Pendapatan</p>
        </div>

        <!-- Expenditure Card (Deep Zenith) -->
        <div class="bg-slate-900 rounded-[2.5rem] sm:rounded-[3.5rem] p-6 sm:p-10 shadow-[0_20px_50px_rgba(15,23,42,0.3)] text-white flex flex-col justify-between group transition-all duration-500 hover:-translate-y-2 relative overflow-hidden" data-aos="fade-left">
            <!-- Decorative Glow -->
            <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-emerald-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex items-center justify-between mb-12">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-white/5 border border-white/10 text-emerald-400 rounded-2xl flex items-center justify-center text-2xl backdrop-blur-md group-hover:bg-emerald-500 group-hover:text-white transition-all duration-500">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] mb-1">Output Belanja</p>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Realisasi Lapangan</p>
                    </div>
                </div>
                <div class="px-4 py-1.5 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-[10px] font-black text-emerald-400 uppercase tracking-widest">
                    Live Status
                </div>
            </div>

            <div class="relative z-10">
                <h2 class="text-2xl sm:text-4xl md:text-5xl font-black text-white leading-none tracking-tighter break-words">
                    Rp {{ number_format($totalBelanja, 0, ',', '.') }}
                </h2>
                <div class="mt-6 flex flex-col gap-2">
                    <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest text-slate-500">
                        <span>Penyaluran (Pusat):</span>
                        <span class="text-emerald-400">Rp {{ number_format($totalPenyaluran, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full h-1 bg-white/5 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500" style="width: {{ round(($totalBelanja / ($totalPenyaluran ?: 1)) * 100, 1) }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. DISTRIBUTION PHASES MONITORING -->
    @if($summary)
    <div class="mb-12" data-aos="fade-up">
        <div class="bg-white border border-emerald-50 rounded-[3.5rem] p-10 md:p-14 shadow-2xl shadow-emerald-900/5">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 mb-12">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-black text-slate-900 font-display mb-3">Monitoring Penyaluran.</h3>
                    <p class="text-slate-500 font-medium text-sm sm:text-base">Status pencairan Dana {{ $villageTerm }} dari Rekening Pusat ke Rekening Kas {{ $villageTerm }}.</p>
                </div>
                <div class="px-6 py-2 bg-emerald-50 text-emerald-600 rounded-full text-xs font-black uppercase tracking-widest border border-emerald-100">
                    TAHUN ANGGARAN {{ $selectedYear }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach(['Tahap 1' => 'tahap1', 'Tahap 2' => 'tahap2', 'Tahap 3' => 'tahap3'] as $label => $key)
                @php 
                    $val = $summary[$key] ?? 0; 
                    $pagu = $summary['pagu'] ?? 1;
                    $percent = ($val / ($pagu ?: 1)) * 100;
                    $isPending = $val <= 0;
                @endphp
                <div class="p-8 rounded-[2.5rem] {{ $isPending ? 'bg-slate-50' : 'bg-emerald-50/30 border border-emerald-100' }} transition-all duration-500 hover:scale-[1.03]">
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] {{ $isPending ? 'text-slate-400' : 'text-emerald-600' }}">{{ $label }}</span>
                        @if(!$isPending)
                            <div class="w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center text-white text-[10px]">
                                <i class="bi bi-check-lg"></i>
                            </div>
                        @else
                            <div class="w-6 h-6 bg-slate-200 rounded-full flex items-center justify-center text-slate-400 text-[10px]">
                                <i class="bi bi-clock"></i>
                            </div>
                        @endif
                    </div>
                    <div class="text-xl sm:text-2xl font-black text-slate-900 mb-4">Rp {{ number_format($val, 0, ',', '.') }}</div>
                    <div class="h-2 bg-slate-200/50 rounded-full overflow-hidden">
                        <div class="h-full {{ $isPending ? 'bg-slate-300' : 'bg-emerald-500 shadow-[0_0_10px_#10b98166]' }}" style="width: {{ $percent ?: 5 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- 3. DETAILED BUDGET TABLE -->
    <div class="bg-white rounded-[3.5rem] shadow-2xl shadow-emerald-900/5 border border-emerald-50 overflow-hidden" data-aos="fade-up">
        <div class="p-10 md:p-12 border-b border-emerald-50 bg-emerald-50/20 flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 font-display mb-2">Rincian Kegiatan.</h3>
                <p class="text-emerald-700/60 font-semibold text-xs sm:text-sm italic">"Transparansi adalah fondasi kepercayaan masyarakat."</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex -space-x-3">
                    <div class="w-10 h-10 rounded-full border-2 border-white bg-emerald-500"></div>
                    <div class="w-10 h-10 rounded-full border-2 border-white bg-lime-500"></div>
                    <div class="w-10 h-10 rounded-full border-2 border-white bg-teal-500"></div>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Verified Data</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px]">
                <thead>
                    <tr class="bg-slate-900 text-white">
                        <th class="px-8 py-6 text-left text-[10px] font-black uppercase tracking-[0.3em] opacity-60">Uraian Program {{ $villageTerm }}</th>
                        <th class="px-8 py-6 text-center text-[10px] font-black uppercase tracking-[0.3em] opacity-60">Volume</th>
                        <th class="px-8 py-6 text-right text-[10px] font-black uppercase tracking-[0.3em] opacity-60">Realisasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50/50">
                    @forelse($budgets as $b)
                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                            <td class="px-8 py-8">
                                <div class="text-[15px] font-black text-slate-800 leading-snug group-hover:text-emerald-700 transition-colors">{{ $b->category }}</div>
                                <div class="flex items-center gap-3 mt-3">
                                    <span class="px-3 py-1 bg-slate-100 rounded-lg text-[9px] font-black text-slate-500 uppercase tracking-widest">{{ $b->type }}</span>
                                    @if($b->output)
                                        <span class="text-[10px] text-slate-400 font-medium italic"><i class="bi bi-bullseye mr-1"></i> {{ $b->output }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-8 text-center">
                                <div class="text-base font-black text-slate-800">{{ $b->volume }}</div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $b->satuan }}</div>
                            </td>
                            <td class="px-8 py-8 text-right">
                                <div class="text-lg font-black text-emerald-600 font-display">Rp {{ number_format($b->amount, 0, ',', '.') }}</div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Sukes Terealisasi</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-8 py-28 text-center text-slate-300">
                                <i class="bi bi-clipboard-x text-5xl mb-4 block"></i>
                                <span class="text-sm font-black uppercase tracking-widest opacity-50">Belum ada rincian kegiatan untuk tahun ini</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-10 py-8 bg-slate-50 border-t border-emerald-50 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <img src="https://jaga.id/favicon.ico" class="w-5 h-5 opacity-50" alt="Jaga.id">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Verified by JAGA.ID (KPK RI)</span>
            </div>
            <div class="text-[10px] font-black text-emerald-600/50 uppercase tracking-widest">© {{ date('Y') }} {{ $villageTerm }} {{ \App\Models\SiteMeta::getVal('village_name') }}</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('budgetCompositionChart').getContext('2d');
        
        const labels = ['Penyerapan', 'Sisa Anggaran'];
        const data = [{{ $totalBelanja }}, {{ max(0, ($totalPendapatan) - $totalBelanja) }}];
        const colors = ['#10b981', '#f1f5f9'];

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors,
                    borderWidth: 0,
                    borderRadius: 10,
                    spacing: 4
                }]
            },
            options: {
                cutout: '85%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 15,
                        cornerRadius: 12,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<style>
    .font-display { font-family: 'Outfit', sans-serif; }
</style>
@endsection
