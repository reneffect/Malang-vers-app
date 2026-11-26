@extends('admin.layout')
@section('title', 'Manage E-Book')

@section('content')
@php
    $totalAktif      = $totalAktif      ?? $ebooks->getCollection()->where('sudah_diterbitkan', true)->count();
    $totalUnduhan    = $totalUnduhan    ?? 0;
    $totalPendapatan = $totalPendapatan ?? 0;
@endphp

{{-- ===== HEADER ===== --}}
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kelola Kamus Boso Walikan</h2>
            <p class="text-sm text-gray-500 mt-1">Manajemen inventaris e-book kamus resmi dialek kiwalan Malang</p>
        </div>
        <button type="button" onclick="openCreateModal()"
                class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-full shadow-md shadow-blue-600/25 flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Kamus Baru
        </button>
    </div>
</div>

{{-- ===== KARTU STATISTIK ===== --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-medium text-gray-500">Total Kamus Aktif</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalAktif, 0, ',', '.') }} Judul</p>
        </div>
        <div class="w-11 h-11 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.04v12.5m0-12.5C10.6 4.8 8.7 4.1 6.75 4.1c-1.05 0-2.06.18-3 .52v12.5c.94-.34 1.95-.52 3-.52 1.95 0 3.85.7 5.25 1.94m0-12.5c1.4-1.24 3.3-1.94 5.25-1.94 1.05 0 2.06.18 3 .52v12.5c-.94-.34-1.95-.52-3-.52-1.95 0-3.85.7-5.25 1.94"/></svg>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-medium text-gray-500">Total Unduhan</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalUnduhan, 0, ',', '.') }}x</p>
        </div>
        <div class="w-11 h-11 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-medium text-gray-500">Pendapatan E-Book</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
        <div class="w-11 h-11 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3"/></svg>
        </div>
    </div>
</div>

{{-- ===== NOTIFIKASI ===== --}}
@if (session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ===== TABEL ===== --}}
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="flex items-center gap-2 px-6 py-4 border-b border-gray-100">
        <h3 class="text-base font-bold text-gray-900">Inventaris Dokumen E-Book</h3>
        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full bg-blue-50 text-blue-600">{{ $ebooks->count() }} Ditampilkan</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">ID Kamus</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Sampul</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Judul Kamus</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Penulis / Kurator</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Format &amp; Halaman</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Harga (Rp)</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-center text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($ebooks as $ebook)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-4 py-4 text-sm font-semibold text-blue-600">KBW-{{ str_pad($ebook->id, 3, '0', STR_PAD_LEFT) }}</td>

                    <td class="px-4 py-4">
                        @if($ebook->lokasi_sampul)
                            <img src="{{ asset('storage/'.$ebook->lokasi_sampul) }}" class="w-10 h-14 object-cover rounded-md shadow-sm border border-gray-200" alt="">
                        @else
                            <div class="w-10 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-md border border-gray-200 flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.04v12.5m0-12.5C10.6 4.8 8.7 4.1 6.75 4.1c-1.05 0-2.06.18-3 .52v12.5c.94-.34 1.95-.52 3-.52 1.95 0 3.85.7 5.25 1.94m0-12.5c1.4-1.24 3.3-1.94 5.25-1.94 1.05 0 2.06.18 3 .52v12.5c-.94-.34-1.95-.52-3-.52-1.95 0-3.85.7-5.25 1.94"/></svg>
                            </div>
                        @endif
                    </td>

                    <td class="px-4 py-4">
                        <p class="text-sm font-bold text-gray-900">{{ $ebook->judul }}</p>
                        <p class="text-[11px] text-gray-500 mt-0.5">{{ $ebook->deskripsi ?? $ebook->kategori ?? $ebook->kode_url }}</p>
                    </td>

                    <td class="px-4 py-4 text-sm text-gray-600">{{ $ebook->penulis ?? '-' }}</td>

                    <td class="px-4 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 rounded-full text-[11px] font-medium text-gray-700 whitespace-nowrap">
                            <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.63a3.38 3.38 0 00-3.38-3.37h-1.5a1.12 1.12 0 01-1.12-1.13v-1.5a3.38 3.38 0 00-3.38-3.37H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.63c-.62 0-1.13.5-1.13 1.13v17.25c0 .62.5 1.12 1.13 1.12h12.75c.62 0 1.12-.5 1.12-1.12V11.25a9 9 0 00-9-9z"/></svg>
                            PDF • {{ $ebook->jumlah_halaman ?? 0 }} Hal
                        </span>
                    </td>

                    <td class="px-4 py-4">
                        <p class="text-[11px] text-gray-400 leading-none">Rp</p>
                        <p class="text-sm font-bold text-gray-900">{{ number_format($ebook->harga, 0, ',', '.') }}</p>
                    </td>

                    <td class="px-4 py-4">
                        @if($ebook->sudah_diterbitkan)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span> Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Draft
                            </span>
                        @endif
                    </td>

                    <td class="px-4 py-4">
                        <div class="flex items-center justify-center gap-1">
                            {{-- UBAH --}}
                            <button type="button"
                                    data-ebook-edit="{{ json_encode($ebook) }}"
                                    class="w-8 h-8 rounded-lg text-gray-500 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-center transition"
                                    title="Ubah" aria-label="Ubah {{ $ebook->judul }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.86 4.49l1.69-1.69a1.87 1.87 0 112.65 2.65L10.58 16.07a4.5 4.5 0 01-1.9 1.13l-3.2.95.95-3.2a4.5 4.5 0 011.13-1.9L16.86 4.49zm0 0L19.5 7.13M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                            </button>

                            {{-- HAPUS --}}
                            <button type="button"
                                    data-ebook-delete
                                    data-name="{{ $ebook->judul }}"
                                    data-url="{{ route('admin.ebooks.destroy', $ebook) }}"
                                    class="w-8 h-8 rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600 flex items-center justify-center transition"
                                    title="Hapus" aria-label="Hapus {{ $ebook->judul }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.35 9m-4.78 0L9.26 9m9.97-3.21c.34.05.68.11 1.02.17m-1.02-.17L18.16 19.67a2.25 2.25 0 01-2.24 2.08H8.08a2.25 2.25 0 01-2.24-2.08L4.77 5.79m14.46 0a48.1 48.1 0 00-3.48-.4m-12 .56c.34-.06.68-.12 1.02-.17m0 0a48.1 48.1 0 013.48-.4m7.5 0v-.92c0-1.18-.91-2.16-2.09-2.2a51.96 51.96 0 00-3.32 0c-1.18.04-2.09 1.02-2.09 2.2v.92m7.5 0a48.67 48.67 0 00-7.5 0"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center">
                        <div class="text-gray-400">
                            <p class="text-sm font-medium">Belum ada kamus yang ditambahkan.</p>
                            <p class="text-xs mt-1">Klik "Tambah Kamus Baru" untuk memulai.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ===== FOOTER + PAGINATION ===== --}}
    @if($ebooks->total() > 0)
    <div class="flex flex-col md:flex-row items-center justify-between gap-3 px-6 py-4 border-t border-gray-100 bg-gray-50/60">
        <p class="text-xs text-gray-500">
            Menampilkan {{ $ebooks->firstItem() }}-{{ $ebooks->lastItem() }} dari {{ $ebooks->total() }} e-book kamus
        </p>

        @if($ebooks->hasPages())
        <div class="flex items-center gap-1.5">
            @if($ebooks->onFirstPage())
                <span class="px-3 py-1.5 text-xs font-medium text-gray-300 border border-gray-200 rounded-full cursor-not-allowed">Sebelumnya</span>
            @else
                <a href="{{ $ebooks->previousPageUrl() }}" class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-200 bg-white hover:bg-gray-50 rounded-full">Sebelumnya</a>
            @endif

            @foreach($ebooks->getUrlRange(1, $ebooks->lastPage()) as $page => $url)
                @if($page == $ebooks->currentPage())
                    <span class="w-7 h-7 flex items-center justify-center text-xs font-semibold text-white bg-blue-600 rounded-full">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="w-7 h-7 flex items-center justify-center text-xs font-medium text-gray-600 border border-gray-200 bg-white hover:bg-gray-50 rounded-full">{{ $page }}</a>
                @endif
            @endforeach

            @if($ebooks->hasMorePages())
                <a href="{{ $ebooks->nextPageUrl() }}" class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-200 bg-white hover:bg-gray-50 rounded-full">Selanjutnya</a>
            @else
                <span class="px-3 py-1.5 text-xs font-medium text-gray-300 border border-gray-200 rounded-full cursor-not-allowed">Selanjutnya</span>
            @endif
        </div>
        @endif
    </div>
    @endif
