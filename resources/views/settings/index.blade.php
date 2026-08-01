@extends('layouts.app') @section('page','Pengaturan Sistem') @section('content')<div class="content-header mb-4">
    <h1><i class="bi bi-gear me-2"></i>Pengaturan Sistem</h1>
    <p>Kelola konfigurasi aplikasi dan sekolah</p>
</div>

<div class="card card-soft p-4">
    <form method="post" action="{{ route('settings.update') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" style="font-weight: 600;">Nama Sekolah</label>
                <input name="nama_sekolah" class="form-control" value="{{ $settings['nama_sekolah'] ?? 'SMA Negeri 1 Surade' }}" placeholder="Masukkan nama sekolah">
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-weight: 600;">Tahun Ajaran</label>
                <input name="tahun_ajaran" class="form-control" value="{{ $settings['tahun_ajaran'] ?? '2026/2027' }}" placeholder="Contoh: 2026/2027">
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-weight: 600;">Semester</label>
                <select name="semester" class="form-select">
                    <option @selected(($settings['semester'] ?? 'Ganjil') === 'Ganjil')>Ganjil</option>
                    <option @selected(($settings['semester'] ?? '') === 'Genap')>Genap</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-weight: 600;">Toleransi Terlambat (Menit)</label>
                <input type="number" name="toleransi_terlambat" class="form-control" value="{{ $settings['toleransi_terlambat'] ?? '10' }}" min="0" placeholder="Dalam menit">
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-weight: 600;">Durasi QR Code (Menit)</label>
                <input type="number" name="durasi_qr" class="form-control" value="{{ $settings['durasi_qr'] ?? '10' }}" min="1" placeholder="Dalam menit">
            </div>
        </div>
        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle me-2"></i>Simpan Perubahan</button>
        </div>
    </form>
</div>@endsection
