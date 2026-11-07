<nav class="site-header">
    <div class="site-navbar">
        <a href="{{ $brandHref }}" class="brand" aria-label="MalangVerse home">
            <span class="brand-mark">M</span>
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
            @foreach ($authLinks as $index => $link)
                <a href="{{ $link['href'] }}"
                   class="button {{ $loggedIn || $index === 1 ? 'button-light' : 'button-outline' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</nav>