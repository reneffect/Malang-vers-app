(function () {
    const sumber = document.getElementById('sumber-teks');
    const hasil  = document.getElementById('hasil-teks');
    const tombol = document.getElementById('btn-terjemah');
    const tukar  = document.getElementById('btn-tukar');
    const salin  = document.getElementById('btn-salin');
    const status = document.getElementById('status-terjemah');
    const hitung = document.getElementById('jumlah-karakter');
    const MAKS   = 500;

    const perbaruiHitungan = () => {
        hitung.textContent = `${sumber.value.length} / ${MAKS}`;
    };

    sumber.addEventListener('input', () => {
        if (sumber.value.length > MAKS) sumber.value = sumber.value.slice(0, MAKS);
        perbaruiHitungan();
    });

    document.querySelectorAll('.btn-kata').forEach(btn => {
        btn.addEventListener('click', () => {
            sumber.value = btn.dataset.kata;
            perbaruiHitungan();
            sumber.focus();
        });
    });

    tombol.addEventListener('click', async () => {
        const teks = sumber.value.trim();
        if (!teks) {
            status.textContent = 'Masukkan teks dulu';
            return;
        }

        tombol.disabled = true;
        status.textContent = 'Menerjemahkan...';

        try {
            const res = await fetch("{{ route('terjemah') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ teks })
            });

            if (!res.ok) throw new Error('Gagal');
            const data = await res.json();
            hasil.textContent = data.hasil ?? 'Tidak ada hasil.';
        } catch (e) {
            hasil.innerHTML = '<span class="text-red-500">Terjadi kesalahan. Coba lagi.</span>';
        } finally {
            status.textContent = '';
            tombol.disabled = false;
        }
    });

    tukar.addEventListener('click', () => {
        const hasilTeks = hasil.textContent.trim();
        if (!hasilTeks || hasilTeks.startsWith('Hasil terjemahan')) return;
        sumber.value = hasilTeks;
        perbaruiHitungan();
        hasil.innerHTML = '<span class="text-slate-400">Hasil terjemahan akan muncul di sini.</span>';
    });

    salin.addEventListener('click', async () => {
        const teks = hasil.textContent.trim();
        if (!teks) return;
        await navigator.clipboard.writeText(teks);
        status.textContent = 'Tersalin!';
        setTimeout(() => status.textContent = '', 1500);
    });
})();