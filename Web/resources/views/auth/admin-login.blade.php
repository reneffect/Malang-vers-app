<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MalangVerse POS - Login Admin</title>
    
    @vite(['resources/css/login/admin/login.css', 'resources/js/login/admin/login.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-[#f5f3ff] min-h-screen flex flex-col font-sans relative overflow-x-hidden">

    {{-- Navbar --}}
    <header class="flex justify-between items-center px-8 py-4 bg-white border-b border-gray-200 z-10">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-gray-800 rounded-lg flex items-center justify-center text-white text-sm">
                <i class="fas fa-store"></i>
            </div>
            <div class="flex flex-col">
                <span class="font-bold text-[15px] text-gray-900">MalangVerse POS</span>
                <span class="text-[11px] text-gray-500">Terminal Kasir Digital</span>
            </div>
        </div>
        <div class="flex items-center gap-2 text-[13px] text-gray-600">
            <span class="w-2 h-2 bg-green-500 rounded-full inline-block"></span>
            <span>Sistem Siaga Operasional</span>
        </div>
    </header>

    {{-- Background Decorations --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[8%] left-[5%] text-[100px] text-purple-200/40">
            <i class="fas fa-book-open"></i>
        </div>
        <div class="absolute top-[12%] right-[8%] text-[90px] text-purple-200/40">
            <i class="fas fa-book-reader"></i>
        </div>
        <div class="absolute bottom-[18%] left-[8%] text-[90px] text-purple-200/40">
            <i class="fas fa-book-open"></i>
        </div>
        <div class="absolute bottom-[12%] right-[10%] text-[80px] text-purple-200/40">
            <i class="fas fa-check-circle"></i>
        </div>
    </div>

    {{-- Main Login Container --}}
    <main class="flex-1 flex items-center justify-center p-10 z-10">
        <div class="bg-white rounded-2xl p-10 w-full max-w-[420px] shadow-[0_4px_24px_rgba(0,0,0,0.06)] text-center">

            {{-- Card Icon --}}
            <div class="w-[52px] h-[52px] bg-[#4f6ef7] rounded-xl flex items-center justify-center mx-auto mb-4 text-white text-[22px]">
                <i class="fas fa-book-open"></i>
            </div>

            <h1 class="text-[22px] font-bold text-gray-900 mb-1">MalangVerse Kasir</h1>
            <p class="text-[12px] text-gray-500 mb-7">Terminal Kasir & Verifikasi Digital E-Book Kamus</p>

            {{-- Display Validation Errors --}}
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-left">
                    <ul class="text-sm text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Display Status Message --}}
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Admin Login Form --}}
            <form method="POST" action="{{ route('admin.login') }}" class="text-left" id="adminLoginForm">
                @csrf

                {{-- Username/Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-[13px] font-semibold text-gray-700 mb-1.5">
                        Nama Pengguna
                    </label>
                    <div class="relative flex items-center">
                        <i class="fas fa-user absolute left-3.5 text-gray-400 text-sm"></i>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="Contoh: budi.santoso / kasir01" 
                            required 
                            autofocus
                            class="w-full pl-10 pr-4 py-3 border-[1.5px] border-gray-200 rounded-xl text-sm text-gray-700 outline-none transition-colors bg-gray-50 focus:border-[#4f6ef7] focus:bg-white"
                        >
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-5">
                    <label for="password" class="block text-[13px] font-semibold text-gray-700 mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative flex items-center">
                        <i class="fas fa-lock absolute left-3.5 text-gray-400 text-sm"></i>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="••••••••••••" 
                            required
                            class="w-full pl-10 pr-10 py-3 border-[1.5px] border-gray-200 rounded-xl text-sm text-gray-700 outline-none transition-colors bg-gray-50 focus:border-[#4f6ef7] focus:bg-white"
                        >
                        <button 
                            type="button" 
                            id="togglePassword" 
                            class="absolute right-3.5 text-gray-400 hover:text-gray-600 text-sm p-1 focus:outline-none"
                        >
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- Options --}}
                <div class="flex justify-between items-center mb-6 text-[13px]">
                    <label class="flex items-center gap-1.5 text-gray-500 cursor-pointer">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember"
                            class="accent-[#4f6ef7] w-4 h-4"
                        >
                        <span>Ingat saya pada perangkat ini</span>
                    </label>
                    <a href="#" class="text-[#4f6ef7] font-medium hover:underline">
                        Lupa Kata Sandi?
                    </a>
                </div>

                {{-- Submit Button --}}
                <button 
                    type="submit" 
                    class="w-full py-3.5 bg-[#4f6ef7] text-white rounded-xl font-semibold text-[15px] flex items-center justify-center gap-2 hover:bg-[#3b5de7] active:scale-[0.98] transition-all shadow-lg shadow-blue-500/30"
                >
                    Masuk <i class="fas fa-arrow-right text-sm"></i>
                </button>
            </form>

            {{-- Card Footer Info --}}
            <div class="mt-5 pt-4 border-t border-gray-100 text-[11px] text-gray-500 flex items-center justify-center gap-1.5">
                <span class="w-1.5 h-1.5 bg-green-500 rounded-full inline-block"></span>
                Shift Kerja Aktif: Terminal Kasir 02 • MalangVerse POS v2.4
            </div>

        </div>
    </main>

    {{-- Footer --}}
    <footer class="flex justify-between items-center px-8 py-3.5 bg-white border-t border-gray-200 text-[12px] text-gray-500 z-10">
        <span>© 2025 MalangVerse Digital Publisher</span>
        <span>Akses Terenkripsi 256-bit TLS</span>
        <span class="flex items-center gap-1.5">
            <i class="fas fa-headset"></i> 
            Bantuan Kasir & IT Support
        </span>
    </footer>

</body>
</html>