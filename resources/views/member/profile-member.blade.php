<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan Profil Member - MalangVerse</title>

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
        $user = auth()->user() ?? $user;
        $membership = $membership ?? (isset($user) ? $user->activeMembership()->with('tier')->first() : null);
        $userAvatar = $user && $user->avatar
            ? asset('storage/' . $user->avatar)
            : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=200&h=200&q=80';
        $userIdSuffix = strtoupper(substr(md5($user->id ?? '1'), 0, 4));
    @endphp

    {{-- ============ HERO SECTION ============ --}}
    <section class="bg-[#2A54F5] text-white pt-8 pb-24 sm:pb-28 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                {{-- Badge Terverifikasi --}}
                <div class="inline-flex items-center gap-1.5 bg-white/15 backdrop-blur-sm border border-white/20 text-white px-3.5 py-1 rounded-full text-xs font-semibold mb-3 shadow-xs select-none">
                    <span class="material-symbols-outlined text-[15px] text-white">verified_user</span>
                    <span>Akun Arek Malang Terverifikasi</span>
                </div>

                {{-- Judul Hero --}}
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-2 leading-tight">
                    Pengaturan Profil Member
                </h1>

                {{-- Subtitle Hero --}}
                <p class="text-blue-100 text-xs sm:text-sm max-w-xl leading-relaxed">
                    Kelola data pribadi, identitas Osob Walikan, dan preferensi langganan eksklusif Anda.
                </p>
            </div>

            {{-- MalangVerse ID on the right --}}
            <div class="flex items-center gap-2 self-start md:self-end text-xs text-blue-100 font-medium">
                <span>MalangVerse ID:</span>
                <span class="bg-white/15 border border-white/25 text-white font-mono text-xs font-bold px-3 py-1 rounded-full shadow-xs">
                    #MV-MLG-{{ $userIdSuffix }}
                </span>
            </div>
        </div>
    </section>

    {{-- ============ MAIN CONTENT CONTAINER ============ --}}
    <main class="max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 -mt-14 sm:-mt-16 relative z-10 pb-16 flex-1">

        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3 rounded-2xl text-xs sm:text-sm font-semibold flex items-center gap-2.5 shadow-xs">
                <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6 items-start">

            {{-- ============ LEFT COLUMN: SIDEBAR ============ --}}
            <aside class="space-y-5">
                {{-- User Profile Card --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100/90 text-center relative overflow-hidden">
                    {{-- Soft Blue Top Banner --}}
                    <div class="h-16 bg-[#EFF6FF] -mx-6 -mt-6"></div>

                    {{-- Avatar Circle with Verified Check --}}
                    <div class="relative inline-block -mt-10 mb-3">
                        <div class="w-22 h-22 rounded-full ring-4 ring-white shadow-md mx-auto overflow-hidden bg-slate-200">
                            <img id="sidebarAvatarImg" src="{{ $userAvatar }}" alt="Foto Profil" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute bottom-0.5 right-0.5 w-6 h-6 rounded-full bg-[#2A54F5] text-white flex items-center justify-center ring-2 ring-white shadow-xs">
                            <span class="material-symbols-outlined text-sm font-bold">check</span>
                        </div>
                    </div>

                    {{-- Nama & Email --}}
                    <h3 class="text-lg font-extrabold text-slate-900 leading-tight">
                        {{ $user->name ?? 'Ngalup Ker' }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5 font-medium">
                        {{ $user->email ?? 'ngalup@ker.id' }}
                    </p>

                    {{-- Membership Pill Badge --}}
                    <div class="mt-4">
                        <span class="inline-flex items-center gap-1.5 bg-[#EEF2FF] text-[#2A54F5] text-[11px] font-semibold px-3 py-1.5 rounded-full border border-blue-100/80">
                            <span class="material-symbols-outlined text-[15px]" style="font-variation-settings: 'FILL' 1;">hotel_class</span>
                            <span>Member Premium (Aktif s/d {{ isset($membership) && $membership->expires_at ? $membership->expires_at->format('d M Y') : '18 Nov 2026' }})</span>
                        </span>
                    </div>
                </div>

                {{-- Sidebar Navigation Links --}}
                <div class="bg-white rounded-3xl p-2.5 shadow-sm border border-slate-100/90 space-y-1">
                    {{-- Profil Saya (Active) --}}
                    <a href="{{ route('profile.index') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-2xl bg-[#EEF2FF] text-[#2A54F5] font-bold text-xs sm:text-sm">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-lg">person</span>
                            <span>Profil Saya</span>
                        </div>
                        <span class="material-symbols-outlined text-base">chevron_right</span>
                    </a>

                    {{-- Koleksi Kamus Digital --}}
                    <a href="{{ route('kamus') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50 font-semibold text-xs sm:text-sm transition">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-lg text-slate-500">auto_stories</span>
                            <span>Koleksi Kamus Digital</span>
                        </div>
                        <span class="w-5 h-5 rounded-full bg-[#2A54F5] text-white text-[10px] font-bold flex items-center justify-center">
                            3
                        </span>
                    </a>

                    {{-- Keluar dari Sesi --}}
                    <div class="pt-2 mt-2 border-t border-slate-100">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-4 py-3 rounded-2xl text-rose-600 hover:bg-rose-50 font-semibold text-xs sm:text-sm transition cursor-pointer text-left">
                                <span class="material-symbols-outlined text-lg text-rose-500">logout</span>
                                <span>Keluar dari Sesi</span>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            {{-- ============ RIGHT COLUMN: FORM & STATUS LANGGANAN ============ --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 shadow-sm border border-slate-100/90">

                {{-- Header Section --}}
                <div class="flex items-start justify-between pb-6 border-b border-slate-100 flex-wrap gap-3">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900">Informasi Profil Member</h2>
                        <p class="text-xs text-slate-400 mt-1">Perbarui identitas visual dan informasi publik Anda di ekosistem MalangVerse.</p>
                    </div>
                    <div class="inline-flex items-center gap-1.5 bg-[#F1F5F9] text-slate-600 text-xs font-semibold px-3 py-1.5 rounded-full border border-slate-200/60 select-none">
                        <span class="material-symbols-outlined text-[15px] text-slate-500">public</span>
                        <span>Profil Publik</span>
                    </div>
                </div>

                {{-- Foto Tampilan Utama Upload Box --}}
                <div class="mt-6 p-4 sm:p-5 bg-[#F8FAFC] rounded-2xl border border-slate-100 flex flex-col sm:flex-row items-center gap-5">
                    <div class="relative shrink-0">
                        <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-full ring-4 ring-white shadow-sm overflow-hidden bg-slate-200">
                            <img id="mainAvatarPreviewImg" src="{{ $userAvatar }}" alt="Foto Tampilan Utama" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="flex-1 text-center sm:text-left">
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800">Foto Tampilan Utama</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5 mb-3">Format file JPG, PNG, atau WEBP. Ukuran maksimal 2MB.</p>

                        <div class="flex items-center justify-center sm:justify-start gap-2.5">
                            <input type="file" id="avatarFileInput" accept="image/jpeg,image/png,image/webp" class="hidden">
                            <button type="button"
                                    onclick="document.getElementById('avatarFileInput').click()"
                                    class="px-4 py-2 bg-[#2A54F5] hover:bg-blue-700 text-white font-bold text-xs rounded-full shadow-xs transition cursor-pointer">
                                Unggah Foto Baru
                            </button>
                            <button type="button"
                                    id="btnDeletePhoto"
                                    class="px-4 py-2 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-xs rounded-full transition cursor-pointer">
                                Hapus Foto
                            </button>
                        </div>
                        <p id="avatarUploadFeedback" class="text-xs mt-2 hidden"></p>
                    </div>
                </div>

                {{-- Form Inputs --}}
                <form id="profileUpdateForm" action="{{ route('profile.update') }}" method="POST" class="mt-6 space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Row 1: Nama Lengkap & Nama Panggilan / Alias Osob --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Nama Lengkap --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                            <div class="relative">
                                <input type="text" name="name" value="{{ old('name', $user->name ?? 'Ngalup Ker') }}" required
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 font-medium focus:outline-none focus:border-[#2A54F5] focus:ring-2 focus:ring-blue-100 transition pr-10">
                                <span class="material-symbols-outlined absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-300 text-lg pointer-events-none">id_card</span>
                            </div>
                        </div>

                        {{-- Nama Panggilan / Alias Osob --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Panggilan / Alias Osob</label>
                            <div class="relative">
                                <input type="text" name="alias_osob" value="{{ old('alias_osob', $user->alias_osob ?? 'Sam Kera Ngalam') }}"
                                       placeholder="Contoh: Sam Kera Ngalam"
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 font-medium focus:outline-none focus:border-[#2A54F5] focus:ring-2 focus:ring-blue-100 transition pr-10">
                                <span class="material-symbols-outlined absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-300 text-lg pointer-events-none">tag</span>
                            </div>
                        </div>
                    </div>

                    {{-- Row 2: Alamat Email & Nomor WhatsApp --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Alamat Email --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-bold text-slate-700">Alamat Email</label>
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60 select-none">
                                    <span class="material-symbols-outlined text-[13px]">check_circle</span>
                                    <span>Terverifikasi</span>
                                </span>
                            </div>
                            <div class="relative">
                                <input type="email" name="email" value="{{ old('email', $user->email ?? 'ngalup@ker.id') }}" required
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 font-medium focus:outline-none focus:border-[#2A54F5] focus:ring-2 focus:ring-blue-100 transition pr-10">
                                <span class="material-symbols-outlined absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-300 text-lg pointer-events-none">mail</span>
                            </div>
                        </div>

                        {{-- Nomor WhatsApp --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor WhatsApp</label>
                            <div class="relative">
                                <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '0812-3456-7890') }}"
                                       placeholder="08xxxxxxxxxx"
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 font-medium focus:outline-none focus:border-[#2A54F5] focus:ring-2 focus:ring-blue-100 transition pr-10">
                                <span class="material-symbols-outlined absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-300 text-lg pointer-events-none">chat</span>
                            </div>
                        </div>
                    </div>

                    {{-- Row 3: Domisili --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Domisili</label>
                        <div class="relative">
                            <input type="text" name="kota" value="{{ old('kota', $user->kota ?? 'Kota Malang, Jawa Timur') }}"
                                   placeholder="Contoh: Kota Malang, Jawa Timur"
                                   class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 font-medium focus:outline-none focus:border-[#2A54F5] focus:ring-2 focus:ring-blue-100 transition pr-10">
                            <span class="material-symbols-outlined absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-300 text-lg pointer-events-none">location_on</span>
                        </div>
                    </div>

                    {{-- Row 4: Bio Singkat --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-xs font-bold text-slate-700">Bio Singkat</label>
                            <span id="bioCharCounter" class="text-[11px] text-slate-400 font-medium">72 / 160 Karakter</span>
                        </div>
                        <textarea name="bio" id="bioInput" rows="3" maxlength="160"
                                  class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-xs sm:text-sm text-slate-800 font-medium focus:outline-none focus:border-[#2A54F5] focus:ring-2 focus:ring-blue-100 transition resize-none leading-relaxed"
                                  placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio', $user->bio ?? 'Pegiat kebudayaan Arema dan penutur aktif Boso Walikan sejak kecil.') }}</textarea>
                    </div>

                    {{-- Status Langganan Aktif Card --}}
                    <div class="mt-10 pt-4">
                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Status Langganan Aktif</h3>
                        <p class="text-xs text-slate-400 mt-0.5 mb-4">Rincian hak akses kamus komprehensif, fitur penerjemah instan, dan lisensi budaya.</p>

                        <div class="bg-gradient-to-r from-[#EFF6FF] via-[#F4F7FF] to-[#EEF2FF] border border-blue-100/90 rounded-3xl p-6 sm:p-7 flex flex-col md:flex-row md:items-center justify-between gap-5">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-full bg-[#1341D1] text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-500/20">
                                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">hotel_class</span>
                                </div>
                                <div>
                                    @if(isset($membership) && $membership->tier)
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-base font-extrabold text-slate-900">{{ $membership->tier->name }}</h4>
                                            <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Aktif</span>
                                        </div>
                                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                            Akses penuh ke 3.500+ entri osob, dan fitur penerjemah tanpa batas.
                                        </p>
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-5 mt-3 text-[11px] text-slate-500">
                                            <div class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-[15px] text-slate-400">qr_code_2</span>
                                                <span>Metode Pembayaran: <strong class="text-slate-800 font-semibold">QRIS Otomatis</strong></span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-[15px] text-slate-400">calendar_today</span>
                                                <span>Masa Langganan: <strong class="text-slate-800 font-semibold">{{ $membership->expires_at ? $membership->expires_at->format('d M Y') : '-' }}</strong></span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-base font-extrabold text-slate-900">Member Gratis</h4>
                                            <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Gratis</span>
                                        </div>
                                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                            Informasi langganan belum tersedia atau belum berlangganan paket berbayar.
                                        </p>
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-5 mt-3 text-[11px] text-slate-500">
                                            <div class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-[15px] text-slate-400">info</span>
                                                <span>Upgrade ke Standar atau Premium untuk akses tanpa batas.</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="shrink-0 text-center md:text-right">
                                <a href="{{ route('membership.public') }}"
                                   class="inline-block px-5 py-2.5 bg-white border border-[#2A54F5] text-[#2A54F5] hover:bg-blue-50 text-xs sm:text-sm font-bold rounded-full transition shadow-xs">
                                    Kelola Langganan
                                </a>
                                <span class="block text-[10px] text-slate-400 mt-1.5">Faktur otomatis dikirim via email</span>
                            </div>
                        </div>
                    </div>

                    {{-- Bottom Action Buttons --}}
                    <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                        <a href="{{ route('profile.index') }}"
                           class="px-6 py-2.5 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs sm:text-sm font-bold rounded-full transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 bg-[#2A54F5] hover:bg-blue-700 text-white text-xs sm:text-sm font-bold rounded-full shadow-md shadow-blue-500/20 transition flex items-center gap-2 cursor-pointer">
                            <span class="material-symbols-outlined text-base">save</span>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </main>

    {{-- Footer Component --}}
    <x-guest.beranda-footer />

    {{-- Script Interaktif Profil --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Karakter counter bio
            const bioInput = document.getElementById('bioInput');
            const bioCounter = document.getElementById('bioCharCounter');

            if (bioInput && bioCounter) {
                const updateCounter = () => {
                    bioCounter.textContent = `${bioInput.value.length} / 160 Karakter`;
                };
                bioInput.addEventListener('input', updateCounter);
                updateCounter();
            }

            // AJAX Upload Avatar
            const avatarInput = document.getElementById('avatarFileInput');
            const mainImg = document.getElementById('mainAvatarPreviewImg');
            const sidebarImg = document.getElementById('sidebarAvatarImg');
            const feedback = document.getElementById('avatarUploadFeedback');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (avatarInput) {
                avatarInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (!file) return;

                    // Preview langsung di UI
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        if (mainImg) mainImg.src = e.target.result;
                        if (sidebarImg) sidebarImg.src = e.target.result;
                    };
                    reader.readAsDataURL(file);

                    // Upload otomatis ke server
                    const formData = new FormData();
                    formData.append('avatar', file);

                    if (feedback) {
                        feedback.classList.remove('hidden', 'text-emerald-600', 'text-rose-600');
                        feedback.classList.add('text-blue-600');
                        feedback.textContent = 'Mengunggah foto...';
                    }

                    fetch("{{ route('profile.avatar') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (mainImg) mainImg.src = data.url;
                            if (sidebarImg) sidebarImg.src = data.url;
                            if (feedback) {
                                feedback.classList.remove('text-blue-600');
                                feedback.classList.add('text-emerald-600');
                                feedback.textContent = 'Foto profil berhasil diperbarui!';
                                setTimeout(() => feedback.classList.add('hidden'), 3000);
                            }
                        } else {
                            throw new Error(data.message || 'Gagal mengunggah foto.');
                        }
                    })
                    .catch(err => {
                        if (feedback) {
                            feedback.classList.remove('text-blue-600');
                            feedback.classList.add('text-rose-600');
                            feedback.textContent = err.message || 'Gagal mengunggah foto.';
                        }
                    });
                });
            }

            // Hapus Foto button
            const btnDeletePhoto = document.getElementById('btnDeletePhoto');
            if (btnDeletePhoto) {
                btnDeletePhoto.addEventListener('click', function () {
                    if (confirm('Apakah Anda yakin ingin menggunakan foto avatar default?')) {
                        const defaultUrl = 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=200&h=200&q=80';
                        if (mainImg) mainImg.src = defaultUrl;
                        if (sidebarImg) sidebarImg.src = defaultUrl;
                    }
                });
            }
        });
    </script>

</body>
</html>
