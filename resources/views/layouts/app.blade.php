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

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <style>
        /* ═══════════════════════════════════════
           DESIGN SYSTEM — NODE SHOP
           Premium IoT E-commerce Interface
        ═══════════════════════════════════════ */

        :root {
            --bg: #f6f4f1;
            --fg: #0a0a0a;

            --card: rgba(255, 255, 255, 0.78);
            --card-fg: #0a0a0a;

            --primary: #FF0000;
            --primary-hover: #cc0000;
            --primary-active: #990000;
            --primary-fg: #ffffff;

            --secondary: #ece8e3;
            --secondary-fg: #0a0a0a;

            --muted: #f1eee9;
            --muted-fg: #66615c;

            --accent: #ebe7e1;
            --border: rgba(10, 10, 10, 0.12);
            --input-bg: rgba(255, 255, 255, 0.68);

            --success: #16a34a;
            --warning: #ca8a04;
            --danger: #FF0000;

            --radius: 8px;
            --radius-sm: 4px;
            --radius-lg: 18px;

            --shadow-soft: 0 14px 40px rgba(0, 0, 0, 0.08);
            --shadow-card: 0 8px 28px rgba(0, 0, 0, 0.06);
            --shadow-red: 0 14px 34px rgba(255, 0, 0, 0.18);
        }

        html.dark {
            --bg: #11100f;
            --fg: #f6f4f1;

            --card: rgba(24, 23, 22, 0.82);
            --card-fg: #f6f4f1;

            --secondary: #201e1d;
            --secondary-fg: #f6f4f1;

            --muted: #1b1918;
            --muted-fg: #a9a29b;

            --accent: #242120;
            --border: rgba(255, 255, 255, 0.1);
            --input-bg: rgba(255, 255, 255, 0.06);

            --success: #22c55e;
            --warning: #eab308;

            --shadow-soft: 0 16px 48px rgba(0, 0, 0, 0.32);
            --shadow-card: 0 12px 32px rgba(0, 0, 0, 0.28);
            --shadow-red: 0 18px 44px rgba(255, 0, 0, 0.16);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--fg);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            transition: background 0.3s ease, color 0.3s ease;

            background:
                radial-gradient(circle at 12% 10%, rgba(255, 255, 255, 0.95), transparent 26%),
                radial-gradient(circle at 85% 20%, rgba(255, 0, 0, 0.055), transparent 28%),
                radial-gradient(circle at 50% 100%, rgba(255, 210, 210, 0.28), transparent 34%),
                linear-gradient(135deg, #f7f5f1 0%, #f1eee9 48%, #f8eeee 100%);
        }

        html.dark body {
            background:
                radial-gradient(circle at 12% 10%, rgba(255, 255, 255, 0.055), transparent 28%),
                radial-gradient(circle at 86% 18%, rgba(255, 0, 0, 0.14), transparent 30%),
                radial-gradient(circle at 50% 100%, rgba(255, 0, 0, 0.08), transparent 36%),
                linear-gradient(135deg, #11100f 0%, #171514 48%, #221110 100%);
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: -1;
            opacity: 0.42;
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.025) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        html.dark body::before {
            opacity: 0.55;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.035) 1px, transparent 1px);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button,
        input,
        textarea,
        select {
            font: inherit;
        }

        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        @media (min-width: 1024px) {
            .container {
                padding: 0 2rem;
            }
        }

        /* ═══════════════════════════════════════
           PRELOADER
        ═══════════════════════════════════════ */

        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 10000;

            background:
                radial-gradient(circle at 35% 25%, rgba(255, 255, 255, 0.14), transparent 26%),
                linear-gradient(135deg, #ff1a1a 0%, #ff0000 48%, #9f0000 100%);

            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 1.5rem;
        }

        .preloader .loader-logo {
            font-family: 'Inter', sans-serif;
            font-weight: 900;
            font-size: 2rem;
            text-transform: uppercase;
            color: #fff;
            letter-spacing: -1px;
        }

        .preloader .loader-logo span {
            color: #111;
        }

        .preloader .loader-bar-track {
            width: 220px;
            height: 3px;
            background: rgba(255, 255, 255, 0.28);
            overflow: hidden;
            border-radius: 999px;
        }

        .preloader .loader-bar {
            width: 0%;
            height: 100%;
            background: #ffffff;
            transition: width 0.1s linear;
            border-radius: 999px;
        }

        .preloader .loader-percent {
            font-family: 'JetBrains Mono', monospace;
            font-size: 3rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -2px;
        }

        /* ═══════════════════════════════════════
           NAVBAR
        ═══════════════════════════════════════ */

        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
            border-bottom: 1px solid var(--border);
            background: color-mix(in srgb, var(--bg) 76%, transparent);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .navbar-inner {
            display: flex;
            height: 64px;
            align-items: center;
            justify-content: space-between;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
        }

        .nav-brand-icon {
            width: 34px;
            height: 34px;
            background: #FF0000;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 900;
            font-size: 1.1rem;
            box-shadow: var(--shadow-red);
        }

        .nav-brand-text {
            font-weight: 900;
            font-size: 1.25rem;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .nav-brand-text span {
            color: #FF0000;
        }

        .nav-links {
            display: none;
            align-items: center;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .nav-links {
                display: flex;
            }
        }

        .nav-link {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            font-weight: 600;
            position: relative;
            background: none;
            border: none;
            color: var(--fg);
            cursor: pointer;
            padding: 0;
            font-family: 'Inter', sans-serif;
            transition: color 0.2s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -7px;
            left: 0;
            width: 0;
            height: 2px;
            background: #FF0000;
            transition: width 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #FF0000;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-icon-btn,
        .theme-toggle,
        .nav-mobile-btn {
            position: relative;
            width: 40px;
            height: 40px;
            padding: 0;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.38);
            color: var(--fg);
            cursor: pointer;
            transition: all 0.22s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        html.dark .nav-icon-btn,
        html.dark .theme-toggle,
        html.dark .nav-mobile-btn {
            background: rgba(255, 255, 255, 0.045);
        }

        .nav-icon-btn:hover,
        .theme-toggle:hover,
        .nav-mobile-btn:hover {
            border-color: #FF0000;
            color: #FF0000;
            transform: translateY(-1px);
        }

        .nav-icon-btn .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #FF0000;
            color: #fff;
            font-size: 0.65rem;
            font-family: 'JetBrains Mono', monospace;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            box-shadow: 0 8px 18px rgba(255, 0, 0, 0.28);
        }

        .nav-mobile-btn {
            display: flex;
        }

        @media (min-width: 768px) {
            .nav-mobile-btn {
                display: none;
            }
        }

        .mobile-menu {
            display: none;
            border-top: 1px solid var(--border);
            padding: 1rem 0;
        }

        .mobile-menu.active {
            display: block;
        }

        .mobile-menu a,
        .mobile-menu button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 0.75rem 0;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            font-weight: 600;
            background: none;
            border: none;
            color: var(--fg);
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: color 0.2s ease;
            text-decoration: none;
        }

        .mobile-menu a::after {
            display: none;
        }

        .mobile-menu a:hover,
        .mobile-menu button:hover {
            color: #FF0000;
        }

        @media (min-width: 768px) {
            .mobile-menu {
                display: none !important;
            }
        }

        /* ═══════════════════════════════════════
           BUTTONS
        ═══════════════════════════════════════ */

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.22s ease;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            border: none;
            cursor: pointer;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            gap: 0.65rem;
            line-height: 1;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-primary {
            background: #FF0000;
            color: #fff;
            padding: 0.85rem 1.5rem;
            box-shadow: var(--shadow-red);
        }

        .btn-primary:hover:not(:disabled) {
            background: #cc0000;
            transform: translateY(-2px);
        }

        .btn-primary:active:not(:disabled) {
            background: #990000;
            transform: translateY(0);
        }

        .btn-sm {
            padding: 0.6rem 1rem;
            font-size: 0.75rem;
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 0.95rem;
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.36);
            color: var(--fg);
            border: 1.5px solid var(--fg);
            padding: calc(0.85rem - 1.5px) calc(1.5rem - 1.5px);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        html.dark .btn-outline {
            background: rgba(255, 255, 255, 0.045);
        }

        .btn-outline:hover:not(:disabled) {
            background: var(--fg);
            color: var(--bg);
            transform: translateY(-2px);
        }

        .btn-ghost {
            background: transparent;
            color: var(--fg);
            padding: 0.75rem 1.5rem;
        }

        .btn-ghost:hover {
            background: var(--accent);
        }

        .btn-block {
            width: 100%;
        }

        /* ═══════════════════════════════════════
           CARDS
        ═══════════════════════════════════════ */

        .card {
            background: var(--card);
            color: var(--card-fg);
            border: 1px solid rgba(255, 255, 255, 0.58);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            transition: all 0.3s ease;
        }

        html.dark .card {
            border-color: rgba(255, 255, 255, 0.08);
        }

        .card-hover:hover {
            border-color: rgba(255, 0, 0, 0.48);
            box-shadow: 0 18px 44px rgba(255, 0, 0, 0.12);
            transform: translateY(-4px);
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--border);
        }

        .card-2x {
            border-width: 2px;
        }

        .card-2x .card-header {
            border-bottom-width: 2px;
        }

        .card-2x .card-footer {
            border-top-width: 2px;
        }

        /* ═══════════════════════════════════════
           HERO PRODUCT BACKGROUND
           Gunakan class ini di welcome/home blade
        ═══════════════════════════════════════ */

        .hero-product-bg {
            position: relative;
            min-height: calc(100vh - 64px);
            overflow: hidden;
            display: flex;
            align-items: center;

            background:
                radial-gradient(circle at 78% 44%, rgba(255, 0, 0, 0.075), transparent 30%),
                radial-gradient(circle at 18% 18%, rgba(255, 255, 255, 0.96), transparent 30%),
                linear-gradient(135deg, #f7f5f1 0%, #f0ede8 46%, #f8eeee 100%);
        }

        html.dark .hero-product-bg {
            background:
                radial-gradient(circle at 78% 44%, rgba(255, 0, 0, 0.18), transparent 32%),
                radial-gradient(circle at 18% 18%, rgba(255, 255, 255, 0.055), transparent 30%),
                linear-gradient(135deg, #11100f 0%, #171514 46%, #241110 100%);
        }

        .hero-product-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.025) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
            z-index: 0;
        }

        html.dark .hero-product-bg::before {
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.035) 1px, transparent 1px);
        }

        .hero-product-bg::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image: var(--hero-image);
            background-repeat: no-repeat;
            background-size: min(64vw, 1080px) auto;
            background-position: right center;
            opacity: 0.96;
            z-index: 1;
            pointer-events: none;
            filter: drop-shadow(0 42px 84px rgba(0, 0, 0, 0.14));
            mask-image: linear-gradient(to right, transparent 0%, rgba(0, 0, 0, 0.08) 31%, black 52%);
            -webkit-mask-image: linear-gradient(to right, transparent 0%, rgba(0, 0, 0, 0.08) 31%, black 52%);
        }

        html.dark .hero-product-bg::after {
            opacity: 0.78;
            filter: drop-shadow(0 42px 90px rgba(255, 0, 0, 0.08));
        }

        .hero-content-left {
            position: relative;
            z-index: 2;
            width: min(760px, 100%);
            padding: 7rem 0;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            padding: 0.45rem 0.8rem;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.62);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.13em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            border-radius: var(--radius-sm);
        }

        html.dark .hero-kicker {
            background: rgba(255, 255, 255, 0.06);
        }

        .hero-title {
            font-size: clamp(4rem, 8vw, 8.6rem);
            line-height: 0.88;
            letter-spacing: -0.08em;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 2rem;
        }

        .hero-title .text-red {
            color: #FF0000;
        }

        .hero-description {
            max-width: 600px;
            font-family: 'JetBrains Mono', monospace;
            font-size: clamp(1rem, 1.4vw, 1.35rem);
            line-height: 1.72;
            color: var(--muted-fg);
            margin-bottom: 2rem;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        @media (max-width: 1024px) {
            .hero-product-bg::after {
                background-size: 82vw auto;
                background-position: right bottom;
                opacity: 0.34;
                mask-image: linear-gradient(to bottom, transparent 0%, black 34%);
                -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 34%);
            }

            .hero-content-left {
                padding: 5rem 0;
            }
        }

        @media (max-width: 640px) {
            .hero-product-bg {
                min-height: auto;
            }

            .hero-product-bg::after {
                background-size: 116vw auto;
                background-position: center bottom;
                opacity: 0.22;
            }

            .hero-content-left {
                padding: 4rem 0 12rem;
            }

            .hero-title {
                font-size: clamp(3.2rem, 18vw, 5rem);
            }

            .hero-actions {
                align-items: stretch;
            }

            .hero-actions .btn {
                width: 100%;
            }
        }

        /* ═══════════════════════════════════════
           BADGES
        ═══════════════════════════════════════ */

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.18rem 0.65rem;
            border-radius: var(--radius-sm);
            font-size: 0.7rem;
            font-family: 'JetBrains Mono', monospace;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 700;
            border: 1px solid transparent;
        }

        .badge-primary {
            background: #FF0000;
            color: #fff;
            border-color: #FF0000;
        }

        .badge-secondary {
            background: var(--secondary);
            color: var(--secondary-fg);
            border-color: var(--secondary);
        }

        .badge-success {
            background: var(--success);
            color: #fff;
            border-color: var(--success);
        }

        .badge-warning {
            background: var(--warning);
            color: #fff;
            border-color: var(--warning);
        }

        .badge-danger {
            background: #FF0000;
            color: #fff;
            border-color: #FF0000;
        }

        .badge-outline {
            background: transparent;
            border-color: var(--border);
            color: var(--fg);
        }

        /* ═══════════════════════════════════════
           FORM INPUTS
        ═══════════════════════════════════════ */

        .form-input {
            width: 100%;
            padding: 0.85rem 1rem;
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--fg);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .form-input:focus {
            border-color: #FF0000;
            box-shadow: 0 0 0 4px rgba(255, 0, 0, 0.08);
        }

        .form-input::placeholder {
            color: var(--muted-fg);
        }

        .form-label {
            display: block;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 600;
        }

        .form-input-icon {
            position: relative;
        }

        .form-input-icon .icon {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted-fg);
            font-size: 0.9rem;
        }

        .form-input-icon .form-input {
            padding-left: 2.6rem;
        }

        /* ═══════════════════════════════════════
           UTILITIES
        ═══════════════════════════════════════ */

        .text-primary {
            color: #FF0000;
        }

        .text-muted {
            color: var(--muted-fg);
        }

        .text-success {
            color: var(--success);
        }

        .text-warning {
            color: var(--warning);
        }

        .text-danger {
            color: #FF0000;
        }

        .font-black {
            font-weight: 900;
        }

        .font-bold {
            font-weight: 700;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .line-through {
            text-decoration: line-through;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        html.dark .theme-icon-sun {
            display: inline;
        }

        html.dark .theme-icon-moon {
            display: none;
        }

        html:not(.dark) .theme-icon-sun {
            display: none;
        }

        html:not(.dark) .theme-icon-moon {
            display: inline;
        }

        /* ═══════════════════════════════════════
           FOOTER
        ═══════════════════════════════════════ */

        .site-footer {
            border-top: 1px solid var(--border);
            margin-top: 5rem;
            background: color-mix(in srgb, var(--bg) 82%, transparent);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 3rem 0;
        }

        @media (min-width: 768px) {
            .footer-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .footer-title {
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            letter-spacing: 0.06em;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            color: var(--muted-fg);
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: #FF0000;
        }

        .footer-bottom {
            border-top: 1px solid var(--border);
            padding: 2rem 0;
            text-align: center;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            color: var(--muted-fg);
        }

        /* ═══════════════════════════════════════
           ANIMATIONS
        ═══════════════════════════════════════ */

        .reveal {
            opacity: 0;
            transform: translateY(40px);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.8s cubic-bezier(0.22, 1, 0.36, 1);
        }

        /* ═══════════════════════════════════════
           ALERT
        ═══════════════════════════════════════ */

        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            font-size: 0.85rem;
            border-left: 3px solid;
            background: var(--card);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: var(--shadow-card);
        }

        .alert-success {
            background: rgba(22, 163, 74, 0.1);
            border-left-color: var(--success);
            color: var(--success);
        }

        .alert-danger {
            background: rgba(255, 0, 0, 0.1);
            border-left-color: #FF0000;
            color: #FF0000;
        }

        /* ═══════════════════════════════════════
           PAGINATION
        ═══════════════════════════════════════ */

        nav[role="navigation"] {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        nav[role="navigation"] .hidden {
            display: none;
        }

        nav[role="navigation"] > div:first-child {
            display: none;
        }

        nav[role="navigation"] > div:last-child {
            width: 100%;
        }

        nav[role="navigation"] > div:last-child > div:first-child {
            display: none;
        }

        nav[role="navigation"] span[aria-current="page"] span,
        nav[role="navigation"] a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.75rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            font-weight: 700;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
            text-decoration: none;
            color: var(--fg);
            background: rgba(255, 255, 255, 0.34);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        html.dark nav[role="navigation"] span[aria-current="page"] span,
        html.dark nav[role="navigation"] a {
            background: rgba(255, 255, 255, 0.045);
        }

        nav[role="navigation"] span[aria-current="page"] span {
            background: #FF0000;
            color: #fff;
            border-color: #FF0000;
        }

        nav[role="navigation"] a:hover {
            border-color: #FF0000;
            color: #FF0000;
        }

        nav[role="navigation"] span[aria-disabled="true"] span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.75rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--muted-fg);
            opacity: 0.5;
            cursor: not-allowed;
        }

        nav[role="navigation"] > div:last-child > div:last-child {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            flex-wrap: wrap;
        }

        nav[role="navigation"] p {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            color: var(--muted-fg);
        }

        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            list-style: none;
        }

        .pagination li a,
        .pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.75rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            font-weight: 700;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
            text-decoration: none;
            color: var(--fg);
        }

        .pagination li.active span {
            background: #FF0000;
            color: #fff;
            border-color: #FF0000;
        }

        .pagination li a:hover {
            border-color: #FF0000;
            color: #FF0000;
        }

        .pagination li.disabled span {
            opacity: 0.5;
            cursor: not-allowed;
        }

        nav[role="navigation"] svg {
            width: 1rem;
            height: 1rem;
        }

        /* ═══════════════════════════════════════
           SCROLLBAR
        ═══════════════════════════════════════ */

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 0, 0, 0.55);
            border-radius: 999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 0, 0, 0.85);
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="loader-logo">NODE<span>SHOP</span></div>
        <div class="loader-bar-track">
            <div class="loader-bar" id="loader-bar"></div>
        </div>
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
                        <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                        <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Shop</a>
                        <a href="{{ auth()->check() ? route('orders.index') : route('login') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">Orders</a>
                        <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->check() ? url('/') : route('login')) }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">Admin</a>
                    </nav>
                </div>

                <div class="nav-actions">
                    <button class="theme-toggle" id="theme-toggle" title="Toggle theme" type="button">
                        <i class="fas fa-sun theme-icon-sun" style="font-size:0.9rem;"></i>
                        <i class="fas fa-moon theme-icon-moon" style="font-size:0.9rem;"></i>
                    </button>

                    @auth
                        <a href="{{ route('cart.index') }}" class="nav-icon-btn" title="Cart">
                            <i class="fas fa-shopping-cart" style="font-size:0.9rem;"></i>
                            @php $cartCount = auth()->user()->carts()->count(); @endphp
                            @if($cartCount > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>

                        <a href="{{ route('profile.edit') }}" class="nav-icon-btn" title="Profile">
                            <i class="fas fa-user" style="font-size:0.9rem;"></i>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="nav-icon-btn" title="Logout">
                                <i class="fas fa-sign-out-alt" style="font-size:0.9rem;"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-icon-btn" title="Login">
                            <i class="fas fa-user" style="font-size:0.9rem;"></i>
                        </a>
                    @endauth

                    <button class="nav-mobile-btn" id="mobile-menu-btn" type="button">
                        <i class="fas fa-bars" style="font-size:0.9rem;"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu" id="mobile-menu">
                <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Shop</a>
                <a href="{{ auth()->check() ? route('orders.index') : route('login') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">Orders</a>
                <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->check() ? url('/') : route('login')) }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">Admin</a>

                @auth
                    <a href="{{ route('cart.index') }}" class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}">Cart</a>
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">Profile</a>

                    <form method="POST" action="{{ route('logout') }}" style="margin-top:0.5rem;">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm btn-block">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
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

    <!-- Main Content -->
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
                        Professional IoT hardware for developers, makers, and engineers.
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
        const loaderPercent = document.getElementById('loader-percent');
        const loaderBar = document.getElementById('loader-bar');
        const preloader = document.getElementById('preloader');

        const path = window.location.pathname;

        const showPreloader =
            path === '/' ||
            path === '/products' ||
            path === '/profile' ||
            path.startsWith('/orders') ||
            path.startsWith('/admin');

        if (!showPreloader) {
            preloader.style.display = 'none';

            document.addEventListener('DOMContentLoaded', () => {
                initAnimations();
            });
        } else {
            let progress = 0;

            const updateLoader = setInterval(() => {
                progress += Math.floor(Math.random() * 10) + 5;

                if (progress >= 100) {
                    progress = 100;
                    clearInterval(updateLoader);

                    setTimeout(() => {
                        gsap.to(preloader, {
                            yPercent: -100,
                            duration: 0.8,
                            ease: "power4.inOut",
                            onComplete: () => {
                                preloader.style.display = 'none';
                                initAnimations();
                            }
                        });
                    }, 200);
                }

                loaderPercent.innerText = progress + '%';
                loaderBar.style.width = progress + '%';
            }, 50);
        }

        // ── Theme Toggle ──
        const html = document.documentElement;
        const savedTheme = localStorage.getItem('node-shop-theme');

        if (savedTheme === 'dark') {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        const themeToggle = document.getElementById('theme-toggle');

        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                html.classList.toggle('dark');

                localStorage.setItem(
                    'node-shop-theme',
                    html.classList.contains('dark') ? 'dark' : 'light'
                );
            });
        }

        // ── Mobile Menu ──
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
            });
        }

        // ── Scroll Animations ──
        function initAnimations() {
            gsap.utils.toArray('.reveal').forEach(el => {
                gsap.fromTo(
                    el,
                    {
                        opacity: 0,
                        y: 40
                    },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 0.8,
                        ease: "power4.out",
                        scrollTrigger: {
                            trigger: el,
                            start: "top 85%",
                            once: true
                        }
                    }
                );
            });

            gsap.utils.toArray('.stagger-reveal').forEach(container => {
                const children = container.children;

                gsap.fromTo(
                    children,
                    {
                        opacity: 0,
                        y: 40
                    },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 0.6,
                        stagger: 0.1,
                        ease: "power4.out",
                        scrollTrigger: {
                            trigger: container,
                            start: "top 85%",
                            once: true
                        }
                    }
                );
            });
        }
    </script>

    @stack('scripts')
</body>
</html>