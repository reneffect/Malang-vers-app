<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Paket Langganan Member Arema - MulangVerse</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/guest.css', 'resources/css/components/navbar.css', 'resources/js/guest.js'])
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900">

    {{-- Panggil Component Navbar --}}
    <x-guest.navbar />

    {{-- ============ HERO ============ --}}
    <section class="page-hero">
        <div class="page-hero-content max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-14 text-center">
            <div class="inline-flex items-center gap-2 bg-white/15 border border-white/25 text-white px-4 py-1 rounded-full text-xs font-semibold mb-5 backdrop-blur-sm">
                <i class="fas fa-fire text-amber-300"></i>
                PROMO - HEMAT 50% 30%
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold mb-3 leading-tight">
                Paket Langganan Member Arema
            </h1>
            <p class="text-sm md:text-base text-blue-100 max-w-2xl mx-auto leading-relaxed">
                Nikmati akses tanpa batas ke seluruh fitur kamus, penerjemah, komunitas, audio, dan banyak lagi. Pilih paket yang sesuai dengan kebutuhanmu.
            </p>

            {{-- Toggle Bulanan / Tahunan --}}
            <div class="mt-7 inline-flex items-center gap-3 bg-white/15 backdrop-blur-md border border-white/20 rounded-full p-1.5">
                <button id="btnMonthly" onclick="setBilling('monthly')"
                        class="billing-btn px-5 py-2 rounded-full text-sm font-semibold bg-white text-blue-700 transition-all">
                    Tagihan Bulanan
                </button>
                <button id="btnYearly" onclick="setBilling('yearly')"
                        class="billing-btn px-5 py-2 rounded-full text-sm font-semibold text-white hover:bg-white/10 transition-all flex items-center gap-2">
                    Tagihan Tahunan
                    <span class="bg-amber-400 text-amber-900 text-[10px] font-bold px-2 py-0.5 rounded-full">HEMAT 50%</span>
                </button>
            </div>
        </div>
    </section>

    {{-- ============ PRICING CARDS ============ --}}
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10 pb-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($plans as $plan)
                @php
                    $isRecommended = $plan->is_recommended;
                @endphp
                <div class="relative {{ $isRecommended ? 'md:-mt-4 md:mb-4' : '' }}">
                    {{-- Badge Rekomendasi --}}
                    @if ($isRecommended)
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                            <span class="bg-gradient-to-r from-amber-400 to-orange-500 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg">
                                <i class="fas fa-crown mr-1"></i> PALING DIREKOMENDASIKAN
                            </span>
                        </div>
                    @endif

                    <div class="bg-white rounded-2xl shadow-lg h-full flex flex-col overflow-hidden border-2 {{ $isRecommended ? 'border-blue-500' : 'border-transparent' }} hover:shadow-2xl transition-shadow duration-300">
                        {{-- Header Card --}}
                        <div class="p-6 border-b border-gray-100">
                            @if ($plan->badge)
                                <span class="inline-block text-[10px] font-bold px-2.5 py-1 rounded-md bg-blue-100 text-blue-700 mb-3 uppercase tracking-wide">
                                    {{ $plan->badge }}
                                </span>
                            @endif
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $plan->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $plan->description }}</p>

                            {{-- Harga --}}
                            <div class="mt-5 flex items-baseline gap-1">
                                <span class="text-sm text-gray-500">Rp</span>
                                <span class="text-4xl font-extrabold text-gray-900 price-value"
                                      data-monthly="{{ $plan->monthly_price }}"
                                      data-yearly="{{ $plan->yearly_price ?? ($plan->monthly_price * 12) }}">
                                    {{ number_format($plan->monthly_price, 0, ',', '.') }}
                                </span>
                                <span class="text-sm text-gray-500 billing-period">/bulan</span>
                            </div>
                            @if ($plan->yearly_price)
                                <p class="text-xs text-gray-400 mt-1 yearly-info hidden">
                                    Rp {{ number_format($plan->yearly_price, 0, ',', '.') }}/tahun
                                </p>
                            @endif
                        </div>

                        {{-- Features --}}
                        <div class="p-6 flex-1">
                            <ul class="space-y-3">
                                @if ($plan->relationLoaded('features') && $plan->features->isNotEmpty())
                                    @foreach ($plan->features as $feature)
                                        <li class="flex items-start gap-3">
                                            @if ($feature->included)
                                                <i class="fas fa-check-circle text-blue-500 mt-0.5"></i>
                                                <span class="text-sm text-gray-700">{{ $feature->feature }}</span>
                                            @else
                                                <i class="fas fa-times-circle text-gray-300 mt-0.5"></i>
                                                <span class="text-sm text-gray-400 line-through">{{ $feature->feature }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                @else
                                    <li class="flex items-start gap-3">
                                        <i class="fas fa-check-circle text-blue-500 mt-0.5"></i>
                                        <span class="text-sm text-gray-700">Akses fitur {{ $plan->name }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        {{-- CTA Button --}}
                        <div class="p-6 pt-0">
                            <button onclick="selectPlan('{{ $plan->name }}', {{ $plan->monthly_price }})"
                                    class="w-full py-3 rounded-xl font-bold text-sm transition-all duration-300
                                           {{ $isRecommended
                                                ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:shadow-lg hover:shadow-blue-600/30 hover:-translate-y-0.5'
                                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ $plan->monthly_price === 0 ? 'Pakai Gratis' : 'Pilih ' . $plan->name }}
                                @if ($isRecommended)
                                    <span class="block text-xs font-normal mt-0.5 opacity-90">(Hemat 50%)</span>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ============ FAQ SECTION ============ --}}
        <section class="mt-20 max-w-3xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-gray-500">Masih bingung? Baca FAQ di bawah ini atau hubungi kami.</p>
            </div>

            <div class="space-y-3">
                @foreach ($faqs as $faq)
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-5 text-left hover:bg-gray-50 transition-colors">
                            <span class="font-semibold text-gray-900 pr-4">{{ $faq->question }}</span>
                            <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300 faq-icon"></i>
                        </button>
                        <div class="faq-answer hidden px-5 pb-5">
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $faq->answer }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ============ BOTTOM CTA ============ --}}
        <section class="mt-16 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 md:p-12 text-center text-white shadow-xl">
            <h3 class="text-2xl md:text-3xl font-extrabold mb-3">
                Siap untuk menjadi bagian dari keluarga besar Boso Walikan?
            </h3>
            <p class="text-blue-100 mb-6 max-w-xl mx-auto">
                Bergabung sekarang dan nikmati semua fitur premium dengan harga terjangkau.
            </p>
            <button onclick="window.location.href='{{ route('home') }}'"
                    class="px-8 py-3.5 bg-white text-blue-700 font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                Gabung Sekarang <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </section>
    </main>

    <x-guest.beranda-footer />

    {{-- Toast --}}
    <div id="toast" class="fixed bottom-8 right-8 z-50 pointer-events-none bg-gray-900 text-white px-6 py-3.5 rounded-xl shadow-2xl text-sm font-medium translate-y-32 opacity-0 transition-all duration-300"></div>

</body>
</html>