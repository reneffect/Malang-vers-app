<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="translate-url" content="{{ route('translate') }}">
    <title>Penerjemah Boso Walikan{{ $membership?->tier ? ' '.$membership->tier->name : '' }} - MulangVerse</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Material Symbols --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    @vite([
        'resources/css/guest.css',
        'resources/css/user/member/member-home.css',
        'resources/js/user/member/member-home.js',
    ])
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900">

    {{-- Panggil Component Navbar --}}
    <x-guest.navbar />

    {{-- ============ HERO SECTION MEMBER ============ --}}
    <section class="relative bg-gradient-to-b from-[#1447E6] via-[#1240D0] to-[#0E35B8] text-white pt-12 pb-24 md:pt-16 md:pb-28 px-4 overflow-hidden">
        {{-- Hero Wave Background di Bagian Bawah --}}
        <div class="hero-wave absolute bottom-0 left-0 right-0 pointer-events-none" aria-hidden="true">
            <svg viewBox="0 0 1440 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-10 md:h-14">
                <path d="M0,20 C320,50 540,10 840,30 C1140,50 1320,55 1440,40 L1440,70 L0,70 Z" fill="#f9fafb"/>
            </svg>
        </div>

        <div class="relative max-w-4xl mx-auto text-center z-10">
            {{-- Badge Unlimited Kuota Terjemahan / Tier Status --}}
            @if(isset($membership) && $membership->status === 'active' && $membership->tier)
                <div class="inline-flex items-center gap-2.5 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs text-white backdrop-blur-xs shadow-sm">
                    <span class="text-white text-xs"><i class="fas fa-crown text-amber-400"></i> {{ $membership->tier->name }}</span>
                    <span class="font-medium text-blue-50">Akses Tanpa Batas Kuota Terjemahan</span>
                    <span class="rounded-full bg-white px-2.5 py-0.5 text-[10px] font-extrabold text-[#1341D1] uppercase tracking-wider">
                        UNLIMITED
                    </span>
                </div>

                {{-- Title --}}
                <h1 class="mt-6 text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    Penerjemah Boso Walikan {{ $membership->tier->name }}
                </h1>
            @else
                <div class="inline-flex items-center gap-2.5 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs text-white backdrop-blur-xs shadow-sm">
                    <span class="text-white text-xs">⚡</span>
                    <span class="font-medium text-blue-50">Akses Kuota Terjemahan</span>
                    <span class="rounded-full bg-white px-2.5 py-0.5 text-[10px] font-extrabold text-[#1341D1] uppercase tracking-wider">
                        MEMBER
                    </span>
                </div>

                {{-- Title --}}
                <h1 class="mt-6 text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    Penerjemah Boso Walikan Member
                </h1>
            @endif

            {{-- Subtitle --}}
            <p class="mt-4 text-sm sm:text-base leading-relaxed text-blue-100/90 max-w-2xl mx-auto">
                Konversi dialek asli kera Ngalam secara cerdas dan seketika. Rasakan<br class="hidden sm:inline">
                perpaduan akurasi semantik bahasa Arema Malang dengan teknologi tata<br class="hidden sm:inline">
                bahasa teranyar.
            </p>
        </div>
    </section>

    {{-- ============ MAIN ============ --}}
    <main class="max-w-4xl mx-auto px-4 sm:px-6 -mt-16 md:-mt-20 relative z-20 pb-16">

        {{-- Penerjemah Sesuai Design --}}
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-4 md:p-6">

            {{-- Quota Badge (Member Credit) --}}
            <div id="quota-badge" class="flex items-center justify-between mb-3 px-1">
                <div class="flex items-center gap-3 flex-1">
                    <div class="flex items-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#2F54EB" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm4.24 16L12 15.45 7.77 18l1.12-4.81-3.73-3.23 4.92-.42L12 5l1.92 4.53 4.92.42-3.73 3.23L16.23 18z"/>
                        </svg>
                        <span id="quota-text" class="text-xs font-semibold text-slate-700">Credit: 100 / 100</span>
                    </div>
                    <div class="flex-1 max-w-[200px] h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div id="quota-bar" class="h-full bg-blue-500 rounded-full transition-all duration-500" style="width: 100%"></div>
                    </div>
                </div>
                <span id="credit-estimate" class="hidden text-[11px] text-blue-600 font-medium"></span>
            </div>
            <div class="relative grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-3.5 items-stretch">

                {{-- Input Sumber --}}
                <div id="card-sumber" class="translate-box is-active rounded-2xl border p-4 md:p-5 flex flex-col cursor-text min-h-[220px]">
                    <span class="lang-badge inline-flex w-fit items-center gap-1.5 text-xs font-semibold text-blue-600 bg-white border border-slate-200/80 px-3 py-1 rounded-full mb-3 shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-blue-600 inline-block"></span>
                        <span id="source-language-label">Boso Walikan</span>
                    </span>

                    <textarea
                        id="walikanText"
                        rows="5"
                        maxlength="1000"
                        class="flex-1 w-full resize-none outline-none text-slate-800 placeholder-slate-400 bg-transparent text-sm md:text-base leading-relaxed"
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
                        onclick="swapText()"
                        class="pointer-events-auto w-10 h-10 rounded-full bg-[#2F54EB] text-white shadow-md hover:bg-blue-700 hover:scale-105 active:scale-95 flex items-center justify-center transition-all border-4 border-white cursor-pointer"
                        aria-label="Tukar bahasa"
                    >
                        <i class="fa-solid fa-right-left text-xs"></i>
                    </button>
                </div>

                {{-- Output Hasil --}}
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
                        id="indoText"
                        rows="5"
                        readonly
                        class="flex-1 w-full resize-none outline-none text-slate-800 placeholder-slate-400 bg-transparent text-sm md:text-base leading-relaxed"
                        placeholder="Iya Mas! Saya anak Malang asli, berangkat kerja ke Ijen naik sepeda motor."
                    ></textarea>

                    <div class="flex items-center justify-between text-xs text-slate-400 mt-2 pt-2 border-t border-slate-200/60">
                        <button
                            type="button"
                            id="btn-salin"
                            onclick="copyText('indoText')"
                            style="display: inline-flex; align-items: center; gap: 6px; background-color: #ECEFFC; color: #0F172A; border: none; padding: 5px 14px; border-radius: 9999px; font-size: 12px; font-weight: 500; cursor: pointer;"
                            class="hover:bg-[#e0e5f8] transition-colors"
                        >
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="#1D4ED8" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
                            </svg>
                            <span>Salin</span>
                        </button>

                        <div class="flex items-center gap-2">
                            <div id="loadingIndicator" class="hidden items-center gap-1.5 text-blue-600 text-xs">
                                <div class="w-3.5 h-3.5 border-2 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                                <span>Menerjemahkan...</span>
                            </div>
                            <span id="translationStatus" class="text-xs text-slate-400"></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Info Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">

            {{-- Riwayat Terjemahan Terkini --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl/5 p-6 md:p-7">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-bold text-slate-900 flex items-center gap-2 text-base sm:text-lg">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        Riwayat Terjemahan Terkini
                    </h3>
                    <a href="#" class="text-xs sm:text-sm font-semibold text-blue-600 hover:underline">Lihat Semua (24)</a>
                </div>
                <div class="space-y-3">
                    @foreach ($recentTranslations as $item)
                        <x-history-item
                            :original="$item['original']"
                            :translated="$item['translated']"
                            :date="$item['date']"
                        />
                    @endforeach
                </div>
            </div>

            {{-- Frasa Cepat Populer --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl/5 p-6 md:p-7">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-slate-900 flex items-center gap-2 text-base sm:text-lg">
                        <!-- Menggunakan Google Material Symbols Outlined -->
                        <span class="material-symbols-outlined" style="color: #9A3412; font-size: 24px;">
                          local_fire_department
                        </span>
                        Frasa Cepat Populer
                    </h3>
                    <span class="text-xs font-semibold text-blue-600 bg-[#E8EDFC] px-3 py-1 rounded-full">Khas Malang</span>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 mb-4 leading-relaxed">Klik frasa untuk langsung menyalin atau memasukkan ke editor:</p>
                <div class="flex flex-wrap gap-2.5">
                    @foreach ($popularPhrases as $phrase)
                        <x-phrase-item :id="$phrase['id']" :walikan="$phrase['walikan']" />
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Banner Member Pro Aktif Sesuai Desain --}}
        <div class="mt-8 bg-[#2554EB] rounded-3xl p-6 md:p-7 flex items-center gap-5 text-white shadow-lg shadow-blue-500/10">
            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    <polyline points="9 12 11 14 15 10"></polyline>
                </svg>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-bold text-white leading-tight">Fitur Member Pro Aktif Sepenuhnya</h3>
                <p class="text-xs sm:text-sm text-blue-100/90 mt-1.5 leading-relaxed">
                    Nikmati model terjemahan Boso Walikan v2.4, sinkronisasi cloud kamus pribadi, dan ekspor kosakata PDF tanpa batas.
                </p>
            </div>
        </div>
    </main>

    {{-- Panggil Component Footer --}}
    <x-guest.beranda-footer />

    {{-- Toast Notification --}}
    <div id="toast"
         class="fixed bottom-8 right-8 z-50 pointer-events-none bg-gray-900 text-white px-6 py-3.5 rounded-xl shadow-2xl text-sm font-medium translate-y-32 opacity-0 transition-all duration-300">
    </div>
</body>
</html>