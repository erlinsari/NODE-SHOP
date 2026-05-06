<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NODE SHOP') }} — Auth</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg: #f5f5f5; --fg: #0a0a0a; --card: #ffffff;
            --muted: #f0f0f0; --muted-fg: #6b6b6b;
            --border: rgba(0,0,0,0.12); --input-bg: #fafafa;
            --radius: 2px;
        }
        html.dark {
            --bg: #000000; --fg: #f5f5f5; --card: #0a0a0a;
            --muted: #1a1a1a; --muted-fg: #a0a0a0;
            --border: rgba(255,255,255,0.1); --input-bg: rgba(255,255,255,0.05);
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif; background: var(--bg); color: var(--fg);
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            -webkit-font-smoothing: antialiased; padding: 1rem;
        }
        a { text-decoration: none; color: inherit; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .auth-container {
            width: 100%; max-width: 440px;
        }
        .auth-brand {
            display: flex; align-items: center; gap: 0.5rem; justify-content: center;
            margin-bottom: 2rem;
        }
        .auth-brand-icon {
            width: 40px; height: 40px; background: #FF0000; border-radius: 2px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 900; font-size: 1.3rem;
        }
        .auth-brand-text {
            font-weight: 900; font-size: 1.5rem; letter-spacing: -0.5px;
            text-transform: uppercase;
        }
        .auth-brand-text span { color: #FF0000; }
        .auth-card {
            background: var(--card); border: 2px solid var(--border);
            border-radius: 2px; padding: 2rem;
        }
        .form-input {
            width: 100%; padding: 0.75rem 1rem; background: var(--input-bg);
            border: 1px solid var(--border); border-radius: 2px;
            color: var(--fg); font-family: 'JetBrains Mono'; font-size: 0.9rem;
            outline: none; transition: border-color 0.2s;
        }
        .form-input:focus { border-color: #FF0000; }
        .form-input::placeholder { color: var(--muted-fg); }
        .form-label {
            display: block; font-family: 'JetBrains Mono'; font-size: 0.8rem;
            margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;
            font-weight: 500;
        }
        .btn-primary {
            display: flex; align-items: center; justify-content: center;
            width: 100%; padding: 0.75rem 1.5rem; background: #FF0000;
            color: #fff; border: none; border-radius: 2px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer;
            font-family: 'Inter'; font-size: 0.9rem; transition: background 0.2s;
        }
        .btn-primary:hover { background: #cc0000; }
        .error-text { color: #FF0000; font-size: 0.75rem; font-family: 'JetBrains Mono'; margin-top: 0.25rem; }
        .form-input-icon { position: relative; }
        .form-input-icon .icon {
            position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%);
            color: var(--muted-fg); font-size: 0.9rem;
        }
        .form-input-icon .form-input { padding-left: 2.5rem; }
    </style>
</head>
<body>
    <div class="auth-container">
        <a href="{{ url('/') }}" class="auth-brand">
            <div class="auth-brand-icon">N</div>
            <span class="auth-brand-text">NODE<span>SHOP</span></span>
        </a>

        <div class="auth-card">
            {{ $slot }}
        </div>

        <p class="font-mono" style="text-align:center; margin-top:1.5rem; font-size:0.75rem; color:var(--muted-fg);">
            &copy; {{ date('Y') }} NODE SHOP. All rights reserved.
        </p>
    </div>

    <script>
        const savedTheme = localStorage.getItem('node-shop-theme');
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</body>
</html>
