<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Paket Langganan Member Arema - MalangVerse</title>

    @vite(['resources/css/guest.css', 'resources/js/guest.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="bg-[#F8FAFC] font-sans antialiased text-slate-800 min-h-screen flex flex-col">

    {{-- Navbar Component --}}
    <x-guest.navbar />

    @php
        $gratisPlan = $plans->first(fn($p) => (float)($p->monthly_price ?: $p->price) == 0 || str_contains(strtolower($p->name), 'gratis'));
        $standarPlan = $plans->first(fn($p) => ((float)($p->monthly_price ?: $p->price) > 0 && (float)($p->monthly_price ?: $p->price) < 40000) || str_contains(strtolower($p->name), 'standar'));
        $premiumPlan = $plans->first(fn($p) => (float)($p->monthly_price ?: $p->price) >= 40000 || str_contains(strtolower($p->name), 'premium'));

        $standarId = $standarPlan ? $standarPlan->getKey() : 2;
        $premiumId = $premiumPlan ? $premiumPlan->getKey() : 3;

        $standarPrice = $standarPlan ? ($standarPlan->monthly_price > 0 ? $standarPlan->monthly_price : 19000) : 19000;
        $premiumPrice = $premiumPlan ? ($premiumPlan->monthly_price > 0 ? $premiumPlan->monthly_price : 49000) : 49000;

        $standarCheckoutUrl = route('payment.checkout', ['tier_id' => $standarId, 'billing' => 'monthly']);
        $premiumCheckoutUrl = route('payment.checkout', ['tier_id' => $premiumId, 'billing' => 'monthly']);
    @endphp

    {{-- ============ HERO SECTION ============ --}}
    <section class="bg-[#2A54F5] text-white pt-10 sm:pt-14 pb-28 sm:pb-32 px-4 relative overflow-hidden text-center">
        <div class="relative z-10 max-w-3xl mx-auto flex flex-col items-center">
            {{-- Badge Sasaji --}}
            <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm border border-white/20 text-white px-4 py-1.5 rounded-full text-xs font-bold tracking-wide mb-5 shadow-xs select-none">
                <span class="material-symbols-outlined" style="color: #FDE047; font-size: 20px; font-variation-settings: 'FILL' 1; line-height: 1;">
                    local_fire_department
                </span>
                <span>SASAJI • SALAM SATU JIWA</span>
            </div>

            {{-- Judul Hero --}}
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-3.5 leading-tight">
                Paket Langganan Member Arema
            </h1>

            {{-- Subtitle Hero --}}
            <p class="text-blue-100 text-xs sm:text-sm md:text-base max-w-xl mx-auto leading-relaxed mb-7">
                Nikmati akses tanpa batas kamus kiwalan terlengkap, penerjemah audio<br>instan, dan modul sejarah eksklusif.
            </p>

            {{-- Pill Tagihan Bulanan --}}
            <div class="inline-flex items-center bg-white text-[#2A54F5] px-6 py-2 rounded-full font-bold text-xs sm:text-sm shadow-md select-none">
                Tagihan Bulanan
            </div>
        </div>

        {{-- Smooth Curved Divider at the bottom sesuai referensi --}}
        <div class="absolute bottom-0 left-0 right-0 overflow-hidden leading-none pointer-events-none">
            <svg class="relative block w-full h-12 sm:h-16 md:h-20 text-[#F8FAFC]" viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path d="M0,15 C120,40 220,32 380,36 C520,40 620,88 740,90 C860,92 1100,56 1440,42 L1440,120 L0,120 Z" fill="currentColor"></path>
            </svg>
        </div>
    </section>

    {{-- ============ PRICING CARDS ============ --}}
    <main class="max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 -mt-16 sm:-mt-20 relative z-10 pb-16 flex-1">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-7 items-stretch">

            {{-- CARD 1: PAKET GRATIS --}}
            <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-slate-100/90 flex flex-col justify-between hover:shadow-md transition">
                <div>
                    {{-- Top Row: Badge & Icon --}}
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center bg-[#F1F5F9] text-slate-500 text-[11px] font-semibold px-3 py-1 rounded-full">
                            Gratis
                        </span>
                        <span class="material-symbols-outlined text-slate-400 text-xl">person</span>
                    </div>

                    {{-- Judul & Deskripsi --}}
                    <h3 class="text-xl font-extrabold text-slate-900 mt-5">Paket Gratis</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                        Coba fitur dasar kamus dan terjemahan tanpa biaya.
                    </p>

                    {{-- Harga --}}
                    <div class="mt-6">
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">Rp 0</span>
                            <span class="text-xs text-slate-400 font-normal">/ Bulan</span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">
                            Selalu gratis selamanya untuk pembelajar mula
                        </p>
                    </div>

                    {{-- Divider --}}
                    <div class="w-full h-px bg-slate-100 my-6"></div>

                    {{-- Fitur --}}
                    <ul class="space-y-3.5 text-xs text-slate-600">
                        <li class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0">check_circle</span>
                            <span>{{ $gratisPlan?->effectiveDailyCredits() ?? 100 }} kredit per hari</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0">check_circle</span>
                            <span>Preview kamus 5 halaman</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0">check_circle</span>
                            <span>Iklan standar komunitas</span>
                        </li>
                    </ul>
                </div>

                {{-- CTA Button --}}
                <div class="mt-8 pt-4">
                    @if ($currentPlanSlug === 'gratis')
                        <button type="button" disabled class="w-full py-2.5 px-4 rounded-full bg-[#EEF2F6] text-slate-400 text-xs font-bold cursor-default text-center">
                            Paket Saat Ini
                        </button>
                    @else
                        <button type="button" disabled class="w-full py-2.5 px-4 rounded-full border border-slate-200 text-slate-400 text-xs font-bold cursor-default text-center">
                            Paket Gratis
                        </button>
                    @endif
                </div>
            </div>

            {{-- CARD 2: PAKET STANDAR --}}
            <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-slate-100/90 flex flex-col justify-between hover:shadow-md transition">
                <div>
                    {{-- Top Row: Badge & Icon --}}
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center bg-[#EEF2FF] text-[#2A54F5] text-[11px] font-semibold px-3 py-1 rounded-full">
                            Standar
                        </span>
                        <span class="material-symbols-outlined text-[#2A54F5] text-xl">auto_stories</span>
                    </div>

                    {{-- Judul & Deskripsi --}}
                    <h3 class="text-xl font-extrabold text-slate-900 mt-5">{{ $standarPlan ? $standarPlan->name : 'Paket Standar' }}</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                        Sangat cocok untuk belajar bahasa kiwalan sehari-hari.
                    </p>

                    {{-- Harga --}}
                    <div class="mt-6">
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                                Rp {{ number_format($standarPrice, 0, ',', '.') }}
                            </span>
                            <span class="text-xs text-slate-400 font-normal">/ Bulan</span>
                        </div>
                        <p class="text-[11px] text-[#2A54F5] font-medium mt-1">
                            Pembayaran mudah melalui beberapa metode
                        </p>
                    </div>

                    {{-- Divider --}}
                    <div class="w-full h-px bg-slate-100 my-6"></div>

                    {{-- Fitur --}}
                    <ul class="space-y-3.5 text-xs text-slate-600">
                        <li class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0">check_circle</span>
                            <span>{{ $standarPlan ? $standarPlan->effectiveDailyCredits().' kredit per hari' : 'Kuota sesuai paket' }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0">check_circle</span>
                            <span>Akses 1 e-book kamus saku pilihan</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0">check_circle</span>
                            <span>Dukungan komunitas Arema</span>
                        </li>
                    </ul>
                </div>

                {{-- CTA Button --}}
                <div class="mt-8 pt-4">
                    @if ($currentPlanSlug === 'standar')
                        <button type="button" disabled class="w-full py-2.5 px-4 rounded-full bg-[#EEF2F6] text-slate-500 text-xs font-bold cursor-default text-center">
                            Paket Saat Ini
                        </button>
                    @else
                        <button type="button"
                                onclick="openCheckout('standar')"
                                class="w-full py-2.5 px-4 rounded-full border border-[#2A54F5] text-[#2A54F5] hover:bg-blue-50 text-xs font-bold transition flex items-center justify-center gap-1.5 text-center cursor-pointer">
                            <span>Pilih {{ $standarPlan ? $standarPlan->name : 'Paket Standar' }}</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                    @endif
                </div>
            </div>

            {{-- CARD 3: PAKET PREMIUM (SINGO EDAN PRO) --}}
            <div class="bg-white rounded-3xl shadow-xl shadow-blue-500/10 border-2 border-[#2A54F5] flex flex-col justify-between overflow-hidden relative transition hover:shadow-2xl">
                {{-- Top Header Ribbon / Banner --}}
                <div class="bg-[#2A54F5] text-white text-[11px] font-extrabold text-center py-2 tracking-wider uppercase">
                    PALING POPULER & KOMPLIT
                </div>

                <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between">
                    <div>
                        {{-- Top Row: Badge & Icon --}}
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center bg-[#2A54F5] text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-xs">
                                Singo Edan Pro
                            </span>
                            <div class="w-9 h-9 rounded-full bg-[#EEF2FF] flex items-center justify-center">
                                <span class="material-symbols-outlined" style="color: #1341D1; font-size: 24px; font-variation-settings: 'FILL' 1; line-height: 1;">
                                    military_tech
                                </span>
                            </div>
                        </div>

                        {{-- Judul & Deskripsi --}}
                        <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-5">Paket Premium</h3>
                        <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                            Akses mutlak fitur bahasa Malang & dukungan pelestarian budaya penuh.
                        </p>

                        {{-- Harga --}}
                        <div class="mt-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-2xl sm:text-3xl font-black text-[#2A54F5]">
                                    Rp {{ number_format($premiumPrice, 0, ',', '.') }}
                                </span>
                                <span class="text-xs text-slate-400 font-normal">/ Bulan</span>
                            </div>
                        </div>

                        {{-- Divider --}}
                        <div class="w-full h-px bg-slate-100 my-6"></div>

                        {{-- Fitur (Highlighted) --}}
                        <ul class="space-y-3.5 text-xs text-slate-700">
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <span class="font-medium">Terjemahan <strong class="font-extrabold text-slate-900">TANPA BATAS (Unlimited)</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <span class="font-medium">Akses <strong class="font-extrabold text-slate-900">SEMUA E-Book Kamus Boso Walikan lengkap</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <span class="font-medium"><strong class="font-extrabold text-slate-900">Badge eksklusif Member Pro</strong> di profil</span>
                            </li>
                        </ul>
                    </div>

                    {{-- CTA Button --}}
                    <div class="mt-8 pt-4">
                        @if ($currentPlanSlug === 'premium')
                            <button type="button" disabled class="w-full py-3 px-4 rounded-xl sm:rounded-2xl bg-[#EEF2F6] text-slate-500 text-xs sm:text-sm font-bold cursor-default text-center">
                                Paket Saat Ini
                            </button>
                        @else
                            <button type="button"
                                    onclick="openCheckout('premium')"
                                    class="w-full py-3 px-4 rounded-xl sm:rounded-2xl bg-[#2A54F5] hover:bg-blue-700 text-white text-xs sm:text-sm font-bold shadow-md shadow-blue-500/20 transition flex items-center justify-center gap-2 cursor-pointer">
                                <span class="material-symbols-outlined text-lg">qr_code_scanner</span>
                                <span>Pilih Paket Premium</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- ============ BOTTOM TRUST / PAYMENT BANNER ============ --}}
        <div class="mt-14 max-w-5xl mx-auto bg-white rounded-3xl p-5 sm:p-6 border border-slate-100/90 shadow-xs flex flex-col md:flex-row items-center justify-between gap-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-[#EFF6FF] text-[#2A54F5] flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-2xl">payments</span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h4 class="text-sm font-bold text-slate-900">Pembayaran Instan & Aman</h4>
                        <span class="bg-[#F1F5F9] text-slate-600 text-[10px] font-bold px-2 py-0.5 rounded">YoBasePay V4</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">
                        Pilih metode pembayaran yang tersedia. Paket aktif otomatis setelah pembayaran terverifikasi.
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-xs text-slate-400 shrink-0 flex-wrap justify-center">
                <span class="text-xs text-slate-400 mr-1 font-medium">Didukung oleh:</span>
                <span class="border border-slate-200 text-slate-700 font-bold text-[11px] px-2.5 py-1 rounded-md bg-white">BCA</span>
                <span class="border border-slate-200 text-slate-700 font-bold text-[11px] px-2.5 py-1 rounded-md bg-white">GoPay</span>
                <span class="border border-slate-200 text-slate-700 font-bold text-[11px] px-2.5 py-1 rounded-md bg-white">ShopeePay</span>
                <span class="border border-slate-200 text-slate-700 font-bold text-[11px] px-2.5 py-1 rounded-md bg-white">OVO</span>
            </div>
        </div>

    </main>

    {{-- Footer Component --}}
    <x-guest.beranda-footer />

    {{-- ============ MODAL / DIV CHECKOUT TRANSAKSI ============ --}}
    <div id="checkoutModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6 hidden">
        <div class="fixed inset-0" onclick="closeCheckout()"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden max-w-4xl w-full z-10 animate-in fade-in zoom-in-95 duration-200 my-auto">
            {{-- Header Modal --}}
            <div class="px-6 sm:px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-[#2A54F5] text-white flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/20">
                        <span class="material-symbols-outlined text-xl">lock</span>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-extrabold text-slate-900 leading-tight">
                            Pembayaran Paket Langganan
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Pilih metode pembayaran melalui halaman checkout YoBasePay.
                        </p>
                    </div>
                </div>
                <button type="button"
                        onclick="closeCheckout()"
                        class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition cursor-pointer"
                        title="Tutup">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>

            {{-- Body Modal --}}
            <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10">
                {{-- Kolom Kiri: Detail Paket & Rincian Biaya --}}
                <div class="flex flex-col justify-between">
                    <div>
                        {{-- Badge Paket --}}
                        <div class="mb-3">
                            <span id="modalPackageBadge" class="inline-flex items-center gap-1.5 bg-[#1341D1] text-white text-[12px] font-bold px-3.5 py-1 rounded-full shadow-xs">
                                <span id="modalBadgeIcon" class="material-symbols-outlined" style="color: #FFFFFF; font-size: 20px; font-variation-settings: 'FILL' 1; line-height: 1;">
                                    hotel_class
                                </span>
                                <span id="modalBadgeText">Paket Premium</span>
                            </span>
                        </div>

                        {{-- Judul & Periode --}}
                        <h3 id="modalPackageTitle" class="text-xl sm:text-2xl font-black text-slate-900">
                            Paket Langganan Premium
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 font-medium">
                            Akses 1 Bulan Penuh.
                        </p>

                        {{-- Manfaat Langganan --}}
                        <div class="mt-6">
                            <h4 class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-3">
                                MANFAAT LANGGANAN:
                            </h4>
                            {{-- Manfaat Standar --}}
                            <ul id="modalBenefitsStandar" class="space-y-3 text-xs text-slate-700 hidden">
                                <li class="flex items-center gap-2.5">
                                    <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    <span class="font-medium">{{ $standarPlan ? $standarPlan->effectiveDailyCredits().' kredit per hari' : 'Kuota sesuai paket' }}</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    <span class="font-medium">Akses 1 E-Book kamus saku pilihan</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    <span class="font-medium">Dukungan komunitas Arema</span>
                                </li>
                            </ul>
                            {{-- Manfaat Premium --}}
                            <ul id="modalBenefitsPremium" class="space-y-3 text-xs text-slate-700">
                                <li class="flex items-center gap-2.5">
                                    <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    <span class="font-medium">Terjemahan tanpa batas (Unlimited)</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    <span class="font-medium">Akses penuh E-Book Kamus Walikan (PDF HD)</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    <span class="font-medium">Badge eksklusif Member Pro di profil</span>
                                </li>
                            </ul>
                        </div>

                        {{-- Rincian Tagihan Box --}}
                        <div class="mt-7 bg-[#F8FAFC] rounded-2xl p-4 sm:p-5 border border-slate-100">
                            <div class="space-y-2 text-xs">
                                <div class="flex items-center justify-between text-slate-600">
                                    <span>Harga Paket (1 Bulan)</span>
                                    <span class="font-bold text-slate-800 modal-price-val">Rp 49.000</span>
                                </div>
                                <div class="flex items-center justify-between text-slate-600">
                                    <span>Biaya Metode</span>
                                    <span id="modalGatewayFee" class="font-bold text-[#2A54F5]">Mengikuti metode pilihan</span>
                                </div>
                                <div class="flex items-center justify-between text-slate-600">
                                    <span>Diskon Komunitas Pelajar</span>
                                    <span class="font-bold text-slate-400">-Rp 0</span>
                                </div>
                            </div>

                            <div class="border-t border-slate-200/80 pt-3.5 mt-3.5 flex items-end justify-between">
                                <div>
                                    <span class="text-xs font-bold text-slate-800 block">Total Tagihan</span>
                                    <span class="text-[10px] text-slate-400">Biaya dapat berubah sesuai metode gateway.</span>
                                </div>
                                <div id="modalTotalAmount" class="text-2xl sm:text-3xl font-black text-[#2A54F5]">
                                    Rp 49.000
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- User Account Info Pill --}}
                    @php
                        $user = auth()->user();
                    @endphp
                    <div class="mt-6 flex items-center gap-2 bg-[#F1F5F9] text-slate-600 text-[11px] sm:text-xs px-3.5 py-2.5 rounded-xl border border-slate-200/60 truncate">
                        <span class="material-symbols-outlined text-slate-400 text-base shrink-0">badge</span>
                        <span class="truncate">
                            Akun: <strong class="text-slate-800 font-semibold">{{ $user->name ?? 'Ngalup Ker' }}</strong> ({{ $user->email ?? 'ngalup@ker.id' }}) • ID: #MV-MLG-{{ strtoupper(substr(md5($user->id ?? '1'), 0, 4)) }}
                        </span>
                    </div>
                </div>

                {{-- Kolom Kanan: Instruksi Pembayaran & Timer --}}
                <div class="bg-[#F1F5FB] rounded-3xl p-5 sm:p-6 border border-slate-100 flex flex-col justify-between">
                    <div>
                        {{-- Countdown Banner --}}
                        <div class="flex items-center justify-between bg-[#FFEDD5] text-[#9A3412] px-4 py-2 rounded-full text-xs font-bold mb-4 shadow-xs">
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-base">timer</span>
                                <span>Batas Waktu Transaksi</span>
                            </div>
                            <span id="countdownModal" class="font-mono bg-white text-[#9A3412] px-3 py-0.5 rounded-full text-xs font-black shadow-xs">
                                14:47
                            </span>
                        </div>

                        {{-- Payment Details Card --}}
                        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/60 text-center">
                            {{-- Top QR Card Header --}}
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100 text-left">
                                <div>
                                    <span id="modalPaymentChannelLabel" class="text-xs font-black text-rose-600 tracking-wider">YOBASEPAY</span>
                                    <span class="text-[11px] text-slate-400 ml-1">| Metode Pembayaran Aman</span>
                                </div>
                                <span class="text-[11px] font-bold text-slate-700">V4</span>
                            </div>

                            {{-- Merchant Header --}}
                            <div class="my-3 text-center">
                                <h4 id="modalReceiverName" class="font-black text-xs text-slate-800 tracking-wider uppercase">
                                    MalangVerse
                                </h4>
                                <p id="modalInvoiceText" class="text-[10px] text-slate-400 font-mono mt-0.5">
                                    Invoice akan muncul setelah transaksi dibuat.
                                </p>
                            </div>

                            {{-- QR Code Image Graphic (Dynamic) --}}
                            <div class="my-3 flex items-center justify-center">
                                <div id="modalQrBox" class="w-48 h-48 bg-white p-2 rounded-2xl border border-slate-100 flex items-center justify-center relative shadow-xs">
                                    <div class="text-center p-3 text-slate-400">
                                        <span class="material-symbols-outlined text-3xl animate-spin">sync</span>
                                        <p class="text-[11px] mt-1 font-medium">Membuat tagihan...</p>
                                    </div>
                                </div>
                            </div>

                            {{-- QR Instructions --}}
                            <p class="text-[11px] text-slate-500 max-w-xs mx-auto leading-relaxed mt-2">
                                Pilih metode pembayaran di halaman YoBasePay, lalu selesaikan transaksi sebelum waktu habis.
                            </p>

                            {{-- Payment Provider Pills --}}
                            <div class="flex items-center justify-center gap-1.5 flex-wrap mt-3 pt-3 border-t border-slate-100 text-[10px]">
                                <span class="border border-slate-200 text-slate-700 font-semibold px-2.5 py-0.5 rounded-full bg-white">Virtual Account</span>
                                <span class="border border-slate-200 text-slate-700 font-semibold px-2.5 py-0.5 rounded-full bg-white">QRIS</span>
                                <span class="border border-slate-200 text-slate-700 font-semibold px-2.5 py-0.5 rounded-full bg-white">E-Wallet</span>
                                <span class="border border-slate-200 text-slate-700 font-semibold px-2.5 py-0.5 rounded-full bg-white">Retail</span>
                            </div>
                        </div>
                    </div>

                    {{-- Pulsing Waiting Status Pill --}}
                    <div class="mt-4 flex items-center justify-center gap-2 bg-[#E0E7FF] text-[#1E40AF] px-4 py-2 rounded-full text-[11px] font-medium text-center">
                        <span class="w-2 h-2 rounded-full bg-[#2563EB] animate-pulse shrink-0"></span>
                        <span class="truncate">Menunggu pembayaran via YoBasePay...</span>
                    </div>
                </div>
            </div>

            {{-- Footer Modal --}}
            <div class="px-6 sm:px-8 py-4 bg-[#F8FAFC] border-t border-slate-100 flex items-center justify-between flex-wrap gap-4">
                <button type="button"
                        onclick="closeCheckout()"
                        class="text-xs sm:text-sm font-semibold text-slate-500 hover:text-slate-800 transition cursor-pointer">
                    Batalkan Transaksi
                </button>
                <button id="btnModalConfirm"
                        type="button"
                        class="inline-flex items-center gap-2 bg-[#1341D1] hover:bg-blue-700 text-white px-5 sm:px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold shadow-md shadow-blue-500/20 transition cursor-pointer">
                    <span class="material-symbols-outlined text-base">sync</span>
                    <span>Konfirmasi Pembayaran →</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Script Modal Checkout Interaktif --}}
    <script>
        let countdownTimer = null;
        let pollTimer = null;
        let activeTransactionCode = null;
        const standarTierId = {{ $standarId }};
        const premiumTierId = {{ $premiumId }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        function startCheckoutTimer(seconds = 900) {
            if (countdownTimer) clearInterval(countdownTimer);
            let timeLeft = seconds;
            const el = document.getElementById('countdownModal');

            countdownTimer = setInterval(() => {
                const minutes = Math.floor(timeLeft / 60);
                const s = timeLeft % 60;
                if (el) {
                    el.textContent = `${minutes.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                }
                if (timeLeft <= 0) {
                    clearInterval(countdownTimer);
                    handleModalExpired();
                }
                timeLeft--;
            }, 1000);
        }

        function openCheckout(type) {
            @guest
                window.location.href = "{{ route('login') }}";
                return;
            @endguest

            const modal = document.getElementById('checkoutModal');
            if (!modal) return;

            const isStandar = type === 'standar';
            const tierId = isStandar ? standarTierId : premiumTierId;

            // Update Badge
            const badgeEl = document.getElementById('modalPackageBadge');
            const badgeTextEl = document.getElementById('modalBadgeText');
            const badgeIconEl = document.getElementById('modalBadgeIcon');
            if (badgeEl && badgeTextEl) {
                badgeTextEl.textContent = isStandar ? 'Paket Standar' : 'Paket Premium';
                badgeEl.className = isStandar
                    ? 'inline-flex items-center gap-1.5 bg-[#2A54F5] text-white text-[12px] font-bold px-3.5 py-1 rounded-full shadow-xs'
                    : 'inline-flex items-center gap-1.5 bg-[#1341D1] text-white text-[12px] font-bold px-3.5 py-1 rounded-full shadow-xs';
                if (badgeIconEl) {
                    badgeIconEl.textContent = isStandar ? 'auto_stories' : 'hotel_class';
                }
            }

            // Update Title
            const titleEl = document.getElementById('modalPackageTitle');
            if (titleEl) {
                titleEl.textContent = isStandar ? 'Paket Langganan Standar' : 'Paket Langganan Premium';
            }

            // Update Benefits
            const benefitsStandar = document.getElementById('modalBenefitsStandar');
            const benefitsPremium = document.getElementById('modalBenefitsPremium');
            if (benefitsStandar && benefitsPremium) {
                benefitsStandar.classList.toggle('hidden', !isStandar);
                benefitsPremium.classList.toggle('hidden', isStandar);
            }

            // Update Price
            const priceText = isStandar ? 'Rp 19.000' : 'Rp 49.000';
            document.querySelectorAll('.modal-price-val').forEach(el => el.textContent = priceText);
            const totalAmountEl = document.getElementById('modalTotalAmount');
            if (totalAmountEl) totalAmountEl.textContent = priceText;
            const gatewayFeeEl = document.getElementById('modalGatewayFee');
            if (gatewayFeeEl) gatewayFeeEl.textContent = 'Mengikuti metode pilihan';

            // Set loading in QR box
            const qrBox = document.getElementById('modalQrBox');
            if (qrBox) {
                qrBox.innerHTML = `
                    <div class="text-center p-3 text-slate-400">
                        <span class="material-symbols-outlined text-3xl animate-spin text-[#2A54F5]">sync</span>
                        <p class="text-[11px] text-slate-600 mt-2 font-semibold">Membuat tagihan YoBasePay...</p>
                    </div>
                `;
            }

            // Show Modal
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // Request a YoBasePay V4 checkout
            fetch('{{ route("subscription.create-qris") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    tier_id: tierId,
                    billing: 'monthly'
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && !data.is_free) {
                    activeTransactionCode = data.transaction_code;

                    if (qrBox) {
                        qrBox.replaceChildren();

                        if (typeof data.checkout_url === 'string' && data.checkout_url !== '') {
                            const checkoutUrl = new URL(data.checkout_url, window.location.origin);
                            if (checkoutUrl.protocol !== 'https:') {
                                throw new Error('Halaman pembayaran harus menggunakan HTTPS.');
                            }

                            const checkoutLink = document.createElement('a');
                            checkoutLink.href = checkoutUrl.toString();
                            checkoutLink.target = '_blank';
                            checkoutLink.rel = 'noopener noreferrer';
                            checkoutLink.className = 'inline-flex items-center justify-center rounded-full bg-[#2A54F5] px-4 py-3 text-center text-xs font-bold text-white shadow-sm transition hover:bg-blue-700';
                            checkoutLink.textContent = 'Pilih Metode Pembayaran';
                            qrBox.append(checkoutLink);
                        } else if (typeof data.qr_image === 'string' && data.qr_image !== '') {
                            const qrUrl = new URL(data.qr_image, window.location.origin);
                            if (!['https:', 'http:'].includes(qrUrl.protocol)) {
                                throw new Error('URL gambar QR pembayaran tidak valid.');
                            }

                            const image = document.createElement('img');
                            image.src = qrUrl.toString();
                            image.alt = 'Kode QR pembayaran YoBasePay';
                            image.className = 'h-full w-full rounded-lg object-contain shadow-xs';
                            qrBox.append(image);
                        } else if (typeof data.qr_string === 'string' && data.qr_string !== '') {
                            const qrText = document.createElement('code');
                            qrText.className = 'max-h-full overflow-auto break-all text-[9px] text-slate-600';
                            qrText.textContent = data.qr_string;
                            qrBox.append(qrText);
                        } else {
                            throw new Error('Gateway tidak mengembalikan metode pembayaran.');
                        }
                    }

                    const invoiceText = document.getElementById('modalInvoiceText');
                    if (invoiceText) {
                        invoiceText.textContent = `INV: ${data.transaction_code}`;
                    }

                    const baseAmount = Number(data.amount);
                    const amountToPay = Number(data.amount_to_pay);
                    if (Number.isFinite(amountToPay) && amountToPay >= baseAmount) {
                        const feeAmount = amountToPay - baseAmount;
                        if (totalAmountEl) {
                            totalAmountEl.textContent = `Rp ${amountToPay.toLocaleString('id-ID')}`;
                        }
                        if (gatewayFeeEl) {
                            gatewayFeeEl.textContent = feeAmount > 0
                                ? `Rp ${feeAmount.toLocaleString('id-ID')}`
                                : (data.fee_payer === 'merchant' ? 'Ditanggung merchant' : 'Rp 0');
                        }
                    }

                    const expiresAt = data.expired_at ? new Date(data.expired_at.replace(' ', 'T')) : null;
                    const secondsRemaining = expiresAt && !Number.isNaN(expiresAt.getTime())
                        ? Math.max(0, Math.ceil((expiresAt.getTime() - Date.now()) / 1000))
                        : 900;
                    startCheckoutTimer(secondsRemaining);
                    startPolling(data.transaction_code);
                } else if (data.is_free) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert(data.message || 'Gagal membuat pembayaran.');
                    closeCheckout();
                }
            })
            .catch(err => {
                alert(err instanceof Error ? err.message : 'Terjadi kendala koneksi ke gateway pembayaran.');
                closeCheckout();
            });
        }

        function startPolling(txCode) {
            if (pollTimer) clearInterval(pollTimer);
            pollTimer = setInterval(() => {
                if (!activeTransactionCode) return;

                fetch(`/api/payment/status/${txCode}`, {
                    headers: { 'Accept': 'application/json' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.is_paid || data.status === 'paid' || data.status === 'SUCCESS') {
                        clearInterval(pollTimer);
                        if (countdownTimer) clearInterval(countdownTimer);
                        alert('Pembayaran berhasil diverifikasi! Paket Anda kini aktif.');
                        closeCheckout();
                        window.location.reload();
                    }
                })
                .catch(() => {});
            }, 3000);
        }

        function closeCheckout() {
            const modal = document.getElementById('checkoutModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
            if (countdownTimer) clearInterval(countdownTimer);
            if (pollTimer) clearInterval(pollTimer);
            activeTransactionCode = null;
        }

        function handleModalExpired() {
            if (pollTimer) clearInterval(pollTimer);
            alert('Waktu pembayaran telah kedaluwarsa. Silakan ulangi transaksi.');
            closeCheckout();
        }

        // Close modal on Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeCheckout();
        });

        // Tombol Konfirmasi Manual Pembayaran Modal
        document.addEventListener('DOMContentLoaded', function () {
            const btnConfirm = document.getElementById('btnModalConfirm');
            if (btnConfirm) {
                btnConfirm.addEventListener('click', function () {
                    if (!activeTransactionCode) return;
                    btnConfirm.disabled = true;

                    fetch(`/api/payment/status/${activeTransactionCode}`, {
                        headers: { 'Accept': 'application/json' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.is_paid || data.status === 'paid' || data.status === 'SUCCESS') {
                            alert('Pembayaran berhasil diverifikasi! Paket Anda kini aktif.');
                            closeCheckout();
                            window.location.reload();
                        } else {
                            alert('Status: ' + data.status.toUpperCase() + '. Pembayaran belum diterima dari gateway.');
                        }
                    })
                    .finally(() => {
                        btnConfirm.disabled = false;
                    });
                });
            }
        });
    </script>

</body>
</html>
