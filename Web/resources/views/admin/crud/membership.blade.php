{{-- resources/views/admin/crud/membership.blade.php --}}
@php
    $modalId = 'modalPaket';
@endphp

<div id="{{ $modalId }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[92vh] overflow-y-auto">

        {{-- HEADER --}}
        <div class="flex items-start gap-3 px-6 pt-6 pb-4">
            <div class="w-10 h-10 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0">
                <i class="fas fa-gear text-blue-600"></i>
            </div>
            <div class="flex-1">
                <h3 id="paketTitle" class="text-base font-bold text-gray-900">Konfigurasi Paket Langganan Baru</h3>
                <p class="text-xs text-gray-500 mt-0.5">Lengkapi parameter tier harga dan benefit Boso Walikan</p>
            </div>
            <button type="button" onclick="closePaketModal()"
                    class="w-8 h-8 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 flex items-center justify-center transition-colors shrink-0">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        <form id="formPaket" method="POST" action="{{ route('admin.membership.store') }}" class="px-6 pb-6 space-y-5">
            @csrf
            <input type="hidden" name="_method" id="paketMethod" value="POST">

            {{-- Nama Tier & Tagline --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-700">Nama Tier Paket <span class="text-red-500">*</span></label>
                    <input type="text" id="f_nama_tier" name="nama_tier" required value="{{ old('nama_tier') }}"
                           placeholder="cth: Paket Pelajar Arena"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                    @error('nama_tier') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-700">Tagline / Subteks</label>
                    <input type="text" id="f_tagline" name="tagline" value="{{ old('tagline') }}"
                           placeholder="Akses hemat untuk kalangan sekolah &amp; mahasiswa"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                    @error('tagline') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Skema Tarif --}}
            <div class="space-y-3 p-4 rounded-xl bg-blue-50/40 border border-blue-100">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-gray-800">Skema Penetapan Tarif (Rupiah)</p>
                    <span class="text-[11px] font-medium text-blue-600">Mendukung Pembayaran QRIS Dinamis</span>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-600">Harga Bulanan (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-400">Rp</span>
                        <input type="number" id="f_harga_bulanan" name="harga_bulanan" required min="0" step="500"
                               value="{{ old('harga_bulanan', 25000) }}"
                               class="w-full pl-10 pr-3.5 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                    </div>
                    @error('harga_bulanan') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-600">Harga Tahunan (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-400">Rp</span>
                        <input type="number" id="f_harga_tahunan" name="harga_tahunan" min="0" step="500"
                               value="{{ old('harga_tahunan', 250000) }}"
                               class="w-full pl-10 pr-3.5 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                    </div>
                    @error('harga_tahunan') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Kuota Terjemahan --}}
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-semibold text-gray-700">Batas Kuota Terjemahan Harian</label>
                    <span id="kuotaBadge" class="text-[11px] font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">250 kata / hari</span>
                </div>
                <div class="flex items-center gap-4">
                    <input type="range" id="kuotaSlider" min="0" max="1000" step="10" value="250"
                           class="flex-1 h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
                    <input type="number" id="kuotaInput" name="kuota_harian" min="0" max="1000" value="250"
                           class="w-24 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-right focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                </div>
                <p class="text-[11px] text-gray-400">*Kosongkan jika ingin Tanpa Batas (Unlimited)</p>
            </div>

            {{-- Hak Akses E-Book --}}
            <div class="space-y-2">
                <label class="text-xs font-semibold text-gray-700">Hak Akses E-Book Kamus</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @foreach (['semua' => 'Semua Kamus', 'saku' => 'Kamus Saku Saja', 'khusus' => 'Pilihan Khusus'] as $val => $text)
                        <label class="radio-card flex items-center justify-between gap-2.5 px-3.5 py-3 rounded-xl border cursor-pointer transition-all">
                            <span class="text-xs font-semibold text-gray-700">{{ $text }}</span>
                            <input type="radio" name="akses_ebook" value="{{ $val }}" class="sr-only" @checked($val === 'saku')>
                            <span class="radio-dot w-4 h-4 rounded-full border flex items-center justify-center shrink-0"></span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Fitur Tambahan --}}
            <div class="space-y-2">
                <label class="text-xs font-semibold text-gray-700">Fitur Tambahan &amp; Privilese</label>
                @php
                    $fiturList = [
                        'audio_kiwalan' => ['Audio Nafiri Kiwalan', 'User dapat mendengarkan pengucapan otentik dari penutur asli Malang'],
                        'badge_pelajar' => ['Badge Komunitas "Kera Ngalam Pelajar"', 'Menonjolkan verifikasi profil di forum diskusi & kuis mingguan'],
                        'ad_free'       => ['Bebas Iklan (Ad-Free Experience)', 'Menghilangkan banner promo pihak ketiga di halaman beranda'],
                    ];
                @endphp
                @foreach ($fiturList as $val => [$judul, $desc])
                    <label class="radio-card flex items-start gap-3 px-4 py-3.5 rounded-xl border cursor-pointer transition-all">
                        <input type="radio" name="fitur_tambahan" value="{{ $val }}" class="sr-only" @checked($val === 'badge_pelajar')>
                        <span class="radio-dot mt-0.5 w-4 h-4 rounded-full border flex items-center justify-center shrink-0"></span>
                        <span>
                            <span class="block text-xs font-bold text-gray-800">{{ $judul }}</span>
                            <span class="block text-[11px] text-gray-500 mt-0.5">{{ $desc }}</span>
                        </span>
                    </label>
                @endforeach
            </div>

            {{-- FOOTER --}}
            <div class="flex items-center justify-between pt-2">
                <button type="button" onclick="closePaketModal()"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 rounded-lg transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md shadow-blue-600/25 transition-all flex items-center gap-2">
                    <i class="fas fa-floppy-disk text-xs"></i> <span id="paketSubmitText">Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    const PAKET_STORE_URL = @json(route('admin.membership.store'));
    const paketModal = document.getElementById('{{ $modalId }}');
    const paketForm  = document.getElementById('formPaket');
    const $ = id => document.getElementById(id);

    /* ---------- buka / tutup ---------- */
    function openPaketModal() {
        paketModal.classList.remove('hidden');
        paketModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closePaketModal() {
        paketModal.classList.add('hidden');
        paketModal.classList.remove('flex');
        document.body.style.overflow = '';
    }
    window.openPaketModal  = openPaketModal;
    window.closePaketModal = closePaketModal;
    window.toggleModal = function (id) {
        if (id === '{{ $modalId }}') {
            paketModal.classList.contains('hidden') ? openCreatePaket() : closePaketModal();
        }
    };

    /* ---------- helper radio ---------- */
    function setRadio(name, value, fallback) {
        const r = document.querySelector(`input[name="${name}"][value="${value}"]`)
               || document.querySelector(`input[name="${name}"][value="${fallback}"]`);
        if (r) r.checked = true;
    }
    function paintRadioCards() {
        document.querySelectorAll('.radio-card').forEach(card => {
            const input  = card.querySelector('input[type=radio]');
            const dot    = card.querySelector('.radio-dot');
            const active = input.checked;
            card.classList.toggle('border-blue-600', active);
            card.classList.toggle('bg-blue-50/60', active);
            card.classList.toggle('border-gray-200', !active);
            if (dot) {
                dot.classList.toggle('bg-blue-600', active);
                dot.classList.toggle('border-blue-600', active);
                dot.classList.toggle('border-gray-300', !active);
                dot.innerHTML = active ? '<i class="fas fa-check text-[8px] text-white"></i>' : '';
            }
        });
    }
    document.querySelectorAll('.radio-card input[type=radio]')
        .forEach(r => r.addEventListener('change', paintRadioCards));

    /* ---------- kuota (kosong = unlimited) ---------- */
    const kuotaSlider = $('kuotaSlider');
    const kuotaInput  = $('kuotaInput');
    const kuotaBadge  = $('kuotaBadge');

    function renderKuota(val, fromInput = false) {
        if (val === '' || val === null || val === undefined) {
            if (!fromInput) kuotaInput.value = '';
            kuotaSlider.value = 1000;
            kuotaBadge.textContent = 'Tanpa Batas';
            return;
        }
        val = Math.max(0, Math.min(1000, parseInt(val) || 0));
        if (!fromInput) kuotaInput.value = val;
        kuotaSlider.value = val;
        kuotaBadge.textContent = val.toLocaleString('id-ID') + ' kata / hari';
    }
    kuotaSlider.addEventListener('input', e => renderKuota(e.target.value));
    kuotaInput.addEventListener('input',  e => renderKuota(e.target.value, true));

    /* ---------- TAMBAH ---------- */
    function openCreatePaket() {
        paketForm.reset();
        paketForm.action = PAKET_STORE_URL;
        $('paketMethod').value = 'POST';
        $('paketTitle').textContent = 'Konfigurasi Paket Langganan Baru';
        $('paketSubmitText').textContent = 'Simpan';
        $('f_harga_bulanan').value = 25000;
        $('f_harga_tahunan').value = 250000;
        setRadio('akses_ebook', 'saku', 'saku');
        setRadio('fitur_tambahan', 'badge_pelajar', 'badge_pelajar');
        renderKuota(250);
        paintRadioCards();
        openPaketModal();
    }
    window.openCreatePaket = openCreatePaket;

    /* ---------- UBAH ----------
       Panggil dari index:
       onclick="openEditPaket(@js($tier), @js(route('admin.membership.update', $tier)))" */
    function openEditPaket(tier, updateUrl) {
        if (!updateUrl || /\/(undefined|null)$/.test(updateUrl)) {
            alert('Alamat update paket tidak valid. Cek pemanggilan openEditPaket di index.');
            return;
        }
        paketForm.reset();
        paketForm.action = updateUrl;
        $('paketMethod').value = 'PUT';
        $('paketTitle').textContent = 'Ubah Konfigurasi Paket: ' + (tier.name ?? '');
        $('paketSubmitText').textContent = 'Simpan Perubahan';

        $('f_nama_tier').value     = tier.name ?? '';
        $('f_tagline').value       = tier.tagline ?? tier.description ?? '';
        $('f_harga_bulanan').value = Math.round(tier.monthly_price ?? 0);
        $('f_harga_tahunan').value = Math.round(tier.yearly_price ?? 0);
        setRadio('akses_ebook', tier.ebook_access ?? 'saku', 'saku');
        setRadio('fitur_tambahan', tier.fitur_tambahan ?? tier.feature ?? 'badge_pelajar', 'badge_pelajar');
        renderKuota(tier.translation_quota ?? '');
        paintRadioCards();
        openPaketModal();
    }
    window.openEditPaket = openEditPaket;

    /* ---------- cegah submit ke alamat rusak ---------- */
    paketForm.addEventListener('submit', function (e) {
        const path = paketForm.action.split('?')[0];
        if (/\/(undefined|null)$/.test(path)) {
            e.preventDefault();
            alert('Alamat form tidak valid. Muat ulang halaman lalu coba lagi.');
        }
    });

    /* klik area gelap / Esc = tutup */
    paketModal.addEventListener('click', e => { if (e.target === paketModal) closePaketModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closePaketModal(); });

    renderKuota(kuotaSlider.value);
    paintRadioCards();
})();
</script>