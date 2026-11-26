<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - MalangVerse Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/guest.css', 'resources/js/guest.js'])
    <style>
        @keyframes drawerIn   { from { transform: translateX(100%); } to { transform: translateX(0); } }
        @keyframes backdropIn { from { opacity: 0; } to { opacity: 1; } }
        .drawer-panel    { animation: drawerIn .28s cubic-bezier(.22,.8,.36,1) both; }
        .drawer-backdrop { animation: backdropIn .2s ease-out both; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    @php
        $tabs = [
            'all'     => 'Semua Akun',
            'gratis'  => 'Paket Gratis',
            'standar' => 'Paket Standar',
            'premium' => 'Paket Premium',
        ];
        $tabBase = request()->except(['page', 'user']);
    @endphp

    <x-admin.sidebar active="users" />

    <div class="ml-64 min-h-screen flex flex-col">
        <x-admin.topbar />

        <main class="flex-1 p-8">

            {{-- HEADER --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Kelola Pengguna MalangVerse</h1>
                <p class="text-sm text-gray-500 mt-1">Direktori akun member terdaftar dan status keanggotaan</p>
            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-medium text-gray-500">Total Member Terdaftar</span>
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                            <i class="fas fa-users text-xs text-blue-600"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">
                        {{ number_format($totalMember) }} <span class="text-sm font-normal text-gray-500">Akun</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-medium text-gray-500">Member Premium Aktif</span>
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                            <i class="fas fa-crown text-xs text-blue-600"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">
                        {{ number_format($premiumAktif) }} <span class="text-sm font-normal text-gray-500">Akun</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-medium text-gray-500">Pengguna Baru (7 Hari)</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <i class="fas fa-user-plus text-xs text-emerald-600"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-emerald-600">
                        +{{ number_format($baruMingguIni) }} <span class="text-sm font-normal text-gray-500">Akun</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-medium text-gray-500">Pengguna Ditangguhkan</span>
                        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">
                            <i class="fas fa-ban text-xs text-red-600"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-red-600">
                        {{ number_format($ditangguhan) }} <span class="text-sm font-normal text-gray-500">Akun</span>
                    </div>
                </div>
            </div>

            {{-- TABEL (full width) --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

                <div class="flex items-center justify-between flex-wrap gap-3 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <h2 class="text-sm font-bold text-gray-900">Direktori Pengguna</h2>
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-blue-50 text-blue-600">
                            {{ $users->total() }} dari {{ number_format($totalMember) }} data
                        </span>
                    </div>

                    <div class="flex items-center gap-1.5 flex-wrap">
                        @foreach ($tabs as $key => $label)
                            <a href="{{ route('admin.users', array_merge($tabBase, ['tab' => $key])) }}"
                               class="px-3 py-1 text-[11px] font-semibold rounded-full transition-colors
                                      {{ $tab === $key ? 'bg-blue-600 text-white' : 'text-gray-500 border border-gray-200 hover:bg-gray-50' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50/70 border-b border-gray-200">
                                <th class="text-left px-5 py-3 text-[10px] font-semibold text-gray-500 uppercase tracking-wide">ID</th>
                                <th class="text-left px-5 py-3 text-[10px] font-semibold text-gray-500 uppercase tracking-wide">Profil</th>
                                <th class="text-left px-5 py-3 text-[10px] font-semibold text-gray-500 uppercase tracking-wide">Paket Aktif</th>
                                <th class="text-left px-5 py-3 text-[10px] font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                                <th class="text-right px-5 py-3 text-[10px] font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($users as $user)
                                @php
                                    $usrId      = 'USR-' . str_pad($user->id, 4, '0', STR_PAD_LEFT);
                                    $paketNama  = $activeTiers[$user->id] ?? null;
                                @endphp
                                <tr class="transition-colors hover:bg-gray-50/60">
                                    <td class="px-5 py-4 text-[11px] font-semibold text-blue-600 whitespace-nowrap">{{ $usrId }}</td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs shrink-0">
                                                {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <div class="font-semibold text-gray-900 text-[13px] leading-tight">{{ $user->name }}</div>
                                                <div class="text-[10px] text-gray-400 mt-0.5">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($paketNama)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                                <i class="fas fa-crown text-[9px]"></i> {{ $paketNama }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-semibold bg-gray-50 text-gray-600 border border-gray-200">
                                                Paket Gratis
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        <button type="button"
                                                data-user-detail="{{ route('admin.users', array_merge(request()->query(), ['user' => $user->id])) }}"
                                                class="inline-flex items-center gap-1 text-[11px] font-semibold rounded-full px-3 py-1 transition-colors
                                                       border border-gray-200 text-gray-500 hover:border-blue-500 hover:text-blue-600 disabled:opacity-60 disabled:cursor-wait">
                                            Detail <i class="fas fa-chevron-right text-[8px]"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-400">
                                        <i class="fas fa-users text-3xl mb-3 block"></i>Belum ada pengguna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="flex items-center justify-between flex-wrap gap-3 px-6 py-3.5 border-t border-gray-200 bg-gray-50/60">
                    <p class="text-[11px] text-gray-500">
                        Menampilkan
                        <span class="font-semibold text-gray-700">{{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }}</span>
                        dari <span class="font-semibold text-gray-700">{{ number_format($users->total()) }}</span> pengguna
                    </p>

                    <div class="flex items-center gap-1">
                        @if ($users->onFirstPage())
                            <span class="text-[11px] text-gray-300 px-2">Sebelumnya</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="text-[11px] text-gray-500 hover:text-blue-600 px-2">Sebelumnya</a>
                        @endif

                        @foreach ($users->getUrlRange(max(1, $users->currentPage() - 1), min($users->lastPage(), $users->currentPage() + 1)) as $page => $url)
                            @if ($page == $users->currentPage())
                                <span class="w-7 h-7 rounded-full bg-blue-600 text-white text-[11px] font-semibold flex items-center justify-center">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                   class="w-7 h-7 rounded-full bg-white border border-gray-200 hover:border-blue-500 text-gray-600 text-[11px] font-semibold flex items-center justify-center transition-colors">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="text-[11px] text-gray-500 hover:text-blue-600 px-2">Berikutnya</a>
                        @else
                            <span class="text-[11px] text-gray-300 px-2">Berikutnya</span>
                        @endif
                    </div>
                </div>
            </div>

        </main>
    </div>

    {{-- ============ POP UP DETAIL PENGGUNA (DRAWER) ============ --}}
    <div id="drawer-root"></div>

    @if ($selectedUser && request()->ajax())
        @php
            $dPaket   = $activeTiers[$selectedUser->id] ?? null;
            $dUname   = $selectedUser->username ?? \Illuminate\Support\Str::before($selectedUser->email, '@');
            $aktifRow = $riwayat->firstWhere('status', 'active');
            $dBerakhir = $aktifRow?->ends_at ? \Illuminate\Support\Carbon::parse($aktifRow->ends_at)->format('d M Y') : null;
        @endphp

        <div id="user-drawer" class="fixed inset-0 z-[60]" role="dialog" aria-modal="true" aria-labelledby="drawer-title">

            {{-- Backdrop: klik untuk menutup --}}
            <button type="button" data-drawer-close aria-label="Tutup"
                    class="drawer-backdrop absolute inset-0 w-full h-full bg-gray-900/40 backdrop-blur-[2px] cursor-default"></button>

            {{-- Panel --}}
            <aside class="drawer-panel absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl flex flex-col">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 shrink-0">
                    <h3 id="drawer-title" class="flex items-center gap-2 text-sm font-bold text-gray-900">
                        <i class="fas fa-circle-user text-blue-600"></i> Detail Informasi Pengguna
                    </h3>
                    <button type="button" data-drawer-close title="Tutup"
                            class="w-8 h-8 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 flex items-center justify-center transition">
                        <i class="fas fa-xmark text-sm"></i>
                    </button>
                </div>

                {{-- Body (scrollable) --}}
                <div class="flex-1 overflow-y-auto px-6 py-5 space-y-6">

                    {{-- Kartu profil --}}
                    <div class="rounded-xl border border-blue-100 bg-blue-50/50 overflow-hidden text-center">
                        <div class="h-1.5 bg-blue-600"></div>
                        <div class="px-5 py-5">
                            <div class="w-16 h-16 mx-auto rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl ring-4 ring-white shadow">
                                {{ mb_strtoupper(mb_substr($selectedUser->name, 0, 1)) }}
                            </div>
                            <h4 class="mt-3 text-base font-bold text-gray-900">{{ $selectedUser->name }}</h4>
                            <p class="text-xs text-gray-400">{{ '@' . $dUname }}</p>

                            <div class="mt-3 flex items-center justify-center gap-2 flex-wrap">
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                                @if ($dPaket)
                                    <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold text-blue-700 bg-white border border-blue-200 px-2.5 py-1 rounded-full">
                                        <i class="fas fa-crown text-[9px]"></i>
                                        {{ $dPaket }}{{ $dBerakhir ? ' (s/d ' . $dBerakhir . ')' : '' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-[10px] font-semibold text-gray-600 bg-white border border-gray-200 px-2.5 py-1 rounded-full">
                                        Paket Gratis
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Informasi akun --}}
                    <section>
                        <h5 class="flex items-center gap-2 text-xs font-bold text-gray-800 mb-3">
                            <i class="fas fa-id-card text-gray-400"></i> Informasi Akun
                        </h5>
                        <dl class="rounded-xl border border-gray-200 divide-y divide-gray-100 text-xs">
                            <div class="flex justify-between gap-4 px-4 py-2.5">
                                <dt class="text-gray-500">ID Pengguna</dt>
                                <dd class="font-semibold text-blue-600">USR-{{ str_pad($selectedUser->id, 4, '0', STR_PAD_LEFT) }}</dd>
                            </div>
                            <div class="flex justify-between gap-4 px-4 py-2.5">
                                <dt class="text-gray-500">Email</dt>
                                <dd class="text-gray-800 text-right break-all">{{ $selectedUser->email }}</dd>
                            </div>
                            <div class="flex justify-between gap-4 px-4 py-2.5">
                                <dt class="text-gray-500">Telepon</dt>
                                <dd class="text-gray-800">{{ $selectedUser->phone ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between gap-4 px-4 py-2.5">
                                <dt class="text-gray-500">Bergabung</dt>
                                <dd class="text-gray-800">{{ $selectedUser->created_at->format('d M Y, H:i') }}</dd>
                            </div>
                            <div class="flex justify-between gap-4 px-4 py-2.5">
                                <dt class="text-gray-500">Paket Aktif</dt>
                                <dd class="font-semibold text-gray-900">{{ $dPaket ?? 'Paket Gratis' }}</dd>
                            </div>
                            <div class="flex justify-between gap-4 px-4 py-2.5">
                                <dt class="text-gray-500">Berakhir</dt>
                                <dd class="text-gray-800">{{ $dBerakhir ?? '-' }}</dd>
                            </div>
                        </dl>
                    </section>

                    {{-- Riwayat paket --}}
                    <section>
                        <div class="flex items-center justify-between mb-3">
                            <h5 class="flex items-center gap-2 text-xs font-bold text-gray-800">
                                <i class="fas fa-clock-rotate-left text-gray-400"></i> Riwayat Paket
                            </h5>
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-blue-50 text-blue-600">
                                {{ $riwayat->count() }} Paket
                            </span>
                        </div>

                        <div class="space-y-2">
                            @forelse ($riwayat as $m)
                                <div class="flex items-center justify-between gap-3 p-3 rounded-lg border border-gray-200 bg-white">
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold text-gray-800 truncate">{{ $m->tier_name ?? '-' }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">
                                            {{ $m->started_at ? \Illuminate\Support\Carbon::parse($m->started_at)->format('d M Y') : '-' }}
                                        </p>
                                    </div>
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full
                                        {{ $m->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($m->status) }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 text-center py-4 rounded-lg border border-dashed border-gray-200">
                                    Belum ada riwayat paket.
                                </p>
                            @endforelse
                        </div>
                    </section>
                </div>

                {{-- Footer --}}
                <div class="flex items-center gap-3 px-6 py-4 border-t border-gray-200 bg-gray-50/60 shrink-0">
                    <button type="button" data-drawer-close
                            class="flex-1 text-center text-xs font-semibold px-4 py-2.5 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition">
                        Tutup
                    </button>
                </div>
            </aside>
        </div>
    @endif

    <script>
        (function () {
            var root = document.getElementById('drawer-root');

            function closeDrawer() {
                root.innerHTML = '';
                document.body.classList.remove('overflow-hidden');
            }

            function openDrawer(btn) {
                btn.disabled = true;
                fetch(btn.dataset.userDetail, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' },
                    credentials: 'same-origin'
                })
                .then(function (r) { if (!r.ok) throw new Error(r.status); return r.text(); })
                .then(function (html) {
                    var doc = new DOMParser().parseFromString(html, 'text/html');
                    var drawer = doc.getElementById('user-drawer');
                    if (!drawer) throw new Error('drawer not found');
                    root.innerHTML = '';
                    root.appendChild(document.importNode(drawer, true));
                    document.body.classList.add('overflow-hidden');
                })
                .catch(function () { alert('Gagal memuat detail pengguna.'); })
                .finally(function () { btn.disabled = false; });
            }

            document.addEventListener('click', function (e) {
                var open = e.target.closest('[data-user-detail]');
                if (open) { openDrawer(open); return; }
                if (e.target.closest('[data-drawer-close]')) closeDrawer();
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeDrawer();
            });
        })();
    </script>

</body>
</html>