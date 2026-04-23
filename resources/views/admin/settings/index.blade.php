@extends('layouts.admin')

@section('title', 'Penyesuaian Website')

@section('content')
<div class="px-4 py-8 md:px-0 md:py-4">
            <div x-data="{ tab: 'identity', showSuccess: false, successMsg: '' }">
                <!-- Page Header -->
                <div class="mb-10 text-center lg:text-left" data-aos="fade-down">
                    <h1 class="text-4xl font-extrabold text-slate-900 font-display tracking-tight mb-2">Penyesuaian Website</h1>
                    <p class="text-slate-500 text-lg">Kelola identitas, struktur organisasi, dan profil desa dalam satu tempat.</p>
                </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start relative">
            <!-- Sidebar Navigation -->
            <div class="w-full lg:w-72 space-y-2 sticky top-24" data-aos="fade-right">
                <button @click="tab = 'identity'" :class="tab == 'identity' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'bg-white text-slate-600 hover:bg-emerald-50'" class="w-full text-left px-6 py-4 rounded-2xl font-bold flex items-center transition-all duration-300 group">
                    <i class="bi bi-geo-alt-fill mr-3 text-lg" :class="tab == 'identity' ? 'text-white' : 'text-emerald-500'"></i> Identitas & Peta
                </button>
                <button @click="tab = 'kades'" :class="tab == 'kades' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'bg-white text-slate-600 hover:bg-emerald-50'" class="w-full text-left px-6 py-4 rounded-2xl font-bold flex items-center transition-all duration-300 group">
                    <i class="bi bi-person-badge-fill mr-3 text-lg" :class="tab == 'kades' ? 'text-white' : 'text-emerald-500'"></i> Profil Kepala Desa
                </button>
                <button @click="tab = 'vision'" :class="tab == 'vision' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'bg-white text-slate-600 hover:bg-emerald-50'" class="w-full text-left px-6 py-4 rounded-2xl font-bold flex items-center transition-all duration-300 group">
                    <i class="bi bi-journal-bookmark-fill mr-3 text-lg" :class="tab == 'vision' ? 'text-white' : 'text-emerald-500'"></i> Profil & Tata Kelola
                </button>
                <button @click="tab = 'appearance'" :class="tab == 'appearance' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'bg-white text-slate-600 hover:bg-emerald-50'" class="w-full text-left px-6 py-4 rounded-2xl font-bold flex items-center transition-all duration-300 group">
                    <i class="bi bi-palette-fill mr-3 text-lg" :class="tab == 'appearance' ? 'text-white' : 'text-emerald-500'"></i> Tampilan Situs
                </button>
                <button @click="tab = 'contact'" :class="tab == 'contact' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'bg-white text-slate-600 hover:bg-emerald-50'" class="w-full text-left px-6 py-4 rounded-2xl font-bold flex items-center transition-all duration-300 group">
                    <i class="bi bi-chat-dots-fill mr-3 text-lg" :class="tab == 'contact' ? 'text-white' : 'text-emerald-500'"></i> Kontak & Sosmed
                </button>
                <button @click="tab = 'email'" :class="tab == 'email' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'bg-white text-slate-600 hover:bg-emerald-50'" class="w-full text-left px-6 py-4 rounded-2xl font-bold flex items-center transition-all duration-300 group">
                    <i class="bi bi-envelope-at-fill mr-3 text-lg" :class="tab == 'email' ? 'text-white' : 'text-emerald-500'"></i> Email & SMTP
                </button>
                <button @click="tab = 'templates'" :class="tab == 'templates' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'bg-white text-slate-600 hover:bg-emerald-50'" class="w-full text-left px-6 py-4 rounded-2xl font-bold flex items-center transition-all duration-300 group">
                    <i class="bi bi-file-earmark-text-fill mr-3 text-lg" :class="tab == 'templates' ? 'text-white' : 'text-emerald-500'"></i> Template Email
                </button>
            </div>

            <!-- Main Form Container -->
            <div class="flex-1 w-full relative z-10" data-aos="fade-left">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8 pb-32">
                    @csrf
                    
                    <!-- Section: Identitas & Peta -->
                    <div x-show="tab == 'identity'" class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-8 md:p-10 space-y-10" x-cloak>
                        <div class="flex items-center space-x-4 border-b border-slate-100 pb-6">
                            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl shadow-inner">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900 font-display">Identitas Wilayah</h2>
                                <p class="text-slate-500">Sesuaikan lokasi dan identitas resmi desa Anda.</p>
                            </div>
                        </div>

                        <div x-data="{
                            provinces: [], regencies: [], districts: [], villages: [],
                            selectedProv: '{{ $metas['province_id'] ?? '' }}',
                            selectedProvName: '{{ $metas['province_name'] ?? '' }}',
                            selectedReg: '{{ $metas['regency_id'] ?? '' }}',
                            selectedRegName: '{{ $metas['regency_name'] ?? '' }}',
                            selectedDist: '{{ $metas['district_id'] ?? '' }}',
                            selectedDistName: '{{ $metas['district_name'] ?? '' }}',
                            selectedVill: '{{ $metas['village_id'] ?? '' }}',
                            selectedVillName: '{{ $metas['village_name'] ?? '' }}',
                            bmkgCode: '{{ $metas['bmkg_code'] ?? '' }}',
                            selectedLat: '{{ $metas['village_lat'] ?? '' }}',
                            selectedLng: '{{ $metas['village_lng'] ?? '' }}',
                            villageTerm: '{{ $metas['village_term'] ?? 'Desa' }}',
                            loading: false,

                            async init() {
                                this.loading = true;
                                try {
                                    const resp = await fetch('/api/provinces');
                                    this.provinces = await resp.json();
                                    if (this.selectedProv) await this.fetchRegencies(false);
                                    if (this.selectedReg) await this.fetchDistricts(false);
                                    if (this.selectedDist) await this.fetchVillages(false);
                                    
                                    // Initial BMKG lookup if not present
                                    if (this.selectedVillName && !this.bmkgCode) {
                                        this.updateVillageName();
                                    }
                                } catch (e) { console.error(e); }
                                this.loading = false;
                            },

                            async fetchRegencies(reset = true) {
                                if (reset) {
                                    this.selectedReg = ''; this.selectedRegName = '';
                                    this.selectedDist = ''; this.selectedDistName = ''; 
                                    this.selectedVill = ''; this.selectedVillName = '';
                                    const p = this.provinces.find(x => x.id == this.selectedProv);
                                    this.selectedProvName = p ? p.name : '';
                                }
                                if (!this.selectedProv) return;
                                const resp = await fetch(`/api/regencies?province_id=${this.selectedProv}`);
                                this.regencies = await resp.json();
                            },

                            async fetchDistricts(reset = true) {
                                if (reset) {
                                    this.selectedDist = ''; this.selectedDistName = '';
                                    this.selectedVill = ''; this.selectedVillName = '';
                                    const r = this.regencies.find(x => x.id == this.selectedReg);
                                    this.selectedRegName = r ? r.name : '';
                                }
                                if (!this.selectedReg) return;
                                const resp = await fetch(`/api/districts?regency_id=${this.selectedReg}`);
                                this.districts = await resp.json();
                            },

                            async fetchVillages(reset = true, searchQuery = '') {
                                if (reset) {
                                    this.selectedVill = ''; this.selectedVillName = '';
                                    this.selectedLat = ''; this.selectedLng = '';
                                    const d = this.districts.find(x => x.id == this.selectedDist);
                                    this.selectedDistName = d ? d.name : '';
                                }
                                if (!this.selectedDist) return;
                                this.loading = true;
                                try {
                                    const resp = await fetch(`/api/villages?district_id=${this.selectedDist}&search=${searchQuery}`);
                                    this.villages = await resp.json();
                                } catch (e) { console.error(e); }
                                this.loading = false;
                            },

                            async updateVillageName() {
                                const v = this.villages.find(x => x.id == this.selectedVill);
                                this.selectedVillName = v ? v.name : '';
                                if (v && v.latitude) this.selectedLat = v.latitude;
                                if (v && v.longitude) this.selectedLng = v.longitude;
                                
                                // Reset and Fetch BMKG Code based on name, district_name and regency_id
                                if (this.selectedVillName) {
                                    this.bmkgCode = ''; 
                                    try {
                                        const res = await fetch(`/api/bmkg-lookup?name=${encodeURIComponent(this.selectedVillName)}&district_name=${encodeURIComponent(this.selectedDistName)}&regency_id=${this.selectedReg}`);
                                        const data = await res.json();
                                        this.bmkgCode = data.code || 'TIDAK DITEMUKAN';
                                    } catch (e) { 
                                        console.error('BMKG Lookup Error:', e);
                                        this.bmkgCode = 'ERROR';
                                    }
                                }

                                this.updateMapUrl();
                            },

                            updateMapUrl() {
                                const mapInput = document.getElementsByName('village_map_url')[0];
                                if (!mapInput) return;
                                if (this.selectedLat && this.selectedLng && (!mapInput.value || !mapInput.value.startsWith('http'))) {
                                    mapInput.value = `https://maps.google.com/maps?q=${this.selectedLat},${this.selectedLng}&t=&z=15&ie=UTF8&iwloc=&output=embed`;
                                } else if (this.selectedVillName && (!mapInput.value || !mapInput.value.startsWith('http'))) {
                                    const full = `Desa ${this.selectedVillName}, ${this.selectedDistName}, ${this.selectedRegName}, ${this.selectedProvName}`;
                                    mapInput.value = full;
                                }
                            }
                        }" class="space-y-8">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Provinsi -->
                                <div class="relative" x-data="{ open: false, search: '' }" @click.away="open = false">
                                    <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Provinsi</label>
                                    <button type="button" @click="open = !open" 
                                            class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-white text-left flex justify-between items-center transition-all duration-300 hover:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none shadow-sm">
                                        <span x-text="selectedProvName || 'Pilih Provinsi'" :class="!selectedProvName && 'text-slate-400 font-normal'"></span>
                                        <i class="bi bi-chevron-down text-xs text-slate-400 transition-transform duration-300" :class="open && 'rotate-180'"></i>
                                    </button>
                                    <div x-show="open" x-cloak 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                         class="absolute z-[100] mt-3 w-full bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-slate-100 overflow-hidden ring-1 ring-slate-900/5">
                                        <div class="p-3 bg-slate-50/50">
                                            <input type="text" x-model="search" placeholder="Cari Provinsi..." class="w-full px-4 py-2 bg-white rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none text-sm shadow-sm transition-all">
                                        </div>
                                        <div class="max-h-64 overflow-y-auto custom-scrollbar">
                                            <template x-for="p in provinces.filter(x => x.name.toLowerCase().includes(search.toLowerCase()))" :key="p.id">
                                                <div @click="selectedProv = p.id; selectedProvName = p.name; fetchRegencies(); open = false; search = ''" 
                                                     class="px-5 py-3 hover:bg-emerald-50 hover:text-emerald-700 cursor-pointer text-sm transition-colors flex items-center justify-between group"
                                                     :class="selectedProv == p.id && 'bg-emerald-50 text-emerald-700 font-bold'">
                                                    <span x-text="p.name"></span>
                                                    <i class="bi bi-check2 text-emerald-500 opacity-0 group-hover:opacity-100" x-show="selectedProv == p.id"></i>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                    <input type="hidden" name="province_id" x-model="selectedProv">
                                    <input type="hidden" name="province_name" x-model="selectedProvName">
                                </div>

                                <!-- Kabupaten -->
                                <div class="relative" x-data="{ open: false, search: '' }" @click.away="open = false">
                                    <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Kabupaten / Kota</label>
                                    <button type="button" @click="if(selectedProv) open = !open" 
                                            :class="!selectedProv && 'opacity-60 bg-slate-50 cursor-not-allowed border-dashed'"
                                            class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-white text-left flex justify-between items-center transition-all duration-300 hover:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none shadow-sm">
                                        <span x-text="selectedRegName || (selectedProv ? 'Pilih Kabupaten' : 'Menunggu Provinsi...')" :class="!selectedRegName && 'text-slate-400 font-normal'"></span>
                                        <i class="bi bi-chevron-down text-xs text-slate-400 transition-transform duration-300" :class="open && 'rotate-180'" x-show="selectedProv"></i>
                                    </button>
                                    <div x-show="open" x-cloak x-transition class="absolute z-[100] mt-3 w-full bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-slate-100 overflow-hidden ring-1 ring-slate-900/5">
                                        <div class="p-3 bg-slate-50/50">
                                            <input type="text" x-model="search" placeholder="Cari Kabupaten..." class="w-full px-4 py-2 bg-white rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none text-sm shadow-sm transition-all">
                                        </div>
                                        <div class="max-h-64 overflow-y-auto custom-scrollbar">
                                            <template x-for="r in regencies.filter(x => x.name.toLowerCase().includes(search.toLowerCase()))" :key="r.id">
                                                <div @click="selectedReg = r.id; selectedRegName = r.name; fetchDistricts(); open = false; search = ''" 
                                                     class="px-5 py-3 hover:bg-emerald-50 hover:text-emerald-700 cursor-pointer text-sm transition-colors flex items-center justify-between group"
                                                     :class="selectedReg == r.id && 'bg-emerald-50 text-emerald-700 font-bold'">
                                                    <span x-text="r.name"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                    <input type="hidden" name="regency_id" x-model="selectedReg">
                                    <input type="hidden" name="regency_name" x-model="selectedRegName">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Kecamatan -->
                                <div class="relative" x-data="{ open: false, search: '' }" @click.away="open = false">
                                    <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Kecamatan</label>
                                    <button type="button" @click="if(selectedReg) open = !open" 
                                            :class="!selectedReg && 'opacity-60 bg-slate-50 cursor-not-allowed border-dashed'"
                                            class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-white text-left flex justify-between items-center transition-all duration-300 hover:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none shadow-sm">
                                        <span x-text="selectedDistName || (selectedReg ? 'Pilih Kecamatan' : 'Menunggu Kabupaten...')" :class="!selectedDistName && 'text-slate-400 font-normal'"></span>
                                        <i class="bi bi-chevron-down text-xs text-slate-400 transition-transform duration-300" :class="open && 'rotate-180'" x-show="selectedReg"></i>
                                    </button>
                                    <div x-show="open" x-cloak x-transition class="absolute z-[100] mt-3 w-full bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-slate-100 overflow-hidden ring-1 ring-slate-900/5">
                                        <div class="p-3 bg-slate-50/50">
                                            <input type="text" x-model="search" placeholder="Cari Kecamatan..." class="w-full px-4 py-2 bg-white rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none text-sm shadow-sm transition-all">
                                        </div>
                                        <div class="max-h-64 overflow-y-auto custom-scrollbar">
                                            <template x-for="d in districts.filter(x => x.name.toLowerCase().includes(search.toLowerCase()))" :key="d.id">
                                                <div @click="selectedDist = d.id; selectedDistName = d.name; fetchVillages(); open = false; search = ''" 
                                                     class="px-5 py-3 hover:bg-emerald-50 hover:text-emerald-700 cursor-pointer text-sm transition-colors flex items-center justify-between group"
                                                     :class="selectedDist == d.id && 'bg-emerald-50 text-emerald-700 font-bold'">
                                                    <span x-text="d.name"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                    <input type="hidden" name="district_id" x-model="selectedDist">
                                    <input type="hidden" name="district_name" x-model="selectedDistName">
                                </div>

                                <!-- Desa -->
                                <div class="relative" x-data="{ open: false, search: '' }" @click.away="open = false">
                                    <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Desa / Kelurahan</label>
                                    <button type="button" @click="if(selectedDist && !loading) open = !open" 
                                            :class="(!selectedDist || loading) && 'opacity-60 bg-slate-50 cursor-not-allowed border-dashed'"
                                            class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-white text-left flex justify-between items-center transition-all duration-300 hover:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none shadow-sm">
                                        <div class="flex items-center gap-2">
                                            <span x-text="selectedVillName || (loading ? 'Memuat...' : (selectedDist ? 'Pilih Desa' : 'Menunggu Kecamatan...'))" :class="!selectedVillName && 'text-slate-400 font-normal'"></span>
                                            <template x-if="selectedVillName && !selectedVill">
                                                <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[9px] font-black uppercase rounded-md border border-amber-200">Manual</span>
                                            </template>
                                        </div>
                                        <div class="flex items-center">
                                            <div x-show="loading" class="mr-2 h-4 w-4 animate-spin rounded-full border-2 border-emerald-500 border-t-transparent"></div>
                                            <i class="bi bi-chevron-down text-xs text-slate-400 transition-transform duration-300" :class="open && 'rotate-180'" x-show="selectedDist && !loading"></i>
                                        </div>
                                    </button>
                                    
                                    <!-- BMKG Code Indicator -->
                                    <div x-show="selectedVillName" class="mt-2 flex items-center gap-2 px-1">
                                        <div class="h-1.5 w-1.5 rounded-full" :class="bmkgCode ? 'bg-emerald-500' : 'bg-slate-300 animate-pulse'"></div>
                                        <span class="text-[10px] font-black uppercase tracking-widest" :class="bmkgCode ? 'text-emerald-600' : 'text-slate-400'">
                                            BMKG ID: <span x-text="bmkgCode || 'Mencari...'"></span>
                                        </span>
                                    </div>
                                    <div x-show="open" x-cloak x-transition class="absolute z-[100] mt-3 w-full bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-slate-100 overflow-hidden ring-1 ring-slate-900/5">
                                        <div class="p-3 bg-slate-50/50">
                                            <input type="text" x-model="search" 
                                                   @input.debounce.500ms="fetchVillages(false, search)"
                                                   placeholder="Cari desa (min. 3 huruf)..." 
                                                   class="w-full px-4 py-2 bg-white rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none text-sm shadow-sm transition-all">
                                        </div>
                                        <div class="max-h-64 overflow-y-auto custom-scrollbar">
                                            <template x-for="v in villages" :key="v.id">
                                                <div @click="selectedVill = v.id; selectedVillName = v.name; updateVillageName(); open = false; search = ''" 
                                                     class="px-5 py-3 hover:bg-emerald-50 hover:text-emerald-700 cursor-pointer text-sm transition-colors flex items-center justify-between group"
                                                     :class="selectedVill == v.id && 'bg-emerald-50 text-emerald-700 font-bold'">
                                                    <span x-text="v.name"></span>
                                                    <i class="bi bi-check2 text-emerald-500 opacity-0 group-hover:opacity-100" x-show="selectedVill == v.id"></i>
                                                </div>
                                            </template>

                                            <!-- Manual Entry Option -->
                                            <div x-show="search.length >= 3" 
                                                 @click="selectedVill = ''; selectedVillName = search; selectedLat = ''; selectedLng = ''; updateVillageName(); open = false; search = ''"
                                                 class="px-5 py-4 bg-slate-50 hover:bg-amber-50 border-t border-slate-100 cursor-pointer transition-all group">
                                                <div class="flex items-center text-amber-600 font-bold text-[11px] uppercase tracking-wider mb-1">
                                                    <i class="bi bi-pencil-square mr-2"></i> Input Manual
                                                </div>
                                                <div class="text-sm text-slate-600">Gunakan <span class="font-black text-slate-900" x-text="'\'' + search + '\''"></span> sebagai Nama Desa</div>
                                                <p class="text-[10px] text-slate-400 mt-1 italic leading-tight">Pilih ini jika desa Anda tidak terdaftar di database wilayah.</p>
                                            </div>

                                            <div x-show="villages.length === 0 && search.length < 3" class="px-5 py-8 text-center text-slate-400 text-sm">
                                                <i class="bi bi-search text-3xl mb-3 block opacity-20"></i>
                                                Ketik minimal 3 huruf...
                                            </div>

                                            <div x-show="villages.length === 0 && search.length >= 3" class="px-5 py-8 text-center text-slate-400 text-sm">
                                                <i class="bi bi-info-circle text-3xl mb-3 block opacity-20 text-amber-500"></i>
                                                Desa tidak ditemukan.<br>Silakan gunakan opsi <b>Input Manual</b> di atas.
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="village_id" x-model="selectedVill">
                                    <input type="hidden" name="village_name" x-model="selectedVillName">
                                    <input type="hidden" name="bmkg_code" x-model="bmkgCode">
                                    <input type="hidden" name="village_lat" x-model="selectedLat">
                                    <input type="hidden" name="village_lng" x-model="selectedLng">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Sebutan Wilayah -->
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Sebutan Wilayah (E.g. Desa/Kelurahan)</label>
                                    <select name="village_term" x-model="villageTerm" class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm bg-white font-bold text-slate-800">
                                        <option value="Desa">Desa</option>
                                        <option value="Kelurahan">Kelurahan</option>
                                        <option value="Gampong">Gampong</option>
                                        <option value="Nagari">Nagari</option>
                                        <option value="Lainnya">Lainnya (Kustom...)</option>
                                    </select>
                                    <p class="mt-2 text-[10px] text-slate-400 font-medium tracking-wide">Pilih sebutan administratif untuk wilayah Anda.</p>
                                </div>

                                <!-- Sebutan Kustom (Visible if Lainnya selected) -->
                                <div x-show="villageTerm === 'Lainnya'" x-transition x-cloak>
                                    <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Sebutan Kustom</label>
                                    <input type="text" name="village_term_custom" value="{{ $metas['village_term_custom'] ?? '' }}" placeholder="Masukkan sebutan wilayah..."
                                           class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-bold text-slate-800">
                                </div>
                            </div>

                            <div class="pt-6 border-t border-slate-100">
                                <label class="block text-sm font-bold text-slate-700 mb-6 tracking-wide uppercase text-[11px] text-emerald-600">Statistik Kependudukan & Wilayah</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Total Populasi</label>
                                        <div class="relative">
                                            <i class="bi bi-people absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                            <input type="number" name="total_population" value="{{ $metas['total_population'] ?? '' }}" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none text-sm" placeholder="Contoh: 2540">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Luas Wilayah (Ha)</label>
                                        <div class="relative">
                                            <i class="bi bi-map absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                            <input type="text" name="village_area" value="{{ $metas['village_area'] ?? '' }}" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none text-sm" placeholder="Contoh: 184,63">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Jumlah KK</label>
                                        <div class="relative">
                                            <i class="bi bi-house-door absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                            <input type="number" name="total_families" value="{{ $metas['total_families'] ?? '' }}" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none text-sm" placeholder="Contoh: 456">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">RT / RW</label>
                                        <div class="relative">
                                            <i class="bi bi-geo-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                            <input type="text" name="total_rt_rw" value="{{ $metas['total_rt_rw'] ?? '' }}" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none text-sm" placeholder="Contoh: 12/04">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6 border-t border-slate-100">
                                <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">URL Google Maps Peta Wilayah</label>
                                <div class="relative group">
                                    <i class="bi bi-map absolute left-5 top-4 text-emerald-500 transition-transform group-focus-within:scale-110"></i>
                                    <input type="text" name="village_map_url" value="{{ $metas['village_map_url'] ?? '' }}" 
                                           class="w-full pl-12 pr-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:bg-white transition-all duration-300 hover:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none font-medium text-slate-600"
                                           placeholder="Tempel link embed atau dibiarkan saja untuk auto-generate">
                                </div>
                                <p class="mt-3 text-xs text-slate-400 italic">Dihasilkan secara otomatis jika dibiarkan kosong.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Profil Kades -->
                    <div x-show="tab == 'kades'" class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-8 md:p-10 space-y-8" x-cloak>
                        <div class="flex items-center space-x-4 border-b border-slate-100 pb-6">
                            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl shadow-inner">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900 font-display">Profil Kepala Desa</h2>
                                <p class="text-slate-500">Kelola identitas pimpinan tertinggi desa.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Nama Lengkap</label>
                                <input type="text" name="kades_name" value="{{ $metas['kades_name'] ?? '' }}" 
                                       class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Foto Kepala Desa</label>
                                <div class="relative group">
                                    <input type="file" name="kades_photo" class="hidden" id="kades_photo_input" accept="image/*" @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => { $refs.preview.src = e.target.result; }; reader.readAsDataURL(file); }">
                                    <label for="kades_photo_input" class="w-full px-5 py-4 rounded-2xl border-2 border-dashed border-slate-200 hover:border-emerald-500 hover:bg-emerald-50 cursor-pointer flex items-center transition-all duration-300">
                                        <i class="bi bi-cloud-upload text-emerald-500 text-xl mr-3"></i>
                                        <span class="text-slate-500 font-medium">Klik untuk unggah foto...</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                            <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Preview Foto</label>
                            <div class="w-40 h-40 rounded-2xl border-4 border-white shadow-lg overflow-hidden bg-white mx-auto">
                                <img x-ref="preview" src="{{ isset($metas['kades_photo']) ? (Str::startsWith($metas['kades_photo'], 'http') ? $metas['kades_photo'] : asset('storage/'.$metas['kades_photo'])) : 'https://ui-avatars.com/api/?name=Kades&background=10b981&color=fff' }}" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Sambutan / Pengantar</label>
                            <textarea name="kades_greeting" rows="5" class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm">{{ $metas['kades_greeting'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- Section: Visi & Misi -->
                    <div x-show="tab == 'vision'" class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-8 md:p-10 space-y-8" x-cloak>
                        <div class="flex items-center space-x-4 border-b border-slate-100 pb-6">
                            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl shadow-inner">
                                <i class="bi bi-journal-bookmark"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900 font-display">Profil & Tata Kelola</h2>
                                <p class="text-slate-500">Kelola sejarah, visi misi, dan struktur organisasi desa.</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Sejarah Desa</label>
                            <textarea name="village_history" rows="6" class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm leading-relaxed">{{ $metas['village_history'] ?? '' }}</textarea>
                            <p class="mt-2 text-xs text-slate-400 italic">Ceritakan asal-usul dan sejarah berdirinya desa Anda.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Visi Desa</label>
                            <textarea name="village_vision" rows="3" class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-display text-lg font-bold text-slate-800">{{ $metas['village_vision'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Misi Desa (Gunakan baris baru untuk setiap poin)</label>
                            <textarea name="village_mission" rows="6" class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm leading-relaxed">{{ $metas['village_mission'] ?? '' }}</textarea>
                        </div>

                        <div class="pt-6 border-t border-slate-100">
                            <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Struktur Organisasi (Gambar)</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="relative group">
                                    <input type="file" name="village_org_chart" class="hidden" id="org_chart_input" accept="image/*" @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => { $refs.orgPreview.src = e.target.result; }; reader.readAsDataURL(file); }">
                                    <label for="org_chart_input" class="w-full px-5 py-8 rounded-2xl border-2 border-dashed border-slate-200 hover:border-emerald-500 hover:bg-emerald-50 cursor-pointer flex flex-col items-center justify-center transition-all duration-300">
                                        <i class="bi bi-diagram-3 text-emerald-500 text-3xl mb-2"></i>
                                        <span class="text-slate-500 font-bold text-sm">Unggah Bagan Organisasi</span>
                                        <span class="text-slate-400 text-xs mt-1">PNG, JPG (Max. 5MB)</span>
                                    </label>
                                </div>
                                <div class="bg-slate-50 rounded-2xl border border-slate-100 p-4 flex items-center justify-center min-h-[150px]">
                                    <img x-ref="orgPreview" src="{{ isset($metas['village_org_chart']) ? (Str::startsWith($metas['village_org_chart'], 'http') ? $metas['village_org_chart'] : asset('storage/'.$metas['village_org_chart'])) : 'https://placehold.co/600x400?text=Struktur+Belum+Diunggah' }}" class="max-h-32 rounded shadow-sm object-contain">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Tampilan Situs -->
                    <div x-show="tab == 'appearance'" class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-8 md:p-10 space-y-8" x-cloak>
                        <div class="flex items-center space-x-4 border-b border-slate-100 pb-6">
                            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl shadow-inner">
                                <i class="bi bi-palette"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900 font-display">Tampilan Visual Situs</h2>
                                <p class="text-slate-500">Sesuaikan logo, ikon, dan gambar pendukung website.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <!-- Logo Utama -->
                            <div class="space-y-4">
                                <label class="block text-sm font-bold text-slate-700 tracking-wide uppercase text-[11px]">Logo Instansi (PNG Transparan Disarankan)</label>
                                <div class="relative group">
                                    <input type="file" name="site_logo" class="hidden" id="site_logo_input" accept="image/*" @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => { $refs.logoPreview.src = e.target.result; }; reader.readAsDataURL(file); }">
                                    <label for="site_logo_input" class="w-full h-32 rounded-2xl border-2 border-dashed border-slate-200 hover:border-emerald-500 hover:bg-emerald-50 cursor-pointer flex flex-col items-center justify-center transition-all duration-300">
                                        <i class="bi bi-image text-emerald-500 text-2xl mb-1"></i>
                                        <span class="text-slate-400 text-xs font-semibold">Ganti Logo</span>
                                    </label>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex items-center justify-center min-h-[100px]">
                                    <img x-ref="logoPreview" src="{{ isset($metas['site_logo']) ? (Str::startsWith($metas['site_logo'], 'http') ? $metas['site_logo'] : asset('storage/'.$metas['site_logo'])) : 'https://placehold.co/400x100?text=Logo+Desa' }}" class="max-h-20 object-contain">
                                </div>
                            </div>

                            <!-- Favicon Browser -->
                            <div class="space-y-4">
                                <label class="block text-sm font-bold text-slate-700 tracking-wide uppercase text-[11px]">Favicon Browser (Ikon Tab)</label>
                                <div class="relative group">
                                    <input type="file" name="site_favicon" class="hidden" id="site_favicon_input" accept="image/x-icon,image/png" @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => { $refs.faviconPreview.src = e.target.result; }; reader.readAsDataURL(file); }">
                                    <label for="site_favicon_input" class="w-full h-32 rounded-2xl border-2 border-dashed border-slate-200 hover:border-emerald-500 hover:bg-emerald-50 cursor-pointer flex flex-col items-center justify-center transition-all duration-300">
                                        <i class="bi bi-app-indicator text-emerald-500 text-2xl mb-1"></i>
                                        <span class="text-slate-400 text-xs font-semibold">Ganti Favicon</span>
                                    </label>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex items-center justify-center min-h-[100px]">
                                    <img x-ref="faviconPreview" src="{{ isset($metas['site_favicon']) ? (Str::startsWith($metas['site_favicon'], 'http') ? $metas['site_favicon'] : asset('storage/'.$metas['site_favicon'])) : 'https://placehold.co/64x64?text=F' }}" class="w-12 h-12 object-contain">
                                </div>
                            </div>
                        </div>

                        <!-- Hero Image Banner -->
                        <div class="space-y-4 pt-4">
                            <label class="block text-sm font-bold text-slate-700 tracking-wide uppercase text-[11px]">Gambar Hero (Banner Utama Halaman Depan)</label>
                            <div class="relative group">
                                <input type="file" name="site_hero_image" class="hidden" id="site_hero_input" accept="image/*" @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => { $refs.heroPreview.src = e.target.result; }; reader.readAsDataURL(file); }">
                                <label for="site_hero_input" class="w-full h-40 rounded-3xl border-2 border-dashed border-slate-200 hover:border-emerald-500 hover:bg-emerald-50 cursor-pointer flex flex-col items-center justify-center transition-all duration-300 overflow-hidden relative">
                                    <div class="absolute inset-0 bg-slate-900/40 z-10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                         <span class="bg-white text-slate-900 px-4 py-2 rounded-xl font-bold shadow-xl">Ubah Banner Utama</span>
                                    </div>
                                    <img x-ref="heroPreview" src="{{ isset($metas['site_hero_image']) ? (Str::startsWith($metas['site_hero_image'], 'http') ? $metas['site_hero_image'] : asset('storage/'.$metas['site_hero_image'])) : 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2013&auto=format&fit=crop' }}" class="w-full h-full object-cover">
                                </label>
                            </div>
                            <p class="text-xs text-slate-400 italic font-medium mt-2"><i class="bi bi-info-circle mr-1"></i> Gunakan gambar resolusi tinggi (min. 1920x1080) untuk hasil terbaik.</p>
                        </div>
                    </div>

                    <!-- Section: Kontak & Sosmed -->
                    <div x-show="tab == 'contact'" class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-8 md:p-10 space-y-8" x-cloak>
                        <div class="flex items-center space-x-4 border-b border-slate-100 pb-6">
                            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl shadow-inner">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900 font-display">Kontak & Media Sosial</h2>
                                <p class="text-slate-500">Kelola informasi kontak kantor dan tautan media sosial resmi.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Email Pelayanan</label>
                                <div class="relative">
                                    <i class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-emerald-500"></i>
                                    <input type="email" name="office_email" value="{{ $metas['office_email'] ?? '' }}" placeholder="desa@mail.go.id"
                                           class="w-full pl-12 pr-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">No. Telepon / WhatsApp Kantor</label>
                                <div class="relative">
                                    <i class="bi bi-telephone absolute left-4 top-1/2 -translate-y-1/2 text-emerald-500"></i>
                                    <input type="text" name="office_phone" value="{{ $metas['office_phone'] ?? '' }}" placeholder="021-xxxxxx atau 08xxxx"
                                           class="w-full pl-12 pr-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Alamat Kantor Lengkap</label>
                            <div class="relative">
                                <i class="bi bi-geo-alt absolute left-4 top-4 text-emerald-500"></i>
                                <textarea name="office_address" rows="3" placeholder="Jl. Raya Utama No. 1..."
                                          class="w-full pl-12 pr-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm">{{ $metas['office_address'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Jam Operasional Kantor</label>
                            <div class="relative">
                                <i class="bi bi-clock absolute left-4 top-1/2 -translate-y-1/2 text-emerald-500"></i>
                                <input type="text" name="office_hours" value="{{ $metas['office_hours'] ?? '' }}" placeholder="Senin - Jumat: 08:00 - 15:00"
                                       class="w-full pl-12 pr-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Tautan Layanan Mandiri (Tombol Dashboard Warga)</label>
                            <div class="relative">
                                <i class="bi bi-link-45deg absolute left-4 top-1/2 -translate-y-1/2 text-emerald-500"></i>
                                <input type="url" name="self_service_link" value="{{ $metas['self_service_link'] ?? '' }}" placeholder="https://layanan.desa.go.id"
                                       class="w-full pl-12 pr-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm">
                            </div>
                            <p class="mt-2 text-xs text-slate-400 italic">Tombol di halaman beranda hanya akan tampil jika tautan ini diisi.</p>
                        </div>

                        <div class="pt-6 border-t border-slate-100">
                            <label class="block text-sm font-bold text-slate-700 mb-6 tracking-wide uppercase text-[11px] text-emerald-600 font-black">Tautan Media Sosial</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">Facebook URL</label>
                                    <div class="relative">
                                        <i class="bi bi-facebook absolute left-4 top-1/2 -translate-y-1/2 text-blue-600"></i>
                                        <input type="url" name="social_facebook" value="{{ $metas['social_facebook'] ?? '' }}" placeholder="https://facebook.com/..."
                                               class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none text-sm shadow-sm transition-all">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">Instagram URL</label>
                                    <div class="relative">
                                        <i class="bi bi-instagram absolute left-4 top-1/2 -translate-y-1/2 text-pink-600"></i>
                                        <input type="url" name="social_instagram" value="{{ $metas['social_instagram'] ?? '' }}" placeholder="https://instagram.com/..."
                                               class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none text-sm shadow-sm transition-all">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">YouTube URL</label>
                                    <div class="relative">
                                        <i class="bi bi-youtube absolute left-4 top-1/2 -translate-y-1/2 text-red-600"></i>
                                        <input type="url" name="social_youtube" value="{{ $metas['social_youtube'] ?? '' }}" placeholder="https://youtube.com/..."
                                               class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none text-sm shadow-sm transition-all">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">TikTok URL</label>
                                    <div class="relative">
                                        <i class="bi bi-tiktok absolute left-4 top-1/2 -translate-y-1/2 text-slate-900"></i>
                                        <input type="url" name="social_tiktok" value="{{ $metas['social_tiktok'] ?? '' }}" placeholder="https://tiktok.com/..."
                                               class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none text-sm shadow-sm transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Email & SMTP -->
                    <div x-show="tab == 'email'" class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-8 md:p-10 space-y-8" x-cloak>
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-6 mb-8">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl shadow-inner">
                                    <i class="bi bi-server"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-slate-900 font-display">Server Email (SMTP)</h2>
                                    <p class="text-slate-500">Konfigurasi pengiriman email otomatis sistem.</p>
                                </div>
                            </div>
                            <!-- Preset Dropdown -->
                            <div class="md:w-64">
                                <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2 px-1">Gunakan Preset</label>
                                <select 
                                    @change="
                                        if($event.target.value == 'gmail') {
                                            $refs.mail_host.value = 'smtp.gmail.com';
                                            $refs.mail_port.value = '587';
                                            $refs.mail_encryption.value = 'tls';
                                        } else if($event.target.value == 'mailtrap') {
                                            $refs.mail_host.value = 'sandbox.smtp.mailtrap.io';
                                            $refs.mail_port.value = '2525';
                                            $refs.mail_encryption.value = 'tls';
                                        }
                                    "
                                    class="w-full px-5 py-3 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700 text-xs font-bold outline-none focus:ring-2 focus:ring-emerald-500/20 translate-y-[-2px]">
                                    <option value="">-- Pilih Provider --</option>
                                    <option value="gmail">Google Mail (Gmail)</option>
                                    <option value="mailtrap">Mailtrap (Testing)</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">SMTP Host</label>
                                <input type="text" name="mail_host" x-ref="mail_host" value="{{ $metas['mail_host'] ?? '' }}" placeholder="smtp.gmail.com"
                                       class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">SMTP Port</label>
                                <input type="number" name="mail_port" x-ref="mail_port" value="{{ $metas['mail_port'] ?? '587' }}" placeholder="587"
                                       class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">SMTP Username</label>
                                <input type="text" name="mail_username" value="{{ $metas['mail_username'] ?? '' }}" placeholder="email@gmail.com"
                                       class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">SMTP Password</label>
                                <input type="password" name="mail_password" value="{{ $metas['mail_password'] ?? '' }}" placeholder="••••••••••••"
                                       class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Mail Encryption</label>
                                <select name="mail_encryption" x-ref="mail_encryption" class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm appearance-none bg-white">
                                    <option value="tls" {{ ($metas['mail_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ ($metas['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                    <option value="" {{ ($metas['mail_encryption'] ?? '') == '' ? 'selected' : '' }}>None</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-3 tracking-wide uppercase text-[11px]">Mail From Address</label>
                                <input type="email" name="mail_from_address" value="{{ $metas['mail_from_address'] ?? '' }}" placeholder="noreply@desa.go.id"
                                       class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm">
                            </div>
                        </div>

                        <div class="p-6 bg-amber-50 rounded-3xl border border-amber-100 flex items-start space-x-4">
                            <i class="bi bi-info-circle-fill text-amber-500 mt-1"></i>
                            <div>
                                <p class="text-[11px] font-black text-amber-800 uppercase tracking-widest mb-1">Catatan Penting</p>
                                <p class="text-xs text-amber-700 leading-relaxed">Pengaturan ini akan menimpa (override) file .env di server. Jika menggunakan Gmail, pastikan Anda menggunakan <strong>App Password</strong> dan mengaktifkan verifikasi 2 langkah.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Template Email -->
                    <div x-show="tab == 'templates'" class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-8 md:p-10 space-y-8" x-cloak>
                        <div class="flex items-center space-x-4 border-b border-slate-100 pb-6">
                            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl shadow-inner">
                                <i class="bi bi-magic"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900 font-display">Template Email Otomatis</h2>
                                <p class="text-slate-500">Email sistem kini menggunakan desain "Zenith" yang premium.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Template: Akun Aktif -->
                            <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 space-y-4">
                                <h3 class="text-sm font-black text-emerald-600 uppercase tracking-widest flex items-center">
                                    <i class="bi bi-check-circle-fill mr-2"></i> Aktivasi Akun
                                </h3>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest px-1">Subjek Email</label>
                                    <input type="text" name="email_activation_subject" value="{{ $metas['email_activation_subject'] ?? 'Akun Anda Telah Aktif!' }}"
                                           class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-bold text-slate-800">
                                </div>
                                <div class="p-4 bg-white rounded-2xl border border-emerald-100 text-[11px] text-slate-500 leading-relaxed italic">
                                    Isi email otomatis menggunakan layout premium dengan nama warga dan tautan login yang sudah terintegrasi.
                                </div>
                            </div>

                            <!-- Template: Reset Password -->
                            <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 space-y-4">
                                <h3 class="text-sm font-black text-amber-600 uppercase tracking-widest flex items-center">
                                    <i class="bi bi-shield-lock-fill mr-2"></i> Reset Password
                                </h3>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest px-1">Subjek Email</label>
                                    <input type="text" name="email_password_reset_subject" value="{{ $metas['email_password_reset_subject'] ?? 'Instruksi Atur Ulang Kata Sandi' }}"
                                           class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-bold text-slate-800">
                                </div>
                                <div class="p-4 bg-white rounded-2xl border border-amber-100 text-[11px] text-slate-500 leading-relaxed italic">
                                    Isi email berisi instruksi pemulihan keamanan yang aman dan instruksi kedaluwarsa tautan.
                                </div>
                            </div>
                        </div>

                        <div class="p-6 bg-emerald-600 rounded-[2rem] text-white overflow-hidden relative group">
                            <div class="relative z-10">
                                <h4 class="font-bold text-lg mb-2">💡 Tips Desain Premium</h4>
                                <p class="text-emerald-50 text-sm leading-relaxed opacity-90">
                                    Email Anda kini menggunakan skema warna <strong>Emerald Green</strong> agar selaras dengan identitas Portal Desa. Semua gambar dan tombol sudah dioptimalkan agar tampil sempurna di Smartphone maupun Desktop.
                                </p>
                            </div>
                            <i class="bi bi-send-check absolute -right-4 -bottom-4 text-8xl text-white/10 -rotate-12 group-hover:scale-110 transition-transform duration-500"></i>
                        </div>
                    </div>

                    <!-- Sticky Action Bar -->
                    <div class="fixed bottom-8 left-1/2 -translate-x-1/2 w-full max-w-[90%] md:max-w-2xl bg-white/80 backdrop-blur-xl p-4 rounded-[2rem] border border-white/50 shadow-2xl flex items-center justify-between z-[1000] animate-bounce-in">
                        <div class="flex items-center px-4">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse mr-2"></span>
                            <span class="text-xs font-bold uppercase tracking-widest text-slate-400 hidden sm:inline">Ready to save</span>
                        </div>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 px-10 rounded-2xl shadow-lg shadow-emerald-200 hover:-translate-y-1 hover:scale-105 transition-all duration-300 flex items-center">
                            <i class="bi bi-save2-fill mr-3"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #10b981; }

    [x-cloak] { display: none !important; }
    
    .animate-bounce-in {
        animation: bounce-in 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    @keyframes bounce-in {
        from { opacity: 0; transform: translate(-50%, 20px) scale(0.95); }
        to { opacity: 1; transform: translate(-50%, 0) scale(1); }
    }
</style>
@endsection
