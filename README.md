![Laravel](https://laravel.com/img/logomark.min.svg)

# Website Peminjaman Buku Perpustakaan

Proyek ini adalah sebuah website peminjaman buku perpustakaan yang memungkinkan pengguna untuk meminjam dan mengembalikan buku secara online. Proyek ini dibangun menggunakan framework Laravel dan berbagai teknologi pendukung lainnya.

## Daftar Isi

- [Fitur](#fitur)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Instalasi](#instalasi)
- [Penggunaan](#penggunaan)
- [Struktur Direktori](#struktur-direktori)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)

## Fitur

- **Autentikasi Pengguna**: Registrasi, Login, Logout
- **Pengelolaan Buku**: Tambah, Edit, Hapus Buku
- **Peminjaman Buku**: Proses peminjaman dan pengembalian buku
- **Notifikasi**: Pemberitahuan tentang status peminjaman
- **Admin Dashboard**: Pengelolaan pengguna dan buku oleh admin
- **Wishlist dan Chat**: Fitur tambahan untuk pengguna

## Teknologi yang Digunakan

- **Front-end**: HTML, CSS, Bootstrap
- **Back-end**: PHP, Laravel
- **Database**: MySQL
- **Tools Lainnya**: Visual Studio Code, Laragon, HeidiSQL, Git, Composer

## Instalasi

1. Clone repository ini:
   ```bash
   git clone https://github.com/username/repo-name.git
   cd repo-name
2. Install Dependensi:
   ```bash
   composer install
3. Buat file .env dari template::
   ```bash
   cp .env.example .env
4. Generate application key::
   ```bash
   php artisan key:generate
5. Atur konfigurasi database di file .env:
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=username_database
   DB_PASSWORD=password_database
7. Migrasi Database:
   ```bash
   php artisan migrate
6. Jalankan seeder untuk mengisi database dengan data awal:
   ```bash
   php artisan db:seed
7. Jalankan server pengembangan:
   ```bash
   php artisan serve









