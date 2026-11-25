import { initializeTranslator } from '../../translator.js';

const walikanEl = document.getElementById('walikanText');
const indoEl = document.getElementById('indoText');
const translator = initializeTranslator({
    sourceInput: walikanEl,
    targetInput: indoEl,
    sourceLabel: document.getElementById('source-language-label'),
    targetLabel: document.getElementById('target-language-label'),
    sourceCount: document.getElementById('sourceCount'),
    targetCount: document.getElementById('targetCount'),
    status: document.getElementById('translationStatus'),
    loadingIndicator: document.getElementById('loadingIndicator'),
});

window.translateText = translator.translateNow;
window.swapText = translator.swapLanguages;

window.clearAll = function () {
    translator.clear();
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
    toast.textContent = message;
    toast.classList.remove('translate-y-32', 'opacity-0');
    toast.classList.add('translate-y-0', 'opacity-100');

    window.setTimeout(() => {
        toast.classList.add('translate-y-32', 'opacity-0');
        toast.classList.remove('translate-y-0', 'opacity-100');
    }, 2500);
};

window.copyText = async function (elementId) {
    const text = document.getElementById(elementId).value;

    try {
        await navigator.clipboard.writeText(text);
        window.showToast('Teks berhasil disalin.');
    } catch (error) {
        console.error('Gagal menyalin teks.', error);
        window.showToast('Teks gagal disalin.');
    }
};

document.addEventListener('keydown', (event) => {
    if (event.ctrlKey && event.key === 'Enter') {
        window.translateText();
    }
});