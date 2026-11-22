document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('login-form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const toggleBtn = document.getElementById('toggle-password');

    // Tampilkan / sembunyikan kata sandi
    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', () => {
            const show = passwordInput.type === 'password';
            passwordInput.type = show ? 'text' : 'password';
            toggleBtn.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
            toggleBtn.textContent = show ? '🙈' : '👁';
        });
    }

    // Validasi sederhana sebelum form dikirim
    if (form) {
        form.addEventListener('submit', (e) => {
            const email = emailInput.value.trim();
            const password = passwordInput.value;

            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                e.preventDefault();
                alert('Format email belum benar.');
                emailInput.focus();
                return;
            }

            if (password.length < 8) {
                e.preventDefault();
                alert('Kata sandi minimal 8 karakter.');
                passwordInput.focus();
                return;
            }

            // Tampilkan status loading agar tidak diklik dua kali
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-70', 'cursor-not-allowed');
                submitBtn.textContent = 'Memproses...';
            }
        });
    }

    // Tombol Google (sementara hanya tampilan)
    const googleBtn = document.getElementById('google-login');
    if (googleBtn) {
        googleBtn.addEventListener('click', () => {
            alert('Login dengan Google belum tersedia.');
        });
    }

     function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
});