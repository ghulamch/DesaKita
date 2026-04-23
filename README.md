# 🏛️ Portal Desa Digital

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.4-blue.svg)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/Tailwind-3.x-38bdf8.svg)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-Proprietary-gray.svg)](#)

Solusi digital modern untuk tata kelola administrasi dan pelayanan publik desa. Dibangun dengan fokus pada kecepatan, keamanan, dan estetika premium.

---

## ✨ Fitur Unggulan

*   **🚀 Dashboard High-End**: Antarmuka modern untuk Admin, Aparatur, dan Warga.
*   **📊 Transparansi Anggaran**: Visualisasi dana APBDes secara real-time.
*   **⚖️ JDIH (Produk Hukum)**: Digitalisasi peraturan dan SK desa yang terorganisir.
*   **📰 Portal Berita & Agenda**: Publikasi kegiatan desa dengan layout koran digital.
*   **🛍️ Marketplace Warga**: Lapak digital khusus untuk memajukan UMKM desa.
*   **📍 Integrasi BMKG**: Prakiraan cuaca lokal otomatis berdasarkan kode wilayah.
*   **📱 Super Responsive**: Nyaman diakses dari HP, Tablet, maupun Laptop.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 12 (PHP 8.4)
- **Frontend**: Tailwind CSS & Alpine.js
- **Build Tool**: Vite
- **Database**: MySQL / MariaDB
- **Icons**: Bootstrap Icons

---

## 🚀 Panduan Instalasi

Ikuti langkah langkah berikut untuk menjalankan project ini di komputer lokal atau server:

### 1. Persiapan Awal
Pastikan Anda sudah menginstall:
- PHP >= 8.4
- Composer
- Node.js & NPM
- Web Server (Apache/Nginx/XAMPP)

### 2. Install Dependency
Masuk ke folder project dan jalankan perintah:
```bash
# Install library PHP
composer install

# Install library Javascript
npm install
```

### 3. Konfigurasi Environment
Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database Anda:
```bash
cp .env.example .env
```
Setelah itu, buat database baru di MySQL dan update bagian ini di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Key & Migrasi Data
Jalankan perintah ini untuk mengaktifkan sistem:
```bash
# Generate aplikasi key
php artisan key:generate

# Migrasi tabel dan data awal (seeding)
php artisan migrate --seed

# Buat link untuk file upload (Foto/Gambar)
php artisan storage:link
```

### 5. Kompilasi Asset
Jalankan Vite untuk memproses CSS dan JS:
```bash
# Untuk Development
npm run dev

# Untuk Produksi (Versi Final)
npm run build
```

### 6. Jalankan Aplikasi
Akses aplikasi melalui browser:
```bash
php artisan serve
```

---

## 🔑 Akun Default (Seeder)
Jika Anda menggunakan `--seed`, Anda dapat mencoba login dengan:
- **Email**: `admin@desa.id`
- **Password**: `password` (Sesuaikan di seeder jika berbeda)

---

## 📝 Catatan Tambahan
*   **Setup Wizard**: Project ini dilengkapi dengan Setup Wizard otomatis jika diakses pertama kali dalam kondisi database kosong.
*   **Optimization**: Gunakan `php artisan optimize` di lingkungan produksi untuk kecepatan maksimal.

---

**© 2026 Portal Desa Digital - Transformasi Digital dari Desa.**
