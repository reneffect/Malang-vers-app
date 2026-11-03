<header class="site-header">
    <nav class="site-navbar" aria-label="Navigasi utama">
        <a class="brand" href="{{ route('home') }}">
            <span class="brand-mark" aria-hidden="true">M</span>
            <span class="brand-copy">
                <span class="brand-name">MalangVerse</span>
                <span class="brand-tagline">Preservasi Boso Walikan</span>
            </span>
        </a>

        <div class="navbar-links">
            @foreach ([
                'Beranda' => 'Beranda',
                'Kamus-Boso-Walikan' => 'Kamus Boso Walikan',
                'Membership' => 'Langganan',
            ] as $routeName => $label)
                @if (Route::has($routeName))
                    <a class="navbar-link" href="{{ route($routeName) }}">{{ $label }}</a>
                @else
                    <span class="navbar-link" aria-disabled="true">{{ $label }}</span>
                @endif
            @endforeach
        </div>

        <div class="navbar-actions">
            <button class="language-button" type="button" aria-label="Pilih bahasa" disabled>
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 3a9 9 0 1 0 9 9 9 9 0 0 0-9-9Zm6.92 8h-3a14.7 14.7 0 0 0-1.22-5.06A7.02 7.02 0 0 1 18.92 11ZM12 5c.94 1.36 1.57 3.55 1.82 6h-3.64C10.43 8.55 11.06 6.36 12 5ZM5.08 13h3a14.7 14.7 0 0 0 1.22 5.06A7.02 7.02 0 0 1 5.08 13Zm3-2h-3a7.02 7.02 0 0 1 4.22-5.06A14.7 14.7 0 0 0 8.08 11Zm3.1 2h3.64c-.25 2.45-.88 4.64-1.82 6-.94-1.36-1.57-3.55-1.82-6Zm4.74 5.06A14.7 14.7 0 0 0 17.92 13h3a7.02 7.02 0 0 1-4.22 5.06ZM17.92 11a14.7 14.7 0 0 0-1.22-5.06A7.02 7.02 0 0 1 20.92 11Z"/>
                </svg>
            </button>

            @if (Route::has('login'))
                <a class="button button-outline" href="{{ route('login') }}">Masuk</a>
            @else
                <span class="button button-outline" aria-disabled="true">Masuk</span>
            @endif

            @if (Route::has('register'))
                <a class="button button-light" href="{{ route('register') }}">Daftar</a>
            @else
                <span class="button button-light" aria-disabled="true">Daftar</span>
            @endif
        </div>
    </nav>
</header>
