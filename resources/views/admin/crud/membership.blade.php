@php
    $action = $action ?? route('admin.membership.store');
    $paket = $paket ?? null;
    $isEdit = $paket !== null;
    $modalId = 'modalPaket';
    $features = $isEdit && is_array($paket->features) ? $paket->features : [];
@endphp

{{-- ===== WRAPPER MODAL ===== --}}
<div id="{{ $modalId }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[92vh] overflow-y-auto">

        {{-- ===== HEADER ===== --}}
        <div class="flex items-start gap-3 px-6 pt-6 pb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0">
                <i class="fas fa-crown text-blue-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-base font-bold text-gray-900" id="modalPaketTitle">
                    Konfigurasi Paket Langganan Baru
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">
                    Lengkapi parameter tier harga dan benefit Boso Walikan
                </p>
            </div>
            <button type="button" onclick="toggleModal('{{ $modalId }}')"
                    class="w-8 h-8 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 flex items-center justify-center transition-colors shrink-0">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        {{-- ===== FORM ===== --}}
        <form id="formPaket" method="POST" action="{{ $action }}" class="px-6 pb-6 space-y-5">
            @csrf
            @if($isEdit) @method('PUT') @endif

            {{-- Nama Tier + Tagline (2 kolom) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-700">Nama Tier Paket <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required
                           value="{{ old('name', $paket->name ?? '') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all"
                           placeholder="Paket Pelajar Arena">
                    @error('name') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-700">Tagline / Subteks</label>
                    <input type="text" name="tagline"
                           value="{{ old('tagline', $paket->tagline ?? '') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all"
                           placeholder="Akses hemat untuk kera ngalam sekolah & ...">
                    @error('tagline') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Skema Tarif (2 kolom + link QRIS) --}}
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-semibold text-gray-700">Skema Penetapan Tarif (Rupiah)</label>
                    <a href="#" class="text-[11px] text-blue-600 hover:underline font-medium">
                        Mendukung Pembayaran QRIS Dinamis
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] text-gray-500">Harga Bulanan (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-semibold text-gray-400">Rp</span>
                            <input type="number" name="monthly_price" required min="0"
                                   value="{{ old('monthly_price', $paket->monthly_price ?? '') }}"
                                   class="w-full pl-10 pr-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all"
                                   placeholder="25.000">
                        </div>
                        @error('monthly_price') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label class="text-[11px] text-gray-500">Harga Tahunan (Rp)</label>
                            <span id="hematBadge" class="hidden text-[10px] font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Hemat <span id="hematPercent">0</span>%</span>
                        </div>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-semibold text-gray-400">Rp</span>
                            <input type="number" name="yearly_price" required min="0" id="yearlyPrice"
                                   value="{{ old('yearly_price', $paket->yearly_price ?? '') }}"
                                   class="w-full pl-10 pr-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all"
                                   placeholder="240.000">
                        </div>
                        @error('yearly_price') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Batas Kuota Terjemahan Harian --}}
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-semibold text-gray-700">Batas Kuota Terjemahan Harian</label>
                    <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                        <span id="kuotaLabel">250</span> kata / hari
                    </span>
                </div>
                <input type="number" name="translation_quota" min="0" id="kuotaInput"
                       value="{{ old('translation_quota', $paket->translation_quota ?? 250) }}"
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15 transition-all"
                       placeholder="250">
                <p class="text-[11px] text-gray-400">*Kosongkan jika ingin Tanpa Batas (Unlimited)</p>
                @error('translation_quota') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Hak Akses E-Book Kamus (Radio) --}}
            <div class="space-y-2">
                <label class="text-xs font-semibold text-gray-700">Hak Akses E-Book Kamus</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @php $aksesOptions = ['semua' => 'Semua Kamus', 'saku' => 'Kamus Saku Saja', 'khusus' => 'Pilihan Khusus']; @endphp
                    @foreach($aksesOptions as $val => $label)
                        <label class="relative flex items-center gap-2 px-4 py-2.5 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                            <input type="radio" name="ebook_access" value="{{ $val }}"
                                   {{ old('ebook_access', $paket->ebook_access ?? 'saku') == $val ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                @error('ebook_access') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Fitur Tambahan & Privilese (Checkbox) --}}
            <div class="space-y-2">
                <label class="text-xs font-semibold text-gray-700">Fitur Tambahan & Privilese</label>
                <div class="space-y-2">
                    @php
                        $privileges = [
                            'audio_nafiri' => [
                                'title' => 'Audio Nafiri Kiwalan',
                                'desc' => 'User dapat mendengarkan pengucapan otentik dari penutur asli Malang'
                            ],
                            'badge_komunitas' => [
                                'title' => 'Badge Komunitas "Kera Ngalam Pelajar"',
                                'desc' => 'Menonjolkan verifikasi profil di forum diskusi & kuis mingguan'
                            ],
                            'bebas_iklan' => [
                                'title' => 'Bebas Iklan (Ad-Free Experience)',
                                'desc' => 'Menghilangkan banner promo pihak ketiga di halaman beranda'
                            ],
                        ];
                        $oldPrivileges = old('privileges', $features);
                    @endphp
                    @foreach($privileges as $key => $item)
                        <label class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/50">
                            <input type="checkbox" name="privileges[]" value="{{ $key }}"
                                   {{ is_array($oldPrivileges) && in_array($key, $oldPrivileges) ? 'checked' : '' }}
                                   class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $item['title'] }}</p>
                                <p class="text-[11px] text-gray-500 mt-0.5">{{ $item['desc'] }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('privileges') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- ===== FOOTER ===== --}}
            <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                <button type="button" onclick="toggleModal('{{ $modalId }}')"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 rounded-lg transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md shadow-blue-600/25 transition-all flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span id="submitLabel">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Perubahan' }}</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script khusus modal paket --}}
<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        if (!modal) {
            throw new Error(`Modal not found: ${id}`);
        }

        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
        document.body.style.overflow = modal.classList.contains('hidden') ? 'auto' : 'hidden';
    }

    // Hitung otomatis persentase hemat
    const monthlyInput = document.querySelector('[name="monthly_price"]');
    const yearlyInput  = document.getElementById('yearlyPrice');
    const hematBadge   = document.getElementById('hematBadge');
    const hematPercent = document.getElementById('hematPercent');

    function hitungHemat() {
        const m = parseInt(monthlyInput?.value || 0);
        const y = parseInt(yearlyInput?.value || 0);
        if (m > 0 && y > 0) {
            const hemat = Math.round(((m * 12 - y) / (m * 12)) * 100);
            if (hemat > 0) {
                hematPercent.textContent = hemat;
                hematBadge.classList.remove('hidden');
            } else {
                hematBadge.classList.add('hidden');
            }
        } else {
            hematBadge.classList.add('hidden');
        }
    }
    monthlyInput?.addEventListener('input', hitungHemat);
    yearlyInput?.addEventListener('input', hitungHemat);
    hitungHemat();

    // Update label kuota real-time
    const kuotaInput = document.getElementById('kuotaInput');
    const kuotaLabel = document.getElementById('kuotaLabel');
    kuotaInput?.addEventListener('input', () => {
        kuotaLabel.textContent = kuotaInput.value || '0';
    });
</script>