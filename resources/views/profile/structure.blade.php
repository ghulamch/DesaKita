@extends('layouts.app')

@php
    $term = \App\Models\SiteMeta::getVal('village_term', 'Desa');
    $villageTerm = ($term === 'Lainnya') ? \App\Models\SiteMeta::getVal('village_term_custom', 'Desa') : $term;
@endphp

@section('title', 'Struktur Organisasi ' . $villageTerm)

@section('content')
<div class="bg-emerald-700 pb-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
    
    <div class="w-full px-4 sm:px-8 lg:px-12 pt-16 relative z-10 text-center">
        <h1 class="text-4xl font-extrabold text-white tracking-tight font-display mb-2">Struktur Organisasi</h1>
        <p class="text-emerald-100 font-medium tracking-widest text-xs uppercase opacity-80">Tata Kelola & Hierarki Pemerintahan {{ $villageTerm }}</p>
    </div>
</div>

<div class="w-full px-4 sm:px-8 lg:px-12 -mt-10 relative z-10 pb-24">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-[3rem] shadow-2xl shadow-emerald-900/10 border border-emerald-50 p-6 md:p-12 relative" data-aos="zoom-in">
            <!-- Decorative Elements -->
            <div class="absolute top-10 left-10 w-20 h-20 bg-emerald-50 rounded-full blur-3xl opacity-60"></div>
            <div class="absolute bottom-10 right-10 w-32 h-32 bg-blue-50 rounded-full blur-3xl opacity-60"></div>

            @php
                $orgChartImg = \App\Models\SiteMeta::getVal('village_org_chart');
            @endphp

            @if($orgChartImg)
                <!-- Explicit image uploaded by admin -->
                <div class="relative group">
                    <div class="absolute -inset-4 bg-gradient-to-tr from-emerald-100 to-teal-100 opacity-20 blur-xl rounded-[3rem] group-hover:opacity-40 transition-opacity"></div>
                    <div class="relative bg-white rounded-[2rem] border border-emerald-50 p-4 shadow-sm overflow-hidden">
                        <img src="{{ Str::startsWith($orgChartImg, 'http') ? $orgChartImg : asset('storage/'.$orgChartImg) }}" 
                             alt="Struktur Organisasi {{ $villageTerm }}"
                             class="w-full h-auto rounded-xl hover:scale-105 transition-transform duration-700 cursor-zoom-in"
                             onclick="window.open(this.src, '_blank')">
                    </div>
                </div>
            @elseif($apparatus->count() > 0)
                <style>
                    #cy-hidden {
                        position: absolute;
                        left: -9999px;
                        top: -9999px;
                        width: 1200px; /* High-res canvas for export */
                        height: 1000px;
                    }
                    #org-chart-container {
                        width: 100%;
                        background: #ffffff;
                        border-radius: 2.5rem;
                        padding: 1.5rem;
                        border: 1px solid #f1f5f9;
                        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);
                    }
                    #org-chart-img {
                        width: 100%;
                        height: auto;
                        display: block;
                    }
                </style>

                <div x-data="{ openModal: false, imgSource: '' }" id="org-chart-container" class="relative group">
                    <img id="org-chart-img" 
                         class="hidden cursor-zoom-in hover:scale-[1.01] transition-all duration-500 rounded-3xl" 
                         @click="imgSource = $el.src; openModal = true">
                    
                    <div id="loading-chart" class="py-24 text-center">
                        <div class="inline-block animate-spin rounded-full h-10 w-10 border-4 border-emerald-500 border-t-transparent"></div>
                        <p class="mt-6 text-sm font-black text-slate-400 uppercase tracking-widest">Menyiapkan Visual Premium...</p>
                    </div>

                    <!-- Fullscreen Modal -->
                    <template x-teleport="body">
                        <div x-show="openModal" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/95 backdrop-blur-md p-4"
                             style="display: none;">
                            
                            <button @click="openModal = false" class="absolute top-6 right-6 text-white/50 hover:text-white transition-colors">
                                <i class="bi bi-x-circle text-4xl"></i>
                            </button>

                            <div class="max-w-[95vw] max-h-[90vh] overflow-auto custom-scrollbar rounded-2xl bg-white/5 p-2 border border-white/10 shadow-2xl"
                                 @click.away="openModal = false">
                                <img :src="imgSource" class="w-full h-auto min-w-[800px] md:min-w-[1200px]" alt="Bagan Fullscreen">
                            </div>

                            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/40 text-[10px] font-bold uppercase tracking-widest pointer-events-none">
                                Geser untuk melihat seluruh bagian
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Hidden rendering area -->
                <div id="cy-hidden"></div>
                
                <!-- Floating Legend -->
                <div class="mt-8 flex flex-col md:flex-row items-center justify-center gap-6 md:gap-12 py-6 bg-white/50 border border-slate-100 rounded-3xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-1 bg-emerald-500 rounded-full"></div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Garis Komando</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-1 border-t-2 border-dashed border-emerald-400"></div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Garis Koordinasi</span>
                    </div>
                </div>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/cytoscape/3.26.0/cytoscape.min.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const elements = [
                            @foreach($apparatus as $staff)
                                { 
                                    data: { 
                                        id: 'node_{{ $staff->id }}', 
                                        name: '{{ addslashes($staff->name) }}', 
                                        role: '{{ addslashes($staff->role) }}',
                                        initials: '{{ collect(explode(' ', $staff->name))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->join('') }}',
                                        image: '{{ $staff->image ? asset('storage/'.$staff->image) : '' }}'
                                    },
                                    position: { 
                                        x: {{ $staff->x ?? 400 }}, 
                                        y: {{ $staff->y ?? ($loop->index * 150) }} 
                                    }
                                },
                                @if($staff->parent_id)
                                { 
                                    data: { 
                                        source: 'node_{{ $staff->parent_id }}', 
                                        target: 'node_{{ $staff->id }}', 
                                        type: '{{ $staff->connection_type }}' 
                                    } 
                                },
                                @endif
                            @endforeach
                        ];

                        const createNodeSvg = (name, role, initials) => {
                            const svg = `
                                <svg xmlns="http://www.w3.org/2000/svg" width="180" height="70" viewBox="0 0 180 70">
                                    <!-- Shadow Glow -->
                                    <rect x="4" y="4" width="172" height="62" rx="18" fill="#10b981" opacity="0.1" />
                                    <!-- Main Card -->
                                    <rect x="2" y="2" width="176" height="66" rx="18" fill="#ffffff" stroke="#f1f5f9" stroke-width="1" />
                                    <!-- Left Accent -->
                                    <path d="M 2 20 Q 2 2 20 2 L 40 2 L 40 68 L 20 68 Q 2 68 2 50 Z" fill="#10b981" opacity="0.05" />
                                    <rect x="2" y="18" width="3" height="34" rx="1.5" fill="#10b981" />
                                    
                                    <rect x="12" y="12" width="46" height="46" rx="14" fill="#f0fdf4"/>
                                    <text x="35" y="42" font-family="sans-serif" font-weight="900" font-size="16" text-anchor="middle" fill="#10b981">${initials}</text>
                                    
                                    <!-- Text Group -->
                                    <text x="68" y="28" font-family="sans-serif" font-weight="900" font-size="6" fill="#10b981" text-transform="uppercase" letter-spacing="0.8">${role}</text>
                                    <text x="68" y="44" font-family="sans-serif" font-weight="800" font-size="10" fill="#1e293b">${name.length > 18 ? name.substring(0, 15) + '...' : name}</text>
                                </svg>
                            `;
                            return 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svg)));
                        };

                        const cy = cytoscape({
                            container: document.getElementById('cy-hidden'),
                            elements: elements,
                            style: [
                                {
                                    selector: 'node',
                                    style: {
                                        'background-color': '#ffffff',
                                        'width': 180,
                                        'height': 70,
                                        'shape': 'rectangle',
                                        'background-image': function(ele) {
                                            return createNodeSvg(ele.data('name'), ele.data('role'), ele.data('initials'));
                                        },
                                        'background-fit': 'contain',
                                        'border-width': 0
                                    }
                                },
                                {
                                    selector: 'edge',
                                    style: {
                                        'width': 2.5,
                                        'line-color': '#10b981',
                                        'target-arrow-color': '#10b981',
                                        'target-arrow-shape': 'triangle',
                                        'curve-style': 'taxi',
                                        'taxi-direction': 'vertical',
                                        'taxi-turn': '40px',
                                        'taxi-turn-min-distance': '10px',
                                        'opacity': 0.8
                                    }
                                },
                                {
                                    selector: 'edge[type="koordinasi"]',
                                    style: {
                                        'line-style': 'dashed',
                                        'target-arrow-shape': 'none',
                                        'line-dash-pattern': [6, 4],
                                        'line-color': '#34d399',
                                        'curve-style': 'taxi',
                                        'taxi-direction': 'vertical',
                                        'taxi-turn': '30px'
                                    }
                                }
                            ],
                            layout: { 
                                name: @if($apparatus->whereNotNull('x')->count() > 0) 'preset' @else 'grid' @endif
                            }
                        });

                        const convertToImage = () => {
                            cy.fit(null, 50);
                            const pngData = cy.png({
                                full: true,
                                bg: '#ffffff',
                                scale: 2 // High resolution
                            });
                            
                            const img = document.getElementById('org-chart-img');
                            img.src = pngData;
                            img.classList.remove('hidden');
                            document.getElementById('loading-chart').classList.add('hidden');
                        };

                        // Give some time for SVG backgrounds to be ready
                        cy.ready(() => {
                            setTimeout(convertToImage, 1000);
                        });
                    });
                </script>
            @else
                <div class="py-24 text-center">
                    <div class="w-24 h-24 bg-emerald-50 text-emerald-300 rounded-3xl flex items-center justify-center mx-auto mb-8 border border-emerald-100 shadow-inner">
                        <i class="bi bi-diagram-3 text-5xl"></i>
                    </div>
                    <h3 class="text-3xl font-black text-slate-900 font-display mb-4">Bagan Belum Tersedia</h3>
                    <p class="text-slate-500 max-w-md mx-auto leading-relaxed">Admin {{ strtolower($villageTerm) }} belum melengkapi data aparatur desa untuk membentuk struktur organisasi.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .mermaid svg {
        max-width: 100% !important;
        height: auto !important;
    }
    .custom-scrollbar::-webkit-scrollbar {
        height: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endsection
