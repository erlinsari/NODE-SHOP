<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Node Shop') — Premium IoT Gear</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        :root {
            /* Beats/Carren Style Red & Black Theme */
            --primary: #E50914;      /* Strong Red */
            --primary-dark: #B20710;
            --primary-light: #FF333D;
            --secondary: #FFFFFF;
            --accent: #E50914;
            --dark: #000000;         /* Pure Black */
            --dark-card: #0A0A0A;    /* Very dark gray */
            --dark-surface: #141414;
            --text-primary: #FFFFFF;
            --text-secondary: #AAAAAA;
            --success: #28A745;
            --warning: #FFC107;
            --danger: #E50914;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--dark); color: var(--text-primary); min-height: 100vh; overflow-x: hidden; }

        /* Navbar - Solid Black with Red Accents */
        .navbar {
            background: #000000;
            border-bottom: 2px solid var(--dark-surface);
            padding: 0 2rem;
            height: 80px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-brand {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-decoration: none; color: var(--text-primary);
            line-height: 1;
        }
        .nav-brand .brand-main { font-size: 1.8rem; font-weight: 900; letter-spacing: 2px; }
        .nav-brand .brand-sub { font-size: 0.7rem; color: var(--primary); font-weight: 700; letter-spacing: 1px; margin-top: 2px;}

        .nav-links {
            display: flex; align-items: center; gap: 2.5rem; list-style: none; height: 100%;
        }
        .nav-links li { height: 100%; display: flex; align-items: center; }
        .nav-links a {
            color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 1px; transition: color 0.3s; position: relative; height: 100%; display: flex; align-items: center;
        }
        .nav-links a:hover { color: var(--text-primary); }
        .nav-links a.active { color: var(--primary); }
        .nav-links a.active::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--primary);
        }

        .nav-actions { display: flex; align-items: center; gap: 1.5rem; }
        .nav-search { position: relative; }
        .nav-search input {
            background: #111; border: 1px solid #333; border-radius: 4px; padding: 8px 16px 8px 38px;
            color: var(--text-primary); font-size: 0.85rem; width: 220px; outline: none; transition: all 0.3s;
        }
        .nav-search input:focus { border-color: var(--primary); background: #1a1a1a; }
        .nav-search i {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-size: 0.85rem;
        }
        .nav-cart {
            position: relative; color: var(--text-primary); text-decoration: none; font-size: 1.2rem; transition: color 0.3s;
        }
        .nav-cart:hover { color: var(--primary); }
        .nav-cart .badge {
            position: absolute; top: -8px; right: -10px; background: var(--primary); color: white; font-size: 0.65rem;
            font-weight: 700; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
        }

        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 10px 24px; border-radius: 2px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase;
            text-decoration: none; border: none; cursor: pointer; transition: all 0.3s ease; letter-spacing: 1px;
        }
        .btn-primary { background: var(--primary); color: #FFF; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-outline { background: transparent; color: var(--primary); border: 1px solid var(--primary); }
        .btn-outline:hover { background: var(--primary); color: #FFF; }

        .main-content { min-height: calc(100vh - 80px); }

        /* Footer - Red Top Border */
        .footer {
            background: #050505; border-top: 4px solid var(--primary); padding: 4rem 2rem 2rem;
        }
        .footer-grid {
            max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 2rem;
        }
        .footer-brand p { color: var(--text-secondary); font-size: 0.85rem; line-height: 1.7; margin-top: 1rem; }
        .footer-col h4 { font-size: 0.9rem; font-weight: 800; text-transform: uppercase; margin-bottom: 1.5rem; color: #FFF; letter-spacing: 1px; }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 0.8rem; }
        .footer-col ul a { color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; transition: color 0.3s; }
        .footer-col ul a:hover { color: var(--primary); }
        .footer-bottom {
            max-width: 1200px; margin: 3rem auto 0; padding-top: 1.5rem; border-top: 1px solid #222;
            display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; color: var(--text-secondary);
        }
        .social-links { display: flex; gap: 1rem; }
        .social-links a {
            color: var(--text-secondary); font-size: 1.2rem; background: #111; width: 36px; height: 36px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s;
        }
        .social-links a:hover { color: #FFF; background: var(--primary); }
        
        .dropdown { position: relative; }
        .dropdown-menu {
            position: absolute; top: calc(100% + 5px); right: 0; background: #111; border: 1px solid #333;
            min-width: 180px; display: none; z-index: 100;
        }
        .dropdown:hover .dropdown-menu { display: block; }
        .dropdown-menu a {
            display: block; padding: 10px 15px; color: var(--text-secondary); text-decoration: none;
            font-size: 0.85rem; transition: all 0.2s; border-bottom: 1px solid #222;
        }
        .dropdown-menu a:hover { background: #222; color: var(--text-primary); border-left: 3px solid var(--primary); }

    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <a href="{{ url('/') }}" class="nav-brand">
            <span class="brand-main">NODE<span style="color:var(--primary)">SHOP</span></span>
            <span class="brand-sub">PREMIUM IOT GEAR</span>
        </a>

        <ul class="nav-links">
            <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Store</a></li>
            <li><a href="{{ route('products.index', ['condition' => 'preloved']) }}" class="{{ request()->is('products*') && request('condition') == 'preloved' ? 'active' : '' }}">Preloved</a></li>
            <li><a href="#">Gallery</a></li>
        </ul>

        <div class="nav-actions">
            <div class="nav-search">
                <i class="fas fa-search"></i>
                <form action="{{ route('products.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Search product..." value="{{ request('search') }}">
                </form>
            </div>

            @auth
                <a href="{{ route('cart.index') }}" class="nav-cart" title="Cart">
                    <i class="fas fa-shopping-cart"></i>
                    @php $cartCount = auth()->user()->carts()->count(); @endphp
                    @if($cartCount > 0)
                        <span class="badge">{{ $cartCount }}</span>
                    @endif
                </a>

                <div class="dropdown">
                    <a href="#" class="btn btn-outline" style="padding: 6px 12px;">
                        <i class="fas fa-user"></i> {{ Str::limit(auth()->user()->name, 10) }}
                    </a>
                    <div class="dropdown-menu">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        @endif
                        <a href="{{ route('orders.index') }}">My Orders</a>
                        <a href="{{ route('profile.edit') }}">Settings</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline" style="padding: 8px 16px;">Log in</a>
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 8px 16px;">Sign Up</a>
            @endauth
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ url('/') }}" class="nav-brand" style="align-items: flex-start;">
                    <span class="brand-main">NODE<span style="color:var(--primary)">SHOP</span></span>
                    <span class="brand-sub">PREMIUM IOT GEAR</span>
                </a>
                <p>High performance IoT devices, microcontrollers, and precision sensors for professional makers and developers.</p>
            </div>
            <div class="footer-col">
                <h4>Hardware</h4>
                <ul>
                    <li><a href="#">Microcontrollers</a></li>
                    <li><a href="#">Sensors</a></li>
                    <li><a href="#">Wireless Modules</a></li>
                    <li><a href="#">Accessories</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Order Tracking</a></li>
                    <li><a href="#">Warranty</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Connect</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright &copy; {{ date('Y') }} Node Shop. All Rights Reserved.</p>
            <div style="display:flex; gap: 15px;">
                <a href="#" style="color:#aaa; text-decoration:none;">Privacy Policy</a>
                <a href="#" style="color:#aaa; text-decoration:none;">Terms of Use</a>
            </div>
        </div>
    </footer>
</body>
</html>
