<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MalangVerse Admin - Terminal Admin Digital</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/login/admin/login.css', 'resources/js/admin/login.js'])
</head>

<body class="font-sans antialiased text-gray-900 min-h-screen flex items-center justify-center bg-[#f1f3fc] relative overflow-hidden px-4">

    {{-- ============ GLOW BACKGROUND ============ --}}
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute top-1/2 -translate-y-1/2 -left-40 w-[55%] h-[75%] bg-indigo-200/40 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -translate-y-1/2 -right-40 w-[55%] h-[75%] bg-blue-200/40 rounded-full blur-3xl"></div>
    </div>

    {{-- ============ LOGIN CARD ============ --}}
    <main class="relative z-10 w-full max-w-[360px]">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-10">

            {{-- Error --}}
            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-xs flex items-start gap-2">
                    <i class="fas fa-exclamation-circle mt-0.5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- Logo MV --}}
            <div class="w-12 h-12 mx-auto mb-5 rounded-xl bg-slate-900 shadow-md flex items-center justify-center">
                <span class="text-lg font-extrabold tracking-tight">
                    <span class="text-white">M</span><span class="text-blue-500">V</span>
                </span>
            </div>

            {{-- Judul --}}
            <h1 class="text-xl font-bold text-gray-900 text-center">MalangVerse Admin</h1>
            <p class="text-xs text-gray-500 text-center mt-1.5 mb-7 leading-relaxed">
                Silakan masuk sebagai<br>administrator terdaftar.
            </p>

            {{-- Form --}}
            <form action="{{ route('admin.login.attempt') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Nama Pengguna / Email --}}
                <div>
                    <label for="username" class="block text-xs font-semibold text-gray-800 mb-1.5">
                        Nama Pengguna atau Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="username" id="username"
                               value="{{ old('username') }}" required autofocus
                               placeholder="admin@malangverse.com"
                               class="w-full pl-9 pr-4 py-2.5 bg-gray-100 border border-transparent
                                      rounded-lg text-xs text-gray-800
                                      placeholder:text-gray-400
                                      focus:outline-none focus:bg-white focus:border-blue-500
                                      focus:ring-4 focus:ring-blue-500/10 transition-all">
                    </div>
                </div>

                {{-- Kata Sandi --}}
                <div>
                    <label for="password" class="block text-xs font-semibold text-gray-800 mb-1.5">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" required
                               placeholder="••••••••••••"
                               class="w-full pl-9 pr-10 py-2.5 bg-gray-100 border border-transparent
                                      rounded-lg text-xs text-gray-800
                                      placeholder:text-gray-400
                                      focus:outline-none focus:bg-white focus:border-blue-500
                                      focus:ring-4 focus:ring-blue-500/10 transition-all">
                        <button type="button" onclick="togglePassword()"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400
                                       hover:text-blue-600 transition-colors text-xs"
                                aria-label="Tampilkan kata sandi">
                            <i id="eyeIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- Tombol --}}
                <button type="submit"
                        class="w-full mt-2 py-2.5 rounded-lg bg-[#3155f5] hover:bg-[#2446e0]
                               text-white text-xs font-semibold
                               shadow-md shadow-blue-600/20
                               transition-colors flex items-center justify-center gap-2">
                    Masuk
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </button>
            </form>
        </div>
    </main>

    {{-- ============ SCRIPT ============ --}}
    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const eye = document.getElementById('eyeIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eye.classList.remove('fa-eye');
                eye.classList.add('fa-eye-slash');
            } else {
                pwd.type = 'password';
                eye.classList.remove('fa-eye-slash');
                eye.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>