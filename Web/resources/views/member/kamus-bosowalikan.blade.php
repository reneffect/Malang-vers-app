<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamus Boso Walikan - MulangVerse</title>
    @vite(['resources/css/guest.css', 'resources/js/guest.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased">

    {{-- Panggil Navbar (sesuaikan jika nama component berbeda) --}}
    <x-guest.navbar />

    {{-- HERO SECTION --}}
    <section class="page-hero">
        <div class="page-hero-content max-w-6xl mx-auto text-center py-12 md:py-14 px-4">
            <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm px-4 py-1 rounded-full text-xs font-semibold mb-5 border border-white/25">
                <i class="fas fa-book-open"></i> KOLEKSI LENGKAP
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-3">Kamus Boso Walikan</h1>
            <p class="text-blue-100 max-w-2xl mx-auto mb-7 text-sm md:text-base">
                Koleksi komprehensif kamus Boso Walikan khas Malang dalam format e-book, 
                mulai dari tingkat dasar hingga mahir.
            </p>
            
            {{-- Search Bar --}}
            <form action="{{ route('kamus') }}" method="GET" class="max-w-2xl mx-auto relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari kamus... (contoh: kamus alit, percakapan)" 
                       class="w-full py-4 px-6 rounded-full text-gray-800 shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-500/30 text-base">
                <button type="submit" class="absolute right-2 top-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-full font-semibold transition-colors">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
            </form>
        </div>
    </section>

    {{-- MAIN CONTENT --}}
    <main class="max-w-6xl mx-auto px-4 py-12">
        
        {{-- Header & Filter --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Produk Unggulan E-Book Kamus Boso Walikan</h2>
                <p class="text-gray-500 mt-1">Pilih koleksi kamus yang sesuai dengan kebutuhan belajar kamu.</p>
            </div>
            
            <div class="flex gap-2 overflow-x-auto pb-2">
                <a href="{{ route('kamus', ['category' => 'semua']) }}" 
                   class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-colors {{ $category === 'semua' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-blue-500' }}">
                    Semua E-Book
                </a>
                <a href="{{ route('kamus', ['category' => 'pemula']) }}" 
                   class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-colors {{ $category === 'pemula' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-blue-500' }}">
                    Kamus Pemula
                </a>
                <a href="{{ route('kamus', ['category' => 'lengkap']) }}" 
                   class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-colors {{ $category === 'lengkap' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-blue-500' }}">
                    Kamus Lengkap
                </a>
            </div>
        </div>

        {{-- Grid Buku --}}
        <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse ($books as $book)
                <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                    <div class="aspect-[3/4] overflow-hidden bg-gradient-to-br from-slate-100 to-indigo-100">
                        @if ($book->lokasi_sampul)
                            <img src="{{ Storage::disk('public')->url($book->lokasi_sampul) }}" alt="Sampul {{ $book->judul }}"
                                 class="h-full w-full object-cover" loading="lazy">
                        @else
                            <div class="flex h-full items-center justify-center p-5">
                                <div class="flex h-full w-[82%] flex-col justify-between rounded-r-xl border-l-[6px] border-blue-950 bg-gradient-to-br from-blue-700 to-indigo-950 p-5 text-white shadow-xl">
                                    <span class="text-[10px] font-semibold uppercase tracking-[0.18em] text-blue-100">Kamus Boso Walikan Malang</span>
                                    <div class="space-y-3">
                                        <i class="fas fa-book-open text-3xl text-amber-300"></i>
                                        <p class="line-clamp-4 text-lg font-extrabold leading-tight">{{ $book->judul }}</p>
                                    </div>
                                    <span class="text-[10px] font-medium text-blue-100">{{ $book->penulis }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col p-4">
                        <h3 class="line-clamp-2 min-h-12 text-base font-bold leading-6 text-slate-900" title="{{ $book->judul }}">
                            {{ $book->judul }}
                        </h3>
                        <p class="mt-1 truncate text-sm text-slate-600">Oleh: <span class="font-medium text-slate-800">{{ $book->penulis ?: 'Tim MalangVerse' }}</span></p>

                        <div class="mt-3 flex flex-wrap gap-2">
                            @if ($book->jumlah_halaman)
                                <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2.5 py-1 text-[11px] font-medium text-slate-600">
                                    <i class="far fa-copy"></i> {{ number_format($book->jumlah_halaman) }} Halaman
                                </span>
                            @endif
                            <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2.5 py-1 text-[11px] font-medium text-slate-600">
                                <i class="far fa-file-pdf"></i> PDF HD
                            </span>
                        </div>

                        <div class="mt-auto flex items-end justify-between gap-2 border-t border-slate-100 pt-4 mt-5">
                            <div>
                                <p class="text-[11px] text-slate-500">Harga Lisensi</p>
                                <p class="text-xl font-extrabold leading-tight text-blue-700">
                                    Rp {{ number_format((float) $book->harga, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="{{ Storage::disk('public')->url($book->lokasi_pratinjau ?: $book->lokasi_berkas) }}"
                               target="_blank" rel="noopener noreferrer"
                               class="inline-flex shrink-0 items-center gap-2 rounded-full bg-blue-700 px-4 py-3 text-xs font-bold text-white transition hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-200">
                                Beli / Baca <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-20">
                    <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Tidak ada buku yang ditemukan.</p>
                </div>
            @endforelse
        </div>

        {{-- Banner Bundle --}}
        @if ($bundle)
        <div class="mt-16 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center text-white text-2xl shadow-lg shadow-blue-600/30">
                    <i class="fas fa-gift"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $bundle->judul }}</h3>
                    <p class="text-gray-500 text-sm mt-1">Paket bundling e-book Boso Walikan.</p>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="text-right">
                    <div class="text-2xl font-extrabold text-blue-600">
                        Rp {{ number_format((float) $bundle->harga, 0, ',', '.') }}
                    </div>
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-1">
                    Ambil Paket Bundling <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
        @endif

    </main>

    {{-- Panggil Footer --}}
    <x-guest.beranda-footer />

</body>
</html>