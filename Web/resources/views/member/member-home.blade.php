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

    @vite([
        'resources/css/guest.css',
        'resources/css/user/member/member-home.css',
        'resources/js/user/member/member-home.js',
    ])
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900">

    {{-- Panggil Component Navbar --}}
    <x-guest.navbar />

    {{-- ============ HERO ============ --}}
    <section class="hero">
        <div class="hero-content">
            @if ($membership?->tier)
                <div class="hero-badge">
                    <i class="fas fa-crown text-amber-400"></i> {{ $membership->tier->name }}
                </div>
            @endif
            <h1 class="hero-title">
                Penerjemah Boso Walikan{{ $membership?->tier ? ' '.$membership->tier->name : '' }}
            </h1>
            <p class="hero-subtitle">
                Terjemahkan teks dan frasa bahasa Indonesia ke Boso Walikan (bahasa terbalik khas Malang) secara instan.
                Dilengkapi kamus lengkap, riwayat terjemahan, dan frasa populer.
            </p>
        </div>
    </section>

    {{-- ============ MAIN ============ --}}
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10 pb-16">

        {{-- Translator Card --}}
        <div class="card overflow-hidden">
            <div class="flex items-center gap-2.5 px-7 py-5 border-b border-gray-100">
                <i class="fas fa-language text-primary-600 text-lg"></i>
                <span class="font-bold text-gray-900">Terjemahkan</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[1fr_auto_1fr] gap-0 p-6 md:p-8">
                {{-- Walikan --}}
                <div class="flex flex-col">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-primary-600"></div>
                        <h3 id="source-language-label" class="font-bold text-gray-900">Boso Walikan</h3>
                        <span class="text-xs font-semibold px-2.5 py-0.5 bg-primary-50 text-primary-600 rounded-full">Bahasa sumber</span>
                    </div>
                    <textarea id="walikanText"
                        maxlength="1000"
                        class="w-full min-h-[140px] border-2 border-gray-200 rounded-xl p-4 text-sm text-gray-700 placeholder-gray-400 resize-y focus:outline-none focus:border-primary-600 focus:ring-4 focus:ring-primary-600/10 transition-all leading-relaxed"
                        placeholder="Tulis teks Boso Walikan di sini... contoh: akuj anayk"></textarea>
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-xs text-gray-400"><span id="sourceCount">0</span> karakter</span>
                        <button onclick="copyText('walikanText')" class="btn-ghost"><i class="far fa-copy"></i> Salin</button>
                    </div>
                </div>

                {{-- Swap --}}
                <div class="flex items-center justify-center px-4 lg:px-6 py-2">
                    <button onclick="swapText()" title="Tukar bahasa"
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-600 to-purple-600 text-white
                               shadow-lg shadow-primary-600/40 border-4 border-white flex items-center justify-center
                               hover:shadow-xl hover:scale-110 active:scale-95 transition-all duration-300 group">
                        <i class="fas fa-exchange-alt group-hover:rotate-180 transition-transform duration-500"></i>
                    </button>
                </div>

                {{-- Indonesia --}}
                <div class="flex flex-col">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                        <h3 id="target-language-label" class="font-bold text-gray-900">Bahasa Indonesia</h3>
                        <span class="text-xs font-semibold px-2.5 py-0.5 bg-green-50 text-green-600 rounded-full">Hasil terjemahan</span>
                    </div>
                    <textarea id="indoText"
                        maxlength="1000"
                        readonly
                        class="w-full min-h-[140px] border-2 border-gray-200 rounded-xl p-4 text-sm text-gray-700 placeholder-gray-400 resize-y focus:outline-none focus:border-primary-600 focus:ring-4 focus:ring-primary-600/10 transition-all leading-relaxed"
                        placeholder="Hasil terjemahan Bahasa Indonesia akan muncul di sini."></textarea>
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-xs text-gray-400"><span id="targetCount">0</span> karakter</span>
                        <button onclick="copyText('indoText')" class="btn-ghost"><i class="far fa-copy"></i> Salin</button>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-6 md:px-8 pb-6">
                <div class="flex items-center gap-3 flex-wrap">
                    <button onclick="clearAll()" class="btn-ghost"><i class="fas fa-eraser"></i> Hapus Semua</button>
                    <button onclick="speakText()" class="btn-ghost"><i class="fas fa-volume-up"></i> Dengarkan</button>
                    <div id="loadingIndicator" class="hidden items-center gap-2 text-primary-600 text-sm">
                        <div class="w-4 h-4 border-2 border-primary-200 border-t-primary-600 rounded-full animate-spin-slow"></div>
                        Menerjemahkan...
                    </div>
                    <span id="translationStatus" class="text-xs text-gray-500" aria-live="polite"></span>
                </div>
                <button onclick="translateText()" class="btn-primary"><i class="fas fa-bolt"></i> Terjemahkan Sekarang</button>
            </div>
        </div>

        {{-- Info Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
            <div class="card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-clock text-primary-600"></i> Riwayat Terjemahan Terakhir
                    </h3>
                    <a href="#" class="text-sm font-semibold text-primary-600 hover:underline">Lihat Semua →</a>
                </div>
                <div class="space-y-1">
                    @foreach ($recentTranslations as $item)
                        <x-history-item
                            :original="$item['original']"
                            :translated="$item['translated']"
                            :date="$item['date']"
                        />
                    @endforeach
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-fire text-primary-600"></i> Frasa Cepat Populer
                    </h3>
                    <a href="#" class="text-sm font-semibold text-primary-600 hover:underline">Lihat Semua →</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    @foreach ($popularPhrases as $phrase)
                        <x-phrase-item :id="$phrase['id']" :walikan="$phrase['walikan']" />
                    @endforeach
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="mt-8 bg-gradient-to-br from-brand-blue to-brand-purple rounded-2xl p-6 md:p-8
                    flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl shadow-primary-600/20">
            <div class="text-center md:text-left">
                <h3 class="text-xl md:text-2xl font-bold text-white mb-1.5">🚀 Yuk! Kenalan Dulu Aja! Supaya Ngga Bingung</h3>
                <p class="text-sm text-white/80">Daftar Member Pro untuk akses fitur lengkap, kamus offline, dan tanpa iklan. Mulai Rp29.000/bulan.</p>
            </div>
            <button class="px-7 py-3.5 bg-white text-primary-600 font-bold rounded-xl shadow-lg
                           hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300
                           flex items-center gap-2 whitespace-nowrap">
                Daftar Member Pro <i class="fas fa-arrow-right"></i>
            </button>
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