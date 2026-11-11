<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - MalangVerse</title>

    @vite(['resources/css/guest.css', 'resources/js/guest.js'])
</head>
<body class="min-h-screen flex flex-col">
    <x-guest.navbar />

    <main class="flex-1">
        <section class="hero">
            <div class="hero-content">
                <span class="hero-badge"><i class="fa-solid fa-seedling"></i> Preservasi Dialek Malangan &amp; Kearifan Asli</span>
                <h1 class="hero-title">{{ $title }}</h1>
                <p class="hero-subtitle">{{ $description }}</p>
            </div>
        </section>

        @php
            $kataPopuler = ['Sam', 'Mbc', 'Ayuo', 'Tuga', 'Ukah', 'Budget', 'Nawak', 'Mbuk', 'Lanbuk', 'Kaan', 'Gieta', 'Banget'];

            $edukasi = [
                [
                    'badge'  => '1949: Sandi Taktis Pejuang',
                    'judul'  => 'Kode Rahasia Gerilya',
                    'isi'    => 'Diciptakan oleh tentara TRIP (Tentara Pelajar Indonesia) untuk mengelabui mata-mata Belanda yang paham bahasa Jawa dan Melayu. Informasi rahasia dienkripsi secara lisan dengan membalik fonem kata.',
                    'footer' => 'Contoh Kunci: <strong>Londo → Odnol</strong>',
                    'icon'   => 'fa-shield-halved',
                    'warna'  => 'bg-blue-100 text-blue-600',
                ],
                [
                    'badge'  => 'Fonetik & Morfologi',
                    'judul'  => 'Aturan Pembalikan Kata',
                    'isi'    => 'Tidak semua kata dibalik secara harfiah per huruf. Pola pembalikan mengikuti pelafalan fonetis bahasa Jawa Malang yang lunak agar tetap nyaman diucapkan dalam percakapan ritmik Arek.',
                    'footer' => 'Contoh Fonetis: <strong>Kera (Arek) &amp; Sam (Mas)</strong>',
                    'icon'   => 'fa-spell-check',
                    'warna'  => 'bg-slate-100 text-slate-600',
                ],
                [
                    'badge'  => 'Identitas Kultural',
                    'judul'  => 'Simbol Solidaritas Arema',
                    'isi'    => 'Kini, Boso Walikan bertransformasi menjadi perekat identitas sosial pemuda Malang raya. Menjadi lambang keakraban, egaliter, dan inklusif tanpa membedakan kasta usia maupun strata sosial.',
                    'footer' => 'Status: <strong>Warisan Budaya Takbenda</strong>',
                    'icon'   => 'fa-users',
                    'warna'  => 'bg-emerald-100 text-emerald-600',
                ],
            ];
        @endphp

        <section class="bg-slate-50 py-12 px-4">
            <div class="max-w-5xl mx-auto space-y-14">

                {{-- Penerjemah --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 md:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-[1fr_auto_1fr] gap-4 items-stretch">

                        {{-- Input --}}
                        <div class="rounded-xl border border-slate-200 p-4 flex flex-col">
                            <span class="text-xs font-semibold text-blue-600 mb-2">Boso Walikan</span>
                            <textarea id="sumber-teks" rows="4"
                                class="flex-1 w-full resize-none outline-none text-slate-800 placeholder-slate-400"
                                placeholder="Ketik kata Boso Walikan di sini..."></textarea>
                            <div class="flex items-center justify-between text-xs text-slate-400 mt-2">
                                <button type="button" id="btn-terjemah"
                                    class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700">
                                    Terjemahkan
                                </button>
                                <span id="jumlah-karakter">0 / 500</span>
                            </div>
                        </div>

                        {{-- Tombol tukar --}}
                        <div class="flex items-center justify-center">
                            <button type="button" id="btn-tukar"
                                class="w-9 h-9 rounded-full border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300"
                                aria-label="Tukar bahasa">
                                <i class="fa-solid fa-right-left"></i>
                            </button>
                        </div>

                        {{-- Output --}}
                        <div class="rounded-xl border border-slate-200 p-4 flex flex-col bg-slate-50/60">
                            <span class="text-xs font-semibold text-slate-500 mb-2">Bahasa Indonesia</span>
                            <div id="hasil-teks" class="flex-1 text-slate-800 min-h-[6rem]">
                                <span class="text-slate-400">Hasil terjemahan akan muncul di sini.</span>
                            </div>
                            <div class="flex items-center justify-between text-xs text-slate-400 mt-2">
                                <button type="button" id="btn-salin" class="hover:text-blue-600">
                                    <i class="fa-regular fa-copy"></i> Salin
                                </button>
                                <span id="status-terjemah"></span>
                            </div>
                        </div>
                    </div>

                    <p class="text-center text-[11px] text-slate-400 mt-4">
                        Dibantu pengguna dan kontributor komunitas MalangVerse
                    </p>
                </div>

                {{-- Kata Populer --}}
                <div>
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Kata Populer</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($kataPopuler as $kata)
                            <button type="button"
                                class="btn-kata px-3 py-1.5 rounded-full bg-blue-100 text-blue-600 text-sm font-medium hover:bg-blue-200"
                                data-kata="{{ $kata }}">
                                {{ $kata }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Edukasi --}}
                <div>
                    <div class="text-center mb-10">
                        <p class="text-[11px] font-semibold tracking-widest text-blue-600 uppercase">Warisan Budaya</p>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-1">Edukasi &amp; Trivia Sejarah Boso Walikan</h2>
                        <p class="text-sm text-slate-500 mt-2">Mengapa Boso Walikan dibalik? Pelajari latar belakang taktik perjuangan kemerdekaan.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        @foreach ($edukasi as $item)
                            <article class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col hover:shadow-md transition">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 {{ $item['warna'] }}">
                                        <i class="fa-solid {{ $item['icon'] }} text-sm"></i>
                                    </div>
                                    <span class="text-[11px] font-semibold text-blue-600">{{ $item['badge'] }}</span>
                                </div>
                                <h3 class="text-base font-bold text-slate-900">{{ $item['judul'] }}</h3>
                                <p class="text-sm text-slate-600 mt-2 leading-relaxed flex-1">{{ $item['isi'] }}</p>
                                <p class="text-xs text-slate-500 mt-4 pt-4 border-t border-slate-100">{!! $item['footer'] !!}</p>
                            </article>
                        @endforeach
                    </div>
                </div>

                {{-- CTA member --}}
                <div class="relative overflow-hidden rounded-2xl border border-dashed border-blue-300 bg-gradient-to-br from-blue-50 to-white p-8 md:p-12">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-8">
                        <div class="max-w-md">
                            <span class="inline-block text-[11px] font-semibold px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                                Akses Eksklusif Komunitas Arek
                            </span>
                            <h3 class="text-xl md:text-2xl font-bold text-slate-900 mt-4 leading-snug">
                                Daftar Member untuk Akses Kamus Lengkap &amp; Simpan Riwayat!
                            </h3>
                            <p class="text-sm text-slate-600 mt-3 leading-relaxed">
                                Nikmati akses tanpa batas kosakata kiwalan, simpan frasa favorit tanpa batas kuota harian, dan baca koleksi E-Book Kamus Akbar.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 shrink-0">
                            <a href="{{ route('register') }}"
                                class="px-6 py-2.5 rounded-full bg-blue-600 text-white text-sm font-semibold text-center hover:bg-blue-700">
                                Daftar Sekarang (Gratis)
                            </a>
                            <a href="{{ route('membership') }}"
                                class="text-sm font-medium text-slate-700 hover:text-blue-600">
                                Pelajari Keuntungan Member →
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <x-guest.beranda-footer />

    
</body>
</html>