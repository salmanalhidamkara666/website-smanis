<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','E-Absensi QR')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --blue: #1f5eff;
            --blue-dark: #1540cc;
            --green: #10b981;
            --red: #ef4444;
            --orange: #f97316;
            --dark: #132238;
            --soft: #f5f7fb;
            --border: #e8edf5;
            --text-light: #667085;
            --shadow-sm: 0 4px 12px rgba(15, 23, 42, .08);
            --shadow-md: 0 10px 30px rgba(15, 23, 42, .12);
            --shadow-lg: 0 20px 60px rgba(15, 23, 42, .15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Inter, system-ui, -apple-system, Segoe UI, sans-serif;
            background: linear-gradient(135deg, #f5f7fb 0%, #f9fafb 100%);
            color: #172033;
            line-height: 1.6;
        }

        .app {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: #fff;
            border-right: 1px solid var(--border);
            position: fixed;
            inset: 0 auto 0 0;
            padding: 22px;
            z-index: 20;
            overflow-y: auto;
            box-shadow: 2px 0 8px rgba(0, 0, 0, .04);
        }

        .brand {
            font-weight: 900;
            color: var(--dark);
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 28px;
            padding: 12px;
            border-radius: 12px;
            transition: all .3s ease;
        }

        .brand img {
            height: 50px;
            width: auto;
            border-radius: 8px;
            object-fit: contain;
        }

        .menu {
            margin-top: 8px;
        }

        .menu a {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 14px 16px;
            border-radius: 14px;
            color: var(--text-light);
            text-decoration: none;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all .2s ease;
            position: relative;
        }

        .menu a:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--blue);
            border-radius: 0 8px 8px 0;
            opacity: 0;
            transition: opacity .2s ease;
        }

        .menu a:hover {
            background: #f0f4ff;
            color: var(--blue);
            transform: translateX(4px);
        }

        .menu a:hover:before {
            opacity: 1;
        }

        .menu a.active {
            background: #eef4ff;
            color: var(--blue);
            font-weight: 700;
        }

        .menu a.active:before {
            opacity: 1;
        }

        .menu i {
            font-size: 18px;
            min-width: 24px;
        }

        .main {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: 74px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: var(--shadow-sm);
        }

        .topbar strong {
            font-size: 18px;
            color: var(--dark);
            font-weight: 700;
        }

        .topbar .text-muted {
            color: var(--text-light);
            font-size: 13px;
            margin-top: 4px;
        }

        .topbar form {
            display: flex;
            gap: 8px;
        }

        .topbar .btn {
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
        }

        .content {
            flex: 1;
            padding: 32px 28px;
            overflow-y: auto;
        }

        .content-header {
            margin-bottom: 28px;
        }

        .content-header h1 {
            font-size: 28px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .content-header p {
            color: var(--text-light);
            font-size: 14px;
        }

        .card-soft {
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            background: #fff;
            transition: all .3s ease;
            overflow: hidden;
        }

        .card-soft:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            border-color: #d1d5db;
        }

        .card-soft.gradient {
            background: linear-gradient(135deg, var(--blue) 0%, var(--blue-dark) 100%);
            border: none;
            color: #fff;
        }

        .card-soft.gradient h5,
        .card-soft.gradient strong {
            color: #fff;
        }

        .card-soft h5 {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-soft h5 i {
            font-size: 20px;
            color: var(--blue);
        }

        .stat {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            transition: all .3s ease;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            cursor: pointer;
            box-shadow: var(--shadow-md);
        }

        .stat:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--blue);
        }

        .stat.primary {
            background: linear-gradient(135deg, #1f5eff 0%, #1540cc 100%);
            border: none;
            color: #fff;
        }

        .stat.primary i {
            color: rgba(255, 255, 255, .9);
        }

        .stat.success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: #fff;
        }

        .stat.success i {
            color: rgba(255, 255, 255, .9);
        }

        .stat.warning {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            border: none;
            color: #fff;
        }

        .stat.warning i {
            color: rgba(255, 255, 255, .9);
        }

        .stat.danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            color: #fff;
        }

        .stat.danger i {
            color: rgba(255, 255, 255, .9);
        }

        .stat i {
            font-size: 32px;
            color: var(--blue);
            min-width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eef4ff;
            border-radius: 12px;
        }

        .stat.primary i,
        .stat.success i,
        .stat.warning i,
        .stat.danger i {
            background: rgba(255, 255, 255, .2);
        }

        .stat-content {
            flex: 1;
        }

        .stat-label {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            opacity: .8;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 800;
            line-height: 1;
        }

        .stat-desc {
            font-size: 12px;
            opacity: .7;
            margin-top: 4px;
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 10px 16px;
            font-size: 14px;
            transition: all .2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--blue) 0%, var(--blue-dark) 100%);
            color: #fff;
            box-shadow: 0 4px 12px rgba(31, 94, 255, .3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(31, 94, 255, .4);
            color: #fff;
        }

        .btn-outline-danger {
            border: 2px solid var(--red);
            color: var(--red);
            background: transparent;
        }

        .btn-outline-danger:hover {
            background: rgba(239, 68, 68, .1);
            color: var(--red);
        }

        .btn-light {
            background: #f3f4f6;
            color: var(--text-light);
        }

        .btn-light:hover {
            background: #e5e7eb;
            color: var(--dark);
        }

        .form-control,
        .form-select {
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 11px 14px;
            font-size: 14px;
            transition: all .2s ease;
            font-weight: 500;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(31, 94, 255, .1);
            outline: none;
        }

        .form-control::placeholder {
            color: #a3a3a3;
            font-weight: 500;
        }

        .table {
            vertical-align: middle;
            font-size: 14px;
        }

        .table thead {
            background: #f9fafb;
        }

        .table thead th {
            font-weight: 700;
            color: var(--dark);
            border-bottom: 2px solid var(--border);
            padding: 14px;
        }

        .table tbody tr {
            transition: all .2s ease;
            border-bottom: 1px solid var(--border);
        }

        .table tbody tr:hover {
            background: #fafbfc;
        }

        .table td {
            padding: 14px;
            color: #4b5563;
        }

        .badge-soft {
            background: #eef4ff;
            color: var(--blue);
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .badge-soft.success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-soft.warning {
            background: #fed7aa;
            color: #92400e;
        }

        .badge-soft.danger {
            background: #fee2e2;
            color: #7f1d1d;
        }

        .badge-soft.info {
            background: #dbeafe;
            color: #0c4a6e;
        }

        .modal-content {
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .15);
        }

        .modal-header {
            border-bottom: 1px solid var(--border);
            padding: 20px 24px;
            background: #fafbfc;
        }

        .modal-header h5 {
            font-weight: 700;
            color: var(--dark);
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            border-top: 1px solid var(--border);
            padding: 16px 24px;
            background: #fafbfc;
        }

        .alert {
            border: none;
            border-radius: 12px;
            padding: 14px 16px;
            font-weight: 500;
            animation: slideIn .3s ease;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid var(--green);
        }

        .alert-danger {
            background: #fee2e2;
            color: #7f1d1d;
            border-left: 4px solid var(--red);
        }

        .alert-warning {
            background: #fed7aa;
            color: #92400e;
            border-left: 4px solid var(--orange);
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
        }

        .table-responsive table {
            width: 100%;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                transform: translateX(-105%);
                transition: .3s ease;
                padding: 16px;
            }

            .sidebar.show {
                transform: none;
            }

            .brand {
                font-size: 16px;
            }

            .brand img {
                height: 40px;
            }

            .menu a {
                padding: 12px 14px;
                font-size: 13px;
            }

            .main {
                margin-left: 0;
            }

            .topbar {
                padding: 0 16px;
                height: 64px;
            }

            .topbar strong {
                font-size: 16px;
            }

            .topbar .text-muted {
                display: none;
            }

            .content {
                padding: 16px;
                padding-bottom: 80px;
            }

            .content-header h1 {
                font-size: 20px;
            }

            .content-header p {
                font-size: 12px;
            }

            .card-soft {
                border-radius: 14px;
            }

            .stat {
                padding: 16px;
                flex-direction: column;
                text-align: center;
            }

            .stat i {
                font-size: 28px;
            }

            .stat-value {
                font-size: 20px;
            }

            .table {
                font-size: 12px;
            }

            .table thead th,
            .table td {
                padding: 10px;
            }

            .bottom-nav {
                display: flex !important;
                width: 100%;
                background: #fff;
                border-top: 1px solid var(--border);
                height: 60px;
                justify-content: space-around;
                padding: 0;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 20;
                box-shadow: 0 -2px 8px rgba(0, 0, 0, .04);
            }

            .bottom-nav a {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 8px;
                text-align: center;
                font-size: 11px;
                color: var(--text-light);
                text-decoration: none;
                transition: .2s ease;
                gap: 4px;
                flex: 1;
            }

            .bottom-nav a.active {
                color: var(--blue);
                font-weight: 700;
            }

            .bottom-nav a i {
                font-size: 20px;
            }

            .hide-mobile {
                display: none !important;
            }
        }

        .qr-reader-wrapper {
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid var(--border);
            max-width: 520px;
            margin: 0 auto;
        }

        #reader {
            width: 100%;
        }

        #reader video {
            border-radius: 14px;
        }

        .scan-tip {
            background: #f0f4ff;
            border-radius: 12px;
            padding: 16px 20px;
            color: #0c4a6e;
            font-size: 14px;
        }

        .slide-in {
            animation: slideIn .3s ease;
        }

        .qr-reader-wrapper {
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid var(--border);
            max-width: 520px;
            margin: 0 auto;
        }

        #reader {
            width: 100%;
        }

        #reader video {
            border-radius: 14px;
        }

        .scan-tip {
            background: #f0f4ff;
            border-radius: 12px;
            padding: 16px 20px;
            color: #0c4a6e;
            font-size: 14px;
        }

        .badge-soft.info {
            background: #dbeafe;
            color: #0c4a6e;
        }
    </style>
</head>
<body>
    <div class="app">
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 50px; width: auto; border-radius: 8px;">
                <span>E-Absensi QR</span>
            </div>

            <nav class="menu">
                @php($role=session('role'))
                <a href="{{ route($role.'.dashboard') }}" class="{{ request()->is('*dashboard')?'active':'' }}">
                    <i class="bi bi-grid"></i>Dashboard
                </a>

                @if($role==='admin')
                    <a href="{{ route('siswa.index') }}">
                        <i class="bi bi-people"></i>Siswa
                    </a>
                    <a href="{{ route('pembina.index') }}">
                        <i class="bi bi-person-badge"></i>Pembina
                    </a>
                    <a href="{{ route('kelas.index') }}">
                        <i class="bi bi-building"></i>Kelas
                    </a>
                    <a href="{{ route('ekskul.index') }}">
                        <i class="bi bi-stars"></i>Ekstrakurikuler
                    </a>
                    <a href="{{ route('anggota.index') }}">
                        <i class="bi bi-person-check"></i>Anggota
                    </a>
                    <a href="{{ route('jadwal.index') }}">
                        <i class="bi bi-calendar-week"></i>Jadwal
                    </a>
                    <a href="{{ route('settings.index') }}">
                        <i class="bi bi-gear"></i>Pengaturan
                    </a>
                @endif

                @if(in_array($role,['admin','pembina']))
                    <a href="{{ route('sesi.index') }}">
                        <i class="bi bi-calendar2-check"></i>Sesi Absensi
                    </a>
                @endif

                @if($role==='siswa')
                    <a href="{{ route('qr.scan') }}">
                        <i class="bi bi-camera"></i>Scan QR
                    </a>
                @endif

                <a href="{{ route('izin.index') }}">
                    <i class="bi bi-file-earmark-text"></i>Izin/Sakit
                </a>

                @if(in_array($role,['admin','pembina','wali']))
                    <a href="{{ route('laporan.index') }}">
                        <i class="bi bi-bar-chart"></i>Laporan
                    </a>
                @endif

                <a href="{{ route('notifikasi.index') }}" class="{{ request()->routeIs('notifikasi.index') ? 'active' : '' }}">
                    <i class="bi bi-bell"></i>Notifikasi
                </a>
            </nav>
        </aside>

        <main class="main">
            <div class="topbar">
                <button class="btn btn-light d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list"></i>
                </button>

                <div>
                    <strong>@yield('page','Dashboard')</strong>
                    <div class="text-muted small">Sistem absensi ekstrakurikuler berbasis QR Code</div>
                </div>

                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>

            <div class="content">
                @if(session('success'))
                    <div class="alert alert-success rounded-4">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger rounded-4">{{ $errors->first() }}</div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <div class="bottom-nav">
        <a href="{{ route(session('role').'.dashboard') }}">
            <i class="bi bi-grid"></i>Home
        </a>

        @if(session('role')==='siswa')
            <a href="{{ route('qr.scan') }}">
                <i class="bi bi-camera"></i>Scan
            </a>
        @endif

        <a href="{{ route('izin.index') }}">
            <i class="bi bi-file-text"></i>Izin
        </a>
        <a href="{{ route('notifikasi.index') }}">
            <i class="bi bi-bell"></i>Info
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
