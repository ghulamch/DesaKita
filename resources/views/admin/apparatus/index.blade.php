@extends('layouts.admin')

@section('title', 'Manajemen Aparatur')

@section('content')
<div class="p-0 md:p-4">
    <div class="px-4 py-8 md:px-0 md:py-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-gray-700 bg-white rounded-xl shadow-sm border border-gray-200">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Aparatur {{ $villageTerm }}</h1>
        </div>
        
        <a href="{{ route('apparatus.create') }}" class="w-12 h-12 md:w-auto md:h-auto px-0 md:px-6 py-0 md:py-3 bg-emerald-600 text-white rounded-2xl font-bold hover:bg-emerald-700 transition shadow-lg shadow-emerald-600/20 flex items-center justify-center">
            <i class="bi bi-plus-lg md:mr-2 text-xl md:text-base"></i> <span class="hidden md:inline">Tambah Data</span>
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center">
            <i class="bi bi-check-circle-fill mr-3"></i>
            {{ session('success') }}
        </div>
    @endif

    <div x-data="{ tab: 'list' }" class="space-y-6">
        <!-- Tab Navigation -->
        <div class="flex p-1 bg-gray-100 rounded-xl w-fit">
            <button @click="tab = 'list'" :class="tab === 'list' ? 'bg-white shadow-sm text-emerald-700' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2 rounded-lg text-sm font-bold transition-all duration-200">
                <i class="bi bi-list-ul mr-2"></i> Daftar Jabatan
            </button>
            <button @click="tab = 'chart'" :class="tab === 'chart' ? 'bg-white shadow-sm text-emerald-700' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2 rounded-lg text-sm font-bold transition-all duration-200">
                <i class="bi bi-diagram-3 mr-2"></i> Struktur Interaktif (Drag & Drop)
            </button>
        </div>

        <!-- List View -->
        <div x-show="tab === 'list'" class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-10"></th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Foto Profil</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jabatan / Role</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="sortable-table">
                        @forelse($apparatus as $staff)
                        <tr class="hover:bg-gray-50 transition cursor-move" data-id="{{ $staff->id }}">
                            <td class="px-6 py-4 text-gray-400">
                                <i class="bi bi-grip-vertical text-xl"></i>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-12 h-16 rounded overflow-hidden border border-gray-200 bg-gray-100 object-cover">
                                    @if($staff->image)
                                        <img src="{{ asset('storage/'.$staff->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 bg-emerald-50 text-[10px] font-bold">
                                            {{ collect(explode(' ', $staff->name))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->join('') }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $staff->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                    {{ $staff->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('apparatus.edit', $staff->id) }}" class="p-2 inline-flex items-center justify-center bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('apparatus.destroy', $staff->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus data ini?')" class="p-2 inline-flex items-center justify-center bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                Belum ada data aparatur desa yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chart View -->
        <div x-show="tab === 'chart'" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Kanvas Struktur Bebas</h3>
                    <p class="text-sm text-gray-500 mt-1">Geser jabatan ke mana saja. Posisi akan disimpan otomatis.</p>
                </div>
            </div>

            <style>
                #cy-admin {
                    width: 100%;
                    height: 700px;
                    background: #ffffff;
                    border: 2px dashed #e2e8f0;
                    border-radius: 3rem;
                }
            </style>
            <div class="relative">
                <div id="cy-admin"></div>
                
                <!-- Legend -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center gap-6 px-8 py-4 bg-white/90 backdrop-blur-md border border-slate-100 rounded-2xl shadow-lg">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-[3px] bg-emerald-500 rounded-full"></div>
                        <span class="text-[9px] font-black uppercase tracking-tighter text-slate-400">Komando</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-[3px] border-t-2 border-dashed border-emerald-400"></div>
                        <span class="text-[9px] font-black uppercase tracking-tighter text-slate-400">Koordinasi</span>
                    </div>
                </div>
            </div>

            <div id="save-status" class="fixed bottom-10 right-10 z-[100] hidden">
                <div class="bg-slate-900 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center space-x-3 animate-bounce">
                    <i class="bi bi-cloud-arrow-up text-emerald-400"></i>
                    <span class="text-sm font-bold">Menyimpan Posisi...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cytoscape/3.26.0/cytoscape.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // List Sortable
        const el = document.getElementById('sortable-table');
        if(el) {
            new Sortable(el, {
                animation: 150,
                ghostClass: 'bg-emerald-50',
                onEnd: function() {
                    const order = [];
                    el.querySelectorAll('tr').forEach(tr => {
                        const id = tr.getAttribute('data-id');
                        if (id) order.push(id);
                    });
                    
                    document.getElementById('save-status').classList.remove('hidden');
                    fetch("{{ route('apparatus.update-order') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ order: order })
                    }).then(() => {
                        setTimeout(() => document.getElementById('save-status').classList.add('hidden'), 1000);
                    });
                }
            });
        }

        // Cytoscape Visual Management
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
                        x: {{ $staff->x ?? 100 + ($loop->index * 50) }}, 
                        y: {{ $staff->y ?? 100 + ($loop->index * 20) }} 
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
                    <rect x="4" y="4" width="172" height="62" rx="18" fill="#10b981" opacity="0.1" />
                    <rect x="2" y="2" width="176" height="66" rx="18" fill="#ffffff" stroke="#f1f5f9" stroke-width="1" />
                    <path d="M 2 20 Q 2 2 20 2 L 40 2 L 40 68 L 20 68 Q 2 68 2 50 Z" fill="#10b981" opacity="0.05" />
                    <rect x="2" y="18" width="3" height="34" rx="1.5" fill="#10b981" />
                    
                    <rect x="12" y="12" width="46" height="46" rx="14" fill="#f0fdf4"/>
                    <text x="35" y="42" font-family="sans-serif" font-weight="900" font-size="16" text-anchor="middle" fill="#10b981">${initials}</text>
                    
                    <text x="68" y="28" font-family="sans-serif" font-weight="900" font-size="6" fill="#10b981" text-transform="uppercase" letter-spacing="0.8">${role}</text>
                    <text x="68" y="44" font-family="sans-serif" font-weight="800" font-size="10" fill="#1e293b">${name.length > 18 ? name.substring(0, 15) + '...' : name}</text>
                </svg>
            `;
            return 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svg)));
        };

        const cy = cytoscape({
            container: document.getElementById('cy-admin'),
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
                        'border-width': 0,
                        'label': ''
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
                        'opacity': 0.7
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

        cy.on('free', 'node', function(evt){
            const node = evt.target;
            const id = node.data('id').replace('node_', '');
            const pos = node.position();

            // Snap to Grid (25px)
            const snapSize = 25;
            const snappedX = Math.round(pos.x / snapSize) * snapSize;
            const snappedY = Math.round(pos.y / snapSize) * snapSize;
            
            node.position({ x: snappedX, y: snappedY });

            document.getElementById('save-status').classList.remove('hidden');
            fetch("{{ route('apparatus.update-hierarchy') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    id: id, 
                    x: Math.round(snappedX), 
                    y: Math.round(snappedY) 
                })
            }).then(() => {
                setTimeout(() => document.getElementById('save-status').classList.add('hidden'), 1000);
            });
        });
    });
</script>
@endsection
