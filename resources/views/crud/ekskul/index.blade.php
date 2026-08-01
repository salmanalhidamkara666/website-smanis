@extends('layouts.app') @section('page','Data Ekstrakurikuler') @section('content')<div class="content-header mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-stars me-2"></i>Data Ekstrakurikuler</h1>
        <p>Kelola program ekstrakurikuler sekolah</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="bi bi-plus-circle me-2"></i>Tambah Ekstrakurikuler
    </button>
</div>

<div class="card card-soft p-4 mb-4">
    <form class="d-flex gap-2" method="GET">
        <input name="q" class="form-control" placeholder="Cari berdasarkan nama..." value="{{ request('q') }}">
        <button class="btn btn-primary"><i class="bi bi-search me-2"></i>Cari</button>
    </form>
</div>

<div class="card card-soft overflow-hidden">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr style="background: #f9fafb;">
                    <th><i class="bi bi-stars me-2"></i>Nama</th>
                    <th><i class="bi bi-person-badge me-2"></i>Pembina</th>
                    <th><i class="bi bi-geo-alt me-2"></i>Lokasi</th>
                    <th><i class="bi bi-flag me-2"></i>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                <tr style="transition: all .2s ease;">
                    <td><strong>{{ $i->nama }}</strong></td>
                    <td>{{ $i->pembina->nama }}</td>
                    <td>{{ $i->lokasi ?? '-' }}</td>
                    <td>
                        <span class="badge-soft" style="background: @if($i->status === 'aktif') #d1fae5 @else #fee2e2 @endif; color: @if($i->status === 'aktif') #065f46 @else #7f1d1d @endif;">
                            {{ ucfirst($i->status) }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <form method='post' action='{{ route("ekskul.destroy",$i) }}' class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
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
                        <p style="margin: 0;">Tidak ada data ekstrakurikuler</p>
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
        <form method="post" action="{{ route('ekskul.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Ekstrakurikuler</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Nama Ekstrakurikuler</label>
                    <input name='nama' class='form-control' placeholder='Contoh: Jurnalistik, Seni, Olahraga' required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Deskripsi</label>
                    <textarea name='deskripsi' class='form-control' placeholder='Jelaskan tujuan dan kegiatan ekstrakurikuler' rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Pembina</label>
                    <select name='pembina_id' class='form-select' required>
                        <option value=''>-- Pilih Pembina --</option>
                        @foreach(\App\Models\Pembina::all() as $p)
                            <option value='{{ $p->id }}'>{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Lokasi</label>
                    <input name='lokasi' class='form-control' placeholder='Contoh: Ruang 101, Lapangan'>
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
</div>
@endsection