</div>

{{-- ===== MODAL TAMBAH / EDIT ===== --}}
<div id="modalEbook" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-start justify-between px-6 py-5 border-b border-gray-100">
            <div>
                <h3 id="modalTitle" class="text-lg font-bold text-gray-900">Tambah Kamus Baru</h3>
                <p id="modalSubtitle" class="text-xs text-gray-500 mt-1">Isi detail dan unggah berkas PDF kamus.</p>
            </div>
            <button type="button" onclick="closeEbookModal()" class="text-gray-400 hover:text-gray-600" aria-label="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="formEbook" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="methodField" name="_method" value="">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Judul Kamus <span class="text-red-500">*</span></label>
                    <input id="f_judul" name="judul" type="text" required maxlength="200"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Penulis / Kurator <span class="text-red-500">*</span></label>
                    <input id="f_penulis" name="penulis" type="text" required maxlength="150"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <input id="f_kategori" name="kategori" type="text" required maxlength="100"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input id="f_harga" name="harga" type="number" step="0.01" min="0" max="9999999999.99" required
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Jumlah Halaman</label>
                    <input id="f_halaman" name="jumlah_halaman" type="number" min="0"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                </div>

                <div id="reqFile">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Berkas PDF <span id="pdfStar" class="text-red-500">*</span>
                    </label>
                    <input id="inputPdf" name="file_pdf" type="file" accept="application/pdf" class="w-full text-sm">
                    <p id="pdfHint" class="hidden text-[11px] text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti berkas PDF.</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Sampul (opsional)</label>
                    <input id="inputCover" name="cover_image" type="file" accept="image/jpeg,image/png,image/webp" class="w-full text-sm">
                    <p id="coverHint" class="hidden text-[11px] text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti sampul.</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeEbookModal()"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 rounded-lg">
                    Batal
                </button>
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg">
                    <span id="submitText">Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL KONFIRMASI HAPUS ===== --}}
