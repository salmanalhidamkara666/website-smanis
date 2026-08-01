@extends('layouts.app') @section('page','Dashboard Wali') @section('content')<div class="content-header mb-4">
    <h1><i class="bi bi-speedometer2 me-2"></i>Dashboard Wali</h1>
    <p>Pantau riwayat absensi dan izin/sakit anak</p>
</div>

@if($anak)
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat primary">
            <i class="bi bi-person-circle"></i>
            <div class="stat-content">
                <div class="stat-label">Nama Anak</div>
                <div class="stat-value">{{ $anak->nama }}</div>
                <div class="stat-desc">NIS {{ $anak->nis }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat success">
            <i class="bi bi-building"></i>
            <div class="stat-content">
                <div class="stat-label">Kelas</div>
                <div class="stat-value">{{ $anak->kelas->nama_kelas ?? 'N/A' }}</div>
                <div class="stat-desc">Tingkat {{ $anak->kelas->tingkat ?? '-' }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat info">
            <i class="bi bi-stars"></i>
            <div class="stat-content">
                <div class="stat-label">Ekstrakurikuler</div>
                <div class="stat-value">{{ $anak->anggota()->where('status','aktif')->count() ?? 0 }}</div>
                <div class="stat-desc">Terdaftar aktif</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('izin.index') }}" class="stat" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: #fff; text-decoration: none; cursor: pointer;">
            <i class="bi bi-file-earmark-text" style="color: rgba(255,255,255,.9);"></i>
            <div class="stat-content">
                <div class="stat-label">Izin/Sakit</div>
                <div class="stat-value" style="color: #fff;">Ajukan</div>
                <div class="stat-desc" style="color: rgba(255,255,255,.8);">Kelola izin</div>
            </div>
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-12">
        <div class="card card-soft p-4">
            <h5><i class="bi bi-clock-history"></i>Riwayat Absensi {{ $anak->nama }}</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr style="background: #f9fafb;">
                            <th><i class="bi bi-calendar me-2"></i>Tanggal</th>
                            <th><i class="bi bi-stars me-2"></i>Ekstrakurikuler</th>
                            <th><i class="bi bi-flag me-2"></i>Status</th>
                            <th><i class="bi bi-clock me-2"></i>Jam Masuk</th>
                            <th><i class="bi bi-clock me-2"></i>Jam Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $r)
                        <tr style="transition: all .2s ease;">
                            <td><strong>{{ $r->sesi->tanggal->format('d M Y') }}</strong></td>
                            <td>{{ $r->sesi->ekstrakurikuler->nama }}</td>
                            <td>
                                <span class="badge-soft" style="background: @if($r->status === 'hadir') #d1fae5 @elseif($r->status === 'terlambat') #fed7aa @elseif($r->status === 'izin' || $r->status === 'sakit') #dbeafe @else #fee2e2 @endif; color: @if($r->status === 'hadir') #065f46 @elseif($r->status === 'terlambat') #92400e @elseif($r->status === 'izin' || $r->status === 'sakit') #0c4a6e @else #7f1d1d @endif;">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>
                            <td>{{ $r->waktu_masuk?->format('H:i') ?? '-' }}</td>
                            <td>{{ $r->waktu_keluar?->format('H:i') ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-light);">
                                <i class="bi bi-inbox" style="font-size: 40px; opacity: 0.5; display: block; margin-bottom: 12px;"></i>
                                <p style="margin: 0;">Belum ada riwayat absensi</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@else
<div class="card card-soft p-4">
    <div style="text-align: center; padding: 40px; color: var(--text-light);">
        <i class="bi bi-person-exclamation" style="font-size: 48px; opacity: 0.5; display: block; margin-bottom: 16px;"></i>
        <p style="font-size: 16px;">Data anak belum terhubung dengan akun Anda</p>
        <p style="font-size: 14px;">Hubungi administrator untuk menghubungkan data anak ke akun Anda</p>
    </div>
</div>
@endif
@endsection
