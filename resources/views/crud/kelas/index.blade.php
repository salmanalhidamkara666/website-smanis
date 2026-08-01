@extends('layouts.app') @section('page', 'Data Kelas') @section('content')<div class="content-header mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-building me-2"></i>Data Kelas</h1>
        <p>Kelola informasi kelas sekolah</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="bi bi-plus-circle me-2"></i>Tambah Kelas
    </button>
</div>

<div class="card card-soft p-4 mb-4">
    <form class="d-flex gap-2" method="GET">
        <input name="q" class="form-control" placeholder="Cari berdasarkan nama kelas..." value="{{ request('q') }}">
        <button class="btn btn-primary"><i class="bi bi-search me-2"></i>Cari</button>
    </form>
</div>

<div class="card card-soft overflow-hidden">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr style="background: #f9fafb;">
                    <th><i class="bi bi-tag me-2"></i>Nama Kelas</th>
                    <th><i class="bi bi-bar-chart me-2"></i>Tingkat</th>
                    <th><i class="bi bi-briefcase me-2"></i>Jurusan</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                <tr style="transition: all .2s ease;">
                    <td><strong>{{ $i->nama_kelas }}</strong></td>
                    <td>{{ $i->tingkat }}</td>
                    <td>{{ $i->jurusan ?? '-' }}</td>
                    <td style="text-align: center;">
                        <form method='post' action='{{ route("kelas.destroy", $i) }}' class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
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
                    <td colspan="4" style="text-align: center; padding: 40px; color: var(--text-light);">
                        <i class="bi bi-inbox" style="font-size: 40px; opacity: 0.5; display: block; margin-bottom: 12px;"></i>
                        <p style="margin: 0;">Tidak ada data kelas</p>
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
        <form method="post" action="{{ route('kelas.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Data Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Nama Kelas</label>
                    <input name='nama_kelas' class='form-control' placeholder='Contoh: X IPA 1' required>
                </div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600;">Tingkat</label>
                        <input name='tingkat' class='form-control' placeholder='Contoh: X, XI, XII'>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600;">Jurusan</label>
                        <input name='jurusan' class='form-control' placeholder='Contoh: IPA, IPS'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>@endsection