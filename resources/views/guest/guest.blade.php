<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="translate-url" content="{{ route('translate') }}">
    <title>{{ $title }} - MalangVerse</title>

    {{-- Font Awesome 6 CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- Material Symbols --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    @vite(['resources/css/guest.css', 'resources/js/guest.js'])
</head>
<body class="min-h-screen flex flex-col bg-slate-50">
    <x-guest.navbar />

    <main class="flex-1">

        {{-- Hero --}}
        <section class="hero">
            <div class="hero-content">
                <span class="hero-badge">
                    <span class="material-symbols-outlined" style="color: #FAD8C3; font-size: 20px;">auto_awesome</span>
                    Preservasi Dialek Malangan &amp; Kiwalan Asli
                </span>
                <h1 class="hero-title">Penerjemah Boso Walikan Malang</h1>
                <p class="hero-subtitle">Jelajahi dan ubah kosakata Kiwalan khas Arema ke Bahasa Indonesia secara<br>instan, akurat, dan interaktif langsung dari peramban desktop Anda.</p>
            </div>

            {{-- Lengkungan background biru halus sesuai Figma --}}
            <div class="hero-wave" aria-hidden="true">
                <svg viewBox="0 0 1440 90" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M0,35 C320,65 540,25 840,48 C1140,70 1320,75 1440,60 L1440,90 L0,90 Z" fill="#f8fafc"/>
                </svg>
            </div>
        </section>

        @php
            $kataPopuler = [
                ['walikan' => 'Sam', 'indonesia' => 'Mas'],
                ['walikan' => 'Ayas', 'indonesia' => 'Saya'],
                ['walikan' => 'Umah', 'indonesia' => 'Rumah'],
                ['walikan' => 'Nawak', 'indonesia' => 'Kawan'],
                ['walikan' => 'Mboie', 'indonesia' => 'Keren'],
                ['walikan' => 'Ladub', 'indonesia' => 'Berangkat'],
                ['walikan' => 'Keram', 'indonesia' => 'Selesai'],
                ['walikan' => 'Oker', 'indonesia' => 'Pura-pura'],
                ['walikan' => 'Ngalam', 'indonesia' => 'Malang'],
                ['walikan' => 'Osob', 'indonesia' => 'Boso/Bahasa'],
            ];

            $edukasi = [
                [
                    'badge'  => '1949: Sandi Taktis Pejuang',
                    'judul'  => 'Kode Rahasia Gerilya',
                    'isi'    => 'Diciptakan oleh tentara TRIP (Tentara<br>Republik Indonesia Pelajar) untuk<br>mengelabui mata-mata Belanda yang<br>paham bahasa Jawa dan Melayu.<br>Informasi rahasia dienkripsi secara lisan<br>dengan membalik fonem kata.',
                    'footer' => 'Contoh Kunci: <strong>Londo → Odnol</strong>',
                    'icon_html' => '<div style="width: 48px; height: 48px; border-radius: 9999px; background-color: #2E5BFF; display: inline-flex; align-items: center; justify-content: center;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>',
                ],
                [
                    'badge'  => 'Fonetik & Morfologi',
                    'judul'  => 'Aturan Pembalikan Kata',
                    'isi'    => 'Tidak semua kata dibalik secara harfiah<br>huruf per huruf. Pola pembalikan<br>mengikuti pelafalan fonetis bahasa Jawa<br>Malangan yang luwes agar tetap nyaman<br>diucapkan dalam percakapan ritmik Arek.',
                    'footer' => 'Contoh Fonetis: <strong>Kera (Arek) &amp; Sam (Mas)</strong>',
                    'icon_html' => '<div style="width: 48px; height: 48px; border-radius: 9999px; background-color: #E2E8FC; display: inline-flex; align-items: center; justify-content: center;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#1341D1" xmlns="http://www.w3.org/2000/svg">
                            <!-- Bodi HP + Tombol Samping Kanan -->
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8 2.5C6.89543 2.5 6 3.39543 6 4.5V19.5C6 20.6046 6.89543 21.5 8 21.5H15C16.1046 21.5 17 20.6046 17 19.5V10.5H17.4C17.9523 10.5 18.4 10.0523 18.4 9.5V7.5C18.4 6.94772 17.9523 6.5 17.4 6.5H17V4.5C17 3.39543 16.1046 2.5 15 2.5H8ZM7.6 4.5H15.4V19.5H7.6V4.5Z" />
                            <!-- Roda Gigi Pengaturan Sedang & Proporsional Sesuai Contoh -->
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.85 9.23H12.15L12.33 10.06C12.54 10.13 12.75 10.24 12.93 10.38L13.72 10.06L14.37 11.17L13.75 11.76C13.78 11.92 13.78 12.08 13.75 12.24L14.37 12.83L13.72 13.94L12.93 13.62C12.75 13.76 12.54 13.87 12.33 13.94L12.15 14.77H10.85L10.67 13.94C10.46 13.87 10.25 13.76 10.07 13.62L9.28 13.94L8.63 12.83L9.25 12.24C9.22 12.08 9.22 11.92 9.25 11.76L8.63 11.17L9.28 10.06L10.07 10.38C10.25 10.24 10.46 10.13 10.67 10.06L10.85 9.23ZM11.5 13.01C12.08 13.01 12.54 12.54 12.54 12C12.54 11.42 12.08 10.96 11.5 10.96C10.92 10.96 10.46 11.42 10.46 12C10.46 12.54 10.92 13.01 11.5 13.01Z" />
                        </svg>
                    </div>',
                ],
                [
                    'badge'  => 'Identitas Kultural',
                    'judul'  => 'Simbol Solidaritas Arema',
                    'isi'    => 'Kini, Kiwalan bertransformasi menjadi<br>perekat identitas sosial pemuda Malang<br>raya. Menjadi lambang keakraban<br>egaliter, egaliteritas tanpa membedakan<br>kasta usia maupun strata sosial.',
                    'footer' => 'Status: <strong>Warisan Budaya Takbenda</strong>',
                    'icon_html' => '<div style="width: 48px; height: 48px; border-radius: 9999px; background-color: #E2E8FC; display: inline-flex; align-items: center; justify-content: center;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#1341D1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 12.75c1.63 0 3.07.39 4.24.9 1.08.48 1.76 1.56 1.76 2.73V18H6v-1.61c0-1.18.68-2.26 1.76-2.73 1.17-.52 2.61-.91 4.24-.91zM4 13c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm1.13 1.1c-.37-.06-.74-.1-1.13-.1-.99 0-1.93.21-2.78.58C.48 14.9 0 15.62 0 16.43V18h4.5v-1.61c0-.83.23-1.61.63-2.29zM20 13c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm4 3.43c0-.81-.48-1.53-1.22-1.85-.85-.37-1.79-.58-2.78-.58-.39 0-.76.04-1.13.1.4.68.63 1.46.63 2.29V18H24v-1.57zM12 6c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 2c-.55 0-1 .45-1 1s.45 1 1 1 1-.45 1-1-.45-1-1-1zm0 6.75c-1.08 0-2.16.25-3.04.64-.46.2-.76.64-.76 1.11h7.6c0-.47-.3-.91-.76-1.11-.88-.39-1.96-.64-3.04-.64z"/>
                        </svg>
                    </div>',
                ],
            ];
        @endphp

        {{-- Penerjemah --}}
        <section class="relative z-10 -mt-24 px-4">
            <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl border border-slate-100 p-4 md:p-6">

                {{-- Quota Badge (Guest Token) --}}
                <div id="quota-badge" class="hidden flex items-center justify-between mb-3 px-1">
                    <div class="flex items-center gap-3 flex-1">
                        <div class="flex items-center gap-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="#2F54EB" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                            </svg>
                            <span id="quota-text" class="text-xs font-semibold text-slate-700">Sisa Token: – / 10</span>
                        </div>
                        <div class="flex-1 max-w-[160px] h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div id="quota-bar" class="h-full bg-blue-500 rounded-full transition-all duration-500" style="width: 100%"></div>
                        </div>
                    </div>
                    <span id="credit-estimate" class="hidden text-[11px] text-blue-600 font-medium"></span>
                </div>
                <div class="relative grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-3.5 items-stretch">

                    {{-- Input --}}
                    <div id="card-sumber" class="translate-box is-active rounded-2xl border p-4 md:p-5 flex flex-col cursor-text min-h-[220px]">
                        <span class="lang-badge inline-flex w-fit items-center gap-1.5 text-xs font-semibold text-blue-600 bg-white border border-slate-200/80 px-3 py-1 rounded-full mb-3 shadow-xs">
                            <span class="w-2 h-2 rounded-full bg-blue-600 inline-block"></span>
                            <span id="source-language-label">Boso Walikan</span>
                        </span>

                        <textarea
                            id="sumber-teks"
                            rows="5"
                            maxlength="500"
                            class="flex-1 w-full resize-none outline-none text-slate-800 placeholder-slate-400 bg-transparent text-sm leading-relaxed"
                            placeholder="Oyi Sam! Ayas kera ngalam sejati, ladub kerjo nak Ijen numpak honda."
                        ></textarea>

                        <div class="flex items-center justify-between text-xs text-slate-400 mt-2 pt-2 border-t border-slate-200/60">
                            <div style="display: inline-flex; align-items: center; gap: 6px; background-color: #E5E9FD; color: #1E40AF; padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 500;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.5 5.6L10 7 8.6 4.5 10 2 7.5 3.4 5 2l1.4 2.5L5 7zm12 9.8L17 14l1.4 2.5L17 19l2.5-1.4L22 19l-1.4-2.5L22 14zM22 2l-2.5 1.4L17 2l1.4 2.5L17 7l2.5-1.4L22 7l-1.4-2.5zm-7.63 5.29a.996.996 0 0 0-1.41 0L1.29 18.96a.996.996 0 0 0 0 1.41l2.34 2.34c.39.39 1.02.39 1.41 0L16.7 11.05a.996.996 0 0 0 0-1.41l-2.33-2.35zm-1.03 5.49l-2.12-2.12 2.44-2.44 2.12 2.12-2.44 2.44z"/>
                                </svg>
                                <span>Terdeteksi Otomatis</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol tukar (di tengah perbatasan kedua card) --}}
                    <div class="md:absolute md:left-1/2 md:top-1/2 md:-translate-x-1/2 md:-translate-y-1/2 z-20 flex items-center justify-center -my-2 md:my-0 pointer-events-none">
                        <button
                            type="button"
                            id="btn-tukar"
                            class="pointer-events-auto w-10 h-10 rounded-full bg-[#2F54EB] text-white shadow-md hover:bg-blue-700 hover:scale-105 active:scale-95 flex items-center justify-center transition-all border-4 border-white cursor-pointer"
                            aria-label="Tukar bahasa"
                        >
                            <i class="fa-solid fa-right-left text-xs"></i>
                        </button>
                    </div>

                    {{-- Output --}}
                    <div id="card-hasil" class="translate-box rounded-2xl border p-4 md:p-5 flex flex-col cursor-text min-h-[220px]">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs font-semibold text-slate-700">
                                <span id="target-language-label">Bahasa Indonesia</span>
                            </span>
                            <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                                Hasil Terjemahan Presisi
                            </span>
                        </div>

                        <textarea
                            id="hasil-teks"
                            rows="5"
                            readonly
                            class="flex-1 w-full resize-none outline-none text-slate-800 placeholder-slate-400 bg-transparent text-sm leading-relaxed"
                            placeholder="Iya Mas! Saya anak Malang asli, berangkat kerja ke Ijen naik sepeda motor."
                        ></textarea>

                        <div class="flex items-center justify-between text-xs text-slate-400 mt-2 pt-2 border-t border-slate-200/60">
                            <button type="button" id="btn-salin" style="display: inline-flex; align-items: center; gap: 6px; background-color: #ECEFFC; color: #0F172A; border: none; padding: 5px 14px; border-radius: 9999px; font-size: 12px; font-weight: 500; cursor: pointer;" class="hover:bg-[#e0e5f8] transition-colors">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="#1D4ED8" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
                                </svg>
                                <span>Salin</span>
                            </button>
                            <span id="status-terjemah"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 px-4">
            <div class="max-w-5xl mx-auto space-y-16">

                {{-- Kata Populer --}}
                <div>
                    <div class="mb-6">
                        <p class="text-[11px] font-bold tracking-[0.15em] text-blue-600 uppercase">
                            Referensi Instan
                        </p>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-1">
                            Kosakata Populer Arema
                        </h2>
                    </div>

                    <div class="flex flex-wrap gap-2.5">
                        @foreach ($kataPopuler as $pair)
                            <button
                                type="button"
                                class="btn-kata group inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full border border-slate-200 bg-white text-sm hover:border-blue-400 hover:bg-blue-50 transition-colors"
                                data-kata="{{ $pair['walikan'] }}"
                            >
                                <span class="font-semibold text-slate-800">{{ $pair['walikan'] }}</span>
                                <span class="text-slate-400">·</span>
                                <span class="text-slate-500">{{ $pair['indonesia'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Edukasi --}}
                <div>
                    <div class="text-center mb-8">
                        <p class="text-[11px] font-bold tracking-[0.15em] text-blue-600 uppercase">
                            Warisan Budaya
                        </p>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-1">
                            Edukasi &amp; Trivia Sejarah Osob Kiwalan
                        </h2>
                        <p class="text-sm text-slate-500 mt-2 max-w-xl mx-auto">
                            Mengapa Boso Walikan dibalik? Pelajari latar belakang taktik perjuangan kemerdekaan.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        @foreach ($edukasi as $item)
                            <article class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col hover:shadow-md transition">
                                <div class="mb-4">
                                    {!! $item['icon_html'] !!}
                                </div>

                                <span class="text-[11px] font-semibold text-blue-600 mb-3">{{ $item['badge'] }}</span>

                                <h3 class="text-base font-bold text-slate-900">{{ $item['judul'] }}</h3>
                                <p class="text-sm text-slate-600 mt-2 leading-relaxed flex-1">{!! $item['isi'] !!}</p>
                                <p class="text-xs text-slate-500 mt-4 pt-4 border-t border-slate-100">{!! $item['footer'] !!}</p>
                            </article>
                        @endforeach
                    </div>
                </div>

                {{-- CTA member --}}
                <div class="relative overflow-hidden rounded-3xl border border-[#D0D7F7] bg-gradient-to-br from-[#EEF2FF] to-[#F8FAFF] p-8 md:p-12">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div class="max-w-md">
                            <div style="display: inline-flex; align-items: center; gap: 6px; background-color: #E0E7FF; color: #1341D1; padding: 6px 14px; border-radius: 9999px; font-family: sans-serif; font-size: 14px; font-weight: 600;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm4.24 16L12 15.45 7.77 18l1.12-4.81-3.73-3.23 4.92-.42L12 5l1.92 4.53 4.92.42-3.73 3.23L16.23 18z"/>
                                </svg>
                                <span>Akses Eklusif Komunitas Arek</span>
                            </div>
                            <h3 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-4 leading-tight">
                                Daftar Member untuk<br>Akses Kamus Lengkap
                            </h3>
                            <p class="text-sm md:text-base text-slate-600 mt-3 leading-relaxed">
                                Nikmati akses tanpa batas kosakata kiwalan,<br>
                                tanpa batas kuota harian, dan baca koleksi E-Book Kamus.
                            </p>
                        </div>

                        <div class="shrink-0">
                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center justify-center px-7 py-3.5 rounded-full bg-[#2F54EB] text-white text-sm font-semibold hover:bg-blue-700 transition-colors shadow-md"
                            >
                                Daftar Sekarang (Gratis)
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <x-guest.beranda-footer />

    {{-- Modal: Token Habis → Ajakan Login/Register --}}
    <div id="login-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md mx-4 text-center relative">
            <button id="close-login-modal" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 transition-colors">
                <i class="fas fa-times text-sm"></i>
            </button>

            <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mx-auto mb-4">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="#2F54EB" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                </svg>
            </div>

            <h3 class="text-xl font-bold text-slate-900 mb-2">Token Gratis Habis!</h3>
            <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                Kamu sudah menggunakan 10 token terjemahan gratis.<br>
                Daftar sekarang untuk mendapatkan <strong class="text-blue-600">100 credit harian</strong> dan fitur premium lainnya!
            </p>

            <div class="flex flex-col gap-3">
                <a href="{{ route('register') }}" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-full bg-[#2F54EB] text-white text-sm font-semibold hover:bg-blue-700 transition-colors shadow-md">
                    Daftar Member (Gratis) →
                </a>
                <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-full border border-slate-200 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Sudah Punya Akun? Masuk
                </a>
            </div>
        </div>
    </div>

</body>
</html>
