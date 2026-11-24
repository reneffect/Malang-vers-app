(function () {
    const sumber = document.getElementById('sumber-teks');
    const hasil  = document.getElementById('hasil-teks');
    const salin  = document.getElementById('btn-salin');
    const status = document.getElementById('status-terjemah');
    const hitung = document.getElementById('jumlah-karakter');
    const MAKS   = 500;

    const TRANSLATE_URL = document.querySelector('meta[name="translate-url"]')?.content || '/translate';
    const CSRF_TOKEN    = document.querySelector('meta[name="csrf-token"]')?.content;

    let timeoutId;
    let requestCount = 0;

    const perbaruiHitungan = () => {
        hitung.textContent = `${sumber.value.length} / ${MAKS}`;
    };

    const lakukanTerjemahan = async (teks) => {
        if (!teks) {
            hasil.innerHTML = '<span class="text-slate-400">Hasil terjemahan akan muncul di sini.</span>';
            status.textContent = '';
            return;
        }

        const myReq = ++requestCount;
        status.textContent = 'Menerjemahkan...';

        try {
            const res = await fetch(TRANSLATE_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({ text: teks, direction: 'walikan_to_id' })
            });

            if (myReq !== requestCount) return;

            if (!res.ok) {
                const errData = await res.json().catch(() => ({}));
                throw new Error(errData.message || 'Gagal menerjemahkan');
            }

            const data = await res.json();
            if (myReq !== requestCount) return;

            hasil.textContent = data.translated ?? 'Tidak ada hasil.';
            status.textContent = '';
        } catch (e) {
            if (myReq !== requestCount) return;
            hasil.innerHTML = `<span class="text-red-500">${e.message}</span>`;
            status.textContent = '';
        }
    };

    // ✨ Auto-translate + auto-clear saat di-backspace
    sumber.addEventListener('input', () => {
        if (sumber.value.length > MAKS) sumber.value = sumber.value.slice(0, MAKS);
        perbaruiHitungan();

        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            lakukanTerjemahan(sumber.value.trim());
        }, 500);
    });

    if (salin) {
        salin.addEventListener('click', async () => {
            const teks = hasil.textContent.trim();
            if (!teks || teks.startsWith('Hasil terjemahan')) return;
            try {
                await navigator.clipboard.writeText(teks);
                status.textContent = 'Tersalin!';
                setTimeout(() => status.textContent = '', 1500);
            } catch (e) {
                status.textContent = 'Gagal menyalin';
            }
        });
    }

    document.querySelectorAll('.btn-kata').forEach(btn => {
        btn.addEventListener('click', () => {
            sumber.value = btn.dataset.kata;
            perbaruiHitungan();
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => lakukanTerjemahan(sumber.value.trim()), 300);
            sumber.focus();
        });
    });
})();