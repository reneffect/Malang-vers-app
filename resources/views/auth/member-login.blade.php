<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun | MalangVerse</title>
    @vite(['resources/css/login/login.css', 'resources/js/login/login.js'])
</head>
<body class="font-sans antialiased bg-white text-slate-800">

<div class="grid min-h-screen lg:grid-cols-[1.1fr_1fr]">

    {{-- ============ PANEL KIRI ============ --}}
    <section class="relative hidden overflow-hidden bg-gradient-to-br from-[#1242d4] via-[#1d50e8] to-[#143bc4] text-white lg:flex lg:flex-col lg:justify-between p-10 xl:p-14">
        {{-- Dekorasi Lengkungan Sesuai Figma --}}
        <div class="pointer-events-none absolute -right-36 -top-36 h-[520px] w-[520px] rounded-full border border-white/10 bg-white/5"></div>
        <div class="pointer-events-none absolute -right-16 -top-16 h-[360px] w-[360px] rounded-full border border-white/10 bg-white/5"></div>
        <div class="pointer-events-none absolute -bottom-32 -left-20 h-96 w-96 rounded-full bg-blue-400/20 blur-3xl"></div>

        {{-- Brand / Logo --}}
        <div class="relative flex items-center">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-white text-[#1341D1] font-extrabold text-base shadow-sm">
                    M
                </div>
                <span class="text-xl font-bold tracking-tight text-white">MalangVerse</span>
            </div>
        </div>

        {{-- Konten Utama Kiri --}}
        <div class="relative max-w-lg my-auto py-10">
            <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3.5 py-1.5 text-xs font-medium text-white backdrop-blur-xs">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12.87 15.07l-2.54-2.51.03-.03c1.74-1.94 2.98-4.17 3.71-6.53H17V4h-7V2H8v2H1v1.99h11.17C11.5 7.92 10.44 9.75 9 11.35 8.07 10.32 7.3 9.19 6.69 8h-2c.73 1.63 1.73 3.17 2.98 4.56l-5.09 5.02L4 19l5-5 3.11 3.11.76-2.04zM18.5 10h-2L12 22h2l1.12-3h4.75L21 22h2l-4.5-12zm-2.62 7l1.62-4.33L19.12 17h-3.24z"/>
                </svg>
                Preservasi Bahasa Kiwalan &amp; Budaya Arema
            </span>

            <h1 class="mt-6 text-4xl xl:text-5xl font-extrabold leading-tight tracking-tight text-white">
                Osob Kiwalan,<br>
                Jiwane Arema.
            </h1>

            <p class="mt-5 text-sm md:text-base leading-relaxed text-blue-100/90 max-w-md">
                Jembatan modern linguistik yang menghubungkan<br class="hidden sm:inline">
                kebanggaan dialek Malangan ke pentas global. Bergabunglah<br class="hidden sm:inline">
                bersama komunitas penjaga identitas kultural Arek Malang.
            </p>

            {{-- Quote Box --}}
            <div class="mt-8 rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur-sm max-w-md">
                <div class="flex items-start gap-3.5">
                    <span class="text-2xl font-serif text-white/80 font-bold leading-none select-none">99</span>
                    <div>
                        <p class="text-sm italic leading-relaxed text-white">
                            "Oyi sam, ayas kera ngalam asli! Lek gak kene sing nguri-<br class="hidden sm:inline">
                            uri basane dewe, sopo maneh sing bakal bangga?"
                        </p>
                        <p class="mt-3 text-xs text-blue-200">
                            <span class="font-bold text-white">Abah Munir (64 th)</span> • Sesepuh Komunitas Osob Kayutangan
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Kiri --}}
        <div class="relative text-xs text-blue-200/80">
            <span>Malang, Jawa Timur — Indonesia</span>
        </div>
    </section>

    {{-- ============ PANEL KANAN ============ --}}
    <section class="flex flex-col px-6 py-8 sm:px-12 lg:px-16 justify-between min-h-screen">
        {{-- Kembali ke Beranda --}}
        <div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs md:text-sm font-medium text-slate-700 hover:text-blue-600 transition-colors">
                <span>&larr;</span> Kembali ke Beranda Guest
            </a>
        </div>

        {{-- Konten Form --}}
        <div class="mx-auto flex w-full max-w-md flex-col justify-center py-8 my-auto">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Sugeng Rawuh Sam!</h2>
            <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                Akses kamus lengkap, kontribusi frasa anyar, dan simpan<br class="hidden sm:inline">
                catatan osob kiwalan panjenengan.
            </p>

            {{-- Tab Masuk / Daftar --}}
            <div class="mt-7 flex rounded-full bg-[#EEF2FC] p-1">
                <button type="button" class="flex-1 rounded-full bg-white py-2.5 text-center text-xs md:text-sm font-bold text-[#1341D1] shadow-xs transition">
                    Masuk Akun
                </button>
                <a href="{{ route('register') }}" class="flex-1 rounded-full py-2.5 text-center text-xs md:text-sm font-semibold text-slate-600 hover:text-slate-900 transition flex items-center justify-center">
                    Daftar Member Baru
                </a>
            </div>

            {{-- Tombol Google --}}
            <button type="button" id="btn-google" class="mt-5 flex w-full items-center justify-center gap-3 rounded-full border border-slate-200 bg-white py-3 px-4 text-xs md:text-sm font-semibold text-slate-700 shadow-xs hover:bg-slate-50 transition cursor-pointer">
                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.5-.2-2.2H12v4.2h6.5c-.3 1.5-1.1 2.8-2.4 3.7v3h3.9c2.3-2.1 3.5-5.2 3.5-8.7z"/>
                    <path fill="#34A853" d="M12 24c3.2 0 6-1.1 7.9-2.9l-3.9-3c-1.1.7-2.5 1.2-4 1.2-3.1 0-5.7-2.1-6.6-4.9H1.4v3.1C3.3 21.3 7.4 24 12 24z"/>
                    <path fill="#FBBC05" d="M5.4 14.4c-.2-.7-.4-1.5-.4-2.4s.1-1.6.4-2.4V6.5H1.4C.5 8.3 0 10.1 0 12s.5 3.7 1.4 5.5l4-3.1z"/>
                    <path fill="#EA4335" d="M12 4.8c1.7 0 3.3.6 4.5 1.8l3.4-3.4C17.9 1.2 15.2 0 12 0 7.4 0 3.3 2.7 1.4 6.5l4 3.1C6.3 6.9 8.9 4.8 12 4.8z"/>
                </svg>
                Masuk dengan Google
            </button>

            {{-- Divider --}}
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <div class="relative flex justify-center">
                    <span class="bg-white px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">ATAU DAFTAR DENGAN EMAIL</span>
                </div>
            </div>

            {{-- Form Login --}}
            <form id="login-form" action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                @if ($errors->any())
                    <div class="rounded-xl bg-red-50 p-3 text-xs text-red-600 border border-red-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Email --}}
                <div>
                    <label for="email" class="text-xs font-bold text-slate-800">Alamat Email</label>
                    <div class="mt-1.5 flex items-center gap-3 rounded-full border border-slate-300 bg-[#F4F6FD] px-5 py-3 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-2 focus-within:ring-blue-100 transition-all">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="text-slate-500 shrink-0">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}" placeholder="sam_kera@ngalam.id"
                               class="w-full bg-transparent text-sm text-slate-800 outline-none placeholder:text-slate-400">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="text-xs font-bold text-slate-800">Kata Sandi</label>
                    <div class="mt-1.5 flex items-center gap-3 rounded-full border border-slate-300 bg-[#F4F6FD] px-5 py-3 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-2 focus-within:ring-blue-100 transition-all">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#3F4451" class="shrink-0" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/>
                        </svg>
                        <input id="password" name="password" type="password" required minlength="8" placeholder="Minimal 8 karakter"
                               class="w-full bg-transparent text-sm text-slate-800 outline-none placeholder:text-slate-400">
                        <button type="button" id="toggle-password" class="text-slate-400 hover:text-slate-600 cursor-pointer focus:outline-none" aria-label="Tampilkan kata sandi">
                            <svg id="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember Me (Circular Checkbox sesuai Figma) --}}
                <div class="pt-1">
                    <label class="inline-flex items-center gap-2.5 text-xs md:text-sm text-slate-600 cursor-pointer select-none">
                        <span class="relative flex items-center justify-center">
                            <input type="checkbox" name="remember" id="remember" class="peer appearance-none h-4 w-4 rounded-full border border-slate-300 bg-white checked:border-[#2F54EB] checked:bg-[#2F54EB] cursor-pointer transition-colors focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <svg class="pointer-events-none absolute hidden h-2.5 w-2.5 text-white peer-checked:block" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="2.5 6 5 8.5 9.5 3.5"></polyline>
                            </svg>
                        </span>
                        <span>Ingat Sesi Saya</span>
                    </label>
                </div>

                {{-- Tombol Submit --}}
                <button type="submit"
                        class="w-full rounded-full bg-[#2F54EB] hover:bg-blue-700 py-3.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition-all cursor-pointer">
                    Masuk ke MalangVerse &rarr;
                </button>
            </form>

            {{-- Link Register --}}
            <p class="mt-6 text-center text-xs md:text-sm text-slate-600">
                Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-[#1341D1] hover:underline">Daftar sekarang</a>
            </p>
        </div>

        {{-- Spacer Bawah --}}
        <div class="h-4"></div>
    </section>
</div>

<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/13.4.0/firebase-app.js";
  import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/13.4.0/firebase-auth.js";

  const firebaseConfig = {
    apiKey: "AIzaSyC9Zy6YlmDDKNQdVwaO6BSKHK0hirReljs",
    authDomain: "malangverse-23c24.firebaseapp.com",
    projectId: "malangverse-23c24",
    storageBucket: "malangverse-23c24.firebasestorage.app",
    messagingSenderId: "143245307614",
    appId: "1:143245307614:web:679d4c4dc254d87f8e5c4f",
    measurementId: "G-LYJJYRFPVQ"
  };

  const app = initializeApp(firebaseConfig);
  const auth = getAuth(app);
  const provider = new GoogleAuthProvider();

  const btnGoogle = document.getElementById('btn-google');
  if (btnGoogle) {
    btnGoogle.addEventListener('click', async () => {
      try {
        const result = await signInWithPopup(auth, provider);
        const user = result.user;

        const response = await fetch("{{ route('firebase.callback') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
          body: JSON.stringify({
            name: user.displayName,
            email: user.email,
            google_id: user.uid
          })
        });

        const data = await response.json();
        if (response.ok && data.redirect) {
          window.location.href = data.redirect;
        } else {
          alert("Gagal memproses sesi login di server.");
        }
      } catch (error) {
        console.error("Firebase Auth Error:", error);
        if (error.code !== 'auth/popup-closed-by-user') {
          alert("Gagal masuk dengan Google: " + error.message);
        }
      }
    });
  }
</script>

</body>
</html>
