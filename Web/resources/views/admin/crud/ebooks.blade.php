@php
    $tier = $tier ?? null;
    $isEdit = $tier !== null;
    $modalId = 'modalPaket';
    $aksesDefault = old('akses_ebook', $tier->ebook_access ?? 'saku');
    $kuotaDefault = old('kuota_harian', $tier->translation_quota ?? 250);
    $hargaDefault = old('harga_bulanan', $tier->monthly_price ?? 25000);
@endphp

{{-- ===== WRAPPER MODAL ===== --}}
<div id="{{ $modalId }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[92vh] overflow-y-auto">

        {{-- HEADER --}}
        <div class="flex items-start gap-3 px-6 pt-6 pb-4">
            <div class="w-10 h-10 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0">
                <i class="fas fa-gear text-blue-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-base font-bold text-gray-900">
                    {{ $isEdit ? 'Ubah Konfigurasi Paket: ' . $tier->name : 'Konfigurasi Paket Langganan Baru' }}
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">Lengkapi parameter tier harga dan benefit Boso Walikan</p>
            </div>
            <button type="button" onclick="toggleModal('{{ $modalId }}')"
                    class="w-8 h-8 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 flex items-center justify-center transition-colors shrink-0">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        {{-- FORM --}}
        <form id="formPaket" method="POST"
              action="{{ $isEdit ? route('admin.membership.update', $tier) : route('admin.membership.store') }}"
              class="px-6 pb-6 space-y-5">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            {{-- Nama Tier & Tagline --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-700">Nama Tier Paket <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_tier" required value="{{ $tier->name ?? '' }}"
                           placeholder="cth: Paket Pelajar Arena"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                    @error('nama_tier') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-700">Tagline / Subteks</label>
                    <input type="text" name="tagline" value="{{ $tier->description ?? '' }}"
                           placeholder="Akses hemat untuk kalangan sekolah &amp; mahasiswa"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                    @error('tagline') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Skema Tarif --}}
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-gray-800">Skema Penetapan Tarif (Rupiah)</p>
                    <span class="text-[11px] font-medium text-blue-600">Mendukung Pembayaran QRIS Dinamis</span>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-600">Harga Bulanan (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-400">Rp</span>
                        <input type="number" name="harga_bulanan" required min="0" step="500" value="{{ $hargaDefault }}"
                               class="w-full pl-10 pr-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                    </div>
                    @error('harga_bulanan') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Kuota Terjemahan --}}
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-semibold text-gray-700">Batas Kuota Terjemahan Harian</label>
                    <span id="kuotaBadge" class="text-[11px] font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">
                        {{ number_format($kuotaDefault, 0, ',', '.') }} kata / hari
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <input type="range" id="kuotaSlider" name="kuota_slider" min="0" max="1000" step="10"
                           value="{{ $kuotaDefault }}"
                           class="flex-1 h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
                    <input type="number" id="kuotaInput" name="kuota_harian" min="0" max="1000"
                           value="{{ $kuotaDefault }}"
                           class="w-24 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-right focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all">
                </div>
            </div>

            {{-- Hak Akses E-Book --}}
            <div class="space-y-2">
                <label class="text-xs font-semibold text-gray-700">Hak Akses E-Book Kamus</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <label class="radio-card flex items-center gap-2.5 px-3.5 py-3 rounded-xl border cursor-pointer transition-all">
                        <input type="radio" name="akses_ebook" value="semua" class="accent-blue-600" {{ $aksesDefault === 'semua' ? 'checked' : '' }}>
                        <span class="text-xs font-semibold text-gray-700">Semua Kamus</span>
                    </label>
                    <label class="radio-card flex items-center gap-2.5 px-3.5 py-3 rounded-xl border cursor-pointer transition-all">
                        <input type="radio" name="akses_ebook" value="saku" class="accent-blue-600" {{ $aksesDefault === 'saku' ? 'checked' : '' }}>
                        <span class="text-xs font-semibold text-gray-700">Kamus Saku Saja</span>
                    </label>
                    <label class="radio-card flex items-center gap-2.5 px-3.5 py-3 rounded-xl border cursor-pointer transition-all">
                        <input type="radio" name="akses_ebook" value="khusus" class="accent-blue-600" {{ $aksesDefault === 'khusus' ? 'checked' : '' }}>
                        <span class="text-xs font-semibold text-gray-700">Pilihan Khusus</span>
                    </label>
                </div>
            </div>

            {{-- Fitur Tambahan --}}
            <div class="space-y-2">
                <label class="text-xs font-semibold text-gray-700">Fitur Tambahan &amp; Privilege</label>
                <label class="radio-card flex items-start gap-3 px-4 py-3.5 rounded-xl border cursor-pointer transition-all">
                    <input type="radio" name="fitur_tambahan" value="badge_pelajar" class="accent-blue-600 mt-0.5" checked>
                    <span>
                        <span class="block text-xs font-bold text-gray-800">Badge Komunitas 'Kara Ngalam Pelajar'</span>
                        <span class="block text-[11px] text-gray-500 mt-0.5">Lencana verifikasi profil di forum diskusi &amp; kulik mingguan</span>
                    </span>
                </label>
            </div>

            {{-- FOOTER --}}
            <div class="flex items-center justify-between pt-2">
                <button type="button" onclick="toggleModal('{{ $modalId }}')"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 rounded-lg transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md shadow-blue-600/25 transition-all flex items-center gap-2">
                    <i class="fas fa-floppy-disk text-xs"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== SCRIPT MODAL PAKET ===== --}}
<script>
    /* Toggle modal (aman walau sudah didefinisikan di modal ebook) */
    if (typeof window.toggleModal !== 'function') {
        window.toggleModal = function (id) {
            const m = document.getElementById(id);
            if (!m) return;
            m.classList.toggle('hidden');
            m.classList.toggle('flex');
            document.body.style.overflow = m.classList.contains('hidden') ? 'auto' : 'hidden';
        };
    }

    /* Sinkron slider <-> input angka <-> badge */
    const kuotaSlider = document.getElementById('kuotaSlider');
    const kuotaInput = document.getElementById('kuotaInput');
    const kuotaBadge = document.getElementById('kuotaBadge');

    function renderKuota(val) {
        val = Math.max(0, Math.min(1000, parseInt(val) || 0));
        kuotaInput.value = val;
        kuotaSlider.value = val;
        kuotaBadge.textContent = val.toLocaleString('id-ID') + ' kata / hari';
    }
    kuotaSlider.addEventListener('input', e => renderKuota(e.target.value));
    kuotaInput.addEventListener('input', e => renderKuota(e.target.value));
    renderKuota(kuotaSlider.value);

    /* Styling radio card terpilih */
    function paintRadioCards() {
        document.querySelectorAll('.radio-card').forEach(card => {
            const radio = card.querySelector('input[type=radio]');
            const active = radio.checked;
            card.classList.toggle('border-blue-600', active);
            card.classList.toggle('bg-blue-50/60', active);
            card.classList.toggle('border-gray-200', !active);
        });
    }
    document.querySelectorAll('.radio-card input[type=radio]').forEach(r => {
        r.addEventListener('change', paintRadioCards);
    });
    paintRadioCards();
</script>