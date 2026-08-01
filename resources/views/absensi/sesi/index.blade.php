@extends('layouts.app') @section('page', 'Sesi Absensi') @section('content')<div class="content-header mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-clock-history me-2"></i>Sesi Absensi</h1>
        <p>Kelola sesi absensi dan generate QR code</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">
        <i class="bi bi-plus-circle me-2"></i>Buat Sesi Baru
    </button>
</div>

<div class="card card-soft overflow-hidden">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr style="background: #f9fafb;">
                    <th><i class="bi bi-calendar me-2"></i>Tanggal</th>
                    <th><i class="bi bi-stars me-2"></i>Ekstrakurikuler</th>
                    <th><i class="bi bi-person-badge me-2"></i>Pembina</th>
                    <th><i class="bi bi-clock me-2"></i>Jam</th>
                    <th><i class="bi bi-flag me-2"></i>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                <tr style="transition: all .2s ease;">
                    <td><strong>{{ $i->tanggal->format('d M Y') }}</strong></td>
                    <td>{{ $i->ekstrakurikuler->nama }}</td>
                    <td>{{ $i->pembina->nama }}</td>
                    <td>{{ $i->jam_mulai }} - {{ $i->jam_selesai }}</td>
                    <td>
                        <span class="badge-soft" style="background: @if($i->status === 'aktif') #d1fae5 @elseif($i->status === 'selesai') #dbeafe @else #fee2e2 @endif; color: @if($i->status === 'aktif') #065f46 @elseif($i->status === 'selesai') #0c4a6e @else #7f1d1d @endif;">
                            {{ ucfirst($i->status) }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a class="btn btn-sm btn-primary" href="{{ route('qr.generate', $i) }}" title="Generate QR Code">
                            <i class="bi bi-qr-code"></i>
                        </a>
                        @if($i->status !== 'selesai')
                            <form class="d-inline" method="post" action="{{ route('sesi.close', $i) }}" style="display: inline;">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary" type="submit" title="Tutup Sesi">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </form>
                        @else
                            <button class="btn btn-sm btn-secondary" disabled title="Sesi Selesai">
                                <i class="bi bi-check-circle"></i>
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-light);">
                        <i class="bi bi-inbox" style="font-size: 40px; opacity: 0.5; display: block; margin-bottom: 12px;"></i>
                        <p style="margin: 0;">Belum ada sesi absensi</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 20px;">
    {{ $items->links() }}
</div>

<div class="modal fade" id="add">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="{{ route('sesi.store') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Buat Sesi Absensi Baru</h5>
                <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Ekstrakurikuler</label>
                    <select name="ekstrakurikuler_id" class="form-select" required>
                        <option value="">-- Pilih Ekstrakurikuler --</option>
                        @foreach(\App\Models\Ekstrakurikuler::all() as $e)
                            <option value="{{ $e->id }}">{{ $e->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Pembina</label>
                    <select name="pembina_id" class="form-select" required>
                        <option value="">-- Pilih Pembina --</option>
                        @foreach(\App\Models\Pembina::all() as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Jadwal (Opsional)</label>
                    <select name="jadwal_id" class="form-select">
                        <option value="">Tanpa jadwal yang spesifik</option>
                        @foreach(\App\Models\Jadwal::all() as $j)
                            <option value="{{ $j->id }}">{{ $j->ekstrakurikuler->nama }} - {{ $j->hari }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600;">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600;">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control" required>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600;">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600;">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i>Buat Sesi</button>
            </div>
        </form>
    </div>
</div>
<style>
/* ===========================
   FIX AKSI SESI ABSENSI HP
   TANPA UBAH SISTEM
=========================== */

/* table responsif tetap aman */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* paksa semua cell tidak wrap */
.table th,
.table td {
    white-space: nowrap !important;
    vertical-align: middle !important;
}

/* kolom aksi khusus */
.table td:last-child {
    min-width: 120px;
    text-align: center;
}

/* tombol aksi supaya tidak turun */
.table td .btn {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* jarak antar tombol */
.table td .btn + .btn {
    margin-left: 6px;
}

/* tampilan mobile */
@media (max-width: 768px) {

    .table {
        min-width: 700px;
    }

    .table td,
    .table th {
        font-size: 13px;
        padding: 10px 12px;
    }

    /* tombol QR & close jadi kecil tapi tetap sejajar */
    .table td .btn {
        width: 40px;
        height: 40px;
        padding: 0;
        border-radius: 10px;
    }

    /* khusus badge status biar tidak pecah */
    .badge-soft {
        white-space: nowrap;
    }
}
</style>
@endsection