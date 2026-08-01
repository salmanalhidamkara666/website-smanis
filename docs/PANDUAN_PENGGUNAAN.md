# Panduan Penggunaan

## Admin
Admin mengelola master data siswa, pembina, kelas, ekstrakurikuler, anggota ekstrakurikuler, jadwal, sesi absensi, laporan, notifikasi, dan pengaturan sistem.

## Pembina
Pembina membuat sesi absensi, membuka halaman QR Code, memantau kehadiran, dan memvalidasi izin atau sakit siswa.

## Siswa
Siswa membuka menu Scan QR, mengarahkan kamera ke QR Code masuk atau keluar, lalu sistem memvalidasi data ke server.

## Wali
Wali melihat riwayat absensi anak dan menerima notifikasi ketika anak berhasil absen.

## Alur Absensi QR
1. Pembina membuat sesi absensi.
2. Pembina membuka tombol QR pada sesi.
3. Sistem menghasilkan QR masuk dan QR keluar.
4. Siswa login dan membuka menu Scan QR.
5. Sistem memeriksa token, masa berlaku QR, sesi aktif, keanggotaan siswa, dan scan ganda.
6. Sistem menyimpan absensi serta memberi notifikasi ke wali.