<div id="modalDelete" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
        <h3 class="text-base font-bold text-gray-900 mb-2">Konfirmasi Hapus</h3>
        <p class="text-sm text-gray-600 mb-5">Yakin ingin menghapus <b id="deleteName"></b>? Tindakan ini tidak bisa dibatalkan.</p>
        <form id="formDelete" action="" method="POST" class="flex justify-end gap-3">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <button type="button" onclick="closeDeleteModal()"
                    class="px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 rounded-lg">
                Batal
            </button>
            <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg">
                Hapus
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const EBOOK_BASE_URL  = @json(url('/admin/ebooks'));
const EBOOK_STORE_URL = @json(route('admin.ebooks.store'));

function showModal(id) {
    const m = document.getElementById(id);
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function hideModal(id) {
    const m = document.getElementById(id);
    m.classList.add('hidden');
    m.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

function closeEbookModal()  { hideModal('modalEbook'); }
function closeDeleteModal() { hideModal('modalDelete'); }

/* ---------- TAMBAH ---------- */
function openCreateModal() {
    const form = document.getElementById('formEbook');
    form.reset();
    form.action = EBOOK_STORE_URL;
    document.getElementById('methodField').value = '';
    document.getElementById('modalTitle').textContent = 'Tambah Kamus Baru';
    document.getElementById('modalSubtitle').textContent = 'Isi detail dan unggah berkas PDF kamus.';
    document.getElementById('submitText').textContent = 'Simpan';
    document.getElementById('inputPdf').required = true;
    document.getElementById('pdfStar').classList.remove('hidden');
    document.getElementById('pdfHint').classList.add('hidden');
    document.getElementById('coverHint').classList.add('hidden');
    showModal('modalEbook');
}

/* ---------- UBAH ---------- */
function openEditModal(e) {
    const form = document.getElementById('formEbook');
    form.reset();
    form.action = EBOOK_BASE_URL + '/' + e.id;
    document.getElementById('methodField').value = 'PUT';
    document.getElementById('modalTitle').textContent = 'Ubah Kamus';
    document.getElementById('modalSubtitle').textContent =
        'Perbarui detail kamus. Unggah berkas baru hanya jika ingin menggantinya.';
    document.getElementById('submitText').textContent = 'Simpan Perubahan';

    document.getElementById('f_judul').value    = e.judul ?? '';
    document.getElementById('f_penulis').value  = e.penulis ?? '';
    document.getElementById('f_kategori').value = e.kategori ?? '';
    document.getElementById('f_harga').value    = e.harga ?? '';
    document.getElementById('f_halaman').value  = e.jumlah_halaman ?? '';

    document.getElementById('inputPdf').required = false;
    document.getElementById('pdfStar').classList.add('hidden');
    document.getElementById('pdfHint').classList.remove('hidden');
    document.getElementById('coverHint').classList.remove('hidden');
    showModal('modalEbook');
}

/* ---------- HAPUS ---------- */
function openDelete(name, url) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('formDelete').action = url;
    showModal('modalDelete');
}

/* Tombol di tabel */
document.addEventListener('click', function (ev) {
    const edit = ev.target.closest('[data-ebook-edit]');
    if (edit) { openEditModal(JSON.parse(edit.dataset.ebookEdit)); return; }

    const del = ev.target.closest('[data-ebook-delete]');
    if (del) { openDelete(del.dataset.name, del.dataset.url); return; }

    if (ev.target.id === 'modalEbook')  closeEbookModal();
    if (ev.target.id === 'modalDelete') closeDeleteModal();
});

document.addEventListener('keydown', function (ev) {
    if (ev.key === 'Escape') { closeEbookModal(); closeDeleteModal(); }
});
</script>
@endpush