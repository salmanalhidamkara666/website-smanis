@extends('layouts.app')

@section('page','Generate QR Code')

@section('content')<div class="content-header mb-4">
    <h1><i class="bi bi-qr-code me-2"></i>Generate QR Code</h1>
    <p>Tampilkan QR Code di bawah ini untuk sesi absensi</p>
</div>

<div class="card card-soft p-4 mb-3">
    <h4>{{ $sesi->ekstrakurikuler->nama }}</h4>
    <div class="text-muted">{{ $sesi->tanggal->format('d/m/Y') }} | {{ $sesi->jam_mulai }} - {{ $sesi->jam_selesai }}</div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-soft p-4 text-center qr-box">
            <h5><i class="bi bi-box-arrow-in-right me-2"></i>QR Masuk</h5>
            <div id="qrcode-masuk" class="d-flex justify-content-center"></div>
            <p class="small text-muted mt-3">Berlaku sampai {{ $qrMasuk->expired_at->format('H:i:s') }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-soft p-4 text-center qr-box">
            <h5><i class="bi bi-box-arrow-right me-2"></i>QR Keluar</h5>
            <div id="qrcode-keluar" class="d-flex justify-content-center"></div>
            <p class="small text-muted mt-3">Berlaku sampai {{ $qrKeluar->expired_at->format('H:i:s') }}</p>
        </div>
    </div>
</div>

<div style="margin-top: 24px;">
    <a href="{{ route('qr.generate',$sesi) }}" class="btn btn-primary"><i class="bi bi-arrow-clockwise me-2"></i>Refresh QR Code</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    new QRCode(document.getElementById('qrcode-masuk'), {
        text: @json($qrMasuk->token),
        width: 280,
        height: 280
    });

    new QRCode(document.getElementById('qrcode-keluar'), {
        text: @json($qrKeluar->token),
        width: 280,
        height: 280
    });
</script>
@endsection
