@props(['active' => ''])

<aside class="w-64 bg-slate-900 text-gray-300 min-h-screen flex flex-col fixed left-0 top-0 bottom-0 z-40">
    
    {{-- ====== BRAND ====== --}}
    <div class="px-6 py-5 border-b border-slate-800">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-600/30">
                <i class="fas fa-book-open text-lg"></i>
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