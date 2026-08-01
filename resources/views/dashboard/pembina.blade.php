@extends('layouts.app') @section('page', 'Dashboard Pembina') @section('content')<div class="content-header mb-4">
    <h1><i class="bi bi-speedometer2 me-2"></i>Dashboard Pembina</h1>
    <p>Kelola ekstrakurikuler dan sesi absensi Anda</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-4 col-md-6">
        <div class="stat primary">
            <i class="bi bi-stars"></i>
            <div class="stat-content">
                <div class="stat-label">Ekstrakurikuler Dibina</div>
                <div class="stat-value">{{ $ekskul->count() }}</div>
                <div class="stat-desc">Program usaha</div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="stat success">
            <i class="bi bi-clock-history"></i>
            <div class="stat-content">
                <div class="stat-label">Sesi Aktif</div>
                <div class="stat-value">{{ $sesi->count() }}</div>
                <div class="stat-desc">Sesi tersedia</div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="stat warning">
            <i class="bi bi-file-earmark-check"></i>
            <div class="stat-content">
                <div class="stat-label">Pengajuan Izin</div>
                <div class="stat-value">{{ $pengajuan->count() }}</div>
                <div class="stat-desc">Menunggu persetujuan</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-12">
        <div class="card card-soft overflow-hidden">
            <div class="p-4" style="border-bottom: 1px solid var(--border);">
                <h5 style="margin: 0; font-weight: 600;"><i class="bi bi-stars me-2"></i>Ekstrakurikuler yang Anda Bina</h5>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr style="background: #f9fafb;">
                            <th><i class="bi bi-stars me-2"></i>Nama Ekstrakurikuler</th>
                            <th><i class="bi bi-people me-2"></i>Jumlah Siswa</th>
                            <th><i class="bi bi-geo-alt me-2"></i>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ekskul as $e)
                        <tr style="transition: all .2s ease;">
                            <td><strong>{{ $e->nama }}</strong></td>
                            <td><span class="badge-soft success">{{ $e->siswa_count }} siswa</span></td>
                            <td>{{ $e->lokasi }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 40px; color: var(--text-light);">
                                <i class="bi bi-inbox" style="font-size: 40px; opacity: 0.5; display: block; margin-bottom: 12px;"></i>
                                <p style="margin: 0;">Belum ada ekstrakurikuler</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
