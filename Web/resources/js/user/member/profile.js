    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const avatarInput = document.getElementById('avatarInput');
    const btnUpload   = document.getElementById('btnUploadAvatar');
    const preview     = document.getElementById('avatarPreview');
    const statusEl    = document.getElementById('avatarStatus');

    // Saat file dipilih → preview + aktifkan tombol Unggah
    avatarInput?.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        // Validasi ukuran (2MB)
        if (file.size > 2 * 1024 * 1024) {
            showAvatarStatus('⚠️ Ukuran foto maksimal 2MB!', 'text-red-500');
            this.value = '';
            return;
        }

        // Preview
        const reader = new FileReader();
        reader.onload = e => {
            preview.innerHTML = `<img src="${e.target.result}" class="avatar-img w-full h-full object-cover">`;
        };
        reader.readAsDataURL(file);

        btnUpload.disabled = false;
        btnUpload.innerHTML = '<i class="fas fa-upload"></i> Unggah';
        showAvatarStatus('📸 Foto dipilih. Klik "Unggah" untuk menyimpan.', 'text-gray-500');
    });

    // Upload via AJAX
    async function uploadAvatar() {
        const file = avatarInput.files[0];
        if (!file) return;

        const fd = new FormData();
        fd.append('avatar', file);

        btnUpload.disabled = true;
        btnUpload.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengunggah...';
        showAvatarStatus('⏳ Mengunggah foto...', 'text-primary-600');

        try {
            const res = await fetch('{{ route("profile.avatar") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: fd,
            });

            const data = await res.json();

            if (data.success) {
                // Update SEMUA avatar (form + sidebar + navbar)
                document.querySelectorAll('.avatar-img').forEach(img => {
                    img.src = data.url + '?t=' + Date.now();
                });

                btnUpload.innerHTML = '<i class="fas fa-check"></i> Tersimpan';
                showAvatarStatus('✅ Foto profil berhasil diunggah!', 'text-green-600');
                window.showToast?.('✅ Foto profil berhasil diunggah!');
            } else {
                throw new Error('Gagal');
            }
        } catch (err) {
            btnUpload.disabled = false;
            btnUpload.innerHTML = '<i class="fas fa-upload"></i> Unggah';
            showAvatarStatus('❌ Gagal mengunggah. Coba lagi.', 'text-red-500');
        }
    }

    function showAvatarStatus(msg, colorClass) {
        statusEl.textContent = msg;
        statusEl.className = `text-xs mt-2 ${colorClass}`;
        statusEl.classList.remove('hidden');
    }