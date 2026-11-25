import { initializeTranslator } from './translator.js';

const sourceInput = document.getElementById('sumber-teks');
const targetInput = document.getElementById('hasil-teks');

if (sourceInput && targetInput) {
    const translator = initializeTranslator({
        sourceInput,
        targetInput,
        sourceLabel: document.getElementById('source-language-label'),
        targetLabel: document.getElementById('target-language-label'),
        sourceCount: document.getElementById('jumlah-karakter'),
        targetCount: document.getElementById('jumlah-hasil'),
        status: document.getElementById('status-terjemah'),
        maxLength: 500,
    });

    document.getElementById('btn-tukar')?.addEventListener('click', translator.swapLanguages);

    document.getElementById('btn-salin')?.addEventListener('click', async () => {
        if (!targetInput.value) {
            return;
        }

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
}
