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

- **Autentikasi Pengguna**:  Pengguna dapat melakukan registrasi, login, dan logout.
- **Pengelolaan Buku**: Pustakawan dapat menambah, mengedit, menghapus, dan melihat daftar buku.
- **Peminjaman Buku**:  Anggota dapat mencari dan meminjam buku yang tersedia, serta melihat riwayat peminjaman. Pustakawan dapat mengelola dan mengkonfirmasi peminjaman.
- **Pengembalian Buku**: Anggota dapat mengembalikan buku yang telah dipinjam. Pustakawan dapat mengelola dan mengkonfirmasi pengembalian, serta menerapkan denda jika terlambat.
- **Notifikasi**:  Pengguna menerima pemberitahuan tentang status peminjaman dan pengembalian.
- **Admin Dashboard**: Admin dapat mengelola akun pustakawan.
- **Pustakawan Dashboard**: Pustakawan dapat mengelola akun member, mengelola peminjaman buku, pengembalian buku, menambahkan buku, mengkonfirmasi peminjaman buku.
- **Wishlist dan Chat**: Anggota dapat menyimpan daftar buku yang ingin dipinjam nanti dan Anggota dapat berkomunikasi dengan pustakawan melalui fitur chat.

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
6. Migrasi Database:
   ```bash
   php artisan migrate
7. Jalankan seeder untuk mengisi database dengan data awal:
   ```bash
   php artisan db:seed
8. Jalankan server pengembangan:
   ```bash
   php artisan serve
9. Instalasi Node Modules dan Kompilasi Aset:
   ```bash
   npm install
   npm run dev

## Penggunaan

### Untuk Anggota:

1. Lakukan registrasi untuk membuat akun baru atau login jika sudah memiliki akun.
2. Cari buku yang ingin dipinjam melalui fitur pencarian.
3. Klik tombol "Pinjam" pada halaman detail buku.
4. Tunggu konfirmasi dari pustakawan.
5. Kembalikan buku tepat waktu untuk menghindari denda.

### Untuk Pustakawan:

1. Login menggunakan akun pustakawan.
2. Kelola data buku (tambah, edit, hapus).
3. Kelola data anggota (tambah, edit, hapus).
4. Konfirmasi peminjaman dan pengembalian buku.
5. Terapkan denda jika ada keterlambatan pengembalian.
6. Gunakan fitur chat untuk berkomunikasi dengan anggota.

### Untuk Admin:

1. Login menggunakan akun admin.
2. Kelola akun pustakawan (tambah, edit, hapus).

### Kontribusi
Jika Anda ingin berkontribusi pada proyek ini, Anda dapat melakukan fork repositori ini dan mengirimkan pull request.

### Troubleshooting
Jika Anda mengalami masalah saat instalasi atau penggunaan, silakan periksa bagian FAQ di dokumentasi Laravel atau cari bantuan di forum komunitas Laravel.

### Kredit
Proyek ini menggunakan beberapa library pihak ketiga:

Laravel 10
Bootstrap 5
Lisensi
Proyek ini dilisensikan di bawah lisensi MIT. Lihat file LICENSE untuk informasi lebih lanjut.










