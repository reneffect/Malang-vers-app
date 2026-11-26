@props(['active' => ''])

@php
    $icons = [
        'ebooks' => '
            <path d="M12 7v14"/>
            <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/>',

        'membership' => '
            <rect width="20" height="14" x="2" y="3" rx="2"/>
            <line x1="8" x2="16" y1="21" y2="21"/>
            <line x1="12" x2="12" y1="17" y2="21"/>',

        'users' => '
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>',

        'transaksi' => '
            <rect width="5" height="5" x="3" y="3" rx="1"/>
            <rect width="5" height="5" x="16" y="3" rx="1"/>
            <rect width="5" height="5" x="3" y="16" rx="1"/>
            <path d="M21 16h-3a2 2 0 0 0-2 2v3"/>
            <path d="M21 21v.01"/>
            <path d="M12 7v3a2 2 0 0 1-2 2H7"/>
            <path d="M3 12h.01"/>
            <path d="M12 3h.01"/>
            <path d="M12 16v.01"/>
            <path d="M16 12h1"/>
            <path d="M21 12v.01"/>
            <path d="M12 21v-1"/>',
    ];

    // Ikon brand per halaman (sesuai screenshot)
    $brandIcons = [
        'ebooks' => '
            <path d="M12 7v14"/>
            <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/>',

        'users' => '
            <path d="m5 8 6 6"/>
            <path d="m4 14 6-6 2-3"/>
            <path d="M2 5h12"/>
            <path d="M7 2h1"/>
            <path d="m22 22-5-10-5 10"/>
            <path d="M14 18h6"/>',

        'transaksi' => $icons['transaksi'],
    ];

    $menuItems = [
        ['key' => 'ebooks',     'label' => 'Manage E-Book',          'route' => 'admin.ebooks'],
        ['key' => 'membership', 'label' => 'Manage Membership Tier', 'route' => 'admin.membership'],
        ['key' => 'users',      'label' => 'Manage Users',           'route' => 'admin.users'],
        ['key' => 'transaksi',  'label' => 'Transactions',           'route' => 'admin.transaksi'],
    ];
@endphp

<aside class="w-64 bg-slate-900 text-gray-300 min-h-screen flex flex-col fixed left-0 top-0 bottom-0 z-40">

    {{-- ====== BRAND ====== --}}
    <div class="px-6 py-5 border-b border-slate-800">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-600/30">
                @if ($active === 'membership')
                    <span class="text-lg font-extrabold leading-none">M</span>
                @else
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        {!! $brandIcons[$active] ?? $brandIcons['ebooks'] !!}
                    </svg>
                @endif
            </div>
            <div class="leading-tight">
                <p class="font-bold text-white text-base">MalangVerse</p>
                <p class="text-[11px] text-gray-400">Portal Administrasi</p>
            </div>
        </div>
    </div>

    {{-- ====== NAVIGATION ====== --}}
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        @foreach ($menuItems as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ $active === $item['key']
                          ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30'
                          : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    {!! $icons[$item['key']] !!}
                </svg>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    {{-- ====== FOOTER ====== --}}
    <div class="px-3 py-4 border-t border-slate-800 space-y-3">

        <div class="px-4 py-3 bg-slate-800/50 rounded-lg border border-slate-700">
            <div class="flex items-center gap-2 mb-2">
                <i class="fas fa-circle-question text-gray-400 text-sm"></i>
                <span class="text-sm font-semibold text-gray-300">Bantuan Sistem</span>
            </div>
            <p class="text-[11px] text-gray-400 mb-3 leading-relaxed">
                Butuh panduan migrasi kuota atau integrasi PG?
            </p>
            <button type="button"
                    class="w-full px-3 py-2 bg-slate-700 hover:bg-slate-600 text-gray-200 text-xs font-medium rounded-lg transition-colors">
                Buka Dokumentasi
            </button>
        </div>

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:bg-red-500/10 hover:text-red-400 transition-colors">
                <i class="fas fa-sign-out-alt w-5 text-center"></i>
                <span>Logout</span>
            </button>
        </form>

    </div>
</aside>