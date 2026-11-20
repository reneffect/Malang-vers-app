<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan Profil Member - MulangVerse</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite([
        'resources/css/guest.css',
        'resources/css/user/member/profile.css',
        'resources/js/user/member/profile.js',
    ])
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <x-guest.navbar />

    {{-- ============ HERO ============ --}}
    <section class="relative bg-gradient-to-br from-blue-700 via-indigo-700 to-purple-800 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-white/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-purple-300/30 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-14">
            <nav class="flex items-center gap-2 text-sm text-blue-200 mb-4">
                <a href="{{ route('beranda') }}" class="hover:text-white transition-colors">Beranda</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-white font-medium">Pengaturan Profil</span>
            </nav>

            <h1 class="text-2xl md:text-3xl font-extrabold mb-2">Pengaturan Profil Member</h1>
            <p class="text-blue-100 text-sm md:text-base max-w-2xl">
                Kelola informasi pribadi, preferensi akun, dan status langganan Anda di MulangVerse.
            </p>
        </div>
    </section>

    {{-- ============ MAIN CONTENT ============ --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6">

            {{-- ============ SIDEBAR ============ --}}
            <aside class="space-y-5">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
                    <div class="relative inline-block mb-3">
                        <div data-avatar-container class="w-20 h-20 rounded-full bg-gradient-to-br from-primary-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg mx-auto overflow-hidden ring-4 ring-white">
                            @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="avatar-img w-full h-full object-cover">
                            @else
                                <span class="avatar-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <span class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>
                    <h3 class="font-bold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-xs text-gray-500 mb-4">{{ $user->email }}</p>

                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div class="bg-primary-50 rounded-xl p-3">
                            <div class="text-2xl font-extrabold text-primary-600">{{ $user->xp ?? 0 }}</div>
                            <div class="text-[10px] text-gray-500 uppercase tracking-wide">XP</div>
                        </div>
                        <div class="bg-amber-50 rounded-xl p-3">
                            <div class="text-2xl font-extrabold text-amber-600">Lv. {{ $user->level ?? 1 }}</div>
                            <div class="text-[10px] text-gray-500 uppercase tracking-wide">Level</div>
                        </div>
                    </div>

                    <div class="text-left">
                        <div class="flex justify-between text-[11px] text-gray-500 mb-1">
                            <span>Progress Level</span>
                            <span>{{ round($user->level_progress ?? 0) }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-primary-500 to-purple-600 h-1.5 rounded-full transition-all duration-500"
                                 style="width: {{ $user->level_progress ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <nav class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-3 space-y-1">
                        <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary-50 text-primary-700 font-semibold text-sm">
                            <i class="fas fa-user-circle w-5"></i> Profil Saya
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 text-sm transition-colors">
                            <i class="fas fa-lock w-5"></i> Ubah Kata Sandi
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 text-sm transition-colors">
                            <i class="fas fa-history w-5"></i> Riwayat Transaksi
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 text-sm transition-colors">
                            <i class="fas fa-bookmark w-5"></i> Frasa Tersimpan
                        </a>
                    </div>
                    <div class="border-t border-gray-100 p-3">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-red-600 hover:bg-red-50 text-sm transition-colors text-left">
                                <i class="fas fa-sign-out-alt w-5"></i> Keluar
                            </button>
                        </form>
                    </div>
                </nav>
            </aside>

            {{-- ============ KONTEN UTAMA ============ --}}
            <div class="space-y-6">

                {{-- Form Profil --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Informasi Profil Member</h2>
                            <p class="text-sm text-gray-500 mt-0.5">Perbarui data pribadi Anda.</p>
                        </div>
                    </div>

                    <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                        @csrf
                        @method('PUT')

                        {{-- Avatar Upload Section --}}
                        <div class="flex items-center gap-5 p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="relative shrink-0">
                                <div id="avatarPreview" data-avatar-container class="w-20 h-20 rounded-full bg-gradient-to-br from-primary-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold overflow-hidden ring-4 ring-white shadow-md">
                                    @if ($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" class="avatar-img w-full h-full object-cover">
                                    @else
                                        <span class="avatar-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <label for="avatarInput" title="Pilih foto" class="absolute -bottom-1 -right-1 w-7 h-7 bg-primary-600 text-white rounded-full flex items-center justify-center cursor-pointer hover:bg-primary-700 hover:scale-110 transition-all shadow-md border-2 border-white">
                                    <i class="fas fa-camera text-xs"></i>
                                </label>
                                <input type="file" id="avatarInput" accept="image/jpeg,image/png,image/webp" class="hidden">
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800">Foto Profil</p>
                                <p class="text-xs text-gray-400 mb-3">JPG, PNG, atau WEBP. Maksimal 2MB.</p>

                                <div class="flex items-center gap-2 flex-wrap">
                                    <button type="button" onclick="document.getElementById('avatarInput').click()" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg hover:border-primary-600 hover:text-primary-600 transition-all text-sm font-semibold flex items-center gap-2">
                                        <i class="fas fa-folder-open"></i> Pilih Foto
                                    </button>

                                    <button type="button"
                                            id="btnUploadAvatar"
                                            data-url="{{ route('profile.avatar') }}"
                                            disabled
                                            class="px-4 py-2 bg-primary-600 text-white text-sm font-semibold rounded-lg disabled:opacity-40 disabled:cursor-not-allowed hover:bg-primary-700 active:scale-95 transition-all flex items-center gap-2">
                                        <i class="fas fa-upload"></i> Unggah
                                    </button>
                                </div>

                                <p id="avatarStatus" class="text-xs mt-2 hidden"></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary-600 focus:ring-4 focus:ring-primary-600/10 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary-600 focus:ring-4 focus:ring-primary-600/10 transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Telepon</label>
                                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary-600 focus:ring-4 focus:ring-primary-600/10 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary-600 focus:ring-4 focus:ring-primary-600/10 transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota Domisili</label>
                            <input type="text" name="kota" value="{{ old('kota', $user->kota) }}" placeholder="Contoh: Malang, Surabaya" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary-600 focus:ring-4 focus:ring-primary-600/10 transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Bio Singkat</label>
                            <textarea name="bio" rows="3" maxlength="500" placeholder="Ceritakan sedikit tentang diri Anda..." class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary-600 focus:ring-4 focus:ring-primary-600/10 transition-all resize-none">{{ old('bio', $user->bio) }}</textarea>
                            <p class="text-xs text-gray-400 mt-1">Maksimal 500 karakter.</p>
                        </div>

                        <div class="-mx-6 -mb-6 mt-6 px-6 py-4 border-t border-gray-100 bg-white flex flex-nowrap items-center justify-end gap-3">
                            <a href="{{ route('profile.index') }}" class="shrink-0 px-5 py-2.5 border border-gray-200 text-gray-600 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="shrink-0 px-5 py-2.5 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Status Langganan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">Status Langganan Aktif</h2>
                    </div>
                    <div class="p-6">
                        @if (isset($membership) && $membership && $membership->tier)
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-5 p-5 bg-gradient-to-r from-primary-50 to-purple-50 border border-primary-100 rounded-xl">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-primary-600 to-purple-600 flex items-center justify-center text-white text-xl shadow-lg">
                                        <i class="fas fa-crown"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-0.5">
                                            <h3 class="font-bold text-gray-900">{{ $membership->tier->name }}</h3>
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-green-100 text-green-700 uppercase">Aktif</span>
                                        </div>
                                        <p class="text-xs text-gray-500">Berlaku sampai {{ $membership->expires_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('pricing') }}" class="px-5 py-2.5 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors shadow-md text-center">
                                    Kelola Langganan
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="font-semibold text-gray-700 mb-1">Informasi langganan belum tersedia</p>
                                <a href="{{ route('pricing') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors mt-2">
                                    Lihat Paket Langganan <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </main>

    <x-guest.beranda-footer />

    {{-- Toast global --}}
    <div id="toast" class="fixed bottom-8 right-8 z-50 pointer-events-none bg-gray-900 text-white px-6 py-3.5 rounded-xl shadow-2xl text-sm font-medium translate-y-32 opacity-0 transition-all duration-300"></div>

</body>
</html>