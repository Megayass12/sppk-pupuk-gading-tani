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
            --hijau: #2d6a4f;
            --hijau-muda: #52b788;
            --hijau-terang: #d8f3dc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--hijau) 0%, var(--hijau-muda) 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        .login-header h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-header p {
            font-size: 14px;
            opacity: 0.95;
            font-weight: 500;
        }

        .login-card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .login-card h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--hijau);
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--hijau);
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--hijau);
            box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.1);
        }

        .form-group input::placeholder {
            color: #bbb;
        }

        .error-messages {
            background-color: #fff5f5;
            border: 1px solid #feb2b2;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            color: #c53030;
            font-size: 13px;
        }

        .error-messages p,
        .error-messages li {
            margin: 4px 0;
        }

        .error-messages ul {
            padding-left: 20px;
            margin: 0;
        }

        .error-text {
            color: #c53030;
            font-size: 12px;
            margin-top: 4px;
            display: none;
        }

        .form-group input:invalid:not(:placeholder-shown) ~ .error-text {
            display: block;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--hijau) 0%, var(--hijau-muda) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(45, 106, 79, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <h1>SPK Supplier Pupuk</h1>
            <p>UD. Gading Tani</p>
        </div>

        <!-- Login Card -->
        <div class="login-card">
            <h2>Login</h2>

            <!-- Error Messages -->
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

            <!-- Login Form -->
            <form action="{{ route('auth.login') }}" method="POST">
                @csrf

                <!-- Username Field -->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username"
                        required
                        autofocus
                    >
                    @error('username')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >
                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>

            <!-- Footer Info -->
            <div class="login-footer">
                <p>Belum punya akun? Hubungi administrator</p>
            </div>
        </div>
    </div>
</body>
</html>
