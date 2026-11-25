@extends('admin.layout')
@section('title', 'Manage E-Book')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kelola Kamus Boso Walikan</h2>
            <p class="text-sm text-gray-500 mt-1">Manajemen inventaris e-book kamus resmi dialek kiwalan Malang</p>
        </div>
        <button onclick="openCreateModal()" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md shadow-blue-600/25 flex items-center gap-2 transition">
            <i class="fa-solid fa-plus"></i> Tambah Kamus Baru
        </button>
    </div>
</div>

{{-- ===== STATS CARDS ===== --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Kamus Aktif</p>
            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                <i class="fa-solid fa-book text-sm"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $totalKamus ?? 0 }}</p>
        <p class="text-xs text-green-600 mt-2"><i class="fa-solid fa-arrow-up"></i> Terverifikasi kurator</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Unduhan</p>
            <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                <i class="fa-solid fa-download text-sm"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $totalUnduhan ?? 0 }}</p>
        <p class="text-xs text-green-600 mt-2"><i class="fa-solid fa-arrow-up"></i> +14.3% bulan ini</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pendapatan E-Book</p>
            <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                <i class="fa-solid fa-wallet text-sm"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($pendapatan ?? 0, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-500 mt-2"><i class="fa-solid fa-building-columns"></i> QRIS & Transfer Bank</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Rata-rata Rating</p>
            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center">
                <i class="fa-solid fa-star text-sm"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $avgRating ?? 0 }} <span class="text-amber-500">★</span></p>
        <p class="text-xs text-gray-500 mt-2">Dari {{ $jumlahUlasan ?? 0 }} ulasan pembaca</p>
    </div>
</div>

{{-- ===== TABEL INVENTARIS ===== --}}
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <div>
            <h3 class="text-base font-bold text-gray-900">Inventaris Dokumen E-Book</h3>
            <p class="text-xs text-gray-500 mt-0.5">{{ $ebooks->total() }} Ditampilkan</p>
        </div>
        <button class="px-3 py-2 text-sm font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 flex items-center gap-2">
            <i class="fa-solid fa-filter text-xs"></i> Filter Kategori
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">ID Kamus</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Sampul</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Judul Kamus</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Penulis / Kurator</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Format & Halaman</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Harga (Rp)</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-center text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($ebooks as $ebook)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-4 py-3 text-sm font-semibold text-blue-600">KBW-{{ str_pad($ebook->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-3">
                        @if($ebook->cover_image)
                            <img src="{{ Storage::url($ebook->cover_image) }}" class="w-10 h-14 object-cover rounded border border-gray-200">
                        @else
                            <div class="w-10 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded border border-gray-200 flex items-center justify-center">
                                <i class="fa-solid fa-book text-blue-500 text-xs"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-sm font-semibold text-gray-900">{{ $ebook->judul }}</p>
                        <p class="text-[11px] text-gray-500 mt-0.5">{{ Str::limit($ebook->deskripsi ?? '', 50) }}</p>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $ebook->penulis ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 rounded-md text-[11px] font-medium text-gray-700">
                            <i class="fa-solid fa-file-pdf text-red-500"></i> PDF • {{ $ebook->halaman ?? 0 }} hal
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">Rp {{ number_format($ebook->harga ?? 0, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[11px] font-semibold {{ ($ebook->status ?? 'draft') === 'published' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-100 text-gray-600 border border-gray-200' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ ($ebook->status ?? 'draft') === 'published' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                            {{ ucfirst($ebook->status ?? 'draft') }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-1">
                            <button onclick='openEditModal(@json($ebook))' class="w-8 h-8 rounded-lg hover:bg-blue-50 text-gray-400 hover:text-blue-600 flex items-center justify-center transition" title="Edit">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </button>
                            <button class="w-8 h-8 rounded-lg hover:bg-green-50 text-gray-400 hover:text-green-600 flex items-center justify-center transition" title="Download">
                                <i class="fa-solid fa-download text-xs"></i>
                            </button>
                            <button onclick='openDelete("Kamus", "{{ $ebook->judul }}", "{{ route('admin.ebooks.destroy', $ebook) }}")' class="w-8 h-8 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-600 flex items-center justify-center transition" title="Hapus">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center">
                        <div class="text-gray-400">
                            <i class="fa-solid fa-book-open text-4xl mb-3 opacity-40"></i>
                            <p class="text-sm font-medium">Belum ada kamus yang ditambahkan.</p>
                            <p class="text-xs mt-1">Klik "Tambah Kamus Baru" untuk memulai.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($ebooks->hasPages())
    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100">
        <p class="text-xs text-gray-500">Menampilkan {{ $ebooks->firstItem() }}-{{ $ebooks->lastItem() }} dari {{ $ebooks->total() }} e-book kamus</p>
        <div class="flex items-center gap-1">
            {{ $ebooks->links() }}
        </div>
    </div>
    @endif
</div>

{{-- ===== MODAL KOMPONEN ===== --}}
<x-admin.ebook-modal />

@push('scripts')
<script>
/* ===== OPEN CREATE MODAL ===== */
function openCreateModal() {
    const m = document.getElementById('modalEbook');
    if (!m) return;
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
    const rf = document.getElementById('reqFile');
    if (rf) rf.style.display = '';
    clearPdf();
    m.classList.remove('hidden'); m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

/* ===== OPEN EDIT MODAL ===== */
function openEditModal(e) {
    const m = document.getElementById('modalEbook');
    if (!m) return;
    document.getElementById('formEbook').action = '/admin/ebooks/' + e.id;
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
    const rf = document.getElementById('reqFile');
    if (rf) rf.style.display = 'none';
    clearPdf();
    m.classList.remove('hidden'); m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

/* ===== DELETE CONFIRM MODAL ===== */
function openDelete(type, name, url) {
    let m = document.getElementById('modal-confirm');
    if (!m) {
        m = document.createElement('div');
        m.id = 'modal-confirm';
        m.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm p-4';
        m.innerHTML = '<div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">' +
            '<div class="flex items-center gap-3 mb-4">' +
            '<div class="w-10 h-10 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center"><i class="fas fa-triangle-exclamation text-red-600"></i></div>' +
            '<h3 class="text-base font-bold text-gray-900">Konfirmasi Hapus</h3></div>' +
            '<p class="text-sm text-gray-600 mb-5">Yakin ingin menghapus <b id="cf-name"></b>? Tindakan ini tidak bisa dibatalkan.</p>' +
            '<form id="cf-form" method="POST" class="flex justify-end gap-3">' +
            '<input type="hidden" name="_token" value="' + document.querySelector('meta[name=csrf-token]').content + '">' +
            '<input type="hidden" name="_method" value="DELETE">' +
            '<button type="button" onclick="document.getElementById(\'modal-confirm\').classList.add(\'hidden\');document.getElementById(\'modal-confirm\').classList.remove(\'flex\');document.body.style.overflow=\'auto\'" class="px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 rounded-lg">Batal</button>' +
            '<button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg"><i class="fas fa-trash"></i> Hapus</button></form></div>';
        document.body.appendChild(m);
    }
    document.getElementById('cf-name').textContent = type + ' "' + name + '"';
    document.getElementById('cf-form').action = url;
    m.classList.remove('hidden'); m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
</script>
@endpush
@endsection