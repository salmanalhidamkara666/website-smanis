@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page', 'Dashboard Admin')
@section('content')

<style>
/* Semua kotak statistik menjadi gradasi biru */
.stat.primary,
.stat.success,
.stat.danger,
.stat.warning {
    background: linear-gradient(135deg, #2f63f5 0%, #1d4ed8 100%) !important;
    border: none !important;
    color: #ffffff !important;
}

.stat i {
    color: rgba(255, 255, 255, 0.9) !important;
}

.stat .stat-label {
    color: rgba(255, 255, 255, 0.85) !important;
}

.stat .stat-value {
    color: #ffffff !important;
}

.stat .stat-desc {
    color: rgba(255, 255, 255, 0.75) !important;
}
</style>

<div class="content-header mb-4">
    <h1><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</h1>
    <p>Pantau semua aktivitas dan statistik sistem</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat primary">
            <i class="bi bi-people"></i>
            <div class="stat-content">
                <div class="stat-label">Total Siswa</div>
                <div class="stat-value">{{ $totalSiswa }}</div>
                <div class="stat-desc">Terdaftar aktif</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat primary">
            <i class="bi bi-person-badge"></i>
            <div class="stat-content">
                <div class="stat-label">Total Pembina</div>
                <div class="stat-value">{{ $totalPembina }}</div>
                <div class="stat-desc">Pengampu ekstra</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat primary">
            <i class="bi bi-stars"></i>
            <div class="stat-content">
                <div class="stat-label">Total Ekstrakurikuler</div>
                <div class="stat-value">{{ $totalEkskul }}</div>
                <div class="stat-desc">Program aktif</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat primary">
            <i class="bi bi-check-circle"></i>
            <div class="stat-content">
                <div class="stat-label">Hadir Hari Ini</div>
                <div class="stat-value">{{ $hadirHariIni }}</div>
                <div class="stat-desc">Absensi tercatat</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat primary">
            <i class="bi bi-file-earmark-check"></i>
            <div class="stat-content">
                <div class="stat-label">Izin</div>
                <div class="stat-value">{{ $izin }}</div>
                <div class="stat-desc">Pengajuan izin</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat primary">
            <i class="bi bi-heart-pulse"></i>
            <div class="stat-content">
                <div class="stat-label">Sakit</div>
                <div class="stat-value">{{ $sakit }}</div>
                <div class="stat-desc">Pengajuan sakit</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat primary">
            <i class="bi bi-x-circle"></i>
            <div class="stat-content">
                <div class="stat-label">Alpha</div>
                <div class="stat-value">{{ $alpha }}</div>
                <div class="stat-desc">Tidak hadir</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat primary">
            <i class="bi bi-exclamation-triangle"></i>
            <div class="stat-content">
                <div class="stat-label">Terlambat</div>
                <div class="stat-value">0</div>
                <div class="stat-desc">Perlu perhatian</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card card-soft p-4">
            <h5 style="margin-bottom: 20px; font-weight: 600;"><i class="bi bi-graph-up me-2"></i>Grafik Kehadiran</h5>
            <div style="position: relative; height: 280px;">
                <canvas id="chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-soft p-4">
            <h5 style="margin-bottom: 20px; font-weight: 600;"><i class="bi bi-clock-history me-2"></i>Aktivitas Terbaru</h5>
            <div style="max-height: 300px; overflow-y: auto;">
                @forelse($aktivitas as $a)
                    <div style="padding-bottom: 16px; border-bottom: 1px solid var(--border);">
                        <strong style="display: block; margin-bottom: 4px;">{{ $a->judul }}</strong>
                        <div style="font-size: 13px; color: var(--text-light);">{{ $a->pesan }}</div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 32px; color: var(--text-light);">
                        <i class="bi bi-inbox" style="font-size: 32px; opacity: 0.3; display: block; margin-bottom: 12px;"></i>
                        <p style="margin: 0; font-size: 14px;">Belum ada aktivitas</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartCanvas = document.getElementById('chart');

    if (!chartCanvas) return;

    new Chart(chartCanvas, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($grafikHadir)) !!},
            datasets: [{
                label: 'Hadir',
                data: {!! json_encode(array_values($grafikHadir)) !!},
                borderColor: '#1f5eff',
                backgroundColor: 'rgba(31, 94, 255, 0.08)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#1f5eff',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: 'rgba(0,0,0,0.04)' } },
                x: { grid: { display: false } }
            },
            interaction: { intersect: false, mode: 'index' }
        }
    });
});
</script>
@endpush