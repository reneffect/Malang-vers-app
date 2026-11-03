<nav class="bg-blue-600 text-white">
    <div class="flex items-center justify-between h-16 px-6">
        <a href="{{ $brandHref }}" class="flex items-center gap-2">
            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-white text-blue-600 font-bold">M</span>
            <div class="leading-tight">
                <div class="font-semibold text-lg">MalangVerse</div>
                <div class="text-xs text-blue-100">Preservasi Boso Walikan</div>
            </div>
        </a>

        <div class="hidden md:flex items-center gap-6">
            @foreach ($menus as $menu)
                <a href="{{ $menu['href'] }}"
                   class="hover:text-blue-100 {{ $menu['active'] ? 'font-semibold underline underline-offset-4' : '' }}">
                    {{ $menu['label'] }}
                </a>
            @endforeach
        </div>

        <div class="flex items-center gap-3">
            @foreach ($authLinks as $index => $link)
                <a href="{{ $link['href'] }}"
                   class="{{ $loggedIn || $index === 1
                        ? 'bg-white text-blue-600 px-4 py-1.5 rounded-full font-medium hover:bg-gray-100'
                        : 'border border-white/60 px-4 py-1.5 rounded-full hover:bg-white/10' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</nav>