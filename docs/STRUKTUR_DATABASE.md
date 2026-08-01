# Struktur Database

Tabel utama: users, siswa, pembina, kelas, ekstrakurikuler, anggota_ekstrakurikuler, jadwal, sesi_absensi, qr_absensi, absensi, izin, notifikasi, audit_log, settings.

Relasi utama:
- User memiliki satu siswa atau pembina.
- Siswa belongsTo kelas.
- Pembina hasMany ekstrakurikuler.
- Ekstrakurikuler belongsToMany siswa melalui anggota_ekstrakurikuler.
- SesiAbsensi hasMany qr_absensi dan absensi.
- Absensi belongsTo siswa dan sesi_absensi.
- Izin belongsTo siswa dan sesi_absensi.
- Notifikasi belongsTo user.
