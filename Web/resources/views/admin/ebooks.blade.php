@extends('admin.layout')
@section('title', 'Manage E-Book')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Kelola Kamus Boso Walikan
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Manajemen inventaris e-book kamus resmi resmu dialek kiwalan Malang
            </p>
        </div>

        <button type="button"
                onclick="openCreateModal()"
                class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md shadow-blue-600/25 flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                 stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah Kamus Baru
        </button>
    </div>
</div>

{{-- ================= ALERT ================= --}}
@if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ================= STATISTIK ================= --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 mb-6">

    {{-- Total Kamus --}}
    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Total Kamus Aktif</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">
                    {{ $ebooks->total() }}
                    <span class="text-sm font-medium text-gray-500">Judul</span>
                </h3>
            </div>

            <div class="w-11 h-11 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 19.5A2.5 2.5 0 016.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Total Unduhan --}}
    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Total Unduhan</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">
                    {{ number_format($totalDownloads ?? 0, 0, ',', '.') }}
                    <span class="text-sm font-medium text-gray-500">x</span>
                </h3>
            </div>

            <div class="w-11 h-11 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 3v12m0 0l4-4m-4 4l-4-4m-4 7h16"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Pendapatan --}}
    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Pendapatan E-Book</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">
                    Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
                </h3>
            </div>

            <div class="w-11 h-11 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8c-1.66 0-3 .67-3 1.5S10.34 11 12 11s3 .67 3 1.5S13.66 14 12 14m0-6v6m0-12v2m0 16v2M5 4h14M5 20h14"/>
                </svg>
            </div>
        </div>
    </div>
</div>

