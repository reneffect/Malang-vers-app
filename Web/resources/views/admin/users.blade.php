<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - MalangVerse Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/guest.css', 'resources/css/user/admin/dashboard.css', 'resources/js/guest.js'])
</head>
<body class="admin-reference-theme bg-gray-100 font-sans antialiased">

    <x-admin.sidebar active="users" />

    <div class="ml-64 min-h-screen flex flex-col">
        <x-admin.topbar />

        <main class="flex-1 p-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Kelola Pengguna MalangVerse</h1>
                <p class="text-sm text-gray-500 mt-1">Direktori akun member terdaftar, status keanggotaan, dan riwayat akses kamus</p>
            </div>

            <div class="grid grid-cols-1 items-start gap-5 xl:grid-cols-[minmax(0,1.8fr)_minmax(18rem,1fr)]">
                <div class="min-w-0 space-y-8">
            {{-- ===== STATS ===== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Total Member Terdaftar</span>
                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center"><i class="fas fa-users text-blue-600"></i></div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($totalMember) }} <span class="text-sm font-normal text-gray-500">Akun</span></div>
                    <p class="text-[11px] text-green-600 mt-1"><i class="fas fa-arrow-up"></i> +12% dari bulan lalu</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Member Premium Aktif</span>
                        <div class="w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center"><i class="fas fa-crown text-purple-600"></i></div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($premiumAktif) }} <span class="text-sm font-normal text-gray-500">Akun</span></div>
                    <p class="text-[11px] text-gray-400 mt-1">{{ $totalMember > 0 ? round(($premiumAktif/$totalMember)*100,1) : 0 }}% Rasio konversi pro</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Pengguna Baru Minggu Ini</span>
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center"><i class="fas fa-user-plus text-emerald-600"></i></div>
                    </div>
                    <div class="text-2xl font-bold text-emerald-600">+{{ $baruMingguIni }} <span class="text-sm font-normal text-gray-500">Akun</span></div>
                    <p class="text-[11px] text-gray-400 mt-1">+124 vs 7 hari sebelumnya</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500">Pengguna Ditangguhan</span>
                        <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center"><i class="fas fa-ban text-red-600"></i></div>
                    </div>
                    <div class="text-2xl font-bold text-red-600">{{ $ditangguhan }} <span class="text-sm font-normal text-gray-500">Akun</span></div>
                    <p class="text-[11px] text-gray-400 mt-1">Pelanggaran ToS &amp; Bot</p>
                </div>
            </div>

            {{-- ===== TABEL ===== --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

                {{-- Header + Tabs --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 flex-wrap gap-3">
                    <div class="flex items-center gap-3">
                        <h2 class="text-base font-bold text-gray-900">Direktori Pengguna</h2>
                        <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">{{ $users->total() }} dari {{ number_format($totalMember) }} data</span>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        @php
                            $tabs = [
                                'all'      => 'Semua Akun',
                                'single'   => 'Single E-Book Pro',
                                'standar'  => 'Paket Standar',
                                'suspended'=> 'Ditangguhan',
                            ];
                        @endphp
                        @foreach ($tabs as $key => $label)
                            <a href="{{ route('admin.users', array_merge(request()->query(), ['tab' => $key])) }}"
                               class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-colors
                                      {{ $tab === $key ? 'bg-blue-600 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">ID Pengguna</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Profil Pengguna</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Email</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Paket Aktif</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Bergabung</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Kamus Dimiliki</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($users as $user)
                                @php
                                    $usrId   = 'USR-' . str_pad($user->id, 4, '0', STR_PAD_LEFT);
                                    $uname   = $user->username ?? Str::before($user->email, '@');
                                    $paket   = $user->activeMembership?->tier?->name ?? 'Paket Gratis';
                                    $status  = $user->status ?? 'active';
                                    $kamus   = $user->kamus_dimiliki ?? 0;
                                    $isPrem  = $user->activeMembership !== null;
                                @endphp
                                <tr class="transition-colors {{ $selectedUser?->is($user) ? 'bg-blue-50/60' : 'hover:bg-gray-50' }}">
                                    <td class="px-6 py-4 font-semibold text-blue-600 text-xs">{{ $usrId }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs overflow-hidden shrink-0">
                                                @if ($user->avatar)
                                                    <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                                                @else
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <div class="font-semibold text-gray-900 truncate">{{ $user->name }}</div>
                                                <div class="text-[11px] text-gray-400 truncate">{{ '@'.$uname }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 text-xs">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium
                                            {{ $isPrem ? 'bg-purple-50 text-purple-700 border border-purple-200' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $paket }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-gray-600 text-xs">
                                        <i class="fas fa-book text-gray-400 mr-1.5"></i>{{ $kamus }} E-Book
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($status === 'suspended')
                                            <span class="inline-flex items-center gap-1.5 text-[11px] font-medium text-red-700 bg-red-50 px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Ditangguhan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-[11px] font-medium text-green-700 bg-green-50 px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.users', array_merge(request()->query(), ['user' => $user->id])) }}#profile-detail"
                                           class="inline-flex items-center gap-1.5 text-xs font-semibold rounded-lg px-3 py-1.5 transition-colors
                                                  {{ $selectedUser?->is($user) ? 'bg-blue-600 text-white hover:bg-blue-700' : 'border border-gray-200 text-gray-600 hover:border-blue-500 hover:text-blue-600' }}">
                                            Detail <i class="fas fa-arrow-right text-[10px]"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-users text-4xl mb-3 block"></i>Belum ada pengguna.
                                </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination (dengan ellipsis) --}}
                <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <p class="text-xs text-gray-500">
                        Menampilkan <span class="font-semibold text-gray-700">{{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }}</span>
                        dari <span class="font-semibold text-gray-700">{{ number_format($users->total()) }}</span> pengguna terdaftar
                    </p>
                    <div class="flex items-center gap-1">
                        @if ($users->onFirstPage())
                            <span class="text-xs text-gray-400 mr-2">Sebelumnya</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="text-xs text-blue-600 hover:text-blue-700 mr-2">Sebelumnya</a>
                        @endif

                        @php $cur = $users->currentPage(); $last = $users->lastPage(); @endphp
                        @for ($i = 1; $i <= $last; $i++)
                            @if ($i == 1 || $i == $last || ($i >= $cur - 1 && $i <= $cur + 1))
                                @if ($i == $cur)
                                    <span class="w-8 h-8 rounded-lg bg-blue-600 text-white text-xs font-semibold flex items-center justify-center">{{ $i }}</span>
                                @else
                                    <a href="{{ $users->urlPage($i) }}" class="w-8 h-8 rounded-lg bg-white border border-gray-200 hover:border-blue-500 text-gray-600 text-xs font-semibold flex items-center justify-center transition-colors">{{ $i }}</a>
                                @endif
                            @elseif ($i == 2 || $i == $last - 1)
                                <span class="text-gray-400 text-xs px-1">…</span>
                            @endif
                        @endfor

                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="text-xs text-blue-600 hover:text-blue-700 ml-2">Berikutnya</a>
                        @else
                            <span class="text-xs text-gray-400 ml-2">Berikutnya</span>
                        @endif
                    </div>
                </div>

            </div>
                </div>

                <aside id="profile-detail" class="xl:sticky xl:top-24">
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
                        <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
                            <h2 class="text-sm font-bold text-gray-900">Detail Informasi Pengguna</h2>
                            @if ($selectedUser)
                                <span class="text-[11px] font-semibold text-blue-600">
                                    USR-{{ str_pad((string) $selectedUser->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            @endif
                        </div>

                        @if ($selectedUser)
                            <div class="space-y-5 p-5">
                                <section class="border-t-4 border-blue-600 bg-indigo-50/70 px-4 py-5 text-center">
                                    <div class="mx-auto mb-3 flex h-16 w-16 items-center justify-center overflow-hidden rounded-full border-4 border-white bg-gradient-to-br from-blue-500 to-purple-600 text-xl font-bold text-white shadow">
                                        @if ($selectedUser->avatar)
                                            <img src="{{ asset('storage/'.$selectedUser->avatar) }}" alt="" class="h-full w-full object-cover">
                                        @else
                                            {{ mb_strtoupper(mb_substr($selectedUser->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <h3 class="font-bold text-gray-900">{{ $selectedUser->name }}</h3>
                                    <p class="mt-1 break-all text-xs text-gray-500">{{ $selectedUser->email }}</p>
                                    <span class="mt-3 inline-flex rounded-full bg-blue-100 px-3 py-1 text-[11px] font-semibold text-blue-700">
                                        {{ $selectedUser->role_label }}
                                    </span>
                                </section>

                                <section>
                                    <h3 class="mb-2 text-[11px] font-bold uppercase tracking-wide text-gray-500">Informasi Akun</h3>
                                    <dl class="divide-y divide-gray-100 rounded-xl border border-gray-200">
                                        <div class="flex items-start justify-between gap-3 px-3 py-2.5">
                                            <dt class="text-xs text-gray-500">Username</dt>
                                            <dd class="break-all text-right text-xs font-semibold text-gray-900">{{ '@'.Str::before($selectedUser->email, '@') }}</dd>
                                        </div>
                                        <div class="flex items-start justify-between gap-3 px-3 py-2.5">
                                            <dt class="text-xs text-gray-500">Nomor telepon</dt>
                                            <dd class="text-right text-xs font-semibold text-gray-900">{{ $selectedUser->phone ?: 'Belum diisi' }}</dd>
                                        </div>
                                        <div class="flex items-start justify-between gap-3 px-3 py-2.5">
                                            <dt class="text-xs text-gray-500">Kota</dt>
                                            <dd class="text-right text-xs font-semibold text-gray-900">{{ $selectedUser->kota ?: 'Belum diisi' }}</dd>
                                        </div>
                                        <div class="flex items-start justify-between gap-3 px-3 py-2.5">
                                            <dt class="text-xs text-gray-500">Bergabung</dt>
                                            <dd class="text-right text-xs font-semibold text-gray-900">{{ $selectedUser->created_at?->translatedFormat('d M Y') ?? '—' }}</dd>
                                        </div>
                                    </dl>
                                </section>

                                <section class="rounded-xl border border-gray-200 p-4">
                                    <h3 class="mb-3 text-[11px] font-bold uppercase tracking-wide text-gray-500">Membership</h3>
                                    @if ($selectedUser->activeMembership?->tier)
                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $selectedUser->activeMembership->tier->name }}</p>
                                                <p class="mt-1 text-[11px] text-gray-500">Akses membership aktif</p>
                                            </div>
                                            <span class="shrink-0 rounded-full bg-green-50 px-2.5 py-1 text-[10px] font-semibold text-green-700">Aktif</span>
                                        </div>
                                    @else
                                        <p class="text-xs text-gray-500">Belum memiliki membership aktif.</p>
                                    @endif
                                </section>

                                <section class="grid grid-cols-2 gap-3">
                                    <div class="rounded-xl bg-gray-50 p-3">
                                        <p class="text-[11px] text-gray-500">Level</p>
                                        <p class="mt-1 text-sm font-bold text-gray-900">{{ $selectedUser->level ?? 1 }}</p>
                                    </div>
                                    <div class="rounded-xl bg-gray-50 p-3">
                                        <p class="text-[11px] text-gray-500">XP</p>
                                        <p class="mt-1 text-sm font-bold text-gray-900">{{ number_format($selectedUser->xp ?? 0) }}</p>
                                    </div>
                                </section>

                                @if ($selectedUser->bio)
                                    <section>
                                        <h3 class="mb-2 text-[11px] font-bold uppercase tracking-wide text-gray-500">Bio</h3>
                                        <p class="whitespace-pre-line text-xs leading-relaxed text-gray-600">{{ $selectedUser->bio }}</p>
                                    </section>
                                @endif
                            </div>
                        @else
                            <div class="px-5 py-12 text-center text-sm text-gray-400">
                                <i class="fas fa-user-circle mb-3 block text-3xl"></i>
                                Belum ada pengguna untuk ditampilkan.
                            </div>
                        @endif
                    </div>
                </aside>
            </div>
        </main>
    </div>
</body>
</html>