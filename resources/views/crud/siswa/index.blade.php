@extends('layouts.app')
@section('page', 'Data Siswa')
@section('content')
<div class="content-header mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-people-fill me-2"></i>Data Siswa</h1>
        <p>Kelola informasi siswa ekstrakurikuler</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="bi bi-plus-circle me-2"></i>Tambah Siswa
    </button>
</div>

<div class="card card-soft p-4 mb-4">
    <form class="d-flex gap-2" method="GET">
        <input name="q" class="form-control" placeholder="Cari berdasarkan NIS atau Nama..." value="{{ request('q') }}">
        <button class="btn btn-primary"><i class="bi bi-search me-2"></i>Cari</button>
    </form>
</div>

<div class="card card-soft overflow-hidden">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr style="background: #f9fafb;">
                    <th><i class="bi bi-hash me-2"></i>NIS</th>
                    <th><i class="bi bi-person me-2"></i>Nama</th>
                    <th><i class="bi bi-building me-2"></i>Kelas</th>
                    <th><i class="bi bi-person-lines-fill me-2"></i>Jenis Kelamin</th>
                    <th><i class="bi bi-telephone me-2"></i>No HP</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                <tr style="transition: all .2s ease;">
                    <td><strong style="font-family: 'Courier New', monospace;">{{ $i->nis }}</strong></td>
                    <td>{{ $i->nama }}</td>
                    <td>{{ $i->kelas->nama_kelas }}</td>
                    <td>
                        @if($i->jenis_kelamin === 'L')
                            <span class="badge-soft info"><i class="bi bi-person-fill"></i> Laki-laki</span>
                        @else
                            <span class="badge-soft" style="background: #fce7f3; color: #be123c;"><i class="bi bi-person-fill"></i> Perempuan</span>
                        @endif
                    </td>
                    <td>{{ $i->no_hp ?? '-' }}</td>
                    <td style="text-align: center;">
                        <form method='post' action='{{ route("siswa.destroy", $i) }}' class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
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
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-light);">
                        <i class="bi bi-inbox" style="font-size: 40px; opacity: 0.5; display: block; margin-bottom: 12px;"></i>
                        <p style="margin: 0;">Tidak ada data siswa</p>
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
        <form method="post" action="{{ route('siswa.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">NIS</label>
                    <input name='nis' class='form-control' placeholder='Nomor Induk Siswa' required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Nama Lengkap</label>
                    <input name='nama' class='form-control' placeholder='Masukkan nama lengkap' required>
                </div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600;">Jenis Kelamin</label>
                        <select name='jenis_kelamin' class='form-select' required>
                            <option value='L'>Laki-laki</option>
                            <option value='P'>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600;">Kelas</label>
                        <select name='kelas_id' class='form-select' required>
                            <option value=''>-- Pilih Kelas --</option>
                            @foreach(\App\Models\Kelas::all() as $k)
                                <option value='{{ $k->id }}'>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
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

<!-- CSS tambahan untuk tabel responsif HP -->
<style>
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    width: 100%;
    border-radius: 12px;
}

.table {
    width: 100%;
    table-layout: auto;
    min-width: 600px;
}

@media (max-width: 768px) {
    .table td, .table th {
        white-space: nowrap;
    }
    .badge-soft i {
        display: inline-block;
        margin-right: 4px;
    }
    .badge-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 4px 8px;
        font-size: 12px;
    }
}
</style>
@endsection