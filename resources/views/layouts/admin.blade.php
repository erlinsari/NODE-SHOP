<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - NODESHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f0f2ff 0%, #fce4f3 50%, #e0f7fa 100%);
            min-height: 100vh;
        }

        /* Sidebar */
        aside {
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
        }

        .sidebar-logo-icon { color: #e94560; }

        .sidebar-section-label {
            color: #64748b;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 0.65rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.2s;
            color: #94a3b8;
            font-size: 0.875rem;
        }

        .sidebar-item:hover:not(.active) {
            background: rgba(255,255,255,0.08);
            color: #ffffff;
        }

        .sidebar-item.active {
            background: linear-gradient(135deg, #e94560, #c2185b);
            color: white;
            box-shadow: 0 4px 15px rgba(233,69,96,0.4);
        }

        .sidebar-item i { width: 1.25rem; font-size: 0.9rem; }

        /* Scrollbar sidebar */
        aside::-webkit-scrollbar { width: 4px; }
        aside::-webkit-scrollbar-track { background: transparent; }
        aside::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }

        /* Main content background */
        main {
            background: transparent;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(102,126,234,0.3);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(102,126,234,0.4);
        }
        .btn-outline {
            border: 1.5px solid #e5e7eb;
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-outline:hover { background: #f9fafb; }

        /* Card style */
        .card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            border: 1px solid rgba(255,255,255,0.6);
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }
    </style>
</head>
<body>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 text-white flex flex-col shadow-2xl" style="flex-shrink: 0;">
            <!-- Logo -->
            <div class="p-6" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-microchip sidebar-logo-icon text-2xl"></i>
                    <h1 class="text-xl font-bold text-white">NODESHOP</h1>
                </div>
                <p class="text-xs mt-2" style="color: #64748b;">Admin Panel</p>
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto py-4">
                <div class="px-4 space-y-1">

                    <a href="{{ route('admin.dashboard') }}"
                       class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>

                    <div class="pt-5 pb-1">
                        <p class="px-3 sidebar-section-label">PRODUCTS</p>
                    </div>
                    <a href="{{ route('admin.products.index') }}"
                       class="sidebar-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span class="ml-3">All Products</span>
                    </a>
                    <a href="{{ route('admin.products.create') }}"
                       class="sidebar-item {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle"></i>
                        <span class="ml-3">Add Product</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                       class="sidebar-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span class="ml-3">Categories</span>
                    </a>
                    <a href="{{ route('admin.preloved.index') }}"
                       class="sidebar-item {{ request()->routeIs('admin.preloved.*') ? 'active' : '' }}">
                        <i class="fas fa-heart"></i>
                        <span class="ml-3">Preloved</span>
                    </a>

                    <div class="pt-5 pb-1">
                        <p class="px-3 sidebar-section-label">ORDERS</p>
                    </div>
                    <a href="{{ route('admin.orders.index') }}"
                       class="sidebar-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="ml-3">All Orders</span>
                    </a>

                    <div class="pt-5 pb-1">
                        <p class="px-3 sidebar-section-label">MANAGEMENT</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}"
                       class="sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span class="ml-3">Users</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}"
                       class="sidebar-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span class="ml-3">Reports</span>
                    </a>

                </div>
            </nav>

            <!-- User Profile -->
            <div class="p-4" style="border-top: 1px solid rgba(255,255,255,0.08);">
                <div class="flex items-center">
                    <div class="rounded-full w-9 h-9 flex items-center justify-center text-white font-bold text-sm"
                         style="background: linear-gradient(135deg, #e94560, #c2185b);">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs" style="color: #64748b;">Administrator</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="ml-2 transition-colors" style="color: #64748b;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#64748b'">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
