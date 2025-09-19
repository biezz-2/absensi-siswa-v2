# <div align='center'>Sistem Absensi Siswa – Berbasis Web</div>

<div align='center'>

![School Management System](https://files.cloudkuimages.guru/images/HFiLkuUz.jpg)

<!-- Project & Social Badges -->
<p align="center">
  <!-- License -->
  <a href="https://opensource.org/licenses/MIT">
    <img src="https://img.shields.io/badge/License-MIT-0A66C2?style=for-the-badge&logo=mit&logoColor=white" alt="License"/>
  </a>
  
  <!-- PHP Version -->
  <a href="https://www.php.net/">
    <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP"/>
  </a>

  <!-- Laravel Version -->
  <a href="https://laravel.com/">
    <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"/>
  </a>
  
  <!-- SQLite -->
  <a href="https://www.sqlite.org/index.html">
    <img src="https://img.shields.io/badge/SQLite-Database-003B57?style=for-the-badge&logo=sqlite&logoColor=white" alt="SQLite"/>
  </a>

  <!-- Tailwind CSS -->
  <a href="https://tailwindcss.com/">
    <img src="https://img.shields.io/badge/Tailwind%20CSS-Styling-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS"/>
  </a>

  <!-- Gemini AI -->
  <a href="https://gemini.google.com/">
    <img src="https://img.shields.io/badge/Gemini-AI%20Powered-4285F4?style=for-the-badge&logo=google&logoColor=white" alt="Gemini AI"/>
  </a>

  <!-- GitHub Repository -->
  <a href="https://github.com/biezz-2/absensi-siswa-v2">
    <img src="https://img.shields.io/badge/GitHub-Repository-181717?style=for-the-badge&logo=github&logoColor=white" alt="GitHub Repository"/>
  </a>
</p>

</div>

## 📋 Daftar Isi

| No. | Bagian |
|-----|---------|
| 1. | [![Deskripsi](https://img.shields.io/badge/📖-Deskripsi-blue?style=for-the-badge)](#-sistem-absensi-siswa)
| 2. | [![Fitur Utama](https://img.shields.io/badge/📂-Fitur_Utama-green?style=for-the-badge)](#-fitur-utama)
| 3. | [![Detail Teknis](https://img.shields.io/badge/⚙️-Detail_Teknis-purple?style=for-the-badge)](#-detail-teknis)
| 4. | [![Struktur Proyek](https://img.shields.io/badge/🧱-Struktur-yellow?style=for-the-badge)](#-struktur-proyek)
| 5. | [![Lisensi](https://img.shields.io/badge/📜-Lisensi-0A66C2?style=for-the-badge)](#-lisensi)

---

# ✨ Sistem Absensi Siswa

⚡ **Cepat. Cerdas. Terintegrasi.**  
🌍 **Open-Source. Fleksibel. Mudah Digunakan.**  
🔧 **Kode Bersih. Mudah Dikembangkan. Didukung AI.**

**Sistem Absensi Siswa** adalah aplikasi web yang dirancang untuk memodernisasi dan menyederhanakan proses pencatatan kehadiran di sekolah. Aplikasi ini dibangun untuk membantu admin, guru, dan siswa dalam mengelola data absensi secara efisien dan transparan.

Dengan arsitektur yang solid dan fitur-fitur cerdas, aplikasi ini bertujuan untuk menjadi:
- 🚀 **Ringan & Cepat** → Dioptimalkan untuk kecepatan dan stabilitas.
- 🧩 **Modular & Mudah Dikembangkan** → Tambah atau ubah fitur dengan mudah.
- 🤖 **Didukung AI** → Terintegrasi dengan Google Gemini untuk analisis data cerdas.
- 💡 **Ramah Pengguna** → Antarmuka yang bersih dan mudah dipahami untuk setiap peran (admin, guru, siswa).

## 📂 Fitur Utama

### Untuk Admin
- 👤 **Manajemen Pengguna** — Mengelola akun untuk admin, guru, dan siswa.
- 🏫 **Manajemen Kelas & Mata Pelajaran** — Membuat kelas, mata pelajaran, dan menugaskan guru.
- 📊 **Dasbor Analitik** — Memantau statistik kehadiran seluruh sekolah dalam tren mingguan.
- 🤖 **AI Assistant** — Menambahkan data (seperti guru baru dan tugas mengajarnya) hanya dengan mengetikkan perintah dalam bahasa alami.
- 📄 **Persetujuan Izin** — Meninjau dan menyetujui pengajuan izin tidak masuk dari siswa dengan bantuan kategori dari AI.

### Untuk Guru
- 📈 **Dasbor Guru** — Melihat statistik kelas, jadwal mengajar, dan ringkasan kehadiran harian.
- 📱 **Absensi Kode QR** — Membuat kode QR unik untuk setiap sesi kelas agar siswa dapat melakukan absensi dengan memindainya.
- 📝 **Manajemen Kehadiran** — Mengelola data kehadiran secara manual (menambah, mengedit, menghapus) jika diperlukan.
- 📊 **Laporan & Ekspor** — Mengekspor data kehadiran kelas ke dalam format Microsoft Excel.
- 💡 **Wawasan Performa Siswa** — Mendapatkan analisis singkat dari AI mengenai pola kehadiran siswa.

### Untuk Siswa
- 🏠 **Dasbor Siswa** — Melihat jadwal pelajaran harian dan rekap absensi pribadi.
- 📲 **Absensi via Pindai QR** — Melakukan absensi dengan cepat dan mudah dengan memindai kode QR yang ditampilkan oleh guru.
- 📬 **Pengajuan Izin** — Mengirimkan permohonan izin tidak masuk beserta dokumen pendukung.

## ⚙️ Detail Teknis

| Info            | Nilai                              |
|-----------------|------------------------------------|
| Nama Proyek     | `Sistem Absensi Siswa v2`            |
| Kerangka Kerja  | `Laravel 12`                       |
| Bahasa          | `PHP 8.3`                          |
| Database        | `SQLite`                           |
| Frontend        | `Tailwind CSS`, `Blade`            |
| AI              | `Google Gemini API`                |
| Lisensi         | MIT License                        |

## 🧱 Struktur Proyek

Struktur direktori utama dari proyek ini:

| Lokasi / File         | Deskripsi |
|-----------------------|-------------|
| `app/`                | Logika inti aplikasi, termasuk Model, Controller, dan Policy. |
| `app/Http/Controllers/` | Berisi Controller untuk setiap peran (Admin, Teacher, Student). |
| `app/Models/`         | Model Eloquent yang merepresentasikan tabel database. |
| `app/Services/`       | Berisi `GeminiService` untuk interaksi dengan AI. |
| `config/`             | File konfigurasi untuk aplikasi, database, dan layanan lainnya. |
| `database/`           | Berisi file migrasi, seeder, dan factory. |
| `public/`             | *Document root* untuk aplikasi web. |
| `resources/views/`    | Berisi file-file Blade untuk antarmuka pengguna (UI). |
| `routes/`             | Definisi rute untuk web dan API. |
| `.env`                | File konfigurasi lingkungan (kunci API, koneksi database, dll). |
| `composer.json`       | Daftar dependensi PHP. |
| `package.json`        | Daftar dependensi JavaScript. |
| `README.md`           | Dokumentasi proyek ini. |

## 📜 Lisensi

Proyek ini dilisensikan di bawah **MIT License** — lihat file [LICENSE](LICENSE) untuk detailnya.
