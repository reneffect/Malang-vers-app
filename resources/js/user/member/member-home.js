import { initializeTranslator } from '../../translator.js';
import { generateFingerprint } from '../../fingerprint.js';

const walikanEl = document.getElementById('walikanText');
const indoEl    = document.getElementById('indoText');

// ─── Quota UI Elements ───────────────────────────────────
const quotaBadge     = document.getElementById('quota-badge');
const quotaText      = document.getElementById('quota-text');
const quotaBar       = document.getElementById('quota-bar');
const creditEstimate = document.getElementById('credit-estimate');

function updateQuotaUI(quota) {
    if (!quotaBadge) return;

    if (quota.type === 'member') {
        const pct = (quota.balance / quota.max) * 100;
        if (quotaText)  quotaText.textContent = `Credit: ${quota.balance} / ${quota.max}`;
        if (quotaBar) {
            quotaBar.style.width = `${pct}%`;
            // Change bar color based on remaining
            quotaBar.className = quotaBar.className.replace(/bg-\S+/, '');
            if (pct > 50) quotaBar.classList.add('bg-blue-500');
            else if (pct > 20) quotaBar.classList.add('bg-yellow-500');
            else quotaBar.classList.add('bg-red-500');
        }
        quotaBadge.classList.remove('hidden');
    }
}

// ─── Estimasi credit real-time ───────────────────────────
function updateCreditEstimate() {
    if (!creditEstimate || !walikanEl) return;
    const text = walikanEl.value.trim();
    if (!text) {
        creditEstimate.classList.add('hidden');
        return;
    }
    const wordCount = text.split(/\s+/).filter(w => w.length > 0).length;
    const cost = wordCount * 5;
    creditEstimate.textContent = `⚡ Estimasi: ${cost} credit (${wordCount} kata × 5)`;
    creditEstimate.classList.remove('hidden');
}

// ─── Initialize Translator ──────────────────────────────
const translator = initializeTranslator({
    sourceInput:    walikanEl,
    targetInput:    indoEl,
    sourceLabel:    document.getElementById('source-language-label'),
    targetLabel:    document.getElementById('target-language-label'),
    sourceCount:    document.getElementById('sourceCount'),
    targetCount:    document.getElementById('targetCount'),
    status:         document.getElementById('translationStatus'),
    loadingIndicator: document.getElementById('loadingIndicator'),
    getFingerprint: generateFingerprint,
    onQuotaUpdate:  updateQuotaUI,
});

walikanEl?.addEventListener('input', updateCreditEstimate);

window.translateText = translator.translateNow;
window.swapText = translator.swapLanguages;

window.clearAll = function () {
    translator.clear();
    if (creditEstimate) creditEstimate.classList.add('hidden');
    window.showToast('🗑️ Teks dihapus!');
};

window.speakText = function () {
    const text = translator.direction() === 'id_to_walikan' ? walikanEl.value : indoEl.value;
    if (!text) {
        return window.showToast('⚠️ Tidak ada teks untuk dibacakan!');
    }

    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'id-ID';
    utterance.rate = 0.9;
    speechSynthesis.speak(utterance);
    window.showToast('🔊 Membacakan teks...');
};

window.usePhrase = function (idText, walikanText) {
    translator.setDirection('walikan_to_id');
    translator.setValues(walikanText, idText);
    window.showToast('✅ Frasa digunakan!');
};

window.showToast = function (message) {
    const toast = document.getElementById('toast');
    if (!toast) return;
    toast.textContent = message;
    toast.classList.remove('translate-y-32', 'opacity-0');
    toast.classList.add('translate-y-0', 'opacity-100');

    window.setTimeout(() => {
        toast.classList.add('translate-y-32', 'opacity-0');
        toast.classList.remove('translate-y-0', 'opacity-100');
    }, 2500);
};

window.copyText = async function (elementId) {
    const el = document.getElementById(elementId);
    if (!el || !el.value) {
        window.showToast('⚠️ Tidak ada teks untuk disalin!');
        return;
    }

    try {
        await navigator.clipboard.writeText(el.value);
        window.showToast('Teks berhasil disalin.');
    } catch (error) {
        console.error('Gagal menyalin teks.', error);
        window.showToast('Teks gagal disalin.');
    }
};

window.copyHistoryText = async function (button) {
    const text = button.dataset.text;
    if (!text) return;

    try {
        await navigator.clipboard.writeText(text);
        window.showToast('📋 Terjemahan berhasil disalin!');
    } catch (error) {
        console.error('Gagal menyalin teks.', error);
        window.showToast('Teks gagal disalin.');
    }
};

// ─── Card focus / active toggle ──────────────────────────
const cardSumber = document.getElementById('card-sumber');
const cardHasil  = document.getElementById('card-hasil');

cardSumber?.addEventListener('click', (e) => {
    cardSumber.classList.add('is-active');
    cardHasil?.classList.remove('is-active');
    if (e.target !== walikanEl) walikanEl?.focus();
});

cardHasil?.addEventListener('click', (e) => {
    cardHasil.classList.add('is-active');
    cardSumber?.classList.remove('is-active');
    if (e.target !== indoEl) indoEl?.focus();
});

walikanEl?.addEventListener('focus', () => {
    cardSumber?.classList.add('is-active');
    cardHasil?.classList.remove('is-active');
});

indoEl?.addEventListener('focus', () => {
    cardHasil?.classList.add('is-active');
    cardSumber?.classList.remove('is-active');
});

document.addEventListener('keydown', (event) => {
    if (event.ctrlKey && event.key === 'Enter') {
        window.translateText();
    }
});
