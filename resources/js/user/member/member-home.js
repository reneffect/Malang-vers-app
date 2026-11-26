import { initializeTranslator } from '../../translator.js';
import { generateFingerprint } from '../../fingerprint.js';

const walikanEl = document.getElementById('walikanText');
const indoEl    = document.getElementById('indoText');

// ─── Quota UI Elements ───────────────────────────────────
const quotaBadge     = document.getElementById('quota-badge');
const quotaText      = document.getElementById('quota-text');
const quotaBar       = document.getElementById('quota-bar');
const creditEstimate = document.getElementById('credit-estimate');
let creditsPerWord = Number(quotaBadge?.dataset.creditsPerWord ?? 5);
let isUnlimited = quotaBadge?.dataset.unlimited === 'true';

function updateQuotaUI(quota) {
    if (!quotaBadge) return;

    if (quota.type === 'member') {
        creditsPerWord = Number(quota.credits_per_word ?? creditsPerWord);
        isUnlimited = quota.is_unlimited === true;
        const pct = isUnlimited ? 100 : (quota.max > 0
            ? Math.min(100, Math.max(0, (quota.balance / quota.max) * 100))
            : 0);
        if (quotaText) {
            quotaText.textContent = isUnlimited
                ? 'Credit: Tanpa Batas'
                : `Credit: ${quota.balance} / ${quota.max}`;
        }
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
    if (isUnlimited) {
        creditEstimate.textContent = '⚡ Terjemahan tanpa batas';
    } else {
        const cost = wordCount * creditsPerWord;
        creditEstimate.textContent = `⚡ Estimasi: ${cost} credit (${wordCount} kata × ${creditsPerWord})`;
    }
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

const historyList = document.getElementById('translation-history-list');
const historyItemTemplate = document.getElementById('translation-history-item-template');
const historyEmptyMessage = document.getElementById('translation-history-empty');
const historyCount = document.getElementById('translation-history-count');
const popularPhraseList = document.getElementById('popular-phrase-list');
const popularPhrasesUrl = document.querySelector('meta[name="popular-phrases-url"]')?.content;

function addTranslationToHistory({ original, translated, direction }) {
    const templateItem = historyItemTemplate?.content.firstElementChild;

    if (!historyList || !templateItem) {
        return;
    }

    const historyItem = templateItem.cloneNode(true);
    historyItem.querySelector('[data-history-direction-label]').textContent =
        direction === 'id_to_walikan' ? 'Bahasa Indonesia:' : 'Osob Kiwalan:';
    historyItem.querySelector('[data-history-original]').textContent = original;
    historyItem.querySelector('[data-history-translated]').textContent = translated;
    historyItem.querySelector('[data-history-copy]').dataset.text = translated;
    historyList.prepend(historyItem);

    while (historyList.children.length > 4) {
        historyList.lastElementChild.remove();
    }

    historyEmptyMessage?.classList.add('hidden');

    if (historyCount) {
        historyCount.textContent = String(Number(historyCount.textContent) + 1);
    }
}

function createPopularPhraseButton(phrase) {
    const button = document.createElement('button');
    button.type = 'button';
    button.dataset.phraseId = phrase.indonesian;
    button.dataset.phraseWalikan = phrase.walikan;
    button.className = 'inline-flex items-center gap-1.5 rounded-full border border-slate-200/90 bg-[#F4F7FF] px-3.5 sm:px-4 py-1.5 sm:py-2 text-left transition-all hover:border-blue-300 hover:bg-blue-50 active:scale-95 cursor-pointer shadow-2xs';

    const walikanLabel = document.createElement('span');
    walikanLabel.className = 'text-xs sm:text-sm font-bold text-slate-800';
    walikanLabel.textContent = phrase.walikan;

    const arrow = document.createElement('span');
    arrow.className = 'text-xs text-slate-400 font-normal';
    arrow.textContent = '→';

    const indonesianLabel = document.createElement('span');
    indonesianLabel.className = 'text-xs sm:text-sm text-slate-400 font-normal';
    indonesianLabel.textContent = phrase.indonesian;

    button.append(walikanLabel, arrow, indonesianLabel);

    return button;
}

async function refreshPopularPhrases() {
    if (!popularPhraseList || !popularPhrasesUrl) {
        return;
    }

    const response = await fetch(popularPhrasesUrl, {
        headers: { Accept: 'application/json' },
        cache: 'no-store',
    });

    if (!response.ok) {
        throw new Error('Frasa populer gagal diperbarui.');
    }

    const phrases = await response.json();

    if (!Array.isArray(phrases) || phrases.length === 0) {
        const emptyMessage = document.createElement('p');
        emptyMessage.className = 'text-sm text-slate-500';
        emptyMessage.textContent = 'Frasa populer akan muncul saat digunakan dalam terjemahan.';
        popularPhraseList.replaceChildren(emptyMessage);

        return;
    }

    popularPhraseList.replaceChildren(...phrases.map(createPopularPhraseButton));
}

popularPhraseList?.addEventListener('click', (event) => {
    if (!(event.target instanceof Element)) {
        return;
    }

    const button = event.target.closest('button[data-phrase-id]');

    if (button && popularPhraseList.contains(button)) {
        window.usePhrase(button.dataset.phraseId, button.dataset.phraseWalikan);
    }
});

window.addEventListener('translation:completed', (event) => {
    addTranslationToHistory(event.detail);
    refreshPopularPhrases().catch((error) => {
        console.error('Gagal memperbarui frasa populer.', error);
    });
});
