# MalangVerse Translation

MalangVerse Translation adalah proyek digital untuk membantu mahasiswa baru, wisatawan, dan pendatang memahami **Boso Walikan**, bahasa khas Malang. Proyek ini bertujuan menjadi media pembelajaran yang praktis, terstruktur, dan mudah diakses sekaligus mendukung pelestarian budaya lokal.

## Tujuan

- Membantu pendatang mempelajari dasar-dasar Boso Walikan agar lebih mudah berkomunikasi dengan warga Malang.
- Mendukung pelestarian bahasa dan identitas budaya lokal melalui media digital.
- Menyediakan materi edukasi terstruktur, seperti panduan bahasa, kosakata, dan contoh percakapan sehari-hari.
- Mengembangkan pengalaman belajar digital yang berpotensi diperluas menjadi produk edukasi.

## Fitur Utama

- **Penerjemah dua arah:** konsep penerjemah instan antara Bahasa Indonesia dan Boso Walikan.
- **Sakelar bahasa:** mengganti arah penerjemahan dengan kontrol switch.
- **Materi pembelajaran:** panduan bahasa, kamus tematik, dan contoh percakapan sehari-hari.

*Catatan: fitur di atas merupakan konsep aplikasi. Ketersediaannya bergantung pada implementasi saat ini.*

## Struktur Repository

```text
Malang-vers-app/
├── Web/       # Aplikasi web
└── dekstop/   # Aplikasi desktop C#
```

## Teknologi

- **Web:** PHP dengan struktur Laravel.
- **Desktop:** C# Windows Forms.

## Menjalankan Aplikasi Web

Pastikan PHP, Composer, Node.js, dan npm sudah terpasang.

1. Masuk ke folder aplikasi:

   ```bash
   cd Web
   ```

2. Pasang dependensi:

   ```bash
   composer install
   ```

3. Buat file konfigurasi lokal:

   ```cmd
   copy .env.example .env
   ```

4. Sesuaikan konfigurasi database di file `.env` jika diperlukan.

5. Buat application key:

   ```bash
   php artisan key:generate
   ```

6. Pasang dependensi frontend:

   ```bash
   npm install
   npm run dev
   ```

7. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

Buka alamat lokal yang ditampilkan di terminal. Jika aplikasi memerlukan database, siapkan database dan jalankan migrasi sesuai konfigurasi proyek.

## Menjalankan Aplikasi Desktop

1. Buka file solusi desktop di folder `dekstop` menggunakan Visual Studio.
2. Pastikan komponen pengembangan .NET dan target framework yang diperlukan sudah terpasang.
3. Pilih project desktop sebagai startup project.
4. Jalankan aplikasi dengan **Start** atau tekan `F5`.

## Rencana Pengembangan

- Mengumpulkan dan mengkurasi kosakata serta konteks budaya Boso Walikan.
- Menyusun panduan bahasa, kamus tematik, dan contoh percakapan.
- Mengembangkan penerjemah dua arah.
- Menguji akurasi terjemahan dan kemudahan penggunaan.
- Menyiapkan materi edukasi digital untuk publikasi.

## Keamanan

- Jangan mengunggah file `.env`, password, token, atau kredensial database ke GitHub.
- Simpan konfigurasi lokal secara terpisah.
- Periksa `git status` sebelum melakukan commit.

## Lisensi

Lisensi proyek belum ditentukan. Ketentuan penggunaan dan distribusi kode maupun materi perlu ditetapkan oleh pemilik proyek.
