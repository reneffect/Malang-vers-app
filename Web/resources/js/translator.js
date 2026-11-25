const LANGUAGE_PAIRS = {
    walikan_to_id: {
        reverse: 'id_to_walikan',
        source: 'Boso Walikan',
        target: 'Bahasa Indonesia',
        sourcePlaceholder: 'Tulis teks Boso Walikan di sini...',
        targetPlaceholder: 'Hasil terjemahan Bahasa Indonesia akan muncul di sini.',
    },
    id_to_walikan: {
        reverse: 'walikan_to_id',
        source: 'Bahasa Indonesia',
        target: 'Boso Walikan',
        sourcePlaceholder: 'Tulis teks Bahasa Indonesia di sini...',
        targetPlaceholder: 'Hasil terjemahan Boso Walikan akan muncul di sini.',
    },
};

export function initializeTranslator({
    sourceInput,
    targetInput,
    sourceLabel,
    targetLabel,
    sourceCount,
    targetCount,
    status,
    loadingIndicator,
    initialDirection = 'walikan_to_id',
    maxLength = 1000,
    debounceDelay = 600,
}) {
    const translateUrl = document.querySelector('meta[name="translate-url"]')?.content || '/translate';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    let direction = initialDirection;
    let debounceTimeout;
    let activeController;
    let requestVersion = 0;

    sourceInput.maxLength = maxLength;

    const updateCounts = () => {
        sourceCount.textContent = `${sourceInput.value.length}${maxLength < 1000 ? ` / ${maxLength}` : ''}`;
        targetCount.textContent = `${targetInput.value.length}${maxLength < 1000 ? ` / ${maxLength}` : ''}`;
    };

    const updateStatus = (message) => {
        status.textContent = message;

        if (loadingIndicator) {
            const isLoading = message === 'Menerjemahkan...';
            loadingIndicator.classList.toggle('hidden', !isLoading);
            loadingIndicator.classList.toggle('flex', isLoading);
        }
    };

    const updateLanguageLabels = () => {
        const pair = LANGUAGE_PAIRS[direction];
        sourceLabel.textContent = pair.source;
        targetLabel.textContent = pair.target;
        sourceInput.placeholder = pair.sourcePlaceholder;
        targetInput.placeholder = pair.targetPlaceholder;
    };

    const cancelActiveRequest = () => {
        requestVersion += 1;
        activeController?.abort();
        activeController = undefined;
    };

    const translateNow = async () => {
        window.clearTimeout(debounceTimeout);
        cancelActiveRequest();

        const text = sourceInput.value.trim();
        if (!text) {
            targetInput.value = '';
            updateStatus('');
            updateCounts();

            return;
        }

        const currentVersion = requestVersion;
        activeController = new AbortController();
        updateStatus('Menerjemahkan...');

        try {
            const response = await fetch(translateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken ?? '',
                },
                body: JSON.stringify({ text, direction }),
                signal: activeController.signal,
            });
            const data = await response.json();

            if (currentVersion !== requestVersion) {
                return;
            }

            if (!response.ok || data.success !== true || typeof data.translated !== 'string') {
                throw new Error(data.message || 'Terjemahan gagal. Silakan coba lagi.');
            }

            targetInput.value = data.translated;
            updateStatus(Number.isInteger(data.remaining)
                ? `Terjemahan otomatis · Sisa kuota gratis hari ini: ${data.remaining}`
                : 'Terjemahan selesai.');
            updateCounts();
        } catch (error) {
            if (error.name === 'AbortError' || currentVersion !== requestVersion) {
                return;
            }

            updateStatus(error.message || 'Terjemahan gagal. Silakan coba lagi.');
        } finally {
            if (currentVersion === requestVersion) {
                activeController = undefined;
            }
        }
    };

    const scheduleTranslation = () => {
        window.clearTimeout(debounceTimeout);
        cancelActiveRequest();
        targetInput.value = '';
        updateCounts();

        if (!sourceInput.value.trim()) {
            updateStatus('');

            return;
        }

        updateStatus('Menunggu teks selesai diketik...');
        debounceTimeout = window.setTimeout(translateNow, debounceDelay);
    };

    const swapLanguages = () => {
        if (targetInput.value.trim()) {
            [sourceInput.value, targetInput.value] = [targetInput.value, sourceInput.value];
        }

        direction = LANGUAGE_PAIRS[direction].reverse;
        updateLanguageLabels();
        scheduleTranslation();
    };

    const clear = () => {
        window.clearTimeout(debounceTimeout);
        cancelActiveRequest();
        sourceInput.value = '';
        targetInput.value = '';
        updateStatus('');
        updateCounts();
    };

    const stopPendingTranslation = () => {
        window.clearTimeout(debounceTimeout);
        cancelActiveRequest();
    };

    sourceInput.addEventListener('input', scheduleTranslation);

    updateLanguageLabels();
    updateCounts();

    return {
        clear,
        direction: () => direction,
        refresh: updateCounts,
        setDirection(nextDirection) {
            if (!LANGUAGE_PAIRS[nextDirection]) {
                throw new Error(`Unknown translation direction: ${nextDirection}`);
            }

            stopPendingTranslation();
            direction = nextDirection;
            updateLanguageLabels();
            updateStatus('');
        },
        setValues(sourceText, targetText) {
            stopPendingTranslation();
            sourceInput.value = sourceText;
            targetInput.value = targetText;
            updateCounts();
        },
        swapLanguages,
        translateNow,
    };
}
