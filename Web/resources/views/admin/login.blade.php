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

<body class="font-sans antialiased text-gray-900 flex min-h-screen items-center justify-center bg-[#f2f3ff] px-0 py-2">

    <main class="flex min-h-[min(682px,calc(100svh-24px))] w-[93vw] max-w-[1240px] items-center justify-center bg-[#e9ebff] px-4 py-4">
        <div class="w-full max-w-[min(504px,calc(100vw-48px))] border border-gray-100 bg-white px-10 py-14 shadow-[0_12px_30px_rgba(30,41,59,0.14)]">

            {{-- Error --}}
            @if ($errors->any())
                <div class="mb-8 flex items-start gap-4 border border-red-200 bg-red-50 px-6 py-4 text-[20px] text-red-700">
                    <i class="fas fa-exclamation-circle mt-1"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- Logo MV --}}
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-xl bg-[#252b43] shadow-sm">
                <span class="text-[26px] font-extrabold leading-none tracking-tight">
                    <span class="text-white">M</span><span class="text-blue-500">V</span>
                </span>
            </div>

            {{-- Judul --}}
            <h1 class="text-center text-[32px] font-bold text-gray-900">MalangVerse Admin</h1>
            <p class="mt-2 mb-6 text-center text-[16px] leading-tight text-gray-500">
                Silakan masuk sebagai<br>administrator terdaftar.
            </p>

            {{-- Form --}}
            <form action="{{ route('admin.login.attempt') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Nama Pengguna / Email --}}
                <div>
                    <label for="username" class="mb-2 block text-[16px] font-semibold text-gray-800">
                        Nama Pengguna atau Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[16px] text-gray-400">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="username" id="username"
                               value="{{ old('username') }}" required autofocus
                               placeholder="admin@malangverse.com"
                               class="w-full border border-transparent bg-[#f1f2ff] py-3 pl-12 pr-6 text-[14px] text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/10 sm:text-[18px]">
                    </div>
                </div>

                {{-- Kata Sandi --}}
                <div>
                    <label for="password" class="mb-2 block text-[16px] font-semibold text-gray-800">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[16px] text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" required
                               placeholder="••••••••••••"
                               class="w-full border border-transparent bg-[#f1f2ff] py-3 pl-12 pr-12 text-[14px] text-gray-800 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/10 sm:text-[18px]">
                        <button type="button" id="togglePassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 p-2 text-[16px] text-gray-400 transition-colors hover:text-blue-600"
                                aria-label="Tampilkan atau sembunyikan kata sandi">
                            <i id="eyeIcon" class="fas fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                {{-- Tombol --}}
                <button type="submit"
                        class="flex w-full items-center justify-center gap-3 rounded-full bg-[#405cff] py-3 text-[18px] font-semibold text-white shadow-md shadow-blue-500/25 transition-colors hover:bg-[#304be8]">
                    Masuk
                    <i class="fas fa-arrow-right text-[16px]" aria-hidden="true"></i>
                </button>
            </form>
        </div>
    </main>

</body>
</html>