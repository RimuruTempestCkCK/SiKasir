# SiKasir - Sistem Informasi Kasir

SiKasir adalah aplikasi Point of Sale (POS) berbasis web yang dirancang untuk membantu pengelolaan toko, inventaris barang, dan pencatatan transaksi secara efisien. Aplikasi ini mendukung multi-toko dan multi-peran pengguna.

## 🚀 Fitur Utama

- **Multi-Role System**:
  - **Admin System**: Mengelola user secara global dan melihat daftar toko.
  - **Pimpinan (Owner)**: Mengelola produk, kategori, kasir, melihat laporan stok, dan laporan transaksi toko mereka.
  - **Kasir**: Melakukan transaksi penjualan, mencetak struk, dan mengecek stok.
- **Manajemen Inventaris**: Pencatatan stok masuk dan keluar secara otomatis melalui transaksi atau input manual.
- **Laporan Real-time**: Dashboard informatif dengan grafik penjualan dan ringkasan data penting.
- **Reporting System**: Laporan transaksi dan pergerakan stok yang detail dengan fitur ekspor/cetak.
- **DataTables Integration**: Tabel data yang responsif dengan fitur pencarian, pengurutan, dan penomoran halaman.

## 🛠️ Tech Stack

- **Framework**: Laravel 11
- **Language**: PHP 8.2+
- **Database**: SQLite (Default)
- **Frontend**: 
  - Bootstrap 5
  - Freedash Admin Template
  - DataTables.net
  - Feather Icons & FontAwesome
- **Build Tool**: Vite

## ⚙️ Cara Instalasi

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd aplikasi-kasir
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturannya (terutama `DB_DATABASE`).
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi dan Seeding**
   Siapkan database (buat file `database/database.sqlite` jika menggunakan SQLite) lalu jalankan:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   npm run dev
   ```

## 🔑 Akun Demo (Default Seeder)

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@gmail.com` | `password` |
| **Pimpinan** | `pimpinan@gmail.com` | `password` |
| **Kasir** | `kasir@gmail.com` | `password` |

---
*Dibuat dengan ❤️ menggunakan Laravel.*