{{-- ================= TABEL INVENTARIS ================= --}}
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">

    {{-- Header tabel --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-5 py-4 border-b border-gray-100">
        <div>
            <h3 class="text-base font-bold text-gray-900">
                Inventaris Dokumen E-Book
            </h3>
            <p class="text-xs text-gray-500 mt-1">
                {{ $ebooks->total() }} Ditampilkan
            </p>
        </div>

        {{-- Search tabel --}}
        <div class="relative w-full sm:w-64">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                 fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m21 21-4.35-4.35M19 11a8 8 0 11-16 0 8 8 0 0116 0z"/>
            </svg>

            <input type="text"
                   id="searchEbook"
                   placeholder="Cari judul atau penulis..."
                   class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>
    </div>

    {{-- Isi tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full min-w-[1000px]">
            <thead>
                <tr class="bg-blue-50/70 border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase">
                        ID Kamus
                    </th>

                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase">
                        Sampul
                    </th>

                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase">
                        Judul Kamus
                    </th>

                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase">
                        Penulis / Kurator
                    </th>

                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase">
                        Format & Halaman
                    </th>

                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase">
                        Harga (Rp)
                    </th>

                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase">
                        Status
                    </th>

                    <th class="px-4 py-3 text-center text-[11px] font-semibold text-gray-500 uppercase">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody id="ebookTableBody" class="divide-y divide-gray-100">

                @forelse($ebooks as $ebook)

                    <tr class="ebook-row hover:bg-gray-50 transition">

                        {{-- ID --}}
                        <td class="px-4 py-3 text-xs font-semibold text-blue-600">
                            KBW-{{ str_pad($ebook->id, 3, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- COVER --}}
                        <td class="px-4 py-3">
                            @if($ebook->lokasi_sampul)
                                <img src="{{ asset('storage/'.$ebook->lokasi_sampul) }}"
                                     class="w-10 h-14 object-cover rounded border border-gray-200 shadow-sm"
                                     alt="Sampul {{ $ebook->judul }}">
                            @else
                                <div class="w-10 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded border border-gray-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-500" fill="none"
                                         stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 6.04v12.5m0-12.5C10.6 4.8 8.7 4.1 6.75 4.1c-1.05 0-2.06.18-3 .52v12.5c.94-.34 1.95-.52 3-.52 1.95 0 3.85.7 5.25 1.94m0-12.5c1.4-1.24 3.3-1.94 5.25-1.94 1.05 0 2.06.18 3 .52v12.5c-.94-.34-1.95-.52-3-.52-1.95 0-3.85.7-5.25 1.94"/>
                                    </svg>
                                </div>
                            @endif
                        </td>

                        {{-- JUDUL --}}
                        <td class="px-4 py-3">
                            <p class="text-xs font-semibold text-gray-900 ebook-title">
                                {{ $ebook->judul }}
                            </p>

                            <p class="text-[10px] text-gray-500 mt-1 font-mono">
                                {{ $ebook->kode_url }}
                            </p>
                        </td>

                        {{-- PENULIS --}}
                        <td class="px-4 py-3 text-xs text-gray-600 ebook-author">
                            {{ $ebook->penulis ?? '-' }}
                        </td>

                        {{-- FORMAT --}}
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 rounded-md text-[10px] font-medium text-gray-700 whitespace-nowrap">
                                <svg class="w-3 h-3 text-red-500" fill="none"
                                     stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 14.25v-2.63a3.38 3.38 0 00-3.38-3.37h-1.5a1.12 1.12 0 01-1.12-1.13v-1.5a3.38 3.38 0 00-3.38-3.37H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.63c-.62 0-1.13.5-1.13 1.13v17.25c0 .62.5 1.12 1.13 1.12h12.75c.62 0 1.12-.5 1.12-1.12V11.25a9 9 0 00-9-9z"/>
                                </svg>

                                PDF • {{ $ebook->jumlah_halaman ?? 0 }} Hal
                            </span>
                        </td>

                        {{-- HARGA --}}
                        <td class="px-4 py-3 text-xs font-semibold text-gray-900 whitespace-nowrap">
                            Rp {{ number_format($ebook->harga, 0, ',', '.') }}
                        </td>

                        {{-- STATUS --}}
                        <td class="px-4 py-3">
                            @if($ebook->sudah_diterbitkan)
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-100 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-600 border border-gray-200 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    Draft
                                </span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-1">

                                {{-- EDIT --}}
                                <button type="button"
                                        data-ebook-edit="{{ json_encode($ebook) }}"
                                        class="w-7 h-7 rounded-lg text-gray-500 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-center transition"
                                        title="Ubah">
                                    <svg class="w-3.5 h-3.5" fill="none"
                                         stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M16.86 4.49l1.69-1.69a1.87 1.87 0 112.65 2.65L10.58 16.07a4.5 4.5 0 01-1.9 1.13l-3.2.95.95-3.2a4.5 4.5 0 011.13-1.9L16.86 4.49z"/>
                                    </svg>
                                </button>

                                {{-- DELETE --}}
                                <button type="button"
                                        data-ebook-delete
                                        data-name="{{ $ebook->judul }}"
                                        data-url="{{ route('admin.ebooks.destroy', $ebook) }}"
                                        class="w-7 h-7 rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600 flex items-center justify-center transition"
                                        title="Hapus">
                                    <svg class="w-3.5 h-3.5" fill="none"
                                         stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M6 7h12m-10 0l1 14h6l1-14M9 7V4h6v3"/>
                                    </svg>
                                </button>

                            </div>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="text-gray-400">
                                <p class="text-sm font-medium">
                                    Belum ada kamus yang ditambahkan.
                                </p>
                                <p class="text-xs mt-1">
                                    Klik "Tambah Kamus Baru" untuk memulai.
                                </p>
                            </div>
                        </td>
                    </tr>

                @endforelse

                {{-- Pesan pencarian kosong --}}
                <tr id="searchEmpty" class="hidden">
                    <td colspan="8" class="px-6 py-10 text-center text-sm text-gray-400">
                        Kamus tidak ditemukan.
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    {{-- ================= PAGINATION ================= --}}
    @if($ebooks->hasPages())
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-5 py-4 border-t border-gray-100 bg-gray-50/50">

            <p class="text-xs text-gray-500">
                Menampilkan
                {{ $ebooks->firstItem() ?? 0 }}-{{ $ebooks->lastItem() ?? 0 }}
                dari {{ $ebooks->total() }} e-book kamus
            </p>

            <div class="text-xs">
                {{ $ebooks->links() }}
            </div>

        </div>
    @endif
</div>


{{-- ================= MODAL TAMBAH / EDIT ================= --}}
<div id="modalEbook"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">

        {{-- Modal header --}}
        <div class="flex items-start justify-between px-6 py-5 border-b border-gray-100">
            <div>
                <h3 id="modalTitle" class="text-lg font-bold text-gray-900">
                    Tambah Kamus Baru
                </h3>

                <p id="modalSubtitle" class="text-xs text-gray-500 mt-1">
                    Isi detail dan unggah berkas PDF kamus.
                </p>
            </div>

            <button type="button"
                    onclick="closeEbookModal()"
                    class="text-gray-400 hover:text-gray-600"
                    aria-label="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="formEbook"
              action=""
              method="POST"
              enctype="multipart/form-data"
              class="p-6 space-y-4">

            @csrf

            <input type="hidden" id="methodField" name="_method" value="">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Judul --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Judul Kamus <span class="text-red-500">*</span>
                    </label>

                    <input id="f_judul"
                           name="judul"
                           type="text"
                           required
                           maxlength="200"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>

                {{-- Penulis --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Penulis / Kurator <span class="text-red-500">*</span>
                    </label>

                    <input id="f_penulis"
                           name="penulis"
                           type="text"
                           required
                           maxlength="150"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Kategori <span class="text-red-500">*</span>
                    </label>

                    <input id="f_kategori"
                           name="kategori"
                           type="text"
                           required
                           maxlength="100"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>

                {{-- Harga --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>

                    <input id="f_harga"
                           name="harga"
                           type="number"
                           step="0.01"
                           min="0"
                           max="9999999999.99"
                           required
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>

                {{-- Halaman --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Jumlah Halaman
                    </label>

                    <input id="f_halaman"
                           name="jumlah_halaman"
                           type="number"
                           min="0"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>

                {{-- PDF --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Berkas PDF
                        <span id="pdfStar" class="text-red-500">*</span>
                    </label>

                    <input id="inputPdf"
                           name="file_pdf"
                           type="file"
                           accept="application/pdf"
                           class="w-full text-sm">

                    <p id="pdfHint" class="hidden text-[11px] text-gray-400 mt-1">
                        Kosongkan jika tidak ingin mengganti berkas PDF.
                    </p>
                </div>

                {{-- Cover --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Sampul (Opsional)
                    </label>

                    <input id="inputCover"
                           name="cover_image"
                           type="file"
                           accept="image/jpeg,image/png,image/webp"
                           class="w-full text-sm">

                    <p id="coverHint" class="hidden text-[11px] text-gray-400 mt-1">
                        Kosongkan jika tidak ingin mengganti sampul.
                    </p>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button"
                        onclick="closeEbookModal()"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 rounded-lg transition">
                    Batal
                </button>

                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
                    <span id="submitText">Simpan</span>
                </button>
            </div>

        </form>
    </div>
</div>


{{-- ================= MODAL HAPUS ================= --}}
<div id="modalDelete"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">

        <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 9v4m0 4h.01M10.29 3.86L1.82 18.5a2 2 0 001.73 3h16.9a2 2 0 001.73-3L11.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>

        <h3 class="text-base font-bold text-gray-900 mb-2">
            Konfirmasi Hapus
        </h3>

        <p class="text-sm text-gray-600 mb-5">
            Yakin ingin menghapus
            <b id="deleteName" class="text-gray-900"></b>?
            Tindakan ini tidak bisa dibatalkan.
        </p>

        <form id="formDelete"
              action=""
              method="POST"
              class="flex justify-end gap-3">

            @csrf
            @method('DELETE')

            <button type="button"
                    onclick="closeDeleteModal()"
                    class="px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 rounded-lg transition">
                Batal
            </button>

            <button type="submit"
                    class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition">
                Hapus
            </button>
        </form>
    </div>
</div>

@endsection


{{-- ================= JAVASCRIPT ================= --}}
@push('scripts')
<script>

const EBOOK_BASE_URL  = @json(url('/admin/ebooks'));
const EBOOK_STORE_URL = @json(route('admin.ebooks.store'));


/* ================= MODAL ================= */

function showModal(id) {
    const modal = document.getElementById(id);

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.body.style.overflow = 'hidden';
}

function hideModal(id) {
    const modal = document.getElementById(id);

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    document.body.style.overflow = 'auto';
}

function closeEbookModal() {
    hideModal('modalEbook');
}

function closeDeleteModal() {
    hideModal('modalDelete');
}


/* ================= TAMBAH E-BOOK ================= */

function openCreateModal() {
    const form = document.getElementById('formEbook');

    form.reset();
    form.action = EBOOK_STORE_URL;

    document.getElementById('methodField').value = '';

    document.getElementById('modalTitle').textContent =
        'Tambah Kamus Baru';

    document.getElementById('modalSubtitle').textContent =
        'Isi detail dan unggah berkas PDF kamus.';

    document.getElementById('submitText').textContent =
        'Simpan';

    document.getElementById('inputPdf').required = true;

    document.getElementById('pdfStar').classList.remove('hidden');
    document.getElementById('pdfHint').classList.add('hidden');
    document.getElementById('coverHint').classList.add('hidden');

    showModal('modalEbook');
}


/* ================= EDIT E-BOOK ================= */

function openEditModal(ebook) {
    const form = document.getElementById('formEbook');

    form.reset();

    form.action = EBOOK_BASE_URL + '/' + ebook.id;

    document.getElementById('methodField').value = 'PUT';

    document.getElementById('modalTitle').textContent =
        'Ubah Kamus';

    document.getElementById('modalSubtitle').textContent =
        'Perbarui detail kamus. Unggah berkas baru hanya jika ingin menggantinya.';

    document.getElementById('submitText').textContent =
        'Simpan Perubahan';

    document.getElementById('f_judul').value =
        ebook.judul ?? '';

    document.getElementById('f_penulis').value =
        ebook.penulis ?? '';

    document.getElementById('f_kategori').value =
        ebook.kategori ?? '';

    document.getElementById('f_harga').value =
        ebook.harga ?? '';

    document.getElementById('f_halaman').value =
        ebook.jumlah_halaman ?? '';

    // PDF tidak wajib saat edit
    document.getElementById('inputPdf').required = false;

    document.getElementById('pdfStar').classList.add('hidden');
    document.getElementById('pdfHint').classList.remove('hidden');
    document.getElementById('coverHint').classList.remove('hidden');

    showModal('modalEbook');
}


/* ================= HAPUS E-BOOK ================= */

function openDelete(name, url) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('formDelete').action = url;

    showModal('modalDelete');
}


/* ================= EVENT CLICK ================= */

document.addEventListener('click', function(event) {

    // Tombol edit
    const editButton = event.target.closest('[data-ebook-edit]');

    if (editButton) {
        const ebook = JSON.parse(editButton.dataset.ebookEdit);

        openEditModal(ebook);
        return;
    }

    // Tombol delete
    const deleteButton = event.target.closest('[data-ebook-delete]');

    if (deleteButton) {
        openDelete(
            deleteButton.dataset.name,
            deleteButton.dataset.url
        );

        return;
    }

    // Klik area luar modal untuk menutup
    if (event.target.id === 'modalEbook') {
        closeEbookModal();
    }

    if (event.target.id === 'modalDelete') {
        closeDeleteModal();
    }
});


/* ================= ESCAPE KEY ================= */

document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {
        closeEbookModal();
        closeDeleteModal();
    }

});


/* ================= SEARCH TABEL ================= */

const searchInput = document.getElementById('searchEbook');
const ebookRows   = document.querySelectorAll('.ebook-row');
const searchEmpty = document.getElementById('searchEmpty');

if (searchInput) {

    searchInput.addEventListener('input', function() {

        const keyword = this.value.toLowerCase().trim();
        let visibleCount = 0;

        ebookRows.forEach(function(row) {

            const title = row.querySelector('.ebook-title')
                ?.textContent.toLowerCase() ?? '';

            const author = row.querySelector('.ebook-author')
                ?.textContent.toLowerCase() ?? '';

            const match = title.includes(keyword) ||
                          author.includes(keyword);

            row.style.display = match ? '' : 'none';

            if (match) {
                visibleCount++;
            }
        });

        if (searchEmpty) {
            searchEmpty.classList.toggle(
                'hidden',
                visibleCount !== 0 || keyword === ''
            );
        }
    });

}

</script>
@endpush