@extends('layouts.app') @section('page', 'Data Anggota Ekstrakurikuler') @section('content')<div class="content-header mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-person-lines-fill me-2"></i>Data Anggota Ekstrakurikuler</h1>
        <p>Kelola keanggotaan siswa pada ekstrakurikuler</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="bi bi-plus-circle me-2"></i>Tambah Anggota
    </button>
</div>

<div class="card card-soft p-4 mb-4">
    <form class="d-flex gap-2" method="GET">
        <input name="q" class="form-control" placeholder="Cari berdasarkan nama siswa..." value="{{ request('q') }}">
        <button class="btn btn-primary"><i class="bi bi-search me-2"></i>Cari</button>
    </form>
</div>

<div class="card card-soft overflow-hidden">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr style="background: #f9fafb;">
                    <th><i class="bi bi-person me-2"></i>Siswa</th>
                    <th><i class="bi bi-stars me-2"></i>Ekstrakurikuler</th>
                    <th><i class="bi bi-flag me-2"></i>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                <tr style="transition: all .2s ease;">
                    <td>{{ $i->siswa->nama }}</td>
                    <td>{{ $i->ekstrakurikuler->nama }}</td>
                    <td>
                        <span class="badge-soft" style="background: @if($i->status === 'aktif') #d1fae5 @else #fee2e2 @endif; color: @if($i->status === 'aktif') #065f46 @else #7f1d1d @endif;">
                            {{ ucfirst($i->status) }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <form method='post' action='{{ route("anggota.destroy", $i) }}' class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
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
                        <p style="margin: 0;">Tidak ada data anggota</p>
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
        <form method="post" action="{{ route('anggota.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Anggota Ekstrakurikuler</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Siswa</label>
                    <select name='siswa_id' class='form-select' required>
                        <option value=''>-- Pilih Siswa --</option>
                        @foreach(\App\Models\Siswa::all() as $s)
                            <option value='{{ $s->id }}'>{{ $s->nama }} ({{ $s->nis }})</option>
                        @endforeach
                    </select>
                </div>
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
                    <label class="form-label" style="font-weight: 600;">Status</label>
                    <select name='status' class='form-select' required>
                        <option value='aktif'>Aktif</option>
                        <option value='nonaktif'>Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>@endsection