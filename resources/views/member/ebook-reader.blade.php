<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Baca {{ $ebook->judul }} - MalangVerse</title>
    @vite(['resources/css/guest.css', 'resources/js/guest.js'])
</head>
<body class="h-dvh min-h-screen overflow-hidden bg-[#101827] font-sans text-slate-100">
    @php
        $ebookPrice = $ebook->licensePrice();
        $initialPageIsLocked = $currentPage > $previewPages;
        $previewBackgroundPage = max(1, min(max($previewPages, 1), $currentPage));
    @endphp

    <div class="flex h-dvh flex-col">
        <header class="z-20 flex h-14 shrink-0 items-center justify-between gap-3 border-b border-slate-700 bg-[#1e293b] px-3 sm:px-5">
            <div class="flex min-w-0 items-center gap-3">
                <a href="{{ route('kamus') }}" class="inline-flex shrink-0 items-center gap-2 text-xs font-semibold text-slate-300 transition hover:text-white sm:text-sm">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"></path>
                    </svg>
                    <span class="hidden sm:inline">Kembali ke Katalog</span>
                    <span class="sm:hidden">Kembali</span>
                </a>
                <span class="hidden h-6 w-px bg-slate-600 sm:block"></span>
                <div class="flex min-w-0 items-center gap-2">
                    <svg class="hidden h-4 w-4 shrink-0 text-slate-300 sm:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5zM4 5.5v16M8 7h8M8 10h8"></path>
                    </svg>
                    <h1 class="truncate text-xs font-bold text-white sm:text-sm">{{ $ebook->judul }}</h1>
                    @if (! $previewAvailable)
                        <span class="shrink-0 rounded-full bg-rose-500/15 px-2 py-0.5 text-[9px] font-bold text-rose-300 sm:text-[10px]">PDF BELUM ADA</span>
                    @elseif ($previewPages > 0)
                        <span class="shrink-0 rounded-full bg-amber-400/15 px-2 py-0.5 text-[9px] font-bold text-amber-300 sm:text-[10px]">PREVIEW</span>
                    @endif
                </div>
            </div>

            <div class="flex shrink-0 items-center gap-2">
                <button id="previous-page" type="button" aria-label="Halaman sebelumnya" class="rounded-full border border-slate-600 p-2 text-slate-300 transition hover:bg-slate-700 disabled:cursor-not-allowed disabled:opacity-40">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6"></path>
                    </svg>
                </button>
                <span id="page-indicator" class="min-w-[94px] text-center text-[10px] font-semibold text-slate-300 sm:min-w-[120px] sm:text-xs">
                    Halaman {{ $currentPage }} dari {{ $totalPages }}
                </span>
                <button id="next-page" type="button" aria-label="Halaman berikutnya" class="rounded-full border border-slate-600 p-2 text-slate-300 transition hover:bg-slate-700 disabled:cursor-not-allowed disabled:opacity-40">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"></path>
                    </svg>
                </button>
            </div>
        </header>

        <div class="flex min-h-0 flex-1">
            <aside id="reader-sidebar" class="hidden w-56 shrink-0 flex-col border-r-2 border-dotted border-blue-500 bg-[#1e293b] transition-[width] duration-200 lg:flex">
                <div id="reader-sidebar-header" class="flex h-14 shrink-0 items-center justify-between border-b border-slate-700 px-3">
                    <p id="reader-sidebar-title" class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-300">Daftar Isi</p>
                    <button id="toggle-reader-sidebar" type="button" aria-label="Ciutkan daftar isi" aria-controls="reader-sidebar-content" aria-expanded="true" class="grid h-8 w-8 shrink-0 place-items-center rounded-lg text-slate-400 transition hover:bg-slate-700 hover:text-white">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <div id="reader-sidebar-content" class="flex min-h-0 flex-1 flex-col">
                    <div class="border-b border-slate-700/80 px-4 py-3">
                        <p class="truncate text-xs font-bold text-white">{{ $ebook->judul }}</p>
                        <p class="mt-1 text-[10px] text-slate-400">Pilih halaman untuk membaca pratinjau.</p>
                    </div>

                    <nav aria-label="Navigasi halaman E-Book" class="min-h-0 flex-1 space-y-2 overflow-y-auto p-3">
                        @for ($page = 1; $page <= $previewPages; $page++)
                            <button type="button" data-page="{{ $page }}" @disabled(! $previewAvailable)
                                    class="page-navigation-item flex w-full items-center gap-3 rounded-xl border border-slate-700 px-3 py-2.5 text-left transition hover:border-blue-500 hover:bg-slate-700/70 disabled:cursor-not-allowed disabled:opacity-50">
                                <span aria-hidden="true" class="flex h-12 w-9 shrink-0 flex-col gap-1 rounded bg-white p-1.5 shadow">
                                    <span class="h-1 w-2/3 rounded bg-blue-400"></span>
                                    <span class="h-0.5 w-full rounded bg-slate-200"></span>
                                    <span class="h-0.5 w-full rounded bg-slate-200"></span>
                                    <span class="h-0.5 w-4/5 rounded bg-slate-200"></span>
                                    <span class="h-0.5 w-full rounded bg-slate-200"></span>
                                    <span class="h-0.5 w-3/4 rounded bg-slate-200"></span>
                                </span>
                                <span class="min-w-0">
                                    <span class="block text-xs font-semibold text-slate-200">Halaman {{ $page }}</span>
                                    <span class="mt-0.5 block text-[10px] text-slate-400">Pratinjau tersedia</span>
                                </span>
                            </button>
                        @endfor

                        @if ($totalPages > $previewPages)
                            <button type="button" data-page="{{ $previewPages + 1 }}"
                                    class="page-navigation-item flex w-full items-center gap-3 rounded-xl border border-blue-500/70 bg-blue-500/5 px-3 py-2.5 text-left transition hover:bg-blue-500/10">
                                <span aria-hidden="true" class="grid h-12 w-9 shrink-0 place-items-center rounded bg-slate-700 text-slate-300">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <rect x="5" y="10" width="14" height="11" rx="2"></rect>
                                        <path stroke-linecap="round" d="M8 10V7a4 4 0 0 1 8 0v3"></path>
                                    </svg>
                                </span>
                                <span class="min-w-0">
                                    <span class="block text-xs font-semibold text-slate-200">Halaman {{ $previewPages + 1 }}</span>
                                    <span class="mt-0.5 block text-[10px] text-amber-300">Batas pratinjau</span>
                                </span>
                            </button>
                        @endif
                    </nav>

                    <div class="border-t border-slate-700 px-4 py-4">
                        <div class="flex items-center justify-between text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                            <span>Halaman Pratinjau</span>
                            <span>{{ $previewPages }} / {{ $totalPages }}</span>
                        </div>
                        <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-700">
                            <div class="h-full rounded-full bg-blue-500" style="width: {{ $totalPages > 0 ? min(100, ($previewPages / $totalPages) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </aside>

            <main class="min-w-0 flex-1 overflow-y-auto bg-[#0f172a] px-3 py-3 sm:px-6 sm:py-5">
                <div class="mx-auto flex min-h-full w-full max-w-[1050px] items-center justify-center">
                    <section class="relative h-[calc(100dvh-5.5rem)] min-h-[420px] max-h-[950px] w-full overflow-hidden rounded-2xl bg-white shadow-2xl shadow-black/30 sm:rounded-[26px]">
                        @if ($previewAvailable)
                            <iframe
                                id="ebook-page"
                                title="Halaman pratinjau {{ $ebook->judul }}"
                                src="{{ route('ebook.reader.page', [$ebook, $initialPageIsLocked ? $previewBackgroundPage : $currentPage]) }}"
                                class="{{ $initialPageIsLocked ? 'blur-sm opacity-40' : '' }} h-full w-full border-0 bg-white transition duration-300"
                            ></iframe>

                            <div id="preview-locked" class="{{ $initialPageIsLocked ? 'flex' : 'hidden' }} absolute inset-0 z-10 items-center justify-center bg-slate-950/60 p-5 text-center backdrop-blur-md">
                                <div class="flex max-w-md flex-col items-center gap-4">
                                    <span class="grid h-12 w-12 place-items-center rounded-full bg-blue-500/20 text-blue-200">
                                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <rect x="5" y="10" width="14" height="11" rx="2"></rect>
                                            <path stroke-linecap="round" d="M8 10V7a4 4 0 0 1 8 0v3"></path>
                                        </svg>
                                    </span>
                                    <span class="rounded-full bg-amber-400/20 px-3 py-1 text-[10px] font-bold uppercase tracking-wide text-amber-300">Akses Terbatas</span>
                                    <div>
                                        <h2 class="text-lg font-extrabold text-white sm:text-xl">Batas Pratinjau {{ $previewPages }} Halaman Tercapai</h2>
                                        <p class="mt-2 text-xs leading-relaxed text-slate-300 sm:text-sm">
                                            Kamu telah melihat {{ $previewPages }} halaman pratinjau. Beli versi lengkap untuk membuka seluruh {{ $totalPages }} halaman.
                                        </p>
                                    </div>
                                    <button id="start-purchase" type="button" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#3f5bff] px-5 py-3 text-xs font-bold text-white shadow-lg shadow-blue-950/30 transition hover:bg-blue-500 disabled:cursor-wait disabled:opacity-60 sm:text-sm">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l2.2 11.2a2 2 0 0 0 2 1.6h8.9a2 2 0 0 0 2-1.6L22 7H6M10 21h.01M18 21h.01"></path>
                                        </svg>
                                        Buka Versi Lengkap Sekarang (Rp {{ number_format($ebookPrice, 0, ',', '.') }})
                                    </button>
                                    <p class="text-[10px] text-slate-400">Pembayaran aman melalui YoBasePay.</p>
                                </div>
                            </div>
                        @else
                            <div id="document-unavailable" class="relative h-full overflow-hidden bg-slate-200">
                                <div aria-hidden="true" class="absolute inset-5 flex justify-center overflow-hidden opacity-60 blur-sm">
                                    <div class="h-full w-full max-w-[740px] bg-white p-8 shadow-lg sm:p-12">
                                        <div class="mx-auto flex h-full max-w-xl flex-col items-center gap-5 pt-10">
                                            <span class="h-3 w-2/5 rounded bg-slate-300"></span>
                                            <span class="h-1.5 w-1/3 rounded bg-slate-200"></span>
                                            <div class="mt-8 flex w-full flex-col gap-3">
                                                <span class="h-1.5 w-full rounded bg-slate-200"></span>
                                                <span class="h-1.5 w-11/12 rounded bg-slate-200"></span>
                                                <span class="h-1.5 w-full rounded bg-slate-200"></span>
                                                <span class="h-1.5 w-10/12 rounded bg-slate-200"></span>
                                                <span class="h-1.5 w-full rounded bg-slate-200"></span>
                                                <span class="h-1.5 w-9/12 rounded bg-slate-200"></span>
                                                <span class="h-1.5 w-full rounded bg-slate-200"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute inset-0 flex flex-col items-center justify-center gap-4 bg-slate-950/65 px-6 text-center backdrop-blur-md">
                                    <span class="grid h-12 w-12 place-items-center rounded-full bg-blue-500/20 text-blue-200">
                                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <rect x="5" y="10" width="14" height="11" rx="2"></rect>
                                            <path stroke-linecap="round" d="M8 10V7a4 4 0 0 1 8 0v3"></path>
                                        </svg>
                                    </span>
                                    <span class="rounded-full bg-amber-400/20 px-3 py-1 text-[10px] font-bold uppercase tracking-wide text-amber-300">PDF Belum Tersedia</span>
                                    <div class="max-w-md">
                                        <h2 class="text-lg font-extrabold text-white sm:text-xl">Dokumen PDF belum tersedia</h2>
                                        <p class="mt-2 text-xs leading-relaxed text-slate-300 sm:text-sm">
                                            Berkas sumber untuk E-Book ini belum diunggah. Silakan hubungi admin; pembelian akan tersedia setelah dokumen siap.
                                        </p>
                                    </div>
                                    <a href="{{ route('kamus') }}" class="inline-flex items-center justify-center rounded-full bg-[#3f5bff] px-5 py-3 text-xs font-bold text-white shadow-lg shadow-blue-950/30 transition hover:bg-blue-500 sm:text-sm">
                                        Kembali ke katalog
                                    </a>
                                </div>
                            </div>
                        @endif
                    </section>
                </div>
            </main>
        </div>
    </div>

    <div id="payment-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/75 p-3 backdrop-blur-sm sm:p-6" role="dialog" aria-modal="true" aria-labelledby="payment-title" aria-hidden="true">
        <div class="grid max-h-[94dvh] w-full max-w-4xl overflow-y-auto rounded-3xl bg-white text-slate-900 shadow-2xl md:grid-cols-2 md:overflow-hidden">
            <section class="flex flex-col justify-between bg-indigo-50 p-5 sm:p-7">
                <div>
                    <div class="flex items-center gap-2 text-lg font-extrabold tracking-tight text-[#1e40af]">
                        <span class="grid h-8 w-8 place-items-center rounded-full bg-[#1e40af] text-white">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5zM4 5.5v16M8 7h8"></path>
                            </svg>
                        </span>
                        MalangVerse <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[9px] font-bold uppercase text-blue-700">E-Library</span>
                    </div>
                    <p class="mt-8 text-[10px] font-bold uppercase tracking-[0.16em] text-slate-500">Ringkasan Pesanan</p>
                    <h2 id="payment-title" class="mt-2 text-lg font-extrabold leading-snug text-slate-900">{{ $ebook->judul }}</h2>
                    <p class="mt-1 text-xs leading-relaxed text-slate-500">Lisensi akses digital pribadi dan komunitas.</p>

                    <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <p class="text-[10px] font-medium text-slate-500">Total Pembayaran</p>
                        <p id="ebook-payment-total" class="mt-1 text-2xl font-black text-slate-900">Rp {{ number_format($ebookPrice, 0, ',', '.') }}</p>
                        <p class="mt-2 text-[10px] text-emerald-700">Biaya mengikuti metode pembayaran yang dipilih.</p>
                    </div>

                    <div class="mt-6">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-500">Fitur yang didapat</p>
                        <ul class="mt-3 space-y-2 text-xs text-slate-700">
                            <li class="flex gap-2"><span class="font-bold text-blue-600">✓</span> Akses seluruh {{ $totalPages }} halaman E-Book</li>
                            <li class="flex gap-2"><span class="font-bold text-blue-600">✓</span> Bisa dibaca kembali kapan saja</li>
                            <li class="flex gap-2"><span class="font-bold text-blue-600">✓</span> Pembayaran melalui YoBasePay</li>
                        </ul>
                    </div>
                </div>
                <p class="mt-6 text-[10px] text-slate-400">Lisensi digital MalangVerse</p>
            </section>

            <section class="flex flex-col p-5 sm:p-7">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-extrabold italic text-rose-600">YOBASEPAY</p>
                        <p class="text-[10px] text-slate-500">Pilih metode pembayaran yang tersedia</p>
                        <p id="payment-invoice" class="mt-1 text-[9px] text-slate-400">Invoice akan muncul setelah transaksi dibuat.</p>
                    </div>
                    <div class="flex items-center gap-1.5 rounded-full bg-rose-50 px-3 py-1.5 text-[10px] font-bold text-rose-600">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path stroke-linecap="round" d="M12 7v5l3 2"></path>
                        </svg>
                        <span id="payment-countdown">Berlaku 15:00</span>
                    </div>
                    <button id="close-payment" type="button" aria-label="Tutup pembayaran" class="rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"></path>
                        </svg>
                    </button>
                </div>

                <div id="payment-qr-container" class="my-5 flex min-h-56 flex-1 items-center justify-center rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="text-xs font-medium text-slate-500">Instruksi pembayaran akan dimuat setelah transaksi dibuat.</p>
                </div>

                <p class="text-center text-[10px] leading-relaxed text-slate-500">
                Pilih metode pembayaran di halaman YoBasePay, lalu kembali untuk melihat status transaksi.
                </p>

                <div id="payment-status" class="mt-4 flex items-center justify-center gap-2 rounded-full bg-indigo-50 px-4 py-2.5 text-center text-[10px] font-semibold text-blue-800" role="status" aria-live="polite">
                    <span class="h-2 w-2 shrink-0 rounded-full bg-blue-600"></span>
                    <span id="payment-status-message">Menunggu transaksi...</span>
                </div>

                <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                    <button id="cancel-payment" type="button" class="text-[11px] font-semibold text-slate-500 transition hover:text-rose-600">Tutup / Batal</button>
                    <button id="check-payment" type="button" class="inline-flex items-center gap-2 rounded-full bg-[#3f5bff] px-4 py-2.5 text-[11px] font-bold text-white shadow-sm transition hover:bg-blue-700 disabled:cursor-wait disabled:opacity-60">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7v5h-5M4 17v-5h5m-4.1-3A8 8 0 0 1 18 6l2 2M4 16l2 2a8 8 0 0 0 13.1-3"></path>
                        </svg>
                        Cek Status Pembayaran
                    </button>
                </div>
            </section>
        </div>
    </div>

    <script>
        const previewLimit = @js($previewPages);
        const totalPages = @js($totalPages);
        const previewFileAvailable = @js($previewAvailable);
        const pageUrlTemplate = @js(route('ebook.reader.page', [$ebook, '__PAGE__']));
        const purchaseUrl = @js(route('ebook.purchase', $ebook));
        const paymentStatusUrlTemplate = @js(route('payment.status', '__TRANSACTION_CODE__'));
        const paymentCancelUrlTemplate = @js(route('payment.cancel', '__TRANSACTION_CODE__'));
        const fullReadUrl = @js(route('ebook.read', $ebook));
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const pageFrame = document.getElementById('ebook-page');
        const lockedNotice = document.getElementById('preview-locked');
        const readerSidebar = document.getElementById('reader-sidebar');
        const readerSidebarHeader = document.getElementById('reader-sidebar-header');
        const readerSidebarTitle = document.getElementById('reader-sidebar-title');
        const readerSidebarContent = document.getElementById('reader-sidebar-content');
        const readerSidebarToggle = document.getElementById('toggle-reader-sidebar');
        const pageIndicator = document.getElementById('page-indicator');
        const previousButton = document.getElementById('previous-page');
        const nextButton = document.getElementById('next-page');
        const navigationItems = document.querySelectorAll('.page-navigation-item');
        const paymentModal = document.getElementById('payment-modal');
        const startPurchaseButton = document.getElementById('start-purchase');
        const paymentQrContainer = document.getElementById('payment-qr-container');
        const paymentStatusMessage = document.getElementById('payment-status-message');
        const paymentCountdown = document.getElementById('payment-countdown');
        const paymentInvoice = document.getElementById('payment-invoice');
        const checkPaymentButton = document.getElementById('check-payment');
        const cancelPaymentButton = document.getElementById('cancel-payment');
        let currentPage = @js($currentPage);
        let activeTransactionCode = null;
        let paymentExpiresAt = null;
        let paymentPollingTimer = null;
        let paymentCountdownTimer = null;
        let isCheckingPayment = false;

        function setPaymentStatus(message, isError = false) {
            paymentStatusMessage.textContent = message;
            const status = document.getElementById('payment-status');
            status.classList.toggle('bg-rose-50', isError);
            status.classList.toggle('text-rose-700', isError);
            status.classList.toggle('bg-indigo-50', !isError);
            status.classList.toggle('text-blue-800', !isError);
        }

        function showPaymentModal() {
            paymentModal.classList.remove('hidden');
            paymentModal.classList.add('flex');
            paymentModal.setAttribute('aria-hidden', 'false');
        }

        function hidePaymentModal() {
            paymentModal.classList.add('hidden');
            paymentModal.classList.remove('flex');
            paymentModal.setAttribute('aria-hidden', 'true');
        }

        function updatePageNavigation() {
            navigationItems.forEach((item) => {
                const isCurrentPage = Number(item.dataset.page) === currentPage;
                item.classList.toggle('border-blue-500', isCurrentPage);
                item.classList.toggle('bg-blue-500/10', isCurrentPage);
                item.setAttribute('aria-current', isCurrentPage ? 'page' : 'false');
            });
        }

        function showPage(page) {
            currentPage = Math.max(1, Math.min(page, totalPages));
            const isLocked = currentPage > previewLimit;

            pageIndicator.textContent = `Halaman ${currentPage} dari ${totalPages}`;
            previousButton.disabled = currentPage <= 1;
            nextButton.disabled = currentPage >= totalPages;
            updatePageNavigation();

            if (!previewFileAvailable || !pageFrame || !lockedNotice) {
                return;
            }

            pageFrame.classList.toggle('blur-sm', isLocked);
            pageFrame.classList.toggle('opacity-40', isLocked);
            lockedNotice.classList.toggle('hidden', !isLocked);
            lockedNotice.classList.toggle('flex', isLocked);
            pageFrame.src = pageUrlTemplate.replace('__PAGE__', isLocked ? previewLimit : currentPage);
        }

        function renderQrCode(data) {
            paymentQrContainer.replaceChildren();

            if (typeof data.checkout_url === 'string' && data.checkout_url !== '') {
                const checkoutUrl = new URL(data.checkout_url, window.location.origin);
                if (checkoutUrl.protocol !== 'https:') {
                    throw new Error('Halaman pembayaran harus menggunakan HTTPS.');
                }

                const link = document.createElement('a');
                link.href = checkoutUrl.toString();
                link.target = '_blank';
                link.rel = 'noopener noreferrer';
                link.className = 'rounded-full bg-blue-700 px-5 py-3 text-xs font-bold text-white transition hover:bg-blue-800';
                link.textContent = 'Pilih Metode Pembayaran';
                paymentQrContainer.append(link);
                return;
            }

            if (typeof data.qr_image === 'string' && data.qr_image !== '') {
                const imageUrl = new URL(data.qr_image, window.location.origin);
                if (!['https:', 'http:'].includes(imageUrl.protocol)) {
                    throw new Error('Alamat gambar pembayaran tidak valid.');
                }

                const image = document.createElement('img');
                image.src = imageUrl.toString();
                image.alt = 'Kode QRIS pembayaran E-Book';
                image.className = 'h-52 w-52 object-contain';
                image.addEventListener('error', () => {
                    paymentQrContainer.textContent = 'Gambar pembayaran gagal dimuat. Coba cek status atau ulangi transaksi.';
                }, { once: true });
                paymentQrContainer.append(image);
                return;
            }

            if (typeof data.qr_string === 'string' && data.qr_string !== '') {
                const content = document.createElement('div');
                content.className = 'max-w-full text-center';

                const label = document.createElement('p');
                label.className = 'text-xs font-semibold text-slate-700';
                label.textContent = 'QRIS tersedia dalam format teks.';

                const code = document.createElement('code');
                code.className = 'mt-2 block max-h-24 max-w-full overflow-auto break-all rounded-lg bg-slate-100 p-2 text-[9px] text-slate-600';
                code.textContent = data.qr_string;

                const copyButton = document.createElement('button');
                copyButton.type = 'button';
                copyButton.className = 'mt-2 rounded-full bg-blue-700 px-3 py-1.5 text-xs font-bold text-white';
                copyButton.textContent = 'Salin kode QRIS';
                copyButton.addEventListener('click', async () => {
                    try {
                        await navigator.clipboard.writeText(data.qr_string);
                        setPaymentStatus('Kode pembayaran berhasil disalin.');
                    } catch (error) {
                        setPaymentStatus('Kode pembayaran tidak dapat disalin dari browser ini.', true);
                    }
                });

                content.append(label, code, copyButton);
                paymentQrContainer.append(content);
                return;
            }

            const message = document.createElement('p');
            message.className = 'text-center text-xs font-medium text-rose-600';
            message.textContent = 'Detail pembayaran dari gateway belum tersedia.';
            paymentQrContainer.append(message);
        }

        function stopPaymentTimers() {
            if (paymentPollingTimer) {
                window.clearInterval(paymentPollingTimer);
                paymentPollingTimer = null;
            }
            if (paymentCountdownTimer) {
                window.clearInterval(paymentCountdownTimer);
                paymentCountdownTimer = null;
            }
        }

        function updatePaymentCountdown() {
            if (!paymentExpiresAt) {
                return;
            }

            const secondsRemaining = Math.max(0, Math.ceil((paymentExpiresAt.getTime() - Date.now()) / 1000));
            const minutes = Math.floor(secondsRemaining / 60).toString().padStart(2, '0');
            const seconds = (secondsRemaining % 60).toString().padStart(2, '0');
            paymentCountdown.textContent = `Berlaku ${minutes}:${seconds}`;

            if (secondsRemaining === 0) {
                stopPaymentTimers();
                setPaymentStatus('Waktu pembayaran telah berakhir. Silakan ulangi transaksi.', true);
            }
        }

        async function checkPaymentStatus() {
            if (!activeTransactionCode || isCheckingPayment) {
                return;
            }

            isCheckingPayment = true;
            checkPaymentButton.disabled = true;

            try {
                const url = paymentStatusUrlTemplate.replace('__TRANSACTION_CODE__', encodeURIComponent(activeTransactionCode));
                const response = await fetch(url, { headers: { Accept: 'application/json' } });
                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Status pembayaran gagal diperiksa.');
                }

                const status = String(data.status || '').toLowerCase();
                if (data.is_paid || status === 'paid' || status === 'success') {
                    stopPaymentTimers();
                    setPaymentStatus('Pembayaran berhasil. Membuka E-Book lengkap...');
                    window.setTimeout(() => window.location.assign(fullReadUrl), 900);
                } else if (['expired', 'cancelled', 'failed'].includes(status)) {
                    stopPaymentTimers();
                    setPaymentStatus('Transaksi tidak aktif. Silakan buat pembayaran baru.', true);
                    activeTransactionCode = null;
                } else {
                    setPaymentStatus(data.checkout_url ? 'Selesaikan pembayaran di halaman YoBasePay...' : 'Menunggu pembayaran...');
                }
            } catch (error) {
                setPaymentStatus(error instanceof Error ? error.message : 'Status pembayaran gagal diperiksa.', true);
            } finally {
                isCheckingPayment = false;
                checkPaymentButton.disabled = false;
            }
        }

        async function startPurchase() {
            if (activeTransactionCode) {
                showPaymentModal();
                return;
            }

            showPaymentModal();
            document.getElementById('ebook-payment-total').textContent =
                `Rp ${Number(@json($ebookPrice)).toLocaleString('id-ID')}`;
            paymentQrContainer.textContent = 'Menghubungkan ke gateway pembayaran...';
            setPaymentStatus('Membuat tagihan pembayaran...');
            startPurchaseButton.disabled = true;

            try {
                const response = await fetch(purchaseUrl, {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({}),
                });
                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Transaksi pembayaran gagal dibuat.');
                }

                activeTransactionCode = data.transaction_code;
                paymentInvoice.textContent = `Invoice: ${data.transaction_code}`;
                renderQrCode(data);
                const amountToPay = Number(data.amount_to_pay);
                if (Number.isFinite(amountToPay) && amountToPay >= Number(data.amount)) {
                    document.getElementById('ebook-payment-total').textContent =
                        `Rp ${amountToPay.toLocaleString('id-ID')}`;
                }
                setPaymentStatus(data.checkout_url ? 'Selesaikan pembayaran di halaman YoBasePay...' : 'Menunggu pembayaran...');

                const expiry = data.expired_at ? new Date(data.expired_at.replace(' ', 'T')) : new Date(Date.now() + 15 * 60 * 1000);
                paymentExpiresAt = Number.isNaN(expiry.getTime()) ? new Date(Date.now() + 15 * 60 * 1000) : expiry;
                updatePaymentCountdown();
                paymentCountdownTimer = window.setInterval(updatePaymentCountdown, 1000);
                paymentPollingTimer = window.setInterval(checkPaymentStatus, 5000);
            } catch (error) {
                paymentQrContainer.textContent = 'Instruksi pembayaran belum dapat dimuat.';
                setPaymentStatus(error instanceof Error ? error.message : 'Transaksi gagal dibuat.', true);
            } finally {
                startPurchaseButton.disabled = false;
            }
        }

        async function cancelPayment() {
            if (!activeTransactionCode) {
                hidePaymentModal();
                return;
            }

            cancelPaymentButton.disabled = true;
            try {
                const url = paymentCancelUrlTemplate.replace('__TRANSACTION_CODE__', encodeURIComponent(activeTransactionCode));
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });
                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Transaksi tidak dapat dibatalkan.');
                }

                activeTransactionCode = null;
                stopPaymentTimers();
                setPaymentStatus('Transaksi berhasil dibatalkan.');
                hidePaymentModal();
            } catch (error) {
                setPaymentStatus(error instanceof Error ? error.message : 'Transaksi tidak dapat dibatalkan.', true);
            } finally {
                cancelPaymentButton.disabled = false;
            }
        }

        previousButton.addEventListener('click', () => showPage(currentPage - 1));
        nextButton.addEventListener('click', () => showPage(currentPage + 1));
        navigationItems.forEach((item) => {
            item.addEventListener('click', () => showPage(Number(item.dataset.page)));
        });
        readerSidebarToggle.addEventListener('click', () => {
            const shouldCollapse = readerSidebarToggle.getAttribute('aria-expanded') === 'true';

            readerSidebar.classList.toggle('w-56', !shouldCollapse);
            readerSidebar.classList.toggle('w-14', shouldCollapse);
            readerSidebarHeader.classList.toggle('justify-between', !shouldCollapse);
            readerSidebarHeader.classList.toggle('justify-center', shouldCollapse);
            readerSidebarTitle.classList.toggle('hidden', shouldCollapse);
            readerSidebarContent.classList.toggle('hidden', shouldCollapse);
            readerSidebarToggle.setAttribute('aria-expanded', String(!shouldCollapse));
            readerSidebarToggle.setAttribute('aria-label', shouldCollapse ? 'Perluas daftar isi' : 'Ciutkan daftar isi');
        });
        if (startPurchaseButton) {
            startPurchaseButton.addEventListener('click', startPurchase);
        }
        document.getElementById('close-payment').addEventListener('click', hidePaymentModal);
        document.getElementById('check-payment').addEventListener('click', checkPaymentStatus);
        cancelPaymentButton.addEventListener('click', cancelPayment);
        paymentModal.addEventListener('click', (event) => {
            if (event.target === paymentModal) {
                hidePaymentModal();
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !paymentModal.classList.contains('hidden')) {
                hidePaymentModal();
            }
        });

        showPage(currentPage);
    </script>
</body>
</html>
