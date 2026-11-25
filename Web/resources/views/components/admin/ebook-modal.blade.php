@props([
    'action' => route('admin.ebooks.store'),
    'ebook'  => null,
])

@php
    $isEdit  = $ebook !== null;
    $modalId = 'modalEbook';
@endphp

<div id="{{ $modalId }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[92vh] overflow-y-auto">

        {{-- HEADER --}}
        <div class="flex items-start gap-3 px-6 pt-6 pb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0">
                <i class="fas {{ $isEdit ? 'fa-pen' : 'fa-book-open' }} text-blue-600"></i>
            </div>
            <div class="flex-1">
                <h3 id="modalTitle" class="text-base font-bold text-gray-900">
                    {{ $isEdit ? 'Edit Kamus: ' . $ebook->judul : 'Tambah Kamus Boso Walikan Baru' }}
                </h3>
                <p id="modalSubtitle" class="text-xs text-gray-500 mt-0.5">
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
            <input type="hidden" id="methodField" name="_method" value="{{ $isEdit ? 'PUT' : '' }}">

            {{-- Judul --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-700">Judul Kamus <span class="text-red-500">*</span></label>
                <input type="text" name="judul" id="f_judul" required
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                @error('judul') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Penulis & Kategori --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-700">Penulis / Kurator <span class="text-red-500">*</span></label>
                    <input type="text" name="penulis" id="f_penulis" required
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                    @error('penulis') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-700">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" id="f_kategori" required
                            class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                        <option value="">— Pilih Kategori —</option>
                        @foreach(['Saku','Akbar','Digital','Cetak','Anak','Akademis'] as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Sampul --}}
            <div class="space-y-1.5">
                <label for="inputCover" class="text-xs font-semibold text-gray-700">Gambar Sampul (JPG, PNG, atau WebP, maks. 2 MB)</label>
                <input type="file" id="inputCover" name="cover_image" accept="image/jpeg,image/png,image/webp"
                       class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-gray-600 file:mr-3 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-blue-700">
                <p class="text-[11px] text-gray-400">Kosongkan saat edit jika sampul tidak ingin diganti.</p>
                @error('cover_image') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-700">Deskripsi Ringkas <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" id="f_deskripsi" rows="3" required
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all resize-none"></textarea>
                @error('deskripsi') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Harga --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-700">Harga Satuan (Rp) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-400">Rp</span>
                    <input type="number" name="harga" id="f_harga" required min="0"
                           class="w-full pl-10 pr-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                </div>
                @error('harga') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Dropzone PDF --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-700">Berkas E-Book PDF <span class="text-red-500" id="reqFile">*</span></label>
                <div id="dropzone"
                     class="border-2 border-dashed border-blue-200 bg-blue-50/40 hover:bg-blue-50 rounded-xl p-6 text-center cursor-pointer transition-all">
                    <i class="fas fa-cloud-upload-alt text-3xl text-blue-500 mb-2"></i>
                    <p class="text-sm text-gray-700">Tarik & Lepas Dokumen PDF Kamus di Sini atau <span class="text-blue-600 font-semibold underline underline-offset-2">Jelajahi File</span></p>
                    <p class="text-[11px] text-gray-400 mt-1">Mendukung PDF hingga 100MB</p>
                    <input type="file" id="inputPdf" name="file_pdf" accept="application/pdf" class="hidden">
                    @error('file_pdf') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Preview file --}}
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

                {{-- File existing saat edit --}}
                @if($isEdit && $ebook->file_pdf)
                <div id="currentFile" class="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-2 bg-gray-50">
                    <i class="fas fa-file-pdf text-red-500 text-lg"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-800 truncate">{{ basename($ebook->file_pdf) }}</p>
                        <p class="text-[10px] text-gray-400">File saat ini (kosongkan upload jika tidak diganti)</p>
                    </div>
                </div>
                @endif
            </div>

            {{-- FOOTER --}}
            <div class="flex items-center justify-between pt-2">
                <button type="button" onclick="toggleModal('{{ $modalId }}')" class="px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 rounded-lg transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md shadow-blue-600/25 transition-all flex items-center gap-2">
                    <i class="fas fa-rocket"></i> <span id="submitText">Simpan & Publikasikan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    /* ===== TOGGLE MODAL ===== */
    function toggleModal(id) {
        const m = document.getElementById(id);
        const open = m.classList.contains('hidden');
        m.classList.toggle('hidden', !open);
        m.classList.toggle('flex', open);
        document.body.style.overflow = open ? 'hidden' : 'auto';
    }

    /* ===== FORMAT BYTE ===== */
    function formatBytes(b) {
        if (b < 1024) return b + ' B';
        if (b < 1048576) return (b / 1024).toFixed(1) + ' KB';
        return (b / 1048576).toFixed(1) + ' MB';
    }

    /* ===== SHOW / CLEAR PREVIEW ===== */
    function showPreview(file) {
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = formatBytes(file.size);
        const p = document.getElementById('filePreview');
        p.classList.remove('hidden'); p.classList.add('flex');
    }
    function clearPdf() {
        const input = document.getElementById('inputPdf');
        input.value = '';
        const p = document.getElementById('filePreview');
        p.classList.add('hidden'); p.classList.remove('flex');
    }

    /* ===== DROPZONE LOGIC ===== */
    (function () {
        const dz = document.getElementById('dropzone');
        const input = document.getElementById('inputPdf');
        if (!dz || !input) return;

        dz.addEventListener('click', () => input.click());

        input.addEventListener('change', () => {
            if (input.files.length) showPreview(input.files[0]); else clearPdf();
        });

        ['dragenter', 'dragover'].forEach(ev =>
            dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.add('border-blue-500','bg-blue-100'); }));

        ['dragleave', 'drop'].forEach(ev =>
            dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.remove('border-blue-500','bg-blue-100'); }));

        dz.addEventListener('drop', e => {
            const files = e.dataTransfer.files;
            if (files.length && files[0].type === 'application/pdf') {
                input.files = files;
                showPreview(files[0]);
            } else {
                alert('Hanya file PDF yang diterima!');
            }
        });
    })();

    /* ===== OPEN CREATE / EDIT ===== */
    function openCreateModal() {
        document.getElementById('formEbook').action = '{{ route('admin.ebooks.store') }}';
        document.getElementById('methodField').value = '';
        document.getElementById('modalTitle').textContent = 'Tambah Kamus Boso Walikan Baru';
        document.getElementById('modalSubtitle').textContent = 'Isi detail metadata buku dan unggah dokumen versi resmi.';
        document.getElementById('submitText').textContent = 'Simpan & Publikasikan';
        document.getElementById('f_judul').value = '';
        document.getElementById('f_penulis').value = '';
        document.getElementById('f_kategori').value = '';
        document.getElementById('f_deskripsi').value = '';
        document.getElementById('f_harga').value = '';
        document.getElementById('inputCover').value = '';
        document.getElementById('inputPdf').required = true;
        document.getElementById('reqFile').style.display = '';
        clearPdf();
        toggleModal('modalEbook');
    }

    function openEditModal(e) {
        document.getElementById('formEbook').action = `/admin/ebooks/${e.id}`;
        document.getElementById('methodField').value = 'PUT';
        document.getElementById('modalTitle').textContent = 'Edit Kamus: ' + (e.judul || '');
        document.getElementById('modalSubtitle').textContent = 'Perbarui metadata dan berkas dokumen kamus.';
        document.getElementById('submitText').textContent = 'Perbarui & Simpan';
        document.getElementById('f_judul').value = e.judul || '';
        document.getElementById('f_penulis').value = e.penulis || '';
        document.getElementById('f_kategori').value = e.kategori || '';
        document.getElementById('f_deskripsi').value = e.deskripsi || '';
        document.getElementById('f_harga').value = e.harga || 0;
        document.getElementById('inputCover').value = '';
        document.getElementById('inputPdf').required = false;
        document.getElementById('reqFile').style.display = 'none';
        clearPdf();
        toggleModal('modalEbook');
    }

    /* Tutup saat klik backdrop */
    document.getElementById('{{ $modalId }}').addEventListener('click', function (e) {
        if (e.target === this) toggleModal('{{ $modalId }}');
    });
</script>