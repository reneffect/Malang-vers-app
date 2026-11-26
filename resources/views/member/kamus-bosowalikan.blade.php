<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Book Kamus Boso Walikan - MalangVerse</title>
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

    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">

        {{-- HERO CARD E-BOOK SESUAI FIGMA/DESAIN --}}
        <section class="bg-[#2A54F5] rounded-3xl p-7 sm:p-10 md:p-12 text-white shadow-xl shadow-blue-500/10 relative overflow-hidden">
            <div class="relative z-10 max-w-2xl">
                {{-- Badge Header --}}
                <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm px-3.5 py-1.5 rounded-full text-xs font-semibold text-white mb-5 border border-white/20 shadow-xs">
                    <span class="material-symbols-outlined select-none" style="font-size: 18px; line-height: 1;">auto_stories</span>
                    <span>Pustaka Resmi E-Book Digital</span>
                </div>

                {{-- Judul Hero --}}
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-3 leading-tight">
                    Kamus Boso Walikan
                </h1>

                {{-- Subtitle Hero --}}
                <p class="text-blue-100 text-xs sm:text-sm md:text-base leading-relaxed mb-7 max-w-xl">
                    Koleksi komprehensif kosakata Kiwalan khas Arema Malang, dari arsip sejarah gerilya kemerdekaan 1949 hingga dialek slang modern pemuda Ngalam.
                </p>

                {{-- Search Bar Telusuri --}}
                <form action="{{ route('kamus') }}" method="GET" class="relative max-w-xl bg-white rounded-full p-1.5 shadow-md flex items-center">
                    <div class="pl-4 pr-2 text-slate-400 flex items-center pointer-events-none">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari lema kata, arti osob, atau judul buku (misal: Ojob)"
                           class="flex-1 w-full bg-transparent text-slate-800 placeholder-slate-400 text-xs sm:text-sm outline-none px-2 py-2">
                    <button type="submit"
                            class="shrink-0 bg-[#1E40AF] hover:bg-blue-800 text-white text-xs sm:text-sm font-semibold px-5 py-2.5 rounded-full transition-colors flex items-center gap-1.5 cursor-pointer">
                        <span>Telusuri</span>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                </form>
            </div>
        </section>

        {{-- SECTION TITLE --}}
        <div class="mt-10 md:mt-12 mb-6">
            <h2 class="text-lg md:text-xl font-extrabold text-slate-900 leading-tight">
                Pustaka Resmi E-Book Kamus Boso<br class="hidden sm:inline"> Walikan
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                Pilih koleksi buku format PDF berlisensi resmi kebudayaan Malang.
            </p>
        </div>

        @php
            // Default 4 buku kurasi sesuai desain Figma/screenshot jika belum ada di database
            $displayBooks = $books->isNotEmpty() ? $books : collect([
                (object)[
                    'id' => 1,
                    'judul' => 'Kamus Akbar Boso Walikan Malang (Edisi Lengkap)',
                    'penulis' => 'Tim Budayawan Arema',
                    'jumlah_halaman' => 480,
                    'harga' => 50000,
                    'lokasi_sampul' => null,
                    'lokasi_berkas' => '#',
                    'lokasi_pratinjau' => '#',
                    'cover_type' => 'akbar',
                ],
                (object)[
                    'id' => 2,
                    'judul' => 'Kamus Saku Kiwalan Populer',
                    'penulis' => 'Sam Kaji & Nawak Ngalam',
                    'jumlah_halaman' => 180,
                    'harga' => 35000,
                    'lokasi_sampul' => null,
                    'lokasi_berkas' => '#',
                    'lokasi_pratinjau' => '#',
                    'cover_type' => 'saku',
                ],
                (object)[
                    'id' => 3,
                    'judul' => 'Ensiklopedia Osob Kiwalan Gerilya 1949',
                    'penulis' => 'Sejarah Arema',
                    'jumlah_halaman' => 620,
                    'harga' => 75000,
                    'lokasi_sampul' => null,
                    'lokasi_berkas' => '#',
                    'lokasi_pratinjau' => '#',
                    'cover_type' => 'ensiklopedia',
                ],
                (object)[
                    'id' => 4,
                    'judul' => 'Percakapan Harian Kiwalan Ngalam',
                    'penulis' => 'Komunitas Osob Ngalam',
                    'jumlah_halaman' => 210,
                    'harga' => 40000,
                    'lokasi_sampul' => null,
                    'lokasi_berkas' => '#',
                    'lokasi_pratinjau' => '#',
                    'cover_type' => 'percakapan',
                ],
            ]);
        @endphp

        {{-- GRID 4 BUKU --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 md:gap-6">
            @foreach ($displayBooks as $book)
                <article class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col transition-all duration-200 hover:shadow-md hover:-translate-y-1 group">
                    {{-- AREA SAMPUL BUKU --}}
                    <div class="aspect-[3/4] p-3.5 bg-[#F6F8FD] flex items-center justify-center overflow-hidden relative">
                        @if (!empty($book->lokasi_sampul))
                            <img src="{{ Storage::disk('public')->url($book->lokasi_sampul) }}"
                                 alt="Sampul {{ $book->judul }}"
                                 class="h-full w-full object-cover rounded-2xl shadow-xs" loading="lazy">
                        @else
                            {{-- MOCKUP SAMPUL KREATIF SESUAI FIGMA JIKA BELUM ADA FILE GAMBAR --}}
                            @php
                                $type = $book->cover_type ?? (
                                    str_contains(strtolower($book->judul), 'akbar') ? 'akbar' :
                                    (str_contains(strtolower($book->judul), 'saku') ? 'saku' :
                                    (str_contains(strtolower($book->judul), 'gerilya') || str_contains(strtolower($book->judul), 'ensiklopedia') ? 'ensiklopedia' : 'percakapan'))
                                );
                            @endphp

                            @if ($type === 'akbar')
                                {{-- 1. Kamus Akbar (Navy & Gold Hardcover) --}}
                                <div class="w-full h-full rounded-2xl bg-gradient-to-br from-[#1C3D82] via-[#142B5C] to-[#0A1835] text-white p-4 flex flex-col justify-between border-l-4 border-[#071328] shadow-md relative overflow-hidden select-none">
                                    <div class="absolute inset-2 border border-amber-300/30 rounded-lg pointer-events-none"></div>
                                    <div class="text-center pt-2">
                                        <p class="text-[9px] font-bold tracking-[0.2em] text-amber-300/80 uppercase">EDISI AKADEMIK RESMI</p>
                                        <h4 class="text-sm font-extrabold text-white mt-1 uppercase tracking-wider leading-tight">KAMUS AKBAR<br><span class="text-amber-200">BOSO WALIKAN</span><br>MALANG</h4>
                                    </div>
                                    <div class="flex flex-col items-center justify-center my-auto py-2">
                                        <div class="w-14 h-14 rounded-full border-2 border-amber-300/40 flex items-center justify-center bg-amber-400/10">
                                            <i class="fas fa-university text-amber-300 text-xl"></i>
                                        </div>
                                    </div>
                                    <div class="text-center pb-1">
                                        <p class="text-[8px] text-blue-200/90 leading-tight">Kamus Lengkap &amp; Komprehensif<br>Bahasa Walikan Malang</p>
                                        <p class="text-[7px] text-amber-300/70 mt-1 font-semibold uppercase">Edisi Budayawan Arema</p>
                                    </div>
                                </div>

                            @elseif ($type === 'saku')
                                {{-- 2. Kamus Saku (Modern Clean Blue 3D) --}}
                                <div class="w-full h-full rounded-2xl bg-gradient-to-br from-[#2E68F5] to-[#1746C9] text-white p-4 flex flex-col justify-between border-l-4 border-blue-900 shadow-md relative overflow-hidden select-none">
                                    <div class="text-left pt-2">
                                        <span class="inline-block px-2 py-0.5 rounded-full bg-white/20 text-[8px] font-bold text-white tracking-wider">MALANG SAKU</span>
                                    </div>
                                    <div class="text-center my-auto py-3">
                                        <h4 class="text-base font-black text-white uppercase tracking-tight leading-tight">
                                            KAMUS<br><span class="text-sky-200 text-lg">SAKU</span><br>KIWALAN<br><span class="text-amber-300">POPULER</span>
                                        </h4>
                                        <div class="w-8 h-1 bg-white/40 mx-auto mt-2 rounded-full"></div>
                                    </div>
                                    <div class="text-center pb-1">
                                        <p class="text-[8px] text-blue-100 font-medium">Panduan Ringkas Praktis Arek</p>
                                    </div>
                                </div>

                            @elseif ($type === 'ensiklopedia')
                                {{-- 3. Ensiklopedia Gerilya 1949 (Vintage Parchment & Badge) --}}
                                <div class="w-full h-full rounded-2xl bg-[#E8DECF] text-[#3D2D1D] p-4 flex flex-col justify-between border-l-4 border-[#8C765C] border-2 border-[#D1C3B0] shadow-md relative overflow-hidden select-none">
                                    <div class="text-center pt-1 border-b border-[#A6937C]/40 pb-1.5">
                                        <p class="text-[8px] tracking-[0.15em] font-bold uppercase text-[#735A40]">ARSIP SEJARAH KEMERDEKAAN</p>
                                    </div>
                                    <div class="text-center my-auto py-2">
                                        <h4 class="text-xs font-black uppercase text-[#332211] tracking-wide leading-tight">
                                            ENSIKLOPEDIA<br><span class="text-sm font-extrabold text-[#7A2A1A]">OSOB KIWALAN</span><br><span class="text-[10px] tracking-widest text-[#5C4530]">GERILYA 1949</span>
                                        </h4>
                                        <div class="my-2.5 mx-auto w-12 h-12 rounded-full border-2 border-[#8C6D51] flex items-center justify-center bg-[#D6C5B0]">
                                            <i class="fas fa-shield-alt text-[#7A2A1A] text-lg"></i>
                                        </div>
                                        <p class="text-[8px] font-semibold text-[#5A4533] uppercase">Sandi Pejuang TRIP Malang</p>
                                    </div>
                                    <div class="text-center border-t border-[#A6937C]/40 pt-1">
                                        <p class="text-[7px] text-[#735A40] font-medium">Komunitas Sejarah Perjuangan Arema</p>
                                    </div>
                                </div>

                            @else
                                {{-- 4. Percakapan Harian (Warm Cream & Casual Guide) --}}
                                <div class="w-full h-full rounded-2xl bg-[#FFF9EE] text-[#4A3B32] p-4 flex flex-col justify-between border-l-4 border-amber-400 border-2 border-amber-200/60 shadow-md relative overflow-hidden select-none">
                                    <div class="text-center pt-1">
                                        <span class="inline-block bg-orange-100 text-orange-800 text-[8px] font-bold px-2 py-0.5 rounded-full uppercase">DAILY CONVERSATION</span>
                                    </div>
                                    <div class="text-center my-auto py-2">
                                        <h4 class="text-xs font-black uppercase text-slate-800 tracking-tight leading-tight">
                                            PERCAKAPAN HARIAN<br><span class="text-sm font-extrabold text-blue-700">KIWALAN NGALAM</span>
                                        </h4>
                                        <div class="my-2.5 mx-auto w-12 h-12 rounded-full bg-gradient-to-tr from-amber-200 to-orange-200 flex items-center justify-center text-orange-700">
                                            <i class="fas fa-comments text-xl"></i>
                                        </div>
                                        <p class="text-[8px] text-slate-600 font-medium">Dialek Santai Nongkrong Kera Ngalam</p>
                                    </div>
                                    <div class="text-center border-t border-amber-200/60 pt-1">
                                        <p class="text-[7px] text-slate-500 font-semibold">Komunitas Osob Ngalam</p>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- DETAIL INFORMASI BUKU --}}
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            {{-- Judul Buku --}}
                            <h3 class="text-sm sm:text-base font-bold text-slate-900 line-clamp-1 leading-snug" title="{{ $book->judul }}">
                                {{ $book->judul }}
                            </h3>

                            {{-- Penulis --}}
                            <p class="text-xs text-slate-500 mt-1 truncate">
                                Oleh: <span class="text-slate-700 font-medium">{{ $book->penulis ?: 'Tim Budayawan Arema' }}</span>
                            </p>

                            {{-- Badge Halaman & PDF --}}
                            <div class="flex items-center gap-2 mt-3">
                                <span class="inline-flex items-center gap-1.5 bg-[#EEF2FF] text-slate-600 px-2.5 py-1 rounded-full text-[11px] font-medium">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 text-slate-600">
                                        <path d="M12 7v14"></path>
                                        <path d="M16 12h2"></path>
                                        <path d="M16 8h2"></path>
                                        <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path>
                                        <path d="M6 12h2"></path>
                                        <path d="M6 8h2"></path>
                                    </svg>
                                    <span>{{ $book->jumlah_halaman ?: 480 }} Halaman</span>
                                </span>
                                <span class="inline-flex items-center gap-1.5 bg-[#EEF2FF] text-slate-600 px-2.5 py-1 rounded-full text-[11px] font-medium">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 text-slate-600">
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M10 9H8"></path>
                                        <path d="M16 13H8"></path>
                                        <path d="M16 17H8"></path>
                                    </svg>
                                    <span>PDF HD</span>
                                </span>
                            </div>
                        </div>

                        {{-- Harga & Tombol Beli / Baca --}}
                        <div class="mt-4 pt-3.5 border-t border-slate-100 flex items-center justify-between gap-2">
                            <div>
                                <p class="text-[10px] text-slate-400 font-medium">Harga Lisensi</p>
                                <p class="text-base sm:text-lg font-extrabold text-[#1E40AF]">
                                    Rp {{ number_format((float) $book->harga, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="{{ !empty($book->lokasi_pratinjau) || !empty($book->lokasi_berkas) ? Storage::disk('public')->url($book->lokasi_pratinjau ?: $book->lokasi_berkas) : '#' }}"
                               target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-1.5 bg-[#1E40AF] hover:bg-blue-800 text-white px-3.5 sm:px-4 py-2 rounded-full text-xs font-semibold transition-colors cursor-pointer shadow-xs">
                                <span>Beli / Baca</span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

    </main>

    {{-- Footer Component --}}
    <x-guest.beranda-footer />

</body>
</html>
