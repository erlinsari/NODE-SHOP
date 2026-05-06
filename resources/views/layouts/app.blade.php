<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NODE SHOP — Premium IoT Hardware')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <style>
        /* ═══════════════════════════════════════
           DESIGN SYSTEM — NODE SHOP
           E-commerce Website Design Theme
        ═══════════════════════════════════════ */

        :root {
            --bg: #f5f5f5;
            --fg: #0a0a0a;
            --card: #ffffff;
            --card-fg: #0a0a0a;
            --primary: #FF0000;
            --primary-hover: #cc0000;
            --primary-active: #990000;
            --primary-fg: #ffffff;
            --secondary: #e0e0e0;
            --secondary-fg: #0a0a0a;
            --muted: #f0f0f0;
            --muted-fg: #6b6b6b;
            --accent: #e8e8e8;
            --border: rgba(0, 0, 0, 0.12);
            --input-bg: #fafafa;
            --success: #16a34a;
            --warning: #ca8a04;
            --danger: #FF0000;
            --radius: 2px;
        }

        html.dark {
            --bg: #000000;
            --fg: #f5f5f5;
            --card: #0a0a0a;
            --card-fg: #f5f5f5;
            --secondary: #1a1a1a;
            --secondary-fg: #f5f5f5;
            --muted: #1a1a1a;
            --muted-fg: #a0a0a0;
            --accent: #1a1a1a;
            --border: rgba(255, 255, 255, 0.1);
            --input-bg: rgba(255,255,255,0.05);
            --success: #22c55e;
            --warning: #eab308;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg);
            color: var(--fg);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            transition: background 0.3s, color 0.3s;
        }

        a { text-decoration: none; color: inherit; }

        .font-mono { font-family: 'JetBrains Mono', monospace; }

        .container { max-width: 1280px; margin: 0 auto; padding: 0 1rem; }
        @media(min-width: 1024px) { .container { padding: 0 2rem; } }

        /* ── Preloader ── */
        .preloader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100vh;
            background: #000; z-index: 10000;
            display: flex; justify-content: center; align-items: center;
            flex-direction: column; gap: 1.5rem;
        }
        .preloader .loader-logo {
            font-family: 'Inter'; font-weight: 900; font-size: 2rem;
            text-transform: uppercase; color: #fff; letter-spacing: -1px;
        }
        .preloader .loader-logo span { color: #FF0000; }
        .preloader .loader-bar-track {
            width: 200px; height: 2px; background: #222; overflow: hidden;
        }
        .preloader .loader-bar {
            width: 0%; height: 100%; background: #FF0000;
            transition: width 0.1s linear;
        }
        .preloader .loader-percent {
            font-family: 'JetBrains Mono'; font-size: 3rem; font-weight: 700;
            color: #fff; letter-spacing: -2px;
        }

        /* ── Navbar ── */
        .navbar {
            position: sticky; top: 0; z-index: 1000; width: 100%;
            border-bottom: 1px solid var(--border);
            background: color-mix(in srgb, var(--bg) 80%, transparent);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .navbar-inner {
            display: flex; height: 64px; align-items: center; justify-content: space-between;
        }
        .nav-brand {
            display: flex; align-items: center; gap: 0.5rem;
            text-decoration: none;
        }
        .nav-brand-icon {
            width: 32px; height: 32px; background: #FF0000;
            border-radius: var(--radius);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 900; font-size: 1.1rem;
        }
        .nav-brand-text {
            font-weight: 900; font-size: 1.25rem; letter-spacing: -0.5px;
            text-transform: uppercase;
        }
        .nav-brand-text span { color: #FF0000; }
        .nav-links {
            display: none; align-items: center; gap: 1.5rem;
        }
        @media(min-width: 768px) { .nav-links { display: flex; } }
        .nav-link {
            font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;
            font-weight: 500; position: relative; background: none; border: none;
            color: var(--fg); cursor: pointer; padding: 0;
            font-family: 'Inter'; transition: color 0.2s;
        }
        .nav-link::after {
            content: ''; position: absolute; bottom: -4px; left: 0;
            width: 0; height: 2px; background: #FF0000;
            transition: width 0.3s ease;
        }
        .nav-link:hover { color: #FF0000; }
        .nav-link:hover::after { width: 100%; }
        .nav-actions {
            display: flex; align-items: center; gap: 0.75rem;
        }
        .nav-icon-btn {
            position: relative; padding: 0.5rem;
            border-radius: var(--radius); border: 1px solid var(--border);
            background: transparent; color: var(--fg); cursor: pointer;
            transition: all 0.2s; display: flex; align-items: center;
            justify-content: center;
        }
        .nav-icon-btn:hover { border-color: #FF0000; }
        .nav-icon-btn .cart-badge {
            position: absolute; top: -4px; right: -4px;
            background: #FF0000; color: #fff; font-size: 0.65rem;
            font-family: 'JetBrains Mono'; width: 18px; height: 18px;
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-weight: 700;
        }
        /* Mobile menu button */
        .nav-mobile-btn {
            display: flex; padding: 0.5rem; border: 1px solid var(--border);
            border-radius: var(--radius); background: transparent;
            color: var(--fg); cursor: pointer;
        }
        @media(min-width: 768px) { .nav-mobile-btn { display: none; } }

        /* Mobile menu */
        .mobile-menu {
            display: none; border-top: 1px solid var(--border); padding: 1rem 0;
        }
        .mobile-menu.active { display: block; }
        .mobile-menu a, .mobile-menu button {
            display: block; width: 100%; text-align: left; padding: 0.5rem 0;
            font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;
            font-weight: 500; background: none; border: none; color: var(--fg);
            cursor: pointer; font-family: 'Inter'; transition: color 0.2s;
        }
        .mobile-menu a:hover, .mobile-menu button:hover { color: #FF0000; }
        @media(min-width: 768px) { .mobile-menu { display: none !important; } }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            transition: all 0.2s; text-transform: uppercase; letter-spacing: 0.05em;
            font-weight: 600; font-family: 'Inter'; border: none; cursor: pointer;
            border-radius: var(--radius); font-size: 0.85rem; gap: 0.5rem;
            line-height: 1;
        }
        .btn:disabled { opacity: 0.5; cursor: not-allowed; }
        .btn-primary {
            background: #FF0000; color: #fff; padding: 0.75rem 1.5rem;
        }
        .btn-primary:hover:not(:disabled) { background: #cc0000; }
        .btn-primary:active:not(:disabled) { background: #990000; }
        .btn-sm { padding: 0.5rem 1rem; font-size: 0.75rem; }
        .btn-lg { padding: 1rem 2rem; font-size: 0.95rem; }
        .btn-outline {
            background: transparent; color: var(--fg);
            border: 2px solid var(--fg); padding: calc(0.75rem - 2px) calc(1.5rem - 2px);
        }
        .btn-outline:hover:not(:disabled) { background: var(--fg); color: var(--bg); }
        .btn-ghost {
            background: transparent; color: var(--fg); padding: 0.75rem 1.5rem;
        }
        .btn-ghost:hover { background: var(--accent); }
        .btn-block { width: 100%; }

        /* ── Cards ── */
        .card {
            background: var(--card); color: var(--card-fg);
            border: 1px solid var(--border); border-radius: var(--radius);
            transition: all 0.3s;
        }
        .card-hover:hover {
            border-color: #FF0000;
            box-shadow: 0 8px 24px rgba(255, 0, 0, 0.1);
        }
        .card-header {
            padding: 1.5rem; border-bottom: 1px solid var(--border);
        }
        .card-body { padding: 1.5rem; }
        .card-footer {
            padding: 1.5rem; border-top: 1px solid var(--border);
        }
        .card-2x { border-width: 2px; }
        .card-2x .card-header { border-bottom-width: 2px; }
        .card-2x .card-footer { border-top-width: 2px; }

        /* ── Badges ── */
        .badge {
            display: inline-flex; align-items: center; padding: 0.15rem 0.6rem;
            border-radius: var(--radius); font-size: 0.7rem;
            font-family: 'JetBrains Mono'; text-transform: uppercase;
            letter-spacing: 0.05em; font-weight: 600; border: 1px solid transparent;
        }
        .badge-primary { background: #FF0000; color: #fff; border-color: #FF0000; }
        .badge-secondary { background: var(--secondary); color: var(--secondary-fg); border-color: var(--secondary); }
        .badge-success { background: var(--success); color: #fff; border-color: var(--success); }
        .badge-warning { background: var(--warning); color: #fff; border-color: var(--warning); }
        .badge-danger { background: #FF0000; color: #fff; border-color: #FF0000; }
        .badge-outline { background: transparent; border-color: var(--border); color: var(--fg); }

        /* ── Form Inputs ── */
        .form-input {
            width: 100%; padding: 0.75rem 1rem;
            background: var(--input-bg); border: 1px solid var(--border);
            border-radius: var(--radius); color: var(--fg);
            font-family: 'JetBrains Mono'; font-size: 0.9rem;
            outline: none; transition: border-color 0.2s;
        }
        .form-input:focus { border-color: #FF0000; }
        .form-input::placeholder { color: var(--muted-fg); }
        .form-label {
            display: block; font-family: 'JetBrains Mono'; font-size: 0.8rem;
            margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;
            font-weight: 500;
        }
        .form-input-icon {
            position: relative;
        }
        .form-input-icon .icon {
            position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%);
            color: var(--muted-fg); font-size: 0.9rem;
        }
        .form-input-icon .form-input { padding-left: 2.5rem; }

        /* ── Utilities ── */
        .text-primary { color: #FF0000; }
        .text-muted { color: var(--muted-fg); }
        .text-success { color: var(--success); }
        .text-warning { color: var(--warning); }
        .text-danger { color: #FF0000; }
        .font-black { font-weight: 900; }
        .font-bold { font-weight: 700; }
        .uppercase { text-transform: uppercase; }
        .line-through { text-decoration: line-through; }
        .line-clamp-2 {
            display: -webkit-box; -webkit-line-clamp: 2;
            -webkit-box-orient: vertical; overflow: hidden;
        }

        /* ── Theme Toggle ── */
        .theme-toggle {
            padding: 0.5rem; border-radius: var(--radius);
            border: 1px solid var(--border); background: transparent;
            color: var(--fg); cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center;
        }
        .theme-toggle:hover { border-color: #FF0000; }
        html.dark .theme-icon-sun { display: inline; }
        html.dark .theme-icon-moon { display: none; }
        html:not(.dark) .theme-icon-sun { display: none; }
        html:not(.dark) .theme-icon-moon { display: inline; }

        /* ── Footer ── */
        .site-footer {
            border-top: 1px solid var(--border); margin-top: 5rem;
        }
        .footer-grid {
            display: grid; grid-template-columns: 1fr; gap: 2rem;
            padding: 3rem 0;
        }
        @media(min-width: 768px) {
            .footer-grid { grid-template-columns: repeat(4, 1fr); }
        }
        .footer-title {
            font-weight: 900; text-transform: uppercase; margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 0.5rem; }
        .footer-links a {
            font-family: 'JetBrains Mono'; font-size: 0.85rem;
            color: var(--muted-fg); transition: color 0.2s;
        }
        .footer-links a:hover { color: #FF0000; }
        .footer-bottom {
            border-top: 1px solid var(--border); padding: 2rem 0;
            text-align: center; font-family: 'JetBrains Mono';
            font-size: 0.8rem; color: var(--muted-fg);
        }

        /* ── Animations ── */
        .reveal { opacity: 0; transform: translateY(40px); }
        .reveal.active { opacity: 1; transform: translateY(0); transition: all 0.8s cubic-bezier(0.22, 1, 0.36, 1); }

        /* Alert/Toast */
        .alert {
            padding: 1rem 1.5rem; border-radius: var(--radius);
            margin-bottom: 1rem; font-size: 0.85rem; border-left: 3px solid;
        }
        .alert-success { background: rgba(22,163,74,0.1); border-left-color: var(--success); color: var(--success); }
        .alert-danger { background: rgba(255,0,0,0.1); border-left-color: #FF0000; color: #FF0000; }

        /* ── Pagination ── */
        nav[role="navigation"] { display:flex; flex-direction:column; align-items:center; gap:1rem; }
        nav[role="navigation"] .hidden { display:none; }
        nav[role="navigation"] > div:first-child { display:none; }
        nav[role="navigation"] > div:last-child { width:100%; }
        nav[role="navigation"] > div:last-child > div:first-child { display:none; }
        nav[role="navigation"] span[aria-current="page"] span,
        nav[role="navigation"] a {
            display:inline-flex; align-items:center; justify-content:center;
            min-width:2.5rem; height:2.5rem; padding:0 0.75rem;
            font-family:'JetBrains Mono'; font-size:0.85rem; font-weight:600;
            border:2px solid var(--border); border-radius:var(--radius);
            transition:all 0.2s; text-decoration:none; color:var(--fg);
        }
        nav[role="navigation"] span[aria-current="page"] span {
            background:#FF0000; color:#fff; border-color:#FF0000;
        }
        nav[role="navigation"] a:hover {
            border-color:#FF0000; color:#FF0000;
        }
        nav[role="navigation"] span[aria-disabled="true"] span {
            display:inline-flex; align-items:center; justify-content:center;
            min-width:2.5rem; height:2.5rem; padding:0 0.75rem;
            font-family:'JetBrains Mono'; font-size:0.85rem;
            border:2px solid var(--border); border-radius:var(--radius);
            color:var(--muted-fg); opacity:0.5; cursor:not-allowed;
        }
        nav[role="navigation"] > div:last-child > div:last-child {
            display:flex; align-items:center; justify-content:center; gap:0.25rem; flex-wrap:wrap;
        }
        /* Hide the "Showing X to Y of Z" text */
        nav[role="navigation"] p { font-family:'JetBrains Mono'; font-size:0.8rem; color:var(--muted-fg); }

        /* Also handle simple pagination */
        .pagination { display:flex; align-items:center; justify-content:center; gap:0.25rem; list-style:none; }
        .pagination li a, .pagination li span {
            display:inline-flex; align-items:center; justify-content:center;
            min-width:2.5rem; height:2.5rem; padding:0 0.75rem;
            font-family:'JetBrains Mono'; font-size:0.85rem; font-weight:600;
            border:2px solid var(--border); border-radius:var(--radius);
            transition:all 0.2s; text-decoration:none; color:var(--fg);
        }
        .pagination li.active span { background:#FF0000; color:#fff; border-color:#FF0000; }
        .pagination li a:hover { border-color:#FF0000; color:#FF0000; }
        .pagination li.disabled span { opacity:0.5; cursor:not-allowed; }

        /* Override SVG icons in pagination to be smaller */
        nav[role="navigation"] svg {
            width:1rem; height:1rem;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="loader-logo">NODE<span>SHOP</span></div>
        <div class="loader-bar-track"><div class="loader-bar" id="loader-bar"></div></div>
        <div class="loader-percent" id="loader-percent">0%</div>
    </div>

    <!-- Navbar -->
    <header class="navbar">
        <div class="container">
            <div class="navbar-inner">
                <div style="display:flex; align-items:center; gap:2rem;">
                    <a href="{{ url('/') }}" class="nav-brand">
                        <div class="nav-brand-icon">N</div>
                        <span class="nav-brand-text">NODE<span>SHOP</span></span>
                    </a>
                    <nav class="nav-links">
                        <a href="{{ url('/') }}" class="nav-link">Home</a>
                        <a href="{{ route('products.index') }}" class="nav-link">Shop</a>
                        <a href="{{ auth()->check() ? route('orders.index') : route('login') }}" class="nav-link">Orders</a>
                        <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->check() ? url('/') : route('login')) }}" class="nav-link">Admin</a>
                    </nav>
                </div>

                <div class="nav-actions">
                    <button class="theme-toggle" id="theme-toggle" title="Toggle theme">
                        <i class="fas fa-sun theme-icon-sun" style="font-size:0.9rem;"></i>
                        <i class="fas fa-moon theme-icon-moon" style="font-size:0.9rem;"></i>
                    </button>

                    @auth
                        <a href="{{ route('cart.index') }}" class="nav-icon-btn">
                            <i class="fas fa-shopping-cart" style="font-size:0.9rem;"></i>
                            @php $cartCount = auth()->user()->carts()->count(); @endphp
                            @if($cartCount > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="nav-icon-btn" title="Logout">
                                <i class="fas fa-sign-out-alt" style="font-size:0.9rem;"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-icon-btn">
                            <i class="fas fa-user" style="font-size:0.9rem;"></i>
                        </a>
                    @endauth

                    <button class="nav-mobile-btn" id="mobile-menu-btn">
                        <i class="fas fa-bars" style="font-size:0.9rem;"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu" id="mobile-menu">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ route('products.index') }}">Shop</a>
                <a href="{{ auth()->check() ? route('orders.index') : route('login') }}">Orders</a>
                <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->check() ? url('/') : route('login')) }}">Admin</a>
                @auth
                    <a href="{{ route('cart.index') }}">Cart</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container" style="padding-top:1rem;">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="container" style="padding-top:1rem;">
            <div class="alert alert-danger">{{ session('error') }}</div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="{{ url('/') }}" class="nav-brand" style="margin-bottom:1rem;">
                        <div class="nav-brand-icon">N</div>
                        <span class="nav-brand-text">NODE<span>SHOP</span></span>
                    </a>
                    <p class="font-mono" style="font-size:0.85rem; color:var(--muted-fg); margin-top:1rem; line-height:1.6;">
                        Professional IoT hardware for developers and engineers.
                    </p>
                </div>
                <div>
                    <h3 class="footer-title">Shop</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('products.index') }}">All Products</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'microcontroller']) }}">Microcontrollers</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'sensor']) }}">Sensors</a></li>
                        <li><a href="{{ route('products.index', ['condition' => 'preloved']) }}">Preloved</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="footer-title">Support</h3>
                    <ul class="footer-links">
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Warranty</a></li>
                        <li><a href="#">Shipping</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="footer-title">Connect</h3>
                    <ul class="footer-links">
                        <li><a href="#">GitHub</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">LinkedIn</a></li>
                        <li><a href="#">YouTube</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} NODE SHOP. All rights reserved. Built with precision.
            </div>
        </div>
    </footer>

    <script>
        gsap.registerPlugin(ScrollTrigger);

        // ── Preloader ──
        let progress = 0;
        const loaderPercent = document.getElementById('loader-percent');
        const loaderBar = document.getElementById('loader-bar');
        const preloader = document.getElementById('preloader');

        const updateLoader = setInterval(() => {
            progress += Math.floor(Math.random() * 10) + 5;
            if (progress >= 100) {
                progress = 100;
                clearInterval(updateLoader);
                setTimeout(() => {
                    gsap.to(preloader, {
                        yPercent: -100, duration: 0.8,
                        ease: "power4.inOut",
                        onComplete: () => { preloader.style.display = 'none'; initAnimations(); }
                    });
                }, 200);
            }
            loaderPercent.innerText = progress + '%';
            loaderBar.style.width = progress + '%';
        }, 50);

        // ── Theme Toggle ──
        const html = document.documentElement;
        const savedTheme = localStorage.getItem('node-shop-theme');
        if (savedTheme === 'dark') {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        document.getElementById('theme-toggle').addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('node-shop-theme', html.classList.contains('dark') ? 'dark' : 'light');
        });

        // ── Mobile Menu ──
        document.getElementById('mobile-menu-btn').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('active');
        });

        // ── Scroll Animations ──
        function initAnimations() {
            gsap.utils.toArray('.reveal').forEach(el => {
                gsap.fromTo(el,
                    { opacity: 0, y: 40 },
                    {
                        opacity: 1, y: 0, duration: 0.8,
                        ease: "power4.out",
                        scrollTrigger: { trigger: el, start: "top 85%", once: true }
                    }
                );
            });

            gsap.utils.toArray('.stagger-reveal').forEach(container => {
                const children = container.children;
                gsap.fromTo(children,
                    { opacity: 0, y: 40 },
                    {
                        opacity: 1, y: 0, duration: 0.6,
                        stagger: 0.1, ease: "power4.out",
                        scrollTrigger: { trigger: container, start: "top 85%", once: true }
                    }
                );
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
