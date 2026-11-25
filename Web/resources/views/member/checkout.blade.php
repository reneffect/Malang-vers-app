<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - MalangVerse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/guest.css', 'resources/js/guest.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-book-open text-lg"></i>
                    </div>
                    <span class="font-bold text-gray-900 text-lg">MalangVerse</span>
                </div>
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('beranda') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600">Beranda</a>
                    <a href="{{ route('kamus') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600">E-Book</a>
                    <a href="{{ route('pricing') }}" class="text-sm font-medium text-blue-600 border-b-2 border-blue-600 pb-1">Membership</a>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg">Join</a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="relative bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-white/20 rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
            <h1 class="text-3xl font-extrabold mb-2">Paket Langganan Member Arema</h1>
            <p class="text-blue-100 text-sm max-w-2xl mx-auto">
                Pilih paket yang sesuai dengan kebutuhan. Nikmati akses tanpa batas ke kamus digital, e-book eksklusif, dan fitur premium lainnya.
            </p>
        </div>
    </section>

    {{-- Modal Pembayaran --}}
    <main class="max-w-4xl mx-auto px-4 py-8 -mt-8 relative z-10">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">

            {{-- Header Modal --}}
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-credit-card text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Pembayaran Paket Langganan</h2>
                        <p class="text-xs text-gray-500">Selesaikan pembayaran dalam 15 menit untuk mengaktifkan paket</p>
                    </div>
                </div>
                <button onclick="window.history.back()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Detail Paket --}}
                <div>
                    <h3 class="text-base font-bold text-gray-900 mb-4">
                        {{ $tier->name }} ({{ $billing === 'yearly' ? 'Tahunan' : 'Bulanan' }})
                    </h3>
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Paket Langganan Premium</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Akses Tanpa Batas ke Kamus</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Simpan 500+ Frasa</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>E-Book Eksklusif</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Harga Paket</span>
                            <span class="text-sm font-semibold">Rp {{ number_format($price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Pajak (0%)</span>
                            <span class="text-sm font-semibold">Rp 0</span>
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                            <span class="text-base font-bold text-gray-900">Total Bayar</span>
                            <span class="text-2xl font-extrabold text-blue-600">Rp {{ number_format($price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                            <div class="text-xs text-blue-700">
                                <p class="font-semibold mb-1">Catatan:</p>
                                <p>Pembayaran akan diproses otomatis melalui QRIS. Setelah pembayaran berhasil, paket akan aktif dalam 1-2 menit.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- QRIS Code --}}
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-qrcode text-blue-600 text-xl"></i>
                            <span class="font-bold text-gray-900">Scan QRIS</span>
                        </div>
                        <span class="text-xs font-semibold px-2 py-1 bg-orange-100 text-orange-700 rounded-full">QRIS</span>
                    </div>

                    {{-- Timer Countdown --}}
                    <div class="mb-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span>Selesaikan pembayaran dalam:</span>
                        </div>
                        <div id="countdown" class="text-2xl font-bold text-red-600 font-mono">14:59</div>
                    </div>

                    {{-- QR Code (dummy) --}}
                    <div class="bg-white rounded-lg p-4 mb-4 border border-gray-200">
                        <div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-qrcode text-6xl text-gray-400 mb-2"></i>
                                <p class="text-xs text-gray-500">QRIS Code</p>
                                <p class="text-xs font-mono text-gray-700 mt-2">00020101021126610016COM.NOBUBANK.WWW01189360050300000000015204581253033605802ID5925MALANGVERSE DIGITAL PUB6007MALANG61056514862070703A016304</p>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Pembayaran --}}
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Nomor Virtual Account</span>
                            <span class="font-mono font-semibold text-gray-900">8808-0857-1234-5678</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Kode Pembayaran</span>
                            <span class="font-mono font-semibold text-gray-900">MV-{{ strtoupper(substr(md5($tier->id . now()), 0, 8)) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Metode</span>
                            <span class="font-semibold text-gray-900">QRIS (Semua Bank)</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
                        <i class="fas fa-shield-alt text-green-500"></i>
                        <span>Pembayaran aman & terenkripsi SSL 256-bit</span>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="grid grid-cols-2 gap-3">
                        <button class="px-4 py-2.5 border border-gray-200 hover:border-blue-500 text-gray-700 hover:text-blue-600 text-sm font-semibold rounded-lg transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-download"></i> Unduh Invoice
                        </button>
                        <button class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i> Lihat Status
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center">
            <p class="text-sm text-gray-500">© 2026 MalangVerse. All rights reserved.</p>
        </div>
    </footer>

    {{-- Script Countdown --}}
    <script>
        // Timer 15 menit
        let timeLeft = 15 * 60; // 900 detik
        const countdownEl = document.getElementById('countdown');

        const timer = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            countdownEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (timeLeft <= 0) {
                clearInterval(timer);
                countdownEl.textContent = '00:00';
                countdownEl.classList.add('text-gray-400');
                countdownEl.classList.remove('text-red-600');
                alert('Waktu pembayaran habis. Silakan refresh halaman untuk membuat pembayaran baru.');
            }

            timeLeft--;
        }, 1000);
    </script>
</body>
</html>