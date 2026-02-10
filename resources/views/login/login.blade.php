<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #f5f7fa, #e4e7eb);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #fff;
            width: 100%;
            max-width: 380px;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        .login-card h2 {
            margin-bottom: 6px;
            font-weight: 600;
            color: #111827;
        }

        .login-card p {
            margin-bottom: 24px;
            color: #6b7280;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-size: 13px;
            color: #374151;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99,102,241,.2);
        }

        .error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: none;
            border-radius: 8px;
            background: #6366f1;
            color: #fff;
            font-weight: 500;
            cursor: pointer;
            transition: .2s;
        }

        button:hover {
            background: #4f46e5;
        }

        .footer-text {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h2>Welcome Back</h2>
    <p>Please login to continue</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Login</button>
    </form>

    <div class="footer-text">
        © {{ date('Y') }} <a href="https://github.com/sulistiyas">Sulistiya Nugroho</a> EduNest. All rights reserved.
    </div>
</div>

</body>
</html>
