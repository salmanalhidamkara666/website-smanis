@extends('layouts.app') @section('page', 'Scan QR Code') @section('content')<div class="content-header mb-4">
    <h1><i class="bi bi-qr-code-scan me-2"></i>Scan Absensi QR Code</h1>
    <p>Arahkan kamera ke QR Code yang ditampilkan pembina untuk melakukan absensi</p>
</div>

<div class="row g-4">
    <div class="col-lg-8 mx-auto">
        <div class="card card-soft p-4">
            <div id="result" class="alert alert-success mb-4 d-none slide-in"></div>

            <div class="text-center mb-4">
                <p style="color: var(--text-light); font-size: 14px;">
                    <i class="bi bi-info-circle me-2"></i>
                    Pastikan cahaya cukup dan QR Code terlihat dengan jelas
                </p>
            </div>

            <div class="qr-reader-wrapper">
                <div id="reader"></div>
            </div>

            <div class="scan-tip mt-4">
                <i class="bi bi-lightbulb me-2"></i>
                <strong>Tips:</strong> Posisikan QR Code di tengah layar untuk hasil scanning yang lebih baik
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
const box = document.getElementById('result');

function show(msg, ok) {
    box.className = 'alert mb-3 ' + (ok ? 'alert-success' : 'alert-danger');
    box.textContent = msg;
    box.classList.remove('d-none');
    box.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

const scanner = new Html5QrcodeScanner('reader', {
    fps: 10,
    qrbox: { width: 250, height: 250 }
});

scanner.render(decoded => {
    fetch('{{ route('qr.validate') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
        },
        body: JSON.stringify({ token: decoded })
    })
    .then(r => r.json().then(j => ({ status: r.status, json: j })))
    .then(({ json }) => show(json.message, json.ok))
    .catch(() => show('Gagal menghubungi server.', false));
});
</script>
@endpush