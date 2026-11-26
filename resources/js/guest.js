import { initializeTranslator } from './translator.js';
import { generateFingerprint } from './fingerprint.js';

const sourceInput = document.getElementById('sumber-teks');
const targetInput = document.getElementById('hasil-teks');

if (sourceInput && targetInput) {
    // ─── Quota UI Elements ───────────────────────────────
    const quotaBadge     = document.getElementById('quota-badge');
    const quotaText      = document.getElementById('quota-text');
    const quotaBar       = document.getElementById('quota-bar');
    const creditEstimate = document.getElementById('credit-estimate');
    const loginModal     = document.getElementById('login-modal');

    function updateQuotaUI(quota) {
        if (!quotaBadge) return;

        if (quota.type === 'guest') {
            const pct = (quota.remaining / quota.max) * 100;
            if (quotaText)  quotaText.textContent = `Sisa Token: ${quota.remaining} / ${quota.max}`;
            if (quotaBar)   quotaBar.style.width = `${pct}%`;
            quotaBadge.classList.remove('hidden');

            // Tampilkan modal login jika token habis
            if (quota.remaining <= 0 && loginModal) {
                loginModal.classList.remove('hidden');
            }
        } else if (quota.type === 'member') {
            const pct = (quota.balance / quota.max) * 100;
            if (quotaText)  quotaText.textContent = `Credit Harian: ${quota.balance} / ${quota.max}`;
            if (quotaBar)   quotaBar.style.width = `${pct}%`;
            quotaBadge.classList.remove('hidden');
        }
    }

    // ─── Estimasi credit real-time (member) ──────────────
    function updateCreditEstimate() {
        if (!creditEstimate) return;
        const text = sourceInput.value.trim();
        if (!text) {
            creditEstimate.classList.add('hidden');
            return;
        }
        const wordCount = text.split(/\s+/).filter(w => w.length > 0).length;
        const cost = wordCount * 5;
        creditEstimate.textContent = `Estimasi biaya: ${cost} credit (${wordCount} kata × 5)`;
        creditEstimate.classList.remove('hidden');
    }

    sourceInput.addEventListener('input', updateCreditEstimate);

    // ─── Initialize Translator ───────────────────────────
    const translator = initializeTranslator({
        sourceInput,
        targetInput,
        sourceLabel:      document.getElementById('source-language-label'),
        targetLabel:      document.getElementById('target-language-label'),
        sourceCount:      document.getElementById('jumlah-karakter'),
        targetCount:      document.getElementById('jumlah-hasil'),
        status:           document.getElementById('status-terjemah'),
        maxLength:        500,
        getFingerprint:   generateFingerprint,
        onQuotaUpdate:    updateQuotaUI,
    });

    document.getElementById('btn-tukar')?.addEventListener('click', translator.swapLanguages);

    document.getElementById('btn-salin')?.addEventListener('click', async () => {
        if (!targetInput.value) return;

        try {
            await navigator.clipboard.writeText(targetInput.value);
            document.getElementById('status-terjemah').textContent = 'Teks berhasil disalin.';
        } catch (error) {
            console.error('Gagal menyalin teks.', error);
            document.getElementById('status-terjemah').textContent = 'Teks gagal disalin.';
        }
    });

    document.querySelectorAll('.btn-kata').forEach((button) => {
        button.addEventListener('click', () => {
            sourceInput.value = button.dataset.kata ?? '';
            sourceInput.dispatchEvent(new Event('input', { bubbles: true }));
            sourceInput.focus();
        });
    });

    // ─── Card active toggle ──────────────────────────────
    const cardSumber = document.getElementById('card-sumber');
    const cardHasil  = document.getElementById('card-hasil');

    cardSumber?.addEventListener('click', (e) => {
        cardSumber.classList.add('is-active');
        cardHasil?.classList.remove('is-active');
        if (e.target !== sourceInput) sourceInput.focus();
    });

    cardHasil?.addEventListener('click', (e) => {
        cardHasil.classList.add('is-active');
        cardSumber?.classList.remove('is-active');
        if (e.target !== targetInput) targetInput.focus();
    });

    sourceInput.addEventListener('focus', () => {
        cardSumber?.classList.add('is-active');
        cardHasil?.classList.remove('is-active');
    });

    targetInput.addEventListener('focus', () => {
        cardHasil?.classList.add('is-active');
        cardSumber?.classList.remove('is-active');
    });

    // ─── Close login modal ───────────────────────────────
    document.getElementById('close-login-modal')?.addEventListener('click', () => {
        loginModal?.classList.add('hidden');
    });
}
