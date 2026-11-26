<header class="sticky top-0 z-50 w-full bg-white border-b border-slate-100/90 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between">
        {{-- Brand / Logo --}}
        <a href="{{ $brandHref }}" class="flex items-center gap-2.5 group select-none" aria-label="MalangVerse Home">
            <div class="w-8 h-8 rounded-full bg-[#1D4ED8] flex items-center justify-center text-white shadow-xs shrink-0">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12.87 15.07l-2.54-2.51.03-.03c1.74-1.94 2.98-4.17 3.71-6.53H17V4h-7V2H8v2H1v1.99h11.17C11.5 7.92 10.44 9.75 9 11.35 8.07 10.32 7.3 9.19 6.69 8h-2c.73 1.63 1.73 3.17 2.98 4.56l-5.09 5.02L4 19l5-5 3.11 3.11.76-2.04zM18.5 10h-2L12 22h2l1.12-3h4.75L21 22h2l-4.5-12zm-2.62 7l1.62-4.33L19.12 17h-3.24z"/>
                </svg>
            </div>
            <span class="text-xl font-bold tracking-tight text-[#1D4ED8]">MalangVerse</span>
        </a>

        {{-- Navigation Menu (Center) --}}
        <nav class="hidden md:flex items-center gap-8 h-full">
            @foreach ($menus as $menu)
                <a href="{{ $menu['href'] }}"
                   class="relative flex items-center h-full text-sm transition-colors {{ $menu['active'] ? 'text-[#1D4ED8] font-bold' : 'text-slate-600 font-semibold hover:text-slate-900' }}">
                    <span>{{ $menu['label'] }}</span>
                    @if ($menu['active'])
                        <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#1D4ED8] rounded-full"></span>
                    @endif
                </a>
            @endforeach
        </nav>

        {{-- Actions (Right) --}}
        <div class="flex items-center gap-3">
            @if ($profile)
                <div class="relative">
                    <details class="profile-dropdown">
                        <summary class="profile-trigger">
                            <div class="flex items-center gap-2.5 rounded-full border border-slate-200/90 bg-white py-1 pl-1 pr-3 shadow-xs hover:border-slate-300 transition-colors cursor-pointer list-none select-none [&::-webkit-details-marker]:hidden">
                                @if ($profile['avatarUrl'])
                                    <img data-navbar-avatar src="{{ $profile['avatarUrl'] }}" alt="{{ $profile['name'] }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 text-white font-bold text-xs flex items-center justify-center">
                                        {{ mb_strtoupper(mb_substr($profile['name'], 0, 1)) }}
                                    </div>
                                @endif
                                <span class="text-sm font-semibold text-slate-800">{{ $profile['name'] }}</span>
                                <span class="rounded-full bg-[#1D4ED8] px-2 py-0.5 text-[10px] font-bold text-white uppercase tracking-wider">
                                    {{ $profile['badge'] }}
                                </span>
                                <svg class="w-3.5 h-3.5 text-slate-400" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="m4 6 4 4 4-4" />
                                </svg>
                            </div>
                        </summary>

                        <div class="absolute right-0 mt-2 w-48 rounded-2xl bg-white p-2 shadow-xl border border-slate-100 z-50">
                            <div class="px-3 py-2 border-b border-slate-100">
                                <p class="text-xs font-bold text-slate-800 truncate">{{ $profile['name'] }}</p>
                                <p class="text-[11px] text-slate-500 truncate">{{ $profile['email'] }}</p>
                            </div>
                            <a href="{{ $profile['profileHref'] }}" class="flex items-center gap-2 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 rounded-xl transition-colors">
                                Profil Saya
                            </a>
                            <a href="{{ $profile['dashboardHref'] }}" class="flex items-center gap-2 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 rounded-xl transition-colors">
                                Dashboard
                            </a>
                            <a href="{{ $profile['membershipHref'] }}" class="flex items-center gap-2 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 rounded-xl transition-colors">
                                Langganan
                            </a>
                            <form method="POST" action="{{ $profile['logoutHref'] }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-2 px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-50 rounded-xl transition-colors cursor-pointer">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </details>
                </div>
            @else
                @foreach ($authLinks as $index => $link)
                    <a href="{{ $link['href'] }}"
                       class="px-5 py-2 text-sm font-semibold rounded-full transition-colors {{ $index === 1 ? 'bg-[#1D4ED8] text-white hover:bg-blue-700 shadow-sm' : 'border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</header>
