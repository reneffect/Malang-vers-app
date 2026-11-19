const avatarInput = document.getElementById('avatarInput');
const avatarPreview = document.getElementById('avatarPreview');
const uploadButton = document.getElementById('btnUploadAvatar');
const avatarStatus = document.getElementById('avatarStatus');
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
let previewObjectUrl = null;

if (avatarInput && avatarPreview && uploadButton && avatarStatus) {
    avatarInput.addEventListener('change', () => {
        const file = avatarInput.files?.[0];

        if (!file) {
            return;
        }

        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            resetAvatarSelection('Format foto harus JPG, PNG, atau WEBP.');
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            resetAvatarSelection('Ukuran foto maksimal 2MB.');
            return;
        }

        releasePreviewObjectUrl();
        previewObjectUrl = URL.createObjectURL(file);
        avatarPreview.innerHTML = `<img src="${previewObjectUrl}" alt="Pratinjau avatar" class="avatar-img w-full h-full object-cover">`;
        uploadButton.disabled = false;
        showAvatarStatus('Foto siap diunggah.');
    });

    uploadButton.addEventListener('click', uploadAvatar);
}

async function uploadAvatar() {
    const file = avatarInput?.files?.[0];
    const uploadUrl = uploadButton?.dataset.url;

    if (!file || !uploadButton || !uploadUrl) {
        showAvatarStatus('Pilih foto terlebih dahulu.', true);
        return;
    }

    const originalButtonText = uploadButton.innerHTML;
    const formData = new FormData();
    formData.append('avatar', file);

    uploadButton.disabled = true;
    uploadButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengunggah...';
    showAvatarStatus('Sedang mengunggah foto...');

    try {
        const response = await fetch(uploadUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken ?? '',
                Accept: 'application/json',
            },
            body: formData,
        });
        const data = await response.json();

        if (!response.ok || !data.success || typeof data.url !== 'string') {
            throw new Error(data.message || 'Foto gagal diunggah.');
        }

        updateAvatarImages(data.url);
        releasePreviewObjectUrl();
        avatarInput.value = '';
        showAvatarStatus('Foto profil berhasil diperbarui.');
        uploadButton.innerHTML = '<i class="fas fa-check"></i> Selesai';
    } catch (error) {
        showAvatarStatus(error instanceof Error ? error.message : 'Foto gagal diunggah.', true);
        uploadButton.disabled = false;
        uploadButton.innerHTML = originalButtonText;
    }
}

function updateAvatarImages(imageUrl) {
    const cacheBustedUrl = new URL(imageUrl, window.location.origin);
    cacheBustedUrl.searchParams.set('t', Date.now().toString());

    document.querySelectorAll('[data-navbar-avatar]').forEach((image) => {
        image.src = cacheBustedUrl.toString();
    });

    document.querySelectorAll('.profile-avatar').forEach((container) => {
        if (container.querySelector('[data-navbar-avatar]')) {
            return;
        }

        const image = document.createElement('img');
        image.dataset.navbarAvatar = '';
        image.src = cacheBustedUrl.toString();
        image.alt = '';
        image.className = 'w-full h-full rounded-full object-cover';
        container.replaceChildren(image);
    });

    document.querySelectorAll('[data-avatar-container]').forEach((container) => {
        let image = container.querySelector('.avatar-img');

        if (!image) {
            image = document.createElement('img');
            image.alt = 'Avatar';
            image.className = 'avatar-img w-full h-full object-cover';
            container.replaceChildren(image);
        }

        image.src = cacheBustedUrl.toString();
    });
}

function resetAvatarSelection(message) {
    avatarInput.value = '';
    uploadButton.disabled = true;
    showAvatarStatus(message, true);
}

function releasePreviewObjectUrl() {
    if (previewObjectUrl) {
        URL.revokeObjectURL(previewObjectUrl);
        previewObjectUrl = null;
    }
}

function showAvatarStatus(message, isError = false) {
    if (!avatarStatus) {
        return;
    }

    avatarStatus.textContent = message;
    avatarStatus.classList.remove('hidden', 'text-red-500', 'text-green-600');
    avatarStatus.classList.add(isError ? 'text-red-500' : 'text-green-600');
}
