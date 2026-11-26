<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran QRIS - MalangVerse</title>

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
        $user = auth()->user();
        $item = isset($transaction) && $transaction->items ? $transaction->items->first() : null;
        $isMembership = !isset($transaction) || ($item && $item->isMembership());
        $isEbook = isset($item) && $item->isEbook();

        if ($isMembership) {
            $tierName = $tier?->name ?? $item?->item_name_snapshot ?? 'Paket Langganan';
            $isStandar = str_contains(strtolower($tierName), 'standar');
            $billingSuffix = isset($billing) && $billing === 'yearly' ? ' (Tahunan)' : (isset($billing) ? ' (Bulanan)' : '');
            $packageName = ($isStandar ? ($tier?->name ?? 'Paket Standar') : ($tier?->name ?? 'Paket Premium')) . $billingSuffix;
            $packageBadge = $isStandar ? 'Paket Standar' : 'Paket Premium';
            $badgeIcon = $isStandar ? 'auto_stories' : 'hotel_class';
        } else {
            $packageName = $item ? $item->item_name_snapshot : 'Lisensi E-Book Malang';
            $packageBadge = 'Lisensi E-Book';
            $badgeIcon = 'menu_book';
        }

        $totalPrice = isset($transaction)
            ? (float) $transaction->total_amount
            : (float) ($price ?? ($isStandar ? 19000 : 49000));

        $txCode = isset($transaction) ? $transaction->transaction_code : 'INV-PREVIEW';
        $expiresAtTimestamp = isset($payment) && $payment?->expires_at
            ? $payment->expires_at->timestamp
            : (isset($transaction) && $transaction?->expires_at ? $transaction->expires_at->timestamp : now()->addMinutes(15)->timestamp);
        $secondsRemaining = max(0, $expiresAtTimestamp - now()->timestamp);
    @endphp

    {{-- ============ HERO SECTION BACKGROUND ============ --}}
    <section class="bg-[#2A54F5] text-white pt-10 sm:pt-14 pb-32 sm:pb-36 px-4 relative overflow-hidden text-center">
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
                Pembayaran Resmi MalangVerse
            </h1>

            {{-- Subtitle Hero --}}
            <p class="text-blue-100 text-xs sm:text-sm md:text-base max-w-xl mx-auto leading-relaxed mb-7">
                Selesaikan transaksi dengan mudah menggunakan QRIS Realtime standar Bank Indonesia.
            </p>

            {{-- Pill Mode Pembayaran --}}
            <div class="inline-flex items-center gap-1.5 bg-white text-[#2A54F5] px-6 py-2 rounded-full font-bold text-xs sm:text-sm shadow-md select-none">
                <span class="material-symbols-outlined text-sm">qr_code_scanner</span>
                <span>QRIS Instan Otomatis</span>
            </div>
        </div>

        {{-- Smooth Curved Divider at the bottom --}}
        <div class="absolute bottom-0 left-0 right-0 overflow-hidden leading-none pointer-events-none">
            <svg class="relative block w-full h-12 sm:h-16 md:h-20 text-[#F8FAFC]" viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path d="M0,15 C120,40 220,32 380,36 C520,40 620,88 740,90 C860,92 1100,56 1440,42 L1440,120 L0,120 Z" fill="currentColor"></path>
            </svg>
        </div>
    </section>

    {{-- ============ FLOATING TRANSACTION CARD ============ --}}
    <main class="max-w-4xl w-full mx-auto px-4 sm:px-6 -mt-24 sm:-mt-28 relative z-20 pb-20 flex-1">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden">

            {{-- Header Modal --}}
            <div class="px-6 sm:px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-[#2A54F5] text-white flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/20">
                        <span class="material-symbols-outlined text-xl">lock</span>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-extrabold text-slate-900 leading-tight">
                            Invoice: {{ $txCode }}
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Pembayaran resmi melalui gateway YoBasePay QRIS Realtime.
                        </p>
                    </div>
                </div>
                <a href="{{ $isEbook ? route('kamus') : route('membership.public') }}"
                   class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition cursor-pointer"
                   title="Kembali">
                    <span class="material-symbols-outlined text-lg">close</span>
                </a>
            </div>

            {{-- Body Modal --}}
            <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10">

                {{-- Kolom Kiri: Detail Paket & Rincian Biaya --}}
                <div class="flex flex-col justify-between">
                    <div>
                        {{-- Badge Produk --}}
                        <div class="mb-3">
                            <span class="inline-flex items-center gap-1.5 bg-[#1341D1] text-white text-[12px] font-bold px-3.5 py-1 rounded-full shadow-xs">
                                <span class="material-symbols-outlined" style="color: #FFFFFF; font-size: 20px; font-variation-settings: 'FILL' 1; line-height: 1;">
                                    {{ $badgeIcon }}
                                </span>
                                <span>{{ $packageBadge }}</span>
                            </span>
                        </div>

                        {{-- Judul & Periode --}}
                        <h3 class="text-xl sm:text-2xl font-black text-slate-900">
                            {{ $packageName }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 font-medium">
                            @if ($isMembership)
                                Akses 1 Bulan Penuh.
                            @else
                                Lisensi Akses Digital Permanen.
                            @endif
                        </p>

                        {{-- Manfaat / Detail Produk --}}
                        <div class="mt-6">
                            <h4 class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-3">
                                RINCIAN ITEM:
                            </h4>
                            <ul class="space-y-3 text-xs text-slate-700">
                                @if ($isMembership && isset($isStandar) && $isStandar)
                                    <li class="flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                        <span class="font-medium">500 kredit / 100 terjemahan harian</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                        <span class="font-medium">Akses 1 E-Book kamus saku pilihan</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                        <span class="font-medium">Bebas iklan & dukungan komunitas</span>
                                    </li>
                                @elseif ($isMembership)
                                    <li class="flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                        <span class="font-medium">Terjemahan TANPA BATAS (Unlimited)</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                        <span class="font-medium">Akses penuh SEMUA E-Book Kamus Walikan</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                        <span class="font-medium">Badge eksklusif PRO di profil & navbar</span>
                                    </li>
                                @else
                                    <li class="flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                        <span class="font-medium">Akses baca penuh file PDF HD seumur hidup</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-[#2A54F5] text-[18px] shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                        <span class="font-medium">Bebas dibaca kapan saja langsung di akun Anda</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        {{-- Rincian Tagihan Box --}}
                        <div class="mt-7 bg-[#F8FAFC] rounded-2xl p-4 sm:p-5 border border-slate-100">
                            <div class="space-y-2 text-xs">
                                <div class="flex items-center justify-between text-slate-600">
                                    <span>Nominal Pembelian</span>
                                    <span class="font-bold text-slate-800">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center justify-between text-slate-600">
                                    <span>Biaya Layanan QRIS</span>
                                    <span class="font-bold text-[#2A54F5]">Gratis (Rp 0)</span>
                                </div>
                                <div class="flex items-center justify-between text-slate-600">
                                    <span>Kode Invoice</span>
                                    <span class="font-mono font-bold text-slate-700">{{ $txCode }}</span>
                                </div>
                            </div>

                            <div class="border-t border-slate-200/80 pt-3.5 mt-3.5 flex items-end justify-between">
                                <div>
                                    <span class="text-xs font-bold text-slate-800 block">Total Tagihan</span>
                                    <span class="text-[10px] text-slate-400">Termasuk PPN 11%</span>
                                </div>
                                <div class="text-2xl sm:text-3xl font-black text-[#2A54F5]">
                                    Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- User Account Info Pill --}}
                    <div class="mt-6 flex items-center gap-2 bg-[#F1F5F9] text-slate-600 text-[11px] sm:text-xs px-3.5 py-2.5 rounded-xl border border-slate-200/60 truncate">
                        <span class="material-symbols-outlined text-slate-400 text-base shrink-0">badge</span>
                        <span class="truncate">
                            Akun: <strong class="text-slate-800 font-semibold">{{ $user->name ?? 'Pelanggan' }}</strong> ({{ $user->email ?? '-' }})
                        </span>
                    </div>
                </div>

                {{-- Kolom Kanan: QRIS Card & Timer --}}
                <div class="bg-[#F1F5FB] rounded-3xl p-5 sm:p-6 border border-slate-100 flex flex-col justify-between">
                    <div>
                        {{-- Countdown Banner --}}
                        <div id="timerBanner" class="flex items-center justify-between bg-[#FFEDD5] text-[#9A3412] px-4 py-2 rounded-full text-xs font-bold mb-4 shadow-xs">
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-base">timer</span>
                                <span>Batas Waktu Pembayaran</span>
                            </div>
                            <span id="countdown" class="font-mono bg-white text-[#9A3412] px-3 py-0.5 rounded-full text-xs font-black shadow-xs">
                                --:--
                            </span>
                        </div>

                        {{-- White QRIS Card --}}
                        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/60 text-center">
                            {{-- Top QR Card Header --}}
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100 text-left">
                                <div>
                                    <span class="text-xs font-black text-rose-600 tracking-wider">QRIS</span>
                                    <span class="text-[11px] text-slate-400 ml-1">| Standar Pembayaran Nasional</span>
                                </div>
                                <span class="text-[11px] font-bold text-slate-700">GPN Indonesia</span>
                            </div>

                            {{-- Merchant Header --}}
                            <div class="my-3 text-center">
                                <h4 class="font-black text-xs text-slate-800 tracking-wider uppercase">
                                    MALANGVERSE DIGITAL NUSANTARA
                                </h4>
                                <p class="text-[10px] text-slate-400 font-mono mt-0.5">
                                    NMID : ID102039201923 • A01
                                </p>
                            </div>

                            {{-- QR Code Image Graphic (Dynamic from YoBasePay) --}}
                            <div class="my-3 flex items-center justify-center">
                                <div class="w-52 h-52 bg-white p-2.5 rounded-2xl border border-slate-100 flex items-center justify-center relative shadow-xs">
                                    @if (!empty($payment?->qr_code_url))
                                        <img src="{{ $payment->qr_code_url }}"
                                             alt="QRIS Realtime YoBasePay"
                                             class="w-full h-full object-contain rounded-lg"
                                             loading="eager" />
                                    @elseif (!empty($payment?->qr_string))
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($payment->qr_string) }}"
                                             alt="QRIS Realtime YoBasePay"
                                             class="w-full h-full object-contain rounded-lg" />
                                    @else
                                        {{-- Fallback SVG Placeholder --}}
                                        <div class="text-center p-4">
                                            <span class="material-symbols-outlined text-4xl text-slate-400 animate-spin">sync</span>
                                            <p class="text-xs text-slate-500 mt-2 font-medium">Memuat QRIS...</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- QR Instructions --}}
                            <p class="text-[11px] text-slate-500 max-w-xs mx-auto leading-relaxed mt-2">
                                Scan QRIS menggunakan <strong>M-Banking</strong> (BCA, Mandiri, BRI, BNI) atau <strong>E-Wallet</strong> (GoPay, OVO, ShopeePay, DANA) pilihan Anda.
                            </p>

                            {{-- Payment Provider Pills --}}
                            <div class="flex items-center justify-center gap-1.5 flex-wrap mt-3 pt-3 border-t border-slate-100 text-[10px]">
                                <span class="border border-slate-200 text-slate-700 font-semibold px-2.5 py-0.5 rounded-full bg-white">BCA mobile</span>
                                <span class="border border-slate-200 text-slate-700 font-semibold px-2.5 py-0.5 rounded-full bg-white">Livin' Mandiri</span>
                                <span class="border border-slate-200 text-slate-700 font-semibold px-2.5 py-0.5 rounded-full bg-white">GoPay</span>
                                <span class="border border-slate-200 text-slate-700 font-semibold px-2.5 py-0.5 rounded-full bg-white">OVO</span>
                                <span class="border border-slate-200 text-slate-700 font-semibold px-2.5 py-0.5 rounded-full bg-white">ShopeePay</span>
                                <span class="border border-slate-200 text-slate-700 font-semibold px-2.5 py-0.5 rounded-full bg-white">DANA</span>
                            </div>
                        </div>
                    </div>

                    {{-- Live Polling Status Pill --}}
                    <div id="statusPill" class="mt-4 flex items-center justify-center gap-2 bg-[#E0E7FF] text-[#1E40AF] px-4 py-2.5 rounded-full text-[11px] font-medium text-center transition-all">
                        <span id="statusIndicator" class="w-2.5 h-2.5 rounded-full bg-[#2563EB] animate-pulse shrink-0"></span>
                        <span id="statusMessage" class="truncate font-semibold">Menunggu pembayaran via QRIS Bank Indonesia...</span>
                    </div>
                </div>

            </div>

            {{-- Footer Modal --}}
            <div class="px-6 sm:px-8 py-4 bg-[#F8FAFC] border-t border-slate-100 flex items-center justify-between flex-wrap gap-4">
                <button type="button"
                        id="btnCancel"
                        onclick="cancelTransaction()"
                        class="text-xs sm:text-sm font-semibold text-slate-500 hover:text-rose-600 transition cursor-pointer">
                    Batalkan Transaksi
                </button>
                <button id="btnCheckManual"
                        type="button"
                        onclick="checkPaymentStatusNow()"
                        class="inline-flex items-center gap-2 bg-[#1341D1] hover:bg-blue-700 text-white px-5 sm:px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold shadow-md shadow-blue-500/20 transition cursor-pointer">
                    <span id="btnIcon" class="material-symbols-outlined text-base">sync</span>
                    <span>Cek Status Pembayaran</span>
                </button>
            </div>

        </div>
    </main>

    {{-- Footer Component --}}
    <x-guest.beranda-footer />

    {{-- Script Realtime Polling & Timer --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const txCode = "{{ $txCode }}";
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            let timeLeft = {{ $secondsRemaining }};
            const countdownEl = document.getElementById('countdown');
            let pollInterval = null;
            let isPaid = {{ isset($transaction) && $transaction->isPaid() ? 'true' : 'false' }};

            // 1. Timer Countdown
            function updateCountdownDisplay() {
                if (timeLeft <= 0) {
                    if (countdownEl) countdownEl.textContent = '00:00';
                    handleExpiredUI();
                    return;
                }
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                if (countdownEl) {
                    countdownEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                }
                timeLeft--;
            }

            updateCountdownDisplay();
            const countdownInterval = setInterval(updateCountdownDisplay, 1000);

            // 2. Polling Status Otomatis setiap 3 detik
            function pollPaymentStatus() {
                if (isPaid) return;

                fetch(`/api/payment/status/${txCode}`, {
                    headers: { 'Accept': 'application/json' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.is_paid || data.status === 'paid' || data.status === 'SUCCESS') {
                        handleSuccessUI();
                    } else if (data.status === 'expired') {
                        handleExpiredUI();
                    } else if (data.status === 'cancelled') {
                        handleCancelledUI();
                    }
                })
                .catch(() => {});
            }

            if (!isPaid && timeLeft > 0) {
                pollInterval = setInterval(pollPaymentStatus, 3000);
            } else if (isPaid) {
                handleSuccessUI();
            }

            // 3. Handle UI saat Pembayaran Sukses
            function handleSuccessUI() {
                isPaid = true;
                clearInterval(pollInterval);
                clearInterval(countdownInterval);

                const statusPill = document.getElementById('statusPill');
                const statusIndicator = document.getElementById('statusIndicator');
                const statusMessage = document.getElementById('statusMessage');
                const btnCheck = document.getElementById('btnCheckManual');
                const btnCancel = document.getElementById('btnCancel');

                if (statusPill) {
                    statusPill.className = 'mt-4 flex items-center justify-center gap-2 bg-emerald-100 text-emerald-800 px-4 py-2.5 rounded-full text-xs font-bold text-center';
                }
                if (statusIndicator) {
                    statusIndicator.className = 'w-2.5 h-2.5 rounded-full bg-emerald-600 shrink-0';
                }
                if (statusMessage) {
                    statusMessage.textContent = '✓ Pembayaran Berhasil Diverifikasi! Mengalihkan...';
                }
                if (btnCancel) btnCancel.style.display = 'none';
                if (btnCheck) {
                    btnCheck.disabled = true;
                    btnCheck.className = 'inline-flex items-center gap-2 bg-emerald-600 text-white px-6 py-2.5 rounded-full text-xs font-bold cursor-default';
                    btnCheck.innerHTML = '<span>Lunas & Aktif</span>';
                }

                setTimeout(() => {
                    @if ($isEbook)
                        window.location.href = "{{ route('kamus') }}";
                    @else
                        window.location.href = "{{ route('profile.index') }}";
                    @endif
                }, 1600);
            }

            // 4. Handle UI saat Expired
            function handleExpiredUI() {
                clearInterval(pollInterval);
                const statusPill = document.getElementById('statusPill');
                const statusIndicator = document.getElementById('statusIndicator');
                const statusMessage = document.getElementById('statusMessage');

                if (statusPill) {
                    statusPill.className = 'mt-4 flex items-center justify-center gap-2 bg-rose-100 text-rose-800 px-4 py-2.5 rounded-full text-xs font-bold text-center';
                }
                if (statusIndicator) {
                    statusIndicator.className = 'w-2.5 h-2.5 rounded-full bg-rose-600 shrink-0';
                }
                if (statusMessage) {
                    statusMessage.textContent = 'Waktu pembayaran telah habis (Kedaluwarsa).';
                }
            }

            function handleCancelledUI() {
                clearInterval(pollInterval);
                alert('Transaksi telah dibatalkan.');
                window.location.href = "{{ route('membership.public') }}";
            }

            // Global check button handler
            window.checkPaymentStatusNow = function () {
                const btn = document.getElementById('btnCheckManual');
                const icon = document.getElementById('btnIcon');
                if (btn) btn.disabled = true;
                if (icon) icon.classList.add('animate-spin');

                fetch(`/api/payment/status/${txCode}`, {
                    headers: { 'Accept': 'application/json' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.is_paid || data.status === 'paid' || data.status === 'SUCCESS') {
                        handleSuccessUI();
                    } else {
                        alert('Status saat ini: ' + data.status.toUpperCase() + '. Belum ada pembayaran masuk dari gateway.');
                    }
                })
                .finally(() => {
                    if (btn && !isPaid) btn.disabled = false;
                    if (icon) icon.classList.remove('animate-spin');
                });
            };

            // Global cancel transaction handler
            window.cancelTransaction = function () {
                if (!confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')) return;

                fetch(`/api/payment/cancel/${txCode}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.href = "{{ route('membership.public') }}";
                    } else {
                        alert(data.message || 'Gagal membatalkan transaksi.');
                    }
                });
            };
        });
    </script>

</body>
</html>
