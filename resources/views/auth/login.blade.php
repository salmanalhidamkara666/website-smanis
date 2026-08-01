<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login E-Absensi QR</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(31, 94, 255, .10), transparent 34%),
                radial-gradient(circle at bottom right, rgba(239, 68, 68, .08), transparent 32%),
                linear-gradient(135deg, #eef4ff, #ffffff 46%, #fef2f2);
            font-family: 'Inter', system-ui, -apple-system, Segoe UI, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #132238;
        }

        .login-card {
            max-width: 430px;
            width: 100%;
            border: 1px solid rgba(232, 237, 245, .95);
            border-radius: 30px;
            box-shadow: 0 28px 80px rgba(31, 94, 255, .14);
            background: rgba(255, 255, 255, .96);
            backdrop-filter: blur(12px);
            overflow: hidden;
        }

        .login-card .card-body {
            padding: 42px 34px 32px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 34px;
        }

        .logo {
            width: 104px;
            height: 104px;
            display: grid;
            place-items: center;
            margin: 0 auto 16px;
            border-radius: 50%;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 14px 35px rgba(31, 94, 255, .12);
        }

        .logo img {
            width: 92%;
            height: 92%;
            object-fit: contain;
        }

        .school-name {
            text-align: center;
            font-size: 15px;
            font-weight: 800;
            color: #1f5eff;
            margin-bottom: 8px;
            letter-spacing: .3px;
            text-transform: uppercase;
        }

        .login-title {
            font-size: 28px;
            line-height: 1.15;
            font-weight: 800;
            color: #132238;
            margin-bottom: 8px;
        }

        .login-subtitle {
            font-size: 14px;
            color: #667085;
            margin-bottom: 0;
        }

        .form-area {
            margin-top: 8px;
        }

        .form-label {
            font-weight: 700;
            font-size: 14px;
            color: #132238;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 16px;
            padding: 13px 16px;
            border: 1.5px solid #e8edf5;
            font-size: 14px;
            font-weight: 500;
            color: #132238;
            transition: all .2s ease;
            background: #ffffff;
        }

        .form-control::placeholder {
            color: #98a2b3;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #1f5eff;
            box-shadow: 0 0 0 4px rgba(31, 94, 255, .10);
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1f5eff 0%, #1540cc 100%);
            border: none;
            border-radius: 16px;
            font-weight: 700;
            padding: 13px 20px;
            font-size: 15px;
            transition: all .2s ease;
            box-shadow: 0 10px 24px rgba(31, 94, 255, .22);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(31, 94, 255, .34);
            color: #fff;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .login-footer {
            margin-top: 28px;
            text-align: center;
            font-size: 12px;
            color: #98a2b3;
        }

        .alert {
            border: none;
            font-size: 14px;
            padding: 13px 16px;
            background: #fee2e2;
            color: #7f1d1d;
            margin-bottom: 18px;
        }

        /* Tampilan HP full layar */
        @media (max-width: 576px) {
            body {
                padding: 0;
                background: #ffffff;
                align-items: stretch;
                justify-content: flex-start;
            }

            .login-card {
                max-width: none;
                width: 100%;
                min-height: 100vh;
                border: none;
                border-radius: 0;
                box-shadow: none;
                display: flex;
                align-items: center;
                background: #ffffff;
            }

            .login-card .card-body {
                width: 100%;
                padding: 34px 24px 28px;
            }

            .login-header {
                margin-bottom: 36px;
            }

            .logo {
                width: 96px;
                height: 96px;
                margin-bottom: 16px;
                box-shadow: 0 12px 28px rgba(31, 94, 255, .10);
            }

            .school-name {
                font-size: 15px;
                margin-bottom: 8px;
            }

            .login-title {
                font-size: 27px;
            }

            .login-subtitle {
                font-size: 14px;
            }

            .form-control {
                height: 54px;
                font-size: 15px;
                border-radius: 16px;
            }

            .btn-primary {
                height: 54px;
                font-size: 15px;
                border-radius: 16px;
            }

            .login-footer {
                margin-top: 34px;
            }
        }
    </style>
</head>

<body>
    <div class="card login-card">
        <div class="card-body">
            <div class="login-header">
                <div class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </div>
                <h3 class="login-title">E-Absensi QR<br> SMA Negeri 1 Surade</h3>
            </div>
            <br>
            <br>
            <br>
            @if($errors->any())
                <div class="alert alert-danger rounded-4">{{ $errors->first() }}</div>
            @endif

            <form method="post" action="{{ route('login.process') }}" class="form-area">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Username/NIS/NIP/Email</label>
                    <input name="login" class="form-control" value="{{ old('login') }}" required autofocus placeholder="Masukkan username atau NIS">
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <div class="login-footer">
                Sistem Absensi Ekstrakurikuler Berbasis QR Code
            </div>
        </div>
    </div>
</body>

</html>