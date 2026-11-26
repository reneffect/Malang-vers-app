<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pratinjau Terbatas - MalangVerse</title>
    @vite(['resources/css/guest.css', 'resources/js/guest.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900">
    <x-guest.navbar />

    <main class="mx-auto flex min-h-[70vh] w-full max-w-3xl items-center justify-center px-4 py-12 sm:px-6">
        <section class="flex w-full max-w-lg flex-col items-center gap-5 rounded-3xl border border-slate-200 bg-white p-7 text-center shadow-sm sm:p-10">
            <svg class="h-12 w-12 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <rect x="4" y="10" width="16" height="11" rx="2"></rect>
                <path stroke-linecap="round" d="M8 10V7a4 4 0 0 1 8 0v3"></path>
            </svg>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Batas Pratinjau {{ $previewPages }} Halaman Tercapai</h1>
                <p class="mt-3 text-sm leading-relaxed text-slate-600">
                    @if ($previewAvailable)
                        Paket Anda dapat membaca {{ $previewPages }} halaman pertama. Beli versi lengkap {{ $ebook->judul }} untuk membuka seluruh buku.
                    @else
                        Berkas sumber untuk E-Book ini belum diunggah. Silakan hubungi admin; pembelian akan tersedia setelah dokumen siap.
                    @endif
                </p>
            </div>
            @if ($previewAvailable)
                <form action="{{ route('ebook.purchase', $ebook) }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-full bg-blue-700 px-5 py-3 text-sm font-bold text-white transition hover:bg-blue-800">
                        Beli versi lengkap
                    </button>
                </form>
            @else
                <p class="text-sm font-medium text-rose-700">Dokumen PDF belum tersedia. Silakan hubungi admin; pembelian sementara tidak dapat diproses.</p>
            @endif
            <a href="{{ route('ebook.reader', $ebook) }}" class="text-sm font-semibold text-blue-700 hover:text-blue-900">
                Kembali ke pratinjau
            </a>
        </section>
    </main>
</body>
</html>
