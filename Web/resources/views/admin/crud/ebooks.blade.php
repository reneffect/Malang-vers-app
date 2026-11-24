@props([
    'action' => route('admin.ebooks.store'),
    'method' => 'POST',
    'ebook' => null, // Kirim data ebook kalau mau mode edit
])

@php
    $isEdit = $ebook !== null;
    $modalId = 'modalEbook';
@endphp

{{-- ===== WRAPPER MODAL ===== --}}
<div id="{{ $modalId }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[92vh] overflow-y-auto">

        {{-- HEADER --}}
        <div class="flex items-start gap-3 px-6 pt-6 pb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0">
                <i class="fas {{ $isEdit ? 'fa-pen' : 'fa-book-open' }} text-blue-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-base font-bold text-gray-900">
                    {{ $isEdit ? 'Edit Kamus: ' . $ebook->judul : 'Tambah Kamus Boso Walikan Baru' }}
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ $isEdit ? 'Perbarui metadata dan berkas dokumen kamus.' : 'Isi detail metadata buku dan unggah dokumen versi resmi.' }}
                </p>
            </div>
            <button type="button" onclick="toggleModal('{{ $modalId }}')"
                    class="w-8 h-8 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 flex items-center justify-center transition-colors shrink-0">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        {{-- FORM --}}
        <form id="formEbook" method="POST" enctype="multipart/form-data" action="{{ $action }}" class="px-6 pb-6 space-y-5">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            {{-- Judul --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-700">Judul Kamus <span class="text-red-500">*</span></label>
                <input type="text" name="judul" required value="{{ old('judul', $ebook->judul ?? '') }}"
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                @error('judul') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Penulis & Kategori --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-700">Penulis / Kurator <span class="text-red-500">*</span></label>
                    <input type="text" name="penulis" required value="{{ old('penulis', $ebook->penulis ?? '') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                    @error('penulis') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-700">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" required class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                        <option value="">— Pilih Kategori —</option>
                        @foreach(['Saku','Akbar','Digital','Cetak','Anak','Akademis'] as $cat)
                            <option value="{{ $cat }}" {{ old('kategori', $ebook->kategori ?? '') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-700">Deskripsi Ringkas <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="3" required class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all resize-none">{{ old('deskripsi', $ebook->deskripsi ?? '') }}</textarea>
                @error('deskripsi') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Harga --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-700">Harga Satuan (Rp) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-400">Rp</span>
                    <input type="number" name="harga" required min="0" value="{{ old('harga', $ebook->harga ?? '') }}"
                           class="w-full pl-10 pr-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                </div>
                @error('harga') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Dropzone PDF --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-700">Berkas E-Book PDF <span class="text-red-500">*</span></label>
                <div id="dropzone" class="border-2 border-dashed border-blue-200 bg-blue-50/40 hover:bg-blue-50 rounded-xl p-6 text-center cursor-pointer transition-all">
                    <i class="fas fa-cloud-upload-alt text-3xl text-blue-500 mb-2"></i>
                    <p class="text-sm text-gray-700">Tarik & Lepas Dokumen PDF Kamus di Sini atau <span class="text-blue-600 font-semibold underline underline-offset-2">Jelajahi File</span></p>
                    <p class="text-[11px] text-gray-400 mt-1">Mendukung PDF hingga 100MB</p>
                    <input type="file" id="inputPdf" name="file_pdf" accept="application/pdf" class="hidden" {{ !$isEdit ? 'required' : '' }}>
                    @error('file_pdf') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div id="filePreview" class="hidden items-center gap-2 border border-gray-200 rounded-lg px-3 py-2 bg-white">
                    <i class="fas fa-file-pdf text-red-500 text-lg"></i>
                    <div class="flex-1 min-w-0">
                        <p id="fileName" class="text-xs font-semibold text-gray-800 truncate">file.pdf</p>
                        <p id="fileSize" class="text-[10px] text-gray-400">0 MB</p>
                    </div>
                    <button type="button" onclick="clearPdf()" class="w-6 h-6 rounded-full bg-gray-100 hover:bg-red-100 text-gray-500 hover:text-red-600 flex items-center justify-center transition-colors shrink-0">
                        <i class="fas fa-times text-[10px]"></i>
                    </button>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="flex items-center justify-between pt-2">
                <button type="button" onclick="toggleModal('{{ $modalId }}')" class="px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 rounded-lg transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md shadow-blue-600/25 transition-all flex items-center gap-2">
                    <i class="fas fa-rocket"></i> {{ $isEdit ? 'Perbarui & Simpan' : 'Simpan & Publikasikan' }}
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script khusus modal ini --}}
<script>
    function toggleModal(id) {
        const m = document.getElementById(id);
        m.classList.toggle('hidden'); m.classList.toggle('flex');
        document.body.style.overflow = m.classList.contains('hidden') ? 'auto' : 'hidden';
    }
    // (Tambahkan logic drag & drop PDF di sini atau di file JS global Ni-sama)
</script>