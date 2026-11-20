<nav class="site-header">
    <div class="site-navbar">
        <a href="{{ $brandHref }}" class="brand" aria-label="MalangVerse home">
            <img src="{{ asset('images/brand.png') }}" 
                 alt="Logo MalangVerse" 
                 class="brand-mark">
            <span class="brand-copy">
                <span class="brand-name">MalangVerse</span>
                <span class="brand-tagline">Preservasi Boso Walikan</span>
            </span>
        </a>

        <div class="navbar-links">
            @foreach ($menus as $menu)
                <a href="{{ $menu['href'] }}"
                   class="navbar-link {{ $menu['active'] ? 'font-semibold underline underline-offset-4' : '' }}">
                    {{ $menu['label'] }}
                </a>
            @endforeach
        </div>

        <div class="navbar-actions">
            @if ($profile)
                <details class="profile-dropdown">
                    <summary class="profile-trigger" aria-label="Buka menu profil {{ $profile['name'] }}">
                        <span class="profile-avatar" aria-hidden="true">
                            @if ($profile['avatarUrl'])
                                <img data-navbar-avatar src="{{ $profile['avatarUrl'] }}" alt="" class="profile-avatar-image">
                            @else
                                {{ mb_strtoupper(mb_substr($profile['name'], 0, 1)) }}
                            @endif
                        </span>
                        <span class="profile-name">{{ $profile['name'] }}</span>
                        <span class="profile-badge">{{ $profile['badge'] }}</span>
                        <svg class="profile-chevron" viewBox="0 0 16 16" aria-hidden="true">
                            <path d="m4 6 4 4 4-4" />
                        </svg>
                    </summary>

                    <div class="profile-menu">
                        <div class="profile-menu-header">
                            <span class="profile-menu-name">{{ $profile['name'] }}</span>
                            <span class="profile-menu-email">{{ $profile['email'] }}</span>
                        </div>

                        <a class="profile-menu-link" href="{{ $profile['profileHref'] }}">Profil Saya</a>
                        <a class="profile-menu-link" href="{{ $profile['dashboardHref'] }}">Dashboard</a>
                        <a class="profile-menu-link" href="{{ $profile['membershipHref'] }}">Langganan</a>

                        <form method="POST" action="{{ $profile['logoutHref'] }}">
                            @csrf
                            <button class="profile-menu-logout" type="submit">Keluar</button>
                        </form>
                    </div>
                </details>
            @else
                @foreach ($authLinks as $index => $link)
                    <a href="{{ $link['href'] }}"
                       class="button {{ $index === 1 ? 'button-light' : 'button-outline' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</nav>