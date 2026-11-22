const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        const walikanEl = document.getElementById('walikanText');
        const indoEl    = document.getElementById('indoText');

        // Counter
        walikanEl?.addEventListener('input', () => {
            document.getElementById('walikanCount').textContent = walikanEl.value.length;
        });
        indoEl?.addEventListener('input', () => {
            document.getElementById('indoCount').textContent = indoEl.value.length;
        });

        window.translateText = async function () {
            const indo = indoEl?.value.trim();
            const walikan = walikanEl?.value.trim();
            if (!indo && !walikan) return window.showToast('⚠️ Masukkan teks terlebih dahulu!');

            const loading = document.getElementById('loadingIndicator');
            loading.classList.remove('hidden'); loading.classList.add('flex');

            try {
                const res = await fetch('/translate', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: JSON.stringify({ text: indo || walikan, direction: indo ? 'id_to_walikan' : 'walikan_to_id' }),
                });
                const data = await res.json();
                if (data.success) {
                    if (indo) { walikanEl.value = data.translated; document.getElementById('walikanCount').textContent = data.translated.length; }
                    else      { indoEl.value    = data.translated; document.getElementById('indoCount').textContent    = data.translated.length; }
                    window.showToast('✅ Terjemahan berhasil!');
                }
            } catch (e) {
                window.showToast('❌ Terjadi kesalahan. Coba lagi.');
                console.error(e);
            } finally {
                loading.classList.add('hidden'); loading.classList.remove('flex');
            }
        };

        window.swapText = function () {
            const t = walikanEl.value; walikanEl.value = indoEl.value; indoEl.value = t;
            document.getElementById('walikanCount').textContent = walikanEl.value.length;
            document.getElementById('indoCount').textContent = indoEl.value.length;
            window.showToast('🔄 Teks ditukar!');
        };

        window.clearAll = function () {
            walikanEl.value = ''; indoEl.value = '';
            document.getElementById('walikanCount').textContent = '0';
            document.getElementById('indoCount').textContent = '0';
            window.showToast('🗑️ Teks dihapus!');
        };

        window.speakText = function () {
            const text = indoEl.value || walikanEl.value;
            if (!text) return window.showToast('⚠️ Tidak ada teks untuk dibacakan!');
            const u = new SpeechSynthesisUtterance(text); u.lang = 'id-ID'; u.rate = 0.9;
            speechSynthesis.speak(u);
            window.showToast('🔊 Membacakan teks...');
        };

        window.usePhrase = function (idText, walikanText) {
            indoEl.value = idText; walikanEl.value = walikanText;
            document.getElementById('indoCount').textContent = idText.length;
            document.getElementById('walikanCount').textContent = walikanText.length;
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

        document.addEventListener('keydown', e => { if (e.ctrlKey && e.key === 'Enter') window.translateText(); });