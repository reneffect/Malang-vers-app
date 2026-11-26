<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi QRIS - MalangVerse Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/user/admin/dashboard.css', 'resources/js/guest.js'])
</head>
<body class="admin-reference-theme bg-gray-100 font-sans antialiased">

    <x-admin.sidebar active="transaksi" />

    <div class="ml-64 min-h-screen flex flex-col">
        <x-admin.topbar />

        <main class="flex-1 p-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Riwayat Transaksi QRIS</h1>
                <p class="text-sm text-gray-500 mt-1">Pemantauan lalu lintas pembayaran otomatis gateway QRIS Nasional (BCA, Mandiri, GoPay, OVO, Dana)</p>
            </div>

            {{-- ===== STATS ===== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Total Pemasukan QRIS</span>
                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center"><i class="fas fa-wallet text-blue-600"></i></div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                    <p class="text-[11px] text-green-600 mt-1"><i class="fas fa-arrow-up"></i> +14.2% bulan ini</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Transaksi Berhasil</span>
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center"><i class="fas fa-check-circle text-emerald-600"></i></div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($transaksiBerhasil) }} <span class="text-sm font-normal text-gray-500">Transaksi</span></div>
                    <p class="text-[11px] text-gray-400 mt-1">Tingkat sukses 99.1%</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Transaksi Tertunda/Gagal</span>
                        <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center"><i class="fas fa-exclamation-circle text-red-600"></i></div>
                    </div>
                    <div class="text-2xl font-bold text-red-600">{{ $transaksiGagal }} <span class="text-sm font-normal text-gray-500">Transaksi</span></div>
                    <p class="text-[11px] text-gray-400 mt-1">0.9% dari total trafik</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Volume Transaksi Hari Ini</span>
                        <div class="w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center"><i class="fas fa-chart-line text-purple-600"></i></div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($volumeHariIni, 0, ',', '.') }}</div>
                    <p class="text-[11px] text-gray-400 mt-1">{{ $transaksiHariIni }} Transaksi hari ini</p>
                </div>
            </div>

            {{-- ===== TABEL ===== --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

                {{-- Header + Filter --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 flex-wrap gap-3">
                    <form method="GET" action="{{ route('admin.transaksi') }}" class="flex items-center gap-2 flex-1 max-w-md">
                        <div class="relative flex-1">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="QRIS-MV-2025..."
                                   class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        </div>
                    </form>
                    <div class="flex items-center gap-2">
                        <select name="status" onchange="window.location.href='{{ route('admin.transaksi') }}?status='+this.value+'&period={{ $period }}'"
                                class="px-3 py-2 border border-gray-200 rounded-lg text-xs font-semibold focus:outline-none focus:border-blue-500">
                            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua QRIS</option>
                            <option value="success" {{ $status === 'success' ? 'selected' : '' }}>Berhasil</option>
                            <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Gagal</option>
                            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                        <select name="period" onchange="window.location.href='{{ route('admin.transaksi') }}?period='+this.value+'&status={{ $status }}'"
                                class="px-3 py-2 border border-gray-200 rounded-lg text-xs font-semibold focus:outline-none focus:border-blue-500">
                            <option value="30" {{ $period === '30' ? 'selected' : '' }}>30 Hari Terakhir</option>
                            <option value="7" {{ $period === '7' ? 'selected' : '' }}>7 Hari Terakhir</option>
                            <option value="1" {{ $period === '1' ? 'selected' : '' }}>Hari Ini</option>
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">ID Referensi QRIS</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Nama Pengguna</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Item yang Dibeli</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Nominal (Rp)</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Metode Pembayaran</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Waktu Transaksi</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($transactions as $trx)
                                @php
                                    $refCode = 'QRIS-MV-' . $trx->created_at->format('Ymd') . '-' . str_pad($trx->id, 4, '0', STR_PAD_LEFT);
                                    $methods = ['GoPay QRIS', 'BCA Mobile QRIS', 'OVO QRIS', 'ShopeePay QRIS'];
                                    $method = $methods[$trx->id % 4];
                                    $itemNames = ['E-Book Kamus Akbar Boso Walikan', 'Langganan Single E-Book Pro (1 Bulan)', 'Kamus Saku Kiwalan Populer', 'Paket Standar Langganan'];
                                    $itemName = $itemNames[$trx->id % 4];
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-blue-600 text-xs">{{ $refCode }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $trx->user->name ?? 'User' }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $trx->user->email ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 text-xs">{{ $itemName }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 text-xs text-gray-600">
                                            <i class="fas fa-qrcode text-gray-400"></i> {{ $method }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 text-xs">
                                        {{ $trx->created_at->format('d M Y') }}<br>
                                        <span class="text-[11px] text-gray-400">{{ $trx->created_at->format('H:i') }} WIB</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($trx->status === 'success')
                                            <span class="inline-flex items-center gap-1.5 text-[11px] font-medium text-green-700 bg-green-50 px-2.5 py-1 rounded-full">
                                                <i class="fas fa-check-circle text-[10px]"></i> Berhasil
                                            </span>
                                        @elseif ($trx->status === 'failed')
                                            <span class="inline-flex items-center gap-1.5 text-[11px] font-medium text-red-700 bg-red-50 px-2.5 py-1 rounded-full">
                                                <i class="fas fa-times-circle text-[10px]"></i> Gagal
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-[11px] font-medium text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full">
                                                <i class="fas fa-clock text-[10px]"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1">
                                            <button class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition-colors">
                                                Lihat
                                            </button>
                                            <button class="px-3 py-1.5 border border-gray-200 hover:border-blue-500 text-gray-600 hover:text-blue-600 text-xs font-semibold rounded-lg transition-colors">
                                                Kuitansi
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-qrcode text-4xl mb-3 block"></i>Belum ada transaksi.
                                </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <p class="text-xs text-gray-500">
                        Menampilkan <span class="font-semibold text-gray-700">{{ $transactions->firstItem() ?? 0 }}-{{ $transactions->lastItem() ?? 0 }}</span>
                        dari <span class="font-semibold text-gray-700">{{ number_format($transactions->total()) }}</span> transaksi QRIS
                    </p>
                    <div class="flex items-center gap-1">
                        @if ($transactions->onFirstPage())
                            <span class="text-xs text-gray-400 mr-2">Sebelumnya</span>
                        @else
                            <a href="{{ $transactions->previousPageUrl() }}" class="text-xs text-blue-600 hover:text-blue-700 mr-2">Sebelumnya</a>
                        @endif

                        @for ($i = 1; $i <= $transactions->lastPage(); $i++)
                            @if ($i == $transactions->currentPage())
                                <span class="w-8 h-8 rounded-lg bg-blue-600 text-white text-xs font-semibold flex items-center justify-center">{{ $i }}</span>
                            @else
                                <a href="{{ $transactions->urlPage($i) }}" class="w-8 h-8 rounded-lg bg-white border border-gray-200 hover:border-blue-500 text-gray-600 text-xs font-semibold flex items-center justify-center transition-colors">{{ $i }}</a>
                            @endif
                        @endfor

                        @if ($transactions->hasMorePages())
                            <a href="{{ $transactions->nextPageUrl() }}" class="text-xs text-blue-600 hover:text-blue-700 ml-2">Berikutnya</a>
                        @else
                            <span class="text-xs text-gray-400 ml-2">Berikutnya</span>
                        @endif
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>