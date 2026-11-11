<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | MalangVerse</title>
    @vite(['resources/css/login/login.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-slate-800">

<div class="grid min-h-screen lg:grid-cols-2">

    {{-- ============ PANEL KIRI ============ --}}
    <section class="relative hidden overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-600 text-white lg:flex lg:flex-col lg:justify-between lg:p-12">
        {{-- Dekorasi --}}
        <div class="pointer-events-none absolute -right-24 -top-24 h-96 w-96 rounded-full bg-white/10 blur-2xl"></div>
        <div class="pointer-events-none absolute -bottom-32 -left-20 h-96 w-96 rounded-full bg-indigo-400/20 blur-3xl"></div>

        <div class="relative flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-blue-700 font-bold">M</div>
                <span class="text-xl font-semibold">MalangVerse</span>
            </div>
            <span class="flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                Arena Digital Gateway
            </span>
        </div>

        <div class="relative max-w-lg">
            <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs">
                Preservasi Bahasa Kiwalan &amp; Budaya Arema
            </span>

            <h1 class="mt-6 text-5xl font-bold leading-tight">
                Osob Kiwalan,<br>
                <span class="text-blue-200">Jiwane Arema.</span>
            </h1>

            <p class="mt-5 text-base leading-relaxed text-blue-100">
                Jembatan modern linguistik yang menghubungkan kebanggaan dialek Malang ke pentas global.
                Bergabunglah bersama komunitas penjaga identitas kultural Arek Malang.
            </p>

            <blockquote class="mt-8 rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur">
                <p class="text-sm italic leading-relaxed">
                    "Oyi sam, ayas kera ngalam asli! Lek gak kene sing nguri-uri basane dewe, sopo maneh sing bakal bangga?"
                </p>
                <footer class="mt-3 text-xs text-blue-200">
                    <span class="font-semibold text-white">Abah Munir (64 th)</span> • Sesepuh Komunitas Osob Kiwalan
                </footer>
            </blockquote>

            <div class="mt-8 grid grid-cols-2 gap-4">
                <div class="rounded-2xl border border-white/20 bg-white/10 p-5">
                    <p class="text-3xl font-bold">6.000+</p>
                    <p class="mt-1 text-xs text-blue-100">Member Aktif se-Nusantara</p>
                </div>
                <div class="rounded-2xl border border-white/20 bg-white/10 p-5">
                    <p class="text-3xl font-bold">480+</p>
                    <p class="mt-1 text-xs text-blue-100">Leksikon Walikan Terverifikasi</p>
                </div>
            </div>
        </div>

        <div class="relative flex items-center justify-between border-t border-white/20 pt-6 text-xs text-blue-100">
            <span>Malang, Jawa Timur — Indonesia</span>
            <span>Dikelola Bersama Budayawan Arema</span>
        </div>
    </section>

    {{-- ============ PANEL KANAN ============ --}}
    <section class="flex flex-col px-6 py-8 sm:px-12">
        <div class="flex items-center justify-between">
            <a href="{{ route('beranda') }}" class="flex items-center gap-2 text-sm text-slate-500 hover:text-blue-600">
                <span>&larr;</span> Kembali ke Beranda
            </a>
            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs text-blue-600">🔒 Enkripsi 256-Bit</span>
        </div>

        <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center py-10">
            <h2 class="text-3xl font-bold text-slate-900">Sugeng Rawuh Sam!</h2>
            <p class="mt-2 text-sm text-slate-500">
                Akses kamus lengkap, kontribusi frasa anyar, dan simpan catatan osob kiwalan penjenengan.
            </p>

            {{-- Tab --}}
            <div class="mt-8 grid grid-cols-2 gap-1 rounded-xl bg-slate-100 p-1">
                <button type="button" class="rounded-lg bg-white py-2.5 text-sm font-semibold text-blue-600 shadow-sm">
                    Masuk Akun
                </button>
                <a href="{{ route('register') }}" class="flex items-center justify-center rounded-lg py-2.5 text-sm font-medium text-slate-500 hover:text-slate-700">
                    Daftar Member Baru
                </a>
            </div>

            {{-- Google --}}
            <button type="button" class="mt-6 flex w-full items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white py-3 text-sm font-medium text-slate-700 hover:bg-slate-50">
                <svg class="h-5 w-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.5-.2-2.2H12v4.2h6.5c-.3 1.5-1.1 2.8-2.4 3.7v3h3.9c2.3-2.1 3.5-5.2 3.5-8.7z"/>
                    <path fill="#34A853" d="M12 24c3.2 0 6-1.1 7.9-2.9l-3.9-3c-1.1.7-2.5 1.2-4 1.2-3.1 0-5.7-2.1-6.6-4.9H1.4v3.1C3.3 21.3 7.4 24 12 24z"/>
                    <path fill="#FBBC05" d="M5.4 14.4c-.2-.7-.4-1.5-.4-2.4s.1-1.6.4-2.4V6.5H1.4C.5 8.3 0 10.1 0 12s.5 3.7 1.4 5.5l4-3.1z"/>
                    <path fill="#EA4335" d="M12 4.8c1.7 0 3.3.6 4.5 1.8l3.4-3.4C17.9 1.2 15.2 0 12 0 7.4 0 3.3 2.7 1.4 6.5l4 3.1C6.3 6.9 8.9 4.8 12 4.8z"/>
                </svg>
                Masuk dengan Google
            </button>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <div class="relative flex justify-center">
                    <span class="bg-white px-3 text-[10px] uppercase tracking-wider text-slate-400">atau dengan email</span>
                </div>
            </div>

            {{-- Form --}}
            <form action="#" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="text-xs font-semibold uppercase tracking-wide text-slate-600">Alamat Email</label>
                    <div class="mt-2 flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-2 focus-within:ring-blue-100">
                        <span class="text-slate-400">✉</span>
                        <input id="email" name="email" type="email" required placeholder="sam_kera@ngalam.id"
                               class="w-full bg-transparent text-sm outline-none placeholder:text-slate-400">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-xs font-semibold uppercase tracking-wide text-slate-600">Kata Sandi</label>
                        <a href="#" class="text-xs font-medium text-blue-600 hover:underline">Lupa Kata Sandi?</a>
                    </div>
                    <div class="mt-2 flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-2 focus-within:ring-blue-100">
                        <span class="text-slate-400">🔒</span>
                        <input id="password" name="password" type="password" required minlength="8" placeholder="Minimal 8 karakter"
                               class="w-full bg-transparent text-sm outline-none placeholder:text-slate-400">
                        <button type="button" onclick="togglePassword()" class="text-slate-400 hover:text-slate-600" aria-label="Tampilkan kata sandi">👁</button>
                    </div>
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    Ingat Sesi Saya
                </label>

                <button type="submit"
                        class="w-full rounded-xl bg-blue-600 py-3.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition hover:bg-blue-700">
                    Masuk ke MalangVerse &rarr;
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-500">
                Dereng gadhah akun?
                <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:underline">Daftar sekarang</a>
            </p>
        </div>

        <footer class="border-t border-slate-100 pt-6 text-center text-[11px] text-slate-400">
            Dengan melanjutkan, Anda menyetujui
            <a href="#" class="underline">Pedoman Komunitas</a> &amp;
            <a href="#" class="underline">Kebijakan Privasi</a> MalangVerse.
        </footer>
    </section>
</div>

</body>
</html>