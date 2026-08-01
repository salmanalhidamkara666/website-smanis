@extends('layouts.app')
@section('page','Data Pembina')
@section('content')

<div class="content-header mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-person-badge-fill me-2"></i>Data Pembina</h1>
        <p>Kelola informasi pembina ekstrakurikuler</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="bi bi-plus-circle me-2"></i>Tambah Pembina
    </button>
</div>

<div class="card card-soft p-4 mb-4">
    <form class="d-flex gap-2" method="GET">
        <input name="q" class="form-control" placeholder="Cari berdasarkan NIP atau Nama..." value="{{ request('q') }}">
        <button class="btn btn-primary"><i class="bi bi-search me-2"></i>Cari</button>
    </form>
</div>

<div class="card card-soft overflow-hidden">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr style="background: #f9fafb;">
                    <th><i class="bi bi-hash me-2"></i>NIP</th>
                    <th><i class="bi bi-person me-2"></i>Nama</th>
                    <th><i class="bi bi-telephone me-2"></i>No HP</th>
                    <th><i class="bi bi-geo-alt me-2"></i>Alamat</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                <tr style="transition: all .2s ease;">
                    <td><strong style="font-family: 'Courier New', monospace;">{{ $i->nip }}</strong></td>
                    <td>{{ $i->nama }}</td>
                    <td>{{ $i->no_hp ?? '-' }}</td>
                    <td>{{ $i->alamat ?? '-' }}</td>
                    <td style="text-align: center;">
                        <form method='post' action='{{ route("pembina.destroy",$i) }}' class='d-inline' onsubmit="return confirm('Yakin ingin menghapus?');">
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
                        <p style="margin: 0;">Tidak ada data pembina</p>
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
        <form method="post" action="{{ route('pembina.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Data Pembina</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">NIP</label>
                    <input name='nip' class='form-control' placeholder='Nomor Induk Pegawai' required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Nama Lengkap</label>
                    <input name='nama' class='form-control' placeholder='Masukkan nama lengkap' required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">No HP</label>
                    <input name='no_hp' class='form-control' placeholder='08xx xxxx xxxx'>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Alamat</label>
                    <textarea name='alamat' class='form-control' placeholder='Masukkan alamat lengkap' rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- CSS tambahan agar tabel pembina responsive di HP -->
<style>
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    width: 100%;
}
.table th, .table td {
    vertical-align: middle;
    white-space: nowrap;
}
@media (max-width: 768px) {
    .table th, .table td {
        font-size: 13px;
        padding: 8px 10px;
    }
}
</style>

@endsection