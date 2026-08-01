@extends('layouts.app') @section('page', 'Dashboard Siswa') @section('content')<div class="content-header mb-4">
    <h1><i class="bi bi-speedometer2 me-2"></i>Dashboard Siswa</h1>
    <p>Kelola data absensi dan jadwal ekstrakurikuler Anda</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat primary">
            <i class="bi bi-person-circle"></i>
            <div class="stat-content">
                <div class="stat-label">Nama Siswa</div>
                <div class="stat-value">{{ $siswa?->nama ?? 'N/A' }}</div>
                <div class="stat-desc">{{ $siswa?->nis ?? 'NIS tidak ditemukan' }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat success">
            <i class="bi bi-building"></i>
            <div class="stat-content">
                <div class="stat-label">Kelas</div>
                <div class="stat-value">{{ $siswa?->kelas?->nama_kelas ?? 'N/A' }}</div>
                <div class="stat-desc">Tingkat {{ $siswa?->kelas?->tingkat ?? '-' }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat warning">
            <i class="bi bi-calendar-check"></i>
            <div class="stat-content">
                <div class="stat-label">Ekstrakurikuler</div>
                <div class="stat-value">{{ count($jadwal) ?? 0 }}</div>
                <div class="stat-desc">Terdaftar aktif</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('qr.scan') }}" class="stat" style="background: linear-gradient(135deg, #1f5eff 0%, #1540cc 100%); text-decoration: none; cursor: pointer; border: none;">
            <i class="bi bi-qr-code-scan" style="color: rgba(255,255,255,.9);"></i>
            <div class="stat-content">
                <div class="stat-label">Scan QR</div>
                <div class="stat-value" style="color: #fff;">Mulai</div>
                <div class="stat-desc" style="color: rgba(255,255,255,.8);">Absen sekarang</div>
            </div>
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card card-soft p-4">
            <h5><i class="bi bi-calendar2-event"></i>Jadwal Ekstrakurikuler</h5>
            @forelse($jadwal as $j)
                <div class="d-flex justify-content-between align-items-center py-3" style="border-bottom: 1px solid var(--border);">
                    <div>
                        <div style="font-weight: 700; color: var(--dark);">{{ $j->ekstrakurikuler->nama }}</div>
                        <div style="font-size: 13px; color: var(--text-light); margin-top: 4px;">
                            <i class="bi bi-calendar"></i> {{ $j->hari }} | 
                            <i class="bi bi-clock"></i> {{ $j->jam_mulai }} - {{ $j->jam_selesai }}
                        </div>
                        <div style="font-size: 12px; color: #667085; margin-top: 4px;">
                            <i class="bi bi-geo-alt"></i> {{ $j->lokasi ?? 'Lokasi tidak ditentukan' }}
                        </div>
                    </div>
                    <span class="badge bg-primary">Aktif</span>
                </div>
            @empty
                <div style="text-align: center; padding: 32px; color: var(--text-light);">
                    <i class="bi bi-inbox" style="font-size: 32px; opacity: 0.5; display: block; margin-bottom: 12px;"></i>
                    <p>Belum ada jadwal ekstrakurikuler</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card card-soft p-4">
            <h5><i class="bi bi-clock-history"></i>Riwayat Absensi Terakhir</h5>
            @forelse($riwayat as $r)
                <div class="d-flex justify-content-between align-items-center py-3" style="border-bottom: 1px solid var(--border);">
                    <div>
                        <div style="font-weight: 700; color: var(--dark);">{{ $r->sesi->ekstrakurikuler->nama }}</div>
                        <div style="font-size: 13px; color: var(--text-light); margin-top: 4px;">
                            <i class="bi bi-calendar"></i> {{ $r->sesi->tanggal->format('d M Y') }}
                            @if($r->waktu_masuk)
                                | <i class="bi bi-clock"></i> {{ $r->waktu_masuk->format('H:i') }}
                            @endif
                        </div>
                    </div>
                    <span class="badge-soft" style="background: @if($r->status === 'hadir') #d1fae5 @elseif($r->status === 'terlambat') #fed7aa @elseif($r->status === 'izin' || $r->status === 'sakit') #dbeafe @else #fee2e2 @endif; color: @if($r->status === 'hadir') #065f46 @elseif($r->status === 'terlambat') #92400e @elseif($r->status === 'izin' || $r->status === 'sakit') #0c4a6e @else #7f1d1d @endif;">
                        {{ ucfirst($r->status) }}
                    </span>
                </div>
            @empty
                <div style="text-align: center; padding: 32px; color: var(--text-light);">
                    <i class="bi bi-inbox" style="font-size: 32px; opacity: 0.5; display: block; margin-bottom: 12px;"></i>
                    <p>Belum ada riwayat absensi</p>
                </div>
            @endforelse
        </div>
    </div>
</div>@endsection