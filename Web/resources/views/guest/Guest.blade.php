<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - MalangVerse</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/guest.css', 'resources/js/guest.js'])
</head>
<body class="min-h-screen flex flex-col">
    <x-guest.navbar />

    <main class="flex-1">
        <div class="page-content max-w-5xl mx-auto px-4 pt-12 pb-4">
            <p class="page-eyebrow">MalangVerse</p>
            <h1>{{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        @php
            $kataPopuler = ['Sam', 'Mbc', 'Ayuo', 'Tuga', 'Ukah', 'Budget', 'Nawak', 'Mbuk', 'Lanbuk', 'Kaan', 'Gieta', 'Banget'];

            $edukasi = [
                [
                    'kategori' => 'Vocab Sehari-hari',
                    'judul'    => 'Kosa Kata Dasar',
                    'isi'      => 'Pelajari kosakata Boso Walikan yang paling sering dipakai dalam percakapan sehari-hari di Malang.',
                    'icon'     => 'fa-book-open',
                    'warna'    => 'bg-blue-100 text-blue-600',
                    'sumber'   => 'Kamus Boso Walikan',
                ],
                [
                    'kategori' => 'Asal Usul',
                    'judul'    => 'Sejarah Kata',
                    'isi'      => 'Telusuri asal-usul Boso Walikan dan bagaimana bahasa ini lahir dari kreativitas warga Malang.',
                    'icon'     => 'fa-landmark',
                    'warna'    => 'bg-amber-100 text-amber-600',
                    'sumber'   => 'Tim Redaksi MalangVerse',
                ],
                [
                    'kategori' => 'Budaya Arema',
                    'judul'    => 'Sindiran Arema',
                    'isi'      => 'Kenali istilah-istilah khas suporter dan komunitas Arema yang lahir dari Boso Walikan.',
                    'icon'     => 'fa-users',
                    'warna'    => 'bg-emerald-100 text-emerald-600',
                    'sumber'   => 'Komunitas MalangVerse',
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
                            </div>
                        </div>

                        <div class="hidden md:flex items-center justify-center">
                            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                <i class="fa-solid fa-arrow-right"></i>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-4 flex flex-col">
                            <span class="text-xs font-semibold text-blue-600 mb-2">Bahasa Indonesia</span>
                            <div class="flex-1 min-h-[130px] rounded-lg bg-slate-50 p-3 text-slate-700">
                                Hasil terjemahan akan muncul di sini.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <x-guest.beranda-footer />
</body>
</html>