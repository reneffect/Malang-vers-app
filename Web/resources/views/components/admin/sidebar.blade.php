@props(['active' => ''])

<aside class="w-64 bg-slate-900 text-gray-300 min-h-screen flex flex-col fixed left-0 top-0 bottom-0 z-40">
    
    {{-- ====== BRAND ====== --}}
    <div class="px-6 py-5 border-b border-slate-800">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-600/30">
                @if ($active === 'ebooks')
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 7.2c-2.3-1.5-5.5-1.8-8.5-.8v12.2c3-.9 6.2-.6 8.5.9m0-12.3c2.3-1.5 5.5-1.8 8.5-.8v12.2c-3-.9-6.2-.6-8.5.9m0-12.3v12.3" />
                        <path d="M6.5 9.5h2.8m-2.8 3h2.8m6-3h2.8m-2.8 3h2.8" />
                    </svg>
                @elseif ($active === 'membership')
                    <i class="fas fa-crown text-lg" aria-hidden="true"></i>
                @elseif ($active === 'users')
                    <i class="fas fa-language text-lg" aria-hidden="true"></i>
                @elseif ($active === 'transaksi')
                    <i class="fas fa-qrcode text-lg" aria-hidden="true"></i>
                @else
                    <span class="text-sm font-bold" aria-hidden="true">MV</span>
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
        
        @php
            $menuItems = [
                ['key' => 'ebooks',      'icon' => 'fa-book',      'label' => 'Manage E-Book',          'route' => 'admin.ebooks'],
                ['key' => 'membership',  'icon' => 'fa-crown',     'label' => 'Manage Membership Tier', 'route' => 'admin.membership'],
                ['key' => 'users',       'icon' => 'fa-users',     'label' => 'Manage Users',           'route' => 'admin.users'],
                ['key' => 'transaksi',   'icon' => 'fa-qrcode',    'label' => 'Transactions',           'route' => 'admin.transaksi'],
            ];
        @endphp

        @foreach ($menuItems as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ $active === $item['key'] 
                          ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' 
                          : 'text-gray-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas {{ $item['icon'] }} w-5 text-center"></i>
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
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:bg-red-500/10 hover:text-red-400 transition-colors">
                <i class="fas fa-sign-out-alt w-5 text-center"></i>
                <span>Logout</span>
            </button>
        </form>

    </div>
</aside>