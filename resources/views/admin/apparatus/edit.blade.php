@extends('layouts.admin')

@section('title', 'Ubah Aparatur')

@section('content')
<!-- Cropper.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">

<div class="space-y-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center space-x-4 mb-8">
            <a href="{{ route('apparatus.index') }}" class="text-gray-500 hover:text-gray-700 bg-white p-2 rounded-lg shadow-sm border border-gray-200">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Ubah Data Aparatur</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <form id="apparatusForm" action="{{ route('apparatus.update', $apparatus->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="cropped_image" id="cropped_image">

                <div class="p-8 space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $apparatus->name ?? '') }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 outline-none" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jabatan (Contoh: Kepala Desa, Kaur Umum)</label>
                        <input type="text" name="role" value="{{ old('role', $apparatus->role ?? '') }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 outline-none" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pas Foto Formal (Auto Crop 4:3)</label>
                        
                        <div class="flex items-start space-x-6">
                            <div class="w-32 h-44 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center bg-gray-50 overflow-hidden relative">
                                <img id="previewImage" src="{{ $apparatus->image ? asset('storage/'.$apparatus->image) : '' }}" class="{{ $apparatus->image ? '' : 'hidden' }} w-full h-full object-cover">
                                <div id="placeholderIcon" class="{{ $apparatus->image ? 'hidden' : '' }} text-gray-300 text-center">
                                    <i class="bi bi-person-bounding-box text-3xl"></i>
                                    <p class="text-[10px] mt-1 uppercase font-bold">Rasio 4:3</p>
                                </div>
                            </div>
                            
                            <div class="flex-1">
                                <input type="file" id="imageInput" accept="image/*" class="w-full px-4 py-3 rounded-xl border border-gray-300 outline-none text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                <p class="mt-2 text-xs text-gray-400 italic">Pilih foto untuk memotong secara otomatis sesuai rasio formal.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Atasan Langsung (Untuk Bagan)</label>
                            <select name="parent_id" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 outline-none appearance-none">
                                <option value="">-- Tanpa Atasan (Puncak Struktur) --</option>
                                @foreach($allApparatus as $staff)
                                    <option value="{{ $staff->id }}" {{ old('parent_id', $apparatus->parent_id ?? '') == $staff->id ? 'selected' : '' }}>
                                        {{ $staff->role }} - {{ $staff->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Garis Hubungan</label>
                            <div class="flex items-center space-x-4 mt-2">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="connection_type" value="komando" class="hidden peer" {{ old('connection_type', $apparatus->connection_type ?? 'komando') == 'komando' ? 'checked' : '' }}>
                                    <div class="px-4 py-2 rounded-lg border border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition">
                                        <i class="bi bi-dash-lg mr-2"></i> Garis Komando
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="connection_type" value="koordinasi" class="hidden peer" {{ old('connection_type', $apparatus->connection_type ?? '') == 'koordinasi' ? 'checked' : '' }}>
                                    <div class="px-4 py-2 rounded-lg border border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition">
                                        <i class="bi bi-dash mr-2 border-b border-dashed border-current"></i> Garis Koordinasi
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-8 rounded-xl transition shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        
    </div>
</div>

<!-- Cropping Modal -->
<div id="cropperModal" class="fixed inset-0 z-[70] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" id="backdrop"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all w-full max-w-xl border border-white/20">
            <div class="bg-white p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-900 flex items-center">
                        <i class="bi bi-crop mr-3 text-emerald-500"></i> Sesuaikan Pas Foto
                    </h3>
                    <p class="text-[10px] font-black bg-slate-100 px-3 py-1 rounded-full uppercase tracking-widest text-slate-500">Formal 3:4</p>
                </div>
                
                <div class="relative rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 aspect-[3/4] max-h-[60vh]">
                    <img id="cropperImage" src="" class="block max-w-full">
                </div>
            </div>
            
            <div class="bg-slate-50 px-6 py-5 flex flex-col sm:flex-row-reverse gap-3">
                <button type="button" id="cropButton" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl bg-emerald-600 px-8 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:-translate-y-0.5 transition-all outline-none">
                    <i class="bi bi-check-lg mr-2"></i> Selesai & Simpan
                </button>
                <button type="button" id="cancelCrop" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl bg-white border border-slate-200 px-6 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all outline-none">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cropper.js JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('imageInput');
    const croppedImageInput = document.getElementById('cropped_image');
    const previewImage = document.getElementById('previewImage');
    const placeholderIcon = document.getElementById('placeholderIcon');
    const cropperModal = document.getElementById('cropperModal');
    const cropperImage = document.getElementById('cropperImage');
    const cropButton = document.getElementById('cropButton');
    const cancelCrop = document.getElementById('cancelCrop');
    
    let cropper;

    imageInput.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const reader = new FileReader();
            reader.onload = function() {
                cropperImage.src = reader.result;
                cropperModal.classList.remove('hidden');
                
                if (cropper) {
                    cropper.destroy();
                }
                
                cropper = new Cropper(cropperImage, {
                    aspectRatio: 0.75, // 3:4
                    viewMode: 1,
                    dragMode: 'move',
                });
            };
            reader.readAsDataURL(files[0]);
        }
    });

    cropButton.addEventListener('click', function() {
        const canvas = cropper.getCroppedCanvas({
            width: 600,
            height: 800,
        });
        
        const base64Image = canvas.toDataURL('image/jpeg');
        croppedImageInput.value = base64Image;
        previewImage.src = base64Image;
        previewImage.classList.remove('hidden');
        placeholderIcon.classList.add('hidden');
        cropperModal.classList.add('hidden');
    });

    cancelCrop.addEventListener('click', function() {
        cropperModal.classList.add('hidden');
        imageInput.value = '';
    });
});
</script>
@endsection
