<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Paket Langganan - MalangVerse Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/user/admin/dashboard.css', 'resources/css/components/navbar.css'])
</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- Sidebar --}}
    <x-admin.sidebar active="membership" />

    {{-- Main Wrapper --}}
    <div class="ml-64 min-h-screen flex flex-col">

        {{-- Topbar --}}
        <x-admin.topbar />

        {{-- Content --}}
        <main class="flex-1 p-8">

            {{-- Page Header --}}
            <div class="flex items-start justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Kelola Paket Langganan</h1>
                    <p class="text-sm text-gray-500 mt-1">Atur skema tier keanggotaan, penentuan harga Rupiah, dan kuota fitur pengguna</p>
                </div>
                <button type="button" onclick="toggleModal('modalPaket')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/25 flex items-center gap-2 transition-all">
                    <i class="fas fa-plus"></i> Tambah Paket
                </button>
            </div>

            {{-- ====== STATS CARDS ====== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

                {{-- Total Pelanggan Aktif --}}
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Total Pelanggan Aktif</span>
                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($totalPelanggan) }} <span class="text-sm font-normal text-gray-500">Member</span></div>
                    <p class="text-[11px] text-green-600 mt-1 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> +8.5% MoM vs bulan lalu
                    </p>
                </div>

                {{-- MRR --}}
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">MRR (Pendapatan Bulanan)</span>
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <i class="fas fa-wallet text-emerald-600"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($mrr, 0, ',', '.') }}</div>
                    <p class="text-[11px] text-green-600 mt-1 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> +12.4% target Rp 50jt tercapai 97%
                    </p>
                </div>

                {{-- ARPU --}}
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">ARPU (Rata-rata Pengguna)</span>
                        <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center">
                            <i class="fas fa-chart-line text-indigo-600"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($arpu, 0, ',', '.') }}</div>
                    <p class="text-[11px] text-green-600 mt-1 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> +3.1% efisiensi konversi
                    </p>
                </div>

                {{-- Tingkat Retensi --}}
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Tingkat Retensi</span>
                        <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center">
                            <i class="fas fa-sync-alt text-amber-600"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $tingkatRetensi }}%</div>
                    <p class="text-[11px] text-red-600 mt-1 flex items-center gap-1">
                        <i class="fas fa-arrow-down"></i> Churn rate rendah (5.8%)
                    </p>
                </div>

            </div>

            {{-- ====== TABEL DAFTAR PAKET ====== --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

                {{-- Tabel Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <h2 class="text-base font-bold text-gray-900">Daftar Paket Aktif</h2>
                        <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">
                            {{ $tiers->count() }} Tier Tersedia
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.membership', ['filter' => 'all']) }}"
                           class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-colors
                                  {{ $filter === 'all' ? 'bg-gray-200 text-gray-700' : 'text-gray-500 hover:bg-gray-100' }}">
                            Semua ({{ $tiers->count() }})
                        </a>
                        <a href="{{ route('admin.membership', ['filter' => 'active']) }}"
                           class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-colors
                                  {{ $filter === 'active' ? 'bg-blue-600 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                            Aktif ({{ $tiers->where('is_active', true)->count() }})
                        </a>
                    </div>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">ID Paket</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama Tier</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Harga Bulanan</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Harga Tahunan</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Fitur Utama</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Kuota Terjemahan</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Pelanggan Aktif</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($tiers as $index => $tier)
                                @php
                                    $kodeId = 'TIER-' . str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                                    $features = is_array($tier->benefits) ? $tier->benefits : json_decode($tier->benefits ?? '[]', true) ?? [];
                                    $quotaText = $tier->translation_quota ? $tier->translation_quota . ' / hari' : 'Tanpa Batas';
                                    $quotaColor = $tier->translation_quota ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-700';
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-[10px] text-gray-400 uppercase tracking-wide">Kode</div>
                                        <div class="font-semibold text-blue-600">{{ $kodeId }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900 flex items-center gap-2">
                                            {{ $tier->name }}
                                            @if ($index === 2)
                                                <i class="fas fa-crown text-amber-500 text-xs"></i>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-gray-400 mt-0.5">{{ $tier->description }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">Rp {{ number_format($tier->monthly_price, 0, ',', '.') }}</div>
                                        <div class="text-[11px] text-gray-400">/ bln</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">Rp {{ number_format($tier->yearly_price, 0, ',', '.') }}</div>
                                        <div class="text-[11px] text-gray-400">/ thn</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <ul class="text-xs text-gray-600 space-y-0.5">
                                            @foreach (array_slice($features, 0, 4) as $feature)
                                                <li>{{ $feature }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium {{ $quotaColor }}">
                                            {{ $quotaText }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $tier->active_members }} Akun</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($tier->is_active)
                                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-green-700 bg-green-50 px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Unggulan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1">
                                            <button class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors">
                                                Ubah
                                            </button>
                                            <button class="w-8 h-8 rounded-lg hover:bg-gray-100 text-gray-500 transition-colors flex items-center justify-center" title="Pengaturan">
                                                <i class="fas fa-cog text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center text-gray-400">
                                        <i class="fas fa-crown text-4xl mb-3 block"></i>
                                        Belum ada data paket langganan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <p class="text-xs text-gray-500">
                        Menampilkan <span class="font-semibold text-gray-700">{{ $tiers->count() }}</span> dari <span class="font-semibold text-gray-700">{{ $tiers->count() }}</span> konfigurasi tier paket
                    </p>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">Sebelumnya</span>
                        <span class="w-8 h-8 rounded-lg bg-blue-600 text-white text-xs font-semibold flex items-center justify-center">1</span>
                        <span class="text-xs text-gray-500">Selanjutnya</span>
                    </div>
                </div>

            </div>

        </main>
    </div>

    @include('admin.crud.membership')

</body>
</html>