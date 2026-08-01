@extends('layouts.app') @section('page','Izin dan Sakit') @section('content')<div class="content-header mb-4">
    <h1><i class="bi bi-file-earmark-check me-2"></i>Manajemen Izin & Sakit</h1>
    <p>Kelola pengajuan izin dan sakit siswa</p>
</div>

@if(session('role')==='siswa')
<div class="card card-soft p-4 mb-4">
    <h5 style="margin-bottom: 20px;"><i class="bi bi-plus-circle me-2"></i>Ajukan Izin/Sakit</h5>
    <form method="post" action="{{ route('izin.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label" style="font-weight: 600;">Jenis Pengajuan</label>
                <select name="jenis" class="form-select" required>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" style="font-weight: 600;">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label" style="font-weight: 600;">Bukti (Jika ada)</label>
                <input type="file" name="bukti" class="form-control">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" style="font-weight: 600; margin-top: 12px;">Keterangan</label>
            <textarea name="keterangan" class="form-control" placeholder="Jelaskan alasan izin/sakit Anda" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-circle me-2"></i>Ajukan</button>
    </form>
</div>
@endif

<div class="card card-soft overflow-hidden">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr style="background: #f9fafb;">
                    <th><i class="bi bi-person me-2"></i>Siswa</th>
                    <th><i class="bi bi-calendar me-2"></i>Tanggal</th>
                    <th><i class="bi bi-tag me-2"></i>Jenis</th>
                    <th><i class="bi bi-flag me-2"></i>Status</th>
                    @if(in_array(session('role'),['admin','pembina']))
                        <th style="text-align: center;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                <tr style="transition: all .2s ease;">
                    <td>
                        <strong>{{ $i->siswa->nama }}</strong>
                        <div style="font-size: 12px; color: var(--text-light);">{{ $i->siswa->nis }}</div>
                    </td>
                    <td>{{ $i->tanggal->format('d M Y') }}</td>
                    <td>
                        <span class="badge-soft" style="background: @if($i->jenis === 'izin') #dbeafe @else #fee2e2 @endif; color: @if($i->jenis === 'izin') #0c4a6e @else #7f1d1d @endif;">
                            {{ ucfirst($i->jenis) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-soft" style="background: @if($i->status === 'menunggu') #fed7aa @elseif($i->status === 'disetujui') #d1fae5 @else #fee2e2 @endif; color: @if($i->status === 'menunggu') #92400e @elseif($i->status === 'disetujui') #065f46 @else #7f1d1d @endif;">
                            {{ ucfirst($i->status) }}
                        </span>
                    </td>
                    @if(in_array(session('role'),['admin','pembina']) && $i->status==='menunggu')
                    <td style="text-align: center;">
                        <form method="post" action="{{ route('izin.status',$i) }}" class="d-flex gap-2" style="justify-content: center; align-items: center;">
                            @csrf
                            <select name="status" class="form-select form-select-sm" style="max-width: 120px; margin: 0;">
                                <option value="disetujui">Setujui</option>
                                <option value="ditolak">Tolak</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-check-circle"></i></button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-light);">
                        <i class="bi bi-inbox" style="font-size: 40px; opacity: 0.5; display: block; margin-bottom: 12px;"></i>
                        <p style="margin: 0;">Tidak ada pengajuan izin/sakit</p>
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
