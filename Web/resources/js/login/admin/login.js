document.addEventListener('DOMContentLoaded', function () {

    // 1. Toggle Password Visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }

    // 2. Form Submit Handler
    const loginForm = document.getElementById('loginForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const remember = document.getElementById('remember').checked;

            // Validasi sederhana
            if (!username || !password) {
                alert('Nama Pengguna dan Kata Sandi harus diisi!');
                return;
            }

            // Simulasi login (ni-sama bisa ganti dengan fetch/Axios ke route Laravel)
            console.log('Login attempt:', {
                username: username,
                password: password,
                remember: remember
            });

            // Simpan ke localStorage jika "Ingat saya" dicentang
            if (remember) {
                localStorage.setItem('rememberedUser', username);
            } else {
                localStorage.removeItem('rememberedUser');
            }

            alert('Login berhasil! Selamat datang, ' + username);
            // window.location.href = '/dashboard'; // Redirect ke dashboard
        });

        // 3. Load remembered user dari localStorage
        const rememberedUser = localStorage.getItem('rememberedUser');
        if (rememberedUser) {
            document.getElementById('username').value = rememberedUser;
            document.getElementById('remember').checked = true;
        }
    }

});