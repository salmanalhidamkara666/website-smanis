@extends('layouts.app')
@section('page','Notifikasi')
@section('content')

<div class="content-header mb-4">
    <h1><i class="bi bi-bell me-2"></i>Notifikasi</h1>
    <p>Lihat informasi dan pemberitahuan sistem</p>
</div>

<div class="card card-soft overflow-hidden">
    @forelse($items as $i)
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: flex-start; transition: all .2s ease; {{ !$i->status_baca ? 'background: #f0f9ff;' : '' }}">
            <div style="flex: 1;">
                <div style="display: flex; gap: 12px; align-items: flex-start;">
                    <i class="bi bi-info-circle" style="font-size: 20px; color: #0c4a6e; flex-shrink: 0; margin-top: 2px;"></i>
                    <div>
                        <strong style="display: block; color: var(--dark);">{{ $i->judul }}</strong>
                        <p style="margin: 4px 0 8px 0; font-size: 14px; color: var(--text-light);">{{ $i->pesan }}</p>
                        <small style="color: var(--text-light); font-size: 12px;">
                            <i class="bi bi-clock me-1"></i>{{ $i->created_at?->diffForHumans() }}
                        </small>
                    </div>
                </div>
            </div>

            <form method="post" action="{{ route('notifikasi.read', $i) }}" style="margin-left: 12px;">
                @csrf
                <button type="submit" class="btn btn-sm {{ $i->status_baca ? 'btn-light' : 'btn-primary' }}" title="{{ $i->status_baca ? 'Sudah dibaca' : 'Tandai sebagai dibaca' }}">
                    <i class="bi {{ $i->status_baca ? 'bi-check-all' : 'bi-check' }}"></i>
                </button>
            </form>
        </div>
    @empty
        <div style="padding: 60px 20px; text-align: center; color: var(--text-light);">
            <i class="bi bi-inbox" style="font-size: 48px; opacity: 0.3; display: block; margin-bottom: 16px;"></i>
            <p style="margin: 0; font-size: 16px;">Tidak ada notifikasi</p>
        </div>
    @endforelse
</div>

<div style="margin-top: 20px;">
    {{ $items->links() }}
</div>

@endsection