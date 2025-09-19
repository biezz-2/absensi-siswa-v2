# Absensi Siswa V2

![Absensi Siswa V2](https://media.giphy.com/media/3o7TKSjRrfIPjeI6pa/giphy.gif)

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2-blue?style=for-the-badge&logo=php" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/Laravel-10-orange?style=for-the-badge&logo=laravel" alt="Laravel 10">
  <img src="https://img.shields.io/badge/MySQL-8.0-blue?style=for-the-badge&logo=mysql" alt="MySQL 8.0">
  <img src="https://img.shields.io/badge/TailwindCSS-3-blue?style=for-the-badge&logo=tailwind-css" alt="TailwindCSS 3">
</p>

Aplikasi Absensi Siswa V2 adalah sebuah sistem informasi absensi siswa berbasis web yang dibangun menggunakan framework Laravel 10. Aplikasi ini memudahkan guru untuk mencatat kehadiran siswa dan merekap data absensi.

## ✨ Fitur

*   **Manajemen Data Master**:
    *   Kelola data siswa
    *   Kelola data guru
    *   Kelola data kelas
    *   Kelola data mata pelajaran
*   **Manajemen Absensi**:
    *   Guru dapat membuat sesi absensi harian untuk setiap mata pelajaran di kelas yang diajar.
    *   Siswa dapat melihat riwayat absensi mereka.
    *   Admin dapat melihat rekap absensi semua siswa.
*   **Laporan**:
    *   Cetak laporan absensi dalam format PDF dan Excel.
*   **Notifikasi WhatsApp**:
    *   Notifikasi absensi kepada orang tua/wali siswa melalui WhatsApp.
*   **Integrasi Gemini API**:
    *   Fitur tambahan yang terintegrasi dengan Google Gemini API.

## 🚀 Instalasi

1.  **Clone repository**
    ```bash
    git clone https://github.com/biezz-2/absensi-siswa-v2.git
    ```
2.  **Masuk ke direktori project**
    ```bash
    cd absensi-siswa-v2
    ```
3.  **Install dependency**
    ```bash
    composer install
    npm install
    ```
4.  **Buat file `.env`**
    ```bash
    cp .env.example .env
    ```
5.  **Generate application key**
    ```bash
    php artisan key:generate
    ```
6.  **Konfigurasi database**
    Buka file `.env` dan sesuaikan konfigurasi database Anda.
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=absensi_siswa_v2
    DB_USERNAME=root
    DB_PASSWORD=
    ```
7.  **Jalankan migrasi dan seeder**
    ```bash
    php artisan migrate --seed
    ```
8.  **Jalankan aplikasi**
    ```bash
    php artisan serve
    npm run dev
    ```

## 👨‍💻 Penggunaan

Setelah aplikasi berjalan, Anda dapat mengaksesnya di `http://localhost:8000`.

*   **Login sebagai Admin**:
    *   Email: `admin@example.com`
    *   Password: `password`
*   **Login sebagai Guru**:
    *   Email: `teacher@example.com`
    *   Password: `password`
*   **Login sebagai Siswa**:
    *   Email: `student@example.com`
    *   Password: `password`

## 🤝 Kontribusi

Kontribusi sangat diterima. Silakan buat *pull request* atau buka *issue* untuk berdiskusi mengenai perubahan yang ingin Anda buat.

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).