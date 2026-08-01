@extends('layouts.app') @section('page','Data Jadwal') @section('content')<div class="content-header mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-calendar2-check me-2"></i>Data Jadwal</h1>
        <p>Kelola jadwal ekstrakurikuler</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="bi bi-plus-circle me-2"></i>Tambah Jadwal
    </button>
</div>

<div class="card card-soft p-4 mb-4">
    <form class="d-flex gap-2" method="GET">
        <input name="q" class="form-control" placeholder="Cari berdasarkan nama ekstrakurikuler..." value="{{ request('q') }}">
        <button class="btn btn-primary"><i class="bi bi-search me-2"></i>Cari</button>
    </form>
</div>

<div class="card card-soft overflow-hidden">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr style="background: #f9fafb;">
                    <th><i class="bi bi-stars me-2"></i>Ekstrakurikuler</th>
                    <th><i class="bi bi-calendar3 me-2"></i>Hari</th>
                    <th><i class="bi bi-clock me-2"></i>Jam</th>
                    <th><i class="bi bi-geo-alt me-2"></i>Lokasi</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                <tr style="transition: all .2s ease;">
                    <td><strong>{{ $i->ekstrakurikuler->nama }}</strong></td>
                    <td>{{ $i->hari }}</td>
                    <td>{{ $i->jam_mulai }} - {{ $i->jam_selesai }}</td>
                    <td>{{ $i->lokasi ?? '-' }}</td>
                    <td style="text-align: center;">
                        <form method='post' action='{{ route("jadwal.destroy",$i) }}' class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                            @csrf 
                            @method('delete')
                            <button class='btn btn-sm btn-outline-danger' type='submit' title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-light);">
                        <i class="bi bi-inbox" style="font-size: 40px; opacity: 0.5; display: block; margin-bottom: 12px;"></i>
                        <p style="margin: 0;">Tidak ada data jadwal</p>
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

<div class="modal fade" id="modalAdd">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="{{ route('jadwal.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Ekstrakurikuler</label>
                    <select name='ekstrakurikuler_id' class='form-select' required>
                        <option value=''>-- Pilih Ekstrakurikuler --</option>
                        @foreach(\App\Models\Ekstrakurikuler::all() as $e)
                            <option value='{{ $e->id }}'>{{ $e->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Hari</label>
                    <select name='hari' class='form-select' required>
                        <option value=''>-- Pilih Hari --</option>
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                            <option>{{ $h }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600;">Jam Mulai</label>
                        <input type='time' name='jam_mulai' class='form-control' required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600;">Jam Selesai</label>
                        <input type='time' name='jam_selesai' class='form-control' required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Lokasi</label>
                    <input name='lokasi' class='form-control' placeholder='Contoh: Ruang 101, Lapangan'>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
