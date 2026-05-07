<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NODE SHOP - EXPERIENCES')</title>
    <!-- Fonts like Vertex -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #050505;
            --text-primary: #FFFFFF;
            --text-secondary: #888888;
            --accent: #E50914; /* Kept the red accent from previous design but in a subtle way */
        }
        * {
            margin: 0; padding: 0; box-sizing: border-box;
        }
        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }
        a { text-decoration: none; color: inherit; }
        
        /* Navbar */
        nav {
            position: fixed; width: 100%; top: 0; padding: 2rem 4rem;
            display: flex; justify-content: space-between; align-items: center;
            z-index: 100;
            mix-blend-mode: difference;
        }
        .logo { font-weight: 900; font-size: 1.5rem; letter-spacing: -1px; text-transform: uppercase; }
        .nav-links { display: flex; gap: 3rem; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }
        .nav-links a { position: relative; }
        .nav-links a::after {
            content: ''; position: absolute; width: 0; height: 1px; background: #fff;
            bottom: -5px; left: 0; transition: width 0.3s ease;
        }
        .nav-links a:hover::after { width: 100%; }

        /* General Utils */
        .container { max-width: 1400px; margin: 0 auto; padding: 0 4rem; }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-color); }
        ::-webkit-scrollbar-thumb { background: #333; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
    </style>
</head>
<body>
    <nav>
        <a href="{{ url('/') }}" class="logo">NODE<span style="color:var(--accent);">SHOP</span></a>
        <div class="nav-links">
            <a href="{{ route('products.index') }}">Projects</a>
            <a href="#">Categories</a>
            <a href="{{ route('cart.index') }}">Cart ({{ session('cart') ? count(session('cart')) : 0 }})</a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer style="padding: 8rem 4rem; background: #000; text-align: center;">
        <h2 style="font-size: 3.5rem; font-weight: 900; letter-spacing: -2px; margin-bottom: 2rem; color: #fff;">THE IMMERSIVE EXPERIENCE STUDIO</h2>
        <p style="font-size: 1.2rem; color: var(--text-secondary); max-width: 600px; margin: 0 auto 4rem; line-height: 1.6;">Strategic UX with Real-Time Data and Premium E-Commerce Performance.</p>
        <div style="font-size: 0.75rem; color: #444; text-transform: uppercase; letter-spacing: 2px;">
            &copy; {{ date('Y') }} NODE SHOP. ALL RIGHTS RESERVED.<br>INSPIRED BY VERTEX3D.ASIA
        </div>
    </footer>
</body>
</html>
