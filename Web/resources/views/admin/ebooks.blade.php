<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Kamus - MalangVerse Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/user/admin/dashboard.css', 'resources/css/components/navbar.css'])
</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- ✅ Sidebar (fixed) --}}
    <x-admin.sidebar active="ebooks" />

    {{-- ✅ Bungkus konten dengan ml-64 biar tidak tertutup sidebar --}}
    <div class="ml-64 min-h-screen flex flex-col">

        <x-admin.topbar />

        <main class="flex-1 p-8">

            {{-- Page Header --}}
            <div class="flex items-start justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Kelola Kamus Boso Walikan</h1>
                    <p class="text-sm text-gray-500 mt-1">Manajemen inventaris e-book kamus resmi dialek kiwalan Malang</p>
                </div>
                <button class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/25 flex items-center gap-2 transition-all">
                    <i class="fas fa-plus"></i> Tambah Kamus Baru
                </button>
            </div>

            {{-- ====== STATS CARDS ====== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Total Kamus Aktif</span>
                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center">
                            <i class="fas fa-book text-blue-600"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $totalKamus ?? 0 }} Judul</div>
                    <p class="text-[11px] text-gray-400 mt-1 flex items-center gap-1">
                        <i class="fas fa-check-circle text-blue-500"></i> Terverifikasi kurator
                    </p>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Total Unduhan</span>
                        <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center">
                            <i class="fas fa-download text-indigo-600"></i>
                        </div>
                    </div>
                    {{-- ✅ FIX: jangan /1000, tampil angka asli biar tidak "0.000x" --}}
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($totalUnduhan ?? 0) }}x</div>
                    <p class="text-[11px] text-green-600 mt-1 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> +14.2% bulan ini
                    </p>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Pendapatan E-Book</span>
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <i class="fas fa-wallet text-emerald-600"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($pendapatan ?? 0, 0, ',', '.') }}</div>
                    <p class="text-[11px] text-gray-400 mt-1 flex items-center gap-1">
                        <i class="fas fa-qrcode text-emerald-500"></i> QRIS & Transfer Bank
                    </p>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Rata-rata Rating</span>
                        <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center">
                            <i class="fas fa-star text-amber-500"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 flex items-center gap-1">
                        {{ number_format($avgRating ?? 0, 2) }}
                        <i class="fas fa-star text-amber-500 text-sm"></i>
                    </div>
                    {{-- ✅ FIX: dulu pakai $totalUnduhan (salah arti), ganti ke jumlah rating --}}
                    <p class="text-[11px] text-gray-400 mt-1">Dari {{ $jumlahUlasan ?? 0 }} ulasan pembaca</p>
                </div>

            </div>

            {{-- ====== TABEL ====== --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <h2 class="text-base font-bold text-gray-900">Inventaris Dokumen E-Book</h2>
                        <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">
                            {{ $ebooks->count() }} Ditampilkan
                        </span>
                    </div>
                    <button class="px-3.5 py-1.5 border border-gray-200 hover:border-blue-500 text-gray-600 hover:text-blue-600 text-xs font-semibold rounded-lg transition-colors flex items-center gap-2">
                        <i class="fas fa-filter"></i> Filter Kategori
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">ID</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Sampul</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Judul</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Penulis</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Halaman</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Harga</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($ebooks as $book)
                                @php
                                    $kodeId = 'KBW-' . str_pad($book->id, 3, '0', STR_PAD_LEFT);
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-blue-600">{{ $kodeId }}</td>

                                    <td class="px-6 py-4">
                                        @if ($book->lokasi_sampul)
                                            <img src="{{ asset($book->lokasi_sampul) }}" alt="{{ $book->judul }}"
                                                 class="w-10 h-14 rounded object-cover shadow-sm">
                                        @else
                                            <div class="w-10 h-14 rounded bg-gradient-to-br from-blue-600 to-indigo-800
                                                        shadow-sm flex items-center justify-center text-white text-[8px] font-bold text-center p-1">
                                                {{ Illuminate\Support\Str::limit($book->judul, 15, '') }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $book->judul }}</div>
                                        <div class="text-[11px] text-gray-400 mt-0.5">{{ $book->kode_url }}</div>
                                    </td>

                                    <td class="px-6 py-4 text-gray-600">{{ $book->penulis ?? 'Tim Kurator' }}</td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 text-xs text-gray-600">
                                            <i class="fas fa-file-pdf text-red-500"></i> PDF · {{ $book->jumlah_halaman ?? 0 }} hal
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($book->harga ?? 0, 0, ',', '.') }}</td>

                                    <td class="px-6 py-4">
                                        @if ($book->sudah_diterbitkan)
                                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-green-700 bg-green-50 px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1">
                                            <button class="w-8 h-8 rounded-lg hover:bg-blue-50 text-gray-500 hover:text-blue-600 transition-colors flex items-center justify-center" title="Edit">
                                                <i class="fas fa-pen text-xs"></i>
                                            </button>
                                            <button class="w-8 h-8 rounded-lg hover:bg-emerald-50 text-gray-500 hover:text-emerald-600 transition-colors flex items-center justify-center" title="Lihat">
                                                <i class="fas fa-eye text-xs"></i>
                                            </button>
                                            <button class="w-8 h-8 rounded-lg hover:bg-red-50 text-gray-500 hover:text-red-600 transition-colors flex items-center justify-center" title="Hapus">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                        <i class="fas fa-book-open text-4xl mb-3 block"></i>
                                        Belum ada data e-book kamus.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($ebooks->hasPages())
                    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <p class="text-xs text-gray-500">
                            Menampilkan <span class="font-semibold text-gray-700">{{ $ebooks->firstItem() }}-{{ $ebooks->lastItem() }}</span>
                            dari <span class="font-semibold text-gray-700">{{ $ebooks->total() }}</span> e-book
                        </p>
                        <div>{{ $ebooks->links() }}</div>
                    </div>
                @endif

            </div>

        </main>
    </div>

</body>
</html>