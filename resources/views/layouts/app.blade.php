<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Node Shop — Marketplace IoT terlengkap di Indonesia. Jual beli mikrokontroler, sensor, module IoT baru & preloved.')">

    <title>@yield('title', 'Node Shop') — Marketplace IoT Indonesia</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        :root {
            --primary: #6C5CE7;
            --primary-dark: #5A4BD1;
            --primary-light: #A29BFE;
            --secondary: #00CEC9;
            --accent: #FD79A8;
            --dark: #0A0A1A;
            --dark-card: #12122A;
            --dark-surface: #1A1A3E;
            --text-primary: #E8E8F0;
            --text-secondary: #9B9BC0;
            --success: #00B894;
            --warning: #FDCB6E;
            --danger: #FF6B6B;
            --gradient-primary: linear-gradient(135deg, #6C5CE7 0%, #A29BFE 100%);
            --gradient-accent: linear-gradient(135deg, #FD79A8 0%, #A29BFE 100%);
            --gradient-dark: linear-gradient(180deg, #0A0A1A 0%, #12122A 100%);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0;
            z-index: 1000;
            background: rgba(10, 10, 26, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(108, 92, 231, 0.15);
            padding: 0 2rem;
            height: 72px;
            display: flex; align-items: center; justify-content: space-between;
            transition: all 0.3s ease;
        }
        .navbar.scrolled {
            background: rgba(10, 10, 26, 0.95);
            box-shadow: 0 4px 30px rgba(108, 92, 231, 0.1);
        }
        .nav-brand {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
            font-size: 1.4rem; font-weight: 800;
            color: var(--text-primary);
        }
        .nav-brand span {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .nav-brand .node-icon {
            width: 36px; height: 36px;
            background: var(--gradient-primary);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            -webkit-text-fill-color: white;
        }
        .nav-links {
            display: flex; align-items: center; gap: 2rem;
            list-style: none;
        }
        .nav-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem; font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }
        .nav-links a:hover, .nav-links a.active {
            color: var(--primary-light);
        }
        .nav-links a.active::after {
            content: '';
            position: absolute; bottom: -4px; left: 0; right: 0;
            height: 2px;
            background: var(--gradient-primary);
            border-radius: 1px;
        }
        .nav-actions {
            display: flex; align-items: center; gap: 1rem;
        }
        .nav-search {
            position: relative;
        }
        .nav-search input {
            background: var(--dark-surface);
            border: 1px solid rgba(108, 92, 231, 0.2);
            border-radius: 12px;
            padding: 8px 16px 8px 38px;
            color: var(--text-primary);
            font-size: 0.85rem;
            width: 220px;
            outline: none;
            transition: all 0.3s;
        }
        .nav-search input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.1);
            width: 280px;
        }
        .nav-search i {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: var(--text-secondary); font-size: 0.85rem;
        }
        .nav-cart {
            position: relative;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 1.2rem;
            transition: color 0.3s;
        }
        .nav-cart:hover { color: var(--primary-light); }
        .nav-cart .badge {
            position: absolute; top: -8px; right: -10px;
            background: var(--accent);
            color: white; font-size: 0.65rem; font-weight: 700;
            width: 18px; height: 18px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 22px;
            border-radius: 12px;
            font-size: 0.85rem; font-weight: 600;
            text-decoration: none;
            border: none; cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4);
        }
        .btn-outline {
            background: transparent;
            color: var(--primary-light);
            border: 1.5px solid var(--primary);
        }
        .btn-outline:hover {
            background: rgba(108, 92, 231, 0.1);
        }
        .btn-sm {
            padding: 7px 16px;
            font-size: 0.8rem;
            border-radius: 10px;
        }
        .btn-secondary {
            background: var(--dark-surface);
            color: var(--text-primary);
            border: 1px solid rgba(108, 92, 231, 0.2);
        }
        .btn-secondary:hover {
            border-color: var(--primary);
            background: rgba(108, 92, 231, 0.1);
        }
        .btn-success {
            background: linear-gradient(135deg, #00B894, #00CEC9);
            color: white;
        }
        .btn-danger {
            background: linear-gradient(135deg, #FF6B6B, #EE5A24);
            color: white;
        }

        /* Main Content */
        .main-content {
            margin-top: 72px;
            min-height: calc(100vh - 72px);
        }

        /* Footer */
        .footer {
            background: var(--dark-card);
            border-top: 1px solid rgba(108, 92, 231, 0.1);
            padding: 3rem 2rem 1.5rem;
        }
        .footer-grid {
            max-width: 1200px; margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 2rem;
        }
        .footer-brand p {
            color: var(--text-secondary);
            font-size: 0.85rem; line-height: 1.7;
            margin-top: 0.8rem;
        }
        .footer-col h4 {
            font-size: 0.9rem; font-weight: 700;
            margin-bottom: 1rem;
            color: var(--primary-light);
        }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 0.5rem; }
        .footer-col ul a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.3s;
        }
        .footer-col ul a:hover { color: var(--primary-light); }
        .footer-bottom {
            max-width: 1200px; margin: 2rem auto 0;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(108, 92, 231, 0.1);
            display: flex; justify-content: space-between; align-items: center;
            font-size: 0.8rem; color: var(--text-secondary);
        }
        .social-links { display: flex; gap: 1rem; }
        .social-links a {
            color: var(--text-secondary);
            font-size: 1.1rem;
            transition: color 0.3s;
        }
        .social-links a:hover { color: var(--primary-light); }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Mobile Menu */
        .mobile-toggle {
            display: none;
            background: none; border: none;
            color: var(--text-primary);
            font-size: 1.4rem; cursor: pointer;
        }

        /* Dropdown */
        .dropdown { position: relative; }
        .dropdown-menu {
            position: absolute; top: calc(100% + 10px); right: 0;
            background: var(--dark-card);
            border: 1px solid rgba(108, 92, 231, 0.2);
            border-radius: 12px;
            padding: 8px;
            min-width: 180px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            display: none;
            z-index: 100;
        }
        .dropdown:hover .dropdown-menu { display: block; }
        .dropdown-menu a {
            display: block;
            padding: 8px 14px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.85rem;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .dropdown-menu a:hover {
            background: rgba(108, 92, 231, 0.1);
            color: var(--text-primary);
        }

        /* Alerts */
        .alert {
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            display: flex; align-items: center; gap: 10px;
        }
        .alert-success {
            background: rgba(0, 184, 148, 0.15);
            border: 1px solid rgba(0, 184, 148, 0.3);
            color: #00B894;
        }
        .alert-danger {
            background: rgba(255, 107, 107, 0.15);
            border: 1px solid rgba(255, 107, 107, 0.3);
            color: #FF6B6B;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .mobile-toggle { display: block; }
            .nav-links, .nav-search { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .container { padding: 0 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <a href="{{ url('/') }}" class="nav-brand">
            <div class="node-icon"><i class="fas fa-microchip"></i></div>
            <span>Node Shop</span>
        </a>

        <ul class="nav-links">
            <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Produk</a></li>
            <li><a href="{{ route('products.index', ['condition' => 'preloved']) }}" class="{{ request()->is('products*') && request('condition') == 'preloved' ? 'active' : '' }}">Preloved</a></li>
        </ul>

        <div class="nav-actions">
            <div class="nav-search">
                <i class="fas fa-search"></i>
                <form action="{{ route('products.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Cari produk IoT..." value="{{ request('search') }}">
                </form>
            </div>

            @auth
                <a href="{{ route('cart.index') }}" class="nav-cart" title="Keranjang">
                    <i class="fas fa-shopping-cart"></i>
                    @php $cartCount = auth()->user()->carts()->count(); @endphp
                    @if($cartCount > 0)
                        <span class="badge">{{ $cartCount }}</span>
                    @endif
                </a>

                <div class="dropdown">
                    <a href="#" class="btn btn-sm btn-secondary">
                        <i class="fas fa-user"></i> {{ Str::limit(auth()->user()->name, 12) }}
                    </a>
                    <div class="dropdown-menu">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                        @endif
                        <a href="{{ route('orders.index') }}"><i class="fas fa-box"></i> Pesanan Saya</a>
                        <a href="{{ route('profile.edit') }}"><i class="fas fa-cog"></i> Pengaturan</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </a>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Daftar</a>
            @endauth

            <button class="mobile-toggle" onclick="document.querySelector('.nav-links').classList.toggle('show')">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="container" style="padding-top: 1rem;">
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="container" style="padding-top: 1rem;">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ url('/') }}" class="nav-brand">
                    <div class="node-icon"><i class="fas fa-microchip"></i></div>
                    <span>Node Shop</span>
                </a>
                <p>Marketplace IoT terlengkap di Indonesia. Menyediakan mikrokontroler, sensor, module, dan komponen IoT dengan harga terjangkau untuk mahasiswa dan maker.</p>
            </div>
            <div class="footer-col">
                <h4>Produk</h4>
                <ul>
                    <li><a href="#">Mikrokontroler</a></li>
                    <li><a href="#">Sensor & Aktuator</a></li>
                    <li><a href="#">Module & Shield</a></li>
                    <li><a href="#">Starter Kit</a></li>
                    <li><a href="#">IoT Preloved</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Bantuan</h4>
                <ul>
                    <li><a href="#">Cara Belanja</a></li>
                    <li><a href="#">Pengiriman</a></li>
                    <li><a href="#">Pengembalian</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Kontak</h4>
                <ul>
                    <li><a href="#"><i class="fas fa-envelope"></i> hello@nodeshop.com</a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i> @nodeshop.id</a></li>
                    <li><a href="#"><i class="fab fa-tiktok"></i> @nodeshop</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Node Shop. Kelompok 2 — E-Bisnis.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-tiktok"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 50);
        });
    </script>
    @stack('scripts')
</body>
</html>
