@extends('layouts.app') @section('page','Laporan Absensi') @section('content')<div class="content-header mb-4">
    <h1><i class="bi bi-file-earmark-bar-graph me-2"></i>Laporan Absensi</h1>
    <p>Lihat dan kelola data absensi siswa ekstrakurikuler</p>
</div>

<div class="card card-soft p-4 mb-4">
    <h5 style="margin-bottom: 20px;"><i class="bi bi-funnel me-2"></i>Filter Data</h5>
    <form class="row g-3">
        <div class="col-md-4">
            <label class="form-label" style="font-weight: 600; font-size: 14px;">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label" style="font-weight: 600; font-size: 14px;">Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                @foreach(['hadir'=>'Hadir','terlambat'=>'Terlambat','izin'=>'Izin','sakit'=>'Sakit','alpha'=>'Alpha'] as $val=>$label)
                <option value="{{ $val }}" @selected(request('status')==$val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end gap-2">
            <button class="btn btn-primary w-100" type="submit"><i class="bi bi-search me-2"></i>Filter</button>
            <a href="{{ route('laporan.excel',request()->query()) }}" class="btn btn-outline-success"><i class="bi bi-file-earmark-excel me-1"></i></a>
            <a href="{{ route('laporan.pdf',request()->query()) }}" class="btn btn-outline-danger"><i class="bi bi-file-earmark-pdf me-1"></i></a>
        </div>
    </form>
</div>

<div class="card card-soft overflow-hidden">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr style="background: #f9fafb;">
                    <th><i class="bi bi-calendar me-2"></i>Tanggal</th>
                    <th><i class="bi bi-person me-2"></i>Siswa</th>
                    <th><i class="bi bi-building me-2"></i>Kelas</th>
                    <th><i class="bi bi-stars me-2"></i>Ekstrakurikuler</th>
                    <th><i class="bi bi-clock me-2"></i>Masuk</th>
                    <th><i class="bi bi-clock me-2"></i>Keluar</th>
                    <th><i class="bi bi-flag me-2"></i>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                <tr style="transition: all .2s ease;">
                    <td><strong>{{ $i->sesi->tanggal }}</strong></td>
                    <td>{{ $i->siswa->nama }}</td>
                    <td>{{ $i->siswa->kelas->nama_kelas }}</td>
                    <td>{{ $i->sesi->ekstrakurikuler->nama }}</td>
                    <td>{{ $i->waktu_masuk?->format('H:i:s') ?? '-' }}</td>
                    <td>{{ $i->waktu_keluar?->format('H:i:s') ?? '-' }}</td>
                    <td>
                        <span class="badge-soft" style="background: @if($i->status === 'hadir') #d1fae5 @elseif($i->status === 'terlambat') #fed7aa @elseif($i->status === 'izin' || $i->status === 'sakit') #dbeafe @else #fee2e2 @endif; color: @if($i->status === 'hadir') #065f46 @elseif($i->status === 'terlambat') #92400e @elseif($i->status === 'izin' || $i->status === 'sakit') #0c4a6e @else #7f1d1d @endif;">
                            {{ ucfirst($i->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-light);">
                        <i class="bi bi-inbox" style="font-size: 40px; opacity: 0.5; display: block; margin-bottom: 12px;"></i>
                        <p style="margin: 0;">Tidak ada data absensi</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 20px;">
    {{ $items->links() }}
</div>@endsection
