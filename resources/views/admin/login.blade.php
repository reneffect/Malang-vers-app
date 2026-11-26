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

    @vite(['resources/css/login/admin/login.css', 'resources/js/login/admin/login.js'])
</head>

<body class="font-sans antialiased text-gray-900 min-h-screen flex items-center justify-center
             bg-gradient-to-br from-indigo-50 via-purple-50 to-blue-50 relative overflow-hidden px-4">

    {{-- ============ BLOK GRADIEN HALUS (sesuai foto) ============ --}}
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -top-24 -left-24 w-[420px] h-[420px] bg-indigo-200/50 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-[420px] h-[420px] bg-purple-200/40 rounded-full blur-3xl"></div>
    </div>

    {{-- ============ LOGIN CARD ============ --}}
    <main class="relative z-10 w-full max-w-sm">
        <div class="bg-white rounded-2xl shadow-xl shadow-indigo-500/10 border border-white p-8">

            {{-- Error --}}
            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-start gap-2">
                    <i class="fas fa-exclamation-circle mt-0.5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- Logo MV --}}
            <div class="w-14 h-14 mx-auto mb-5 rounded-2xl bg-white shadow-md shadow-indigo-500/15
                        border border-gray-100 flex items-center justify-center">
                <span class="text-2xl font-extrabold tracking-tight">
                    <span class="text-blue-600">M</span><span class="text-purple-600">V</span>
                </span>
            </div>

            {{-- Judul --}}
            <h1 class="text-xl font-extrabold text-gray-900 text-center">MalangVerse Admin</h1>
            <p class="text-sm text-gray-500 text-center mt-1.5 mb-7 leading-relaxed">
                Silakan masuk sebagai<br>administrator terdaftar.
            </p>

            {{-- Form --}}
            <form action="{{ route('admin.login.attempt') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Nama Pengguna / Email --}}
                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama Pengguna atau Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="username" id="username"
                               value="{{ old('username') }}" required autofocus
                               placeholder="admin@malangverse.com"
                               class="w-full pl-10 pr-4 py-2.5 bg-gray-100 border border-transparent
                                      rounded-lg text-sm text-gray-800
                                      placeholder:text-gray-400
                                      focus:outline-none focus:bg-white focus:border-blue-500
                                      focus:ring-4 focus:ring-blue-500/10 transition-all">
                    </div>
                </div>

                {{-- Kata Sandi --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" required
                               placeholder="••••••••••••"
                               class="w-full pl-10 pr-11 py-2.5 bg-gray-100 border border-transparent
                                      rounded-lg text-sm text-gray-800
                                      focus:outline-none focus:bg-white focus:border-blue-500
                                      focus:ring-4 focus:ring-blue-500/10 transition-all">
                        <button type="button" onclick="togglePassword()"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400
                                       hover:text-blue-600 transition-colors">
                            <i id="eyeIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- Tombol --}}
                <button type="submit"
                        class="w-full py-3 rounded-full bg-blue-600 hover:bg-blue-700
                               text-white text-sm font-semibold
                               shadow-lg shadow-blue-600/30
                               hover:-translate-y-0.5 active:translate-y-0
                               transition-all flex items-center justify-center gap-2">
                    Masuk ke Dasbor
                    <i class="fas fa-arrow-right text-xs"></i>
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