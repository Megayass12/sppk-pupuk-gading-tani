<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SPK Supplier Pupuk - UD. Gading Tani</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-start: #0b3d2f;
            --bg-end: #1d7a4d;
            --surface: rgba(255,255,255,0.92);
            --surface-strong: #ffffff;
            --primary: #2d6a4f;
            --primary-soft: #d8f3dc;
            --text-dark: #10321f;
            --text-muted: #5f6b62;
            --shadow: 0 24px 60px rgba(15, 49, 31, 0.16);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--text-dark);
            background: radial-gradient(circle at top left, rgba(255,255,255,0.12), transparent 18%),
                        radial-gradient(circle at bottom right, rgba(255,255,255,0.08), transparent 15%),
                        linear-gradient(135deg, var(--bg-start), var(--bg-end));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-shell {
            width: 100%;
            max-width: 960px;
            border-radius: 32px;
            overflow: hidden;
            box-shadow: var(--shadow);
            display: grid;
            grid-template-columns: 1.15fr 1fr;
            min-height: 560px;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255,255,255,0.16);
        }

        .login-panel {
            padding: 48px 42px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 28px;
            background: linear-gradient(180deg, rgba(255,255,255,0.16), rgba(255,255,255,0.06));
        }

        .brand-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 12px 18px;
            border-radius: 999px;
            background: rgba(255,255,255,0.22);
            color: #f7faf6;
            font-size: 0.96rem;
            font-weight: 600;
            width: fit-content;
        }

        .brand-chip i {
            color: var(--primary-soft);
        }

        .login-title {
            font-size: clamp(2rem, 2.5vw, 3rem);
            line-height: 1.04;
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            letter-spacing: -0.05em;
        }

        .login-caption {
            max-width: 420px;
            color: rgba(255,255,255,0.92);
            font-size: 1rem;
            line-height: 1.8;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 14px;
        }

        .feature-list li {
            display: flex;
            align-items: center;
            gap: 14px;
            color: rgba(255,255,255,0.88);
            font-size: 0.98rem;
        }

        .feature-list li .icon {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: rgba(255,255,255,0.12);
            color: #ffffff;
        }

        .login-box {
            padding: 40px 36px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--surface-strong);
            border-left: 1px solid rgba(16,50,31,0.06);
        }

        .login-box h2 {
            margin-bottom: 16px;
            font-size: 1.85rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .login-box p {
            margin: 0 0 32px;
            color: var(--text-muted);
            font-size: 0.98rem;
            line-height: 1.7;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .form-control {
            height: 52px;
            border-radius: 16px;
            border: 1px solid #dce7dd;
            box-shadow: inset 0 1px 2px rgba(16,50,31,0.04);
            background: #fbfdf8;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 5px rgba(45,106,79,0.08);
        }

        .submit-btn {
            width: 100%;
            height: 54px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), var(--bg-end));
            border: none;
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            box-shadow: 0 18px 30px rgba(45,106,79,0.18);
            transition: transform 0.25s ease, filter 0.25s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.05);
        }

        .login-box small {
            display: block;
            margin-top: 18px;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .error-messages {
            background: #fff3f2;
            border: 1px solid #f8c2bf;
            color: #9f2a2e;
            border-radius: 14px;
            padding: 16px;
            margin-bottom: 20px;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .error-messages ul {
            margin: 0;
            padding-left: 18px;
        }

        @media (max-width: 900px) {
            .login-shell {
                grid-template-columns: 1fr;
                min-height: auto;
            }
            .login-card,
            .login-panel,
            .login-box {
                padding: 32px;
            }
            .login-panel {
                padding-bottom: 24px;
            }
        }

        @media (max-width: 640px) {
            body {
                padding: 16px;
            }
            .login-shell {
                border-radius: 24px;
            }
            .login-panel,
            .login-box {
                padding: 28px 20px;
            }
            .login-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-shell">
        <section class="login-panel">
            <span class="brand-chip">
                <i class="fas fa-seedling"></i>
                SPK Supplier Pupuk
            </span>

            <h1 class="login-title">Selamat datang kembali</h1>
            <p class="login-caption">Masuk untuk melihat rekomendasi supplier terbaik dan nilai analisis yang akurat untuk UD. Gading Tani.</p>

            <ul class="feature-list">
                <li><span class="icon"><i class="fas fa-check"></i></span> Dashboard ringkas untuk kinerja supplier</li>
                <li><span class="icon"><i class="fas fa-chart-line"></i></span> Filter dan evaluasi cepat dengan tampilan modern</li>
                <li><span class="icon"><i class="fas fa-lock"></i></span> Login aman dalam satu langkah</li>
            </ul>
        </section>

        <section class="login-box">
            <h2>Masuk ke akun Anda</h2>
            <p>Gunakan kredensial yang benar untuk mengakses data supplier dan rekomendasi.</p>

            @if ($errors->any())
                <div class="error-messages">
                    @if ($errors->has('login_error'))
                        <p>{{ $errors->first('login_error') }}</p>
                    @else
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif

            <form action="{{ route('auth.login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-control"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username"
                        required
                        autofocus>
                    @error('username')
                        <div class="text-danger mt-2 small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required>
                    @error('password')
                        <div class="text-danger mt-2 small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>

            <small>Belum punya akun? Hubungi administrator untuk akses.</small>
        </section>
    </div>
</body>
</html>
