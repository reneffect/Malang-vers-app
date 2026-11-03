<nav class="flex items-center justify-between h-16 px-4 bg-blue-600 border-b border-gray-200">
    <div class="flex items-center">
        <a href="{{ route('home') }}" class="text-white text-lg font-semibold">
            Malang Vers
        </a>
    </div>

    <div class="flex items-center gap-4">
        <a href="{{ route('Beranda') }}" class="text-white hover:text-gray-200">
            Beranda
        </a>
        <a href="{{ route('Kamus-Boso-Walikan') }}" class="text-white hover:text-gray-200">
            Kamus Boso Walikan
        </a>
        <a href="{{ route('Membership') }}" class="text-white hover:text-gray-200">
            Langganan
        </a>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('login') }}"
           class="bg-white text-blue-600 px-4 py-2 rounded hover:bg-gray-100">
            Login
        </a>
        <a href="{{ route('register') }}"
           class="bg-white text-blue-600 px-4 py-2 rounded hover:bg-gray-100">
            Register
        </a>
    </div>
</nav>