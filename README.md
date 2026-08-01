# Web E-Absensi QR Code Ekstrakurikuler SMA Negeri 1 Surade

Aplikasi Laravel + MySQL untuk absensi kegiatan ekstrakurikuler sekolah berbasis QR Code. Sistem mendukung role Admin, Pembina, Siswa, dan Orang Tua/Wali.

## Fitur Utama

- Login manual berbasis session
- Role-Based Access Control: admin, pembina, siswa, wali
- Dashboard per role
- CRUD data siswa, pembina, kelas, ekstrakurikuler, anggota, dan jadwal
- Sesi absensi ekstrakurikuler
- Generate QR Code masuk dan keluar dengan token unik dan expired tanpa dependency ext-gd
- Scan QR Code realtime memakai `html5-qrcode`
- Validasi absensi: sesi aktif, token valid, siswa terdaftar, dan pencegahan scan ganda
- Pengajuan izin/sakit dan validasi oleh pembina/admin
- Laporan absensi sederhana dengan filter, export PDF, dan export Excel CSV
- Notifikasi per user
- Audit log aktivitas penting
- Pengaturan sistem
- Seeder akun default dan data dummy

## Teknologi

- Laravel 10
- PHP 8.1 sampai 8.2
- MySQL
- Blade Template
- Bootstrap 5
- Bootstrap Icons
- Chart.js
- html5-qrcode
- QR Code generator berbasis JavaScript qrcodejs
- Export Excel berbasis CSV tanpa ekstensi GD
- barryvdh/laravel-dompdf

## Instalasi

1. Ekstrak project.
2. Masuk ke folder project.
3. Jalankan:

```bash
composer install
```

4. Salin file environment:

```bash
cp .env.example .env
```

5. Atur database di `.env`:

```env
DB_DATABASE=e_absensi_qr
DB_USERNAME=root
DB_PASSWORD=
```

6. Generate key:

```bash
php artisan key:generate
```

7. Jalankan migrasi dan seeder:

```bash
php artisan migrate --seed
```

8. Buat storage link:

```bash
php artisan storage:link
```

9. Jalankan server:

```bash
php artisan serve
```

10. Akses:

```text
http://127.0.0.1:8000
```

## Akun Default

| Role | Username | Password |
|---|---|---|
| Admin | admin | password |
| Pembina | pembina | password |
| Siswa | siswa | password |
| Wali | wali | password |

## Catatan Implementasi

Project ini dibuat sebagai MVP lengkap yang sudah menjalankan alur inti. Beberapa fitur lanjutan seperti validasi GPS dan selfie disediakan dalam struktur database dan titik pengembangan, tetapi belum diwajibkan agar aplikasi tetap ringan dan stabil untuk XAMPP/Laragon.
