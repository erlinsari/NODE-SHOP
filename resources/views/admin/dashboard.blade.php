@extends('layouts.app')
@section('title', 'Admin Dashboard — NODE SHOP')

@section('content')
<section style="min-height:100vh; padding:2rem 0;">
    <div class="container">
        {{-- Header — matches AdminPage.tsx --}}
        <div class="reveal" style="margin-bottom:2rem;">
            <h1 class="font-black uppercase" style="font-size:clamp(2.5rem, 6vw, 4.5rem); margin-bottom:0.5rem;">
                Admin <span class="text-primary">Dashboard</span>
            </h1>
            <p class="font-mono text-muted">CONTROL PANEL / SYSTEM OVERVIEW</p>
        </div>

        {{-- Stats Cards — 4 cols matching AdminPage.tsx exactly --}}
        @php
        $statCards = [
            [
                'title' => 'Total Revenue',
                'value' => 'Rp ' . number_format($stats['total_revenue'], 0, ',', '.'),
                'icon' => 'fa-dollar-sign',
                'change' => '+12.5%',
                'trend' => 'up'
            ],
            [
                'title' => 'Total Orders',
                'value' => number_format($stats['total_orders']),
                'icon' => 'fa-shopping-cart',
                'change' => '+8.2%',
                'trend' => 'up'
            ],
            [
                'title' => 'Active Users',
                'value' => number_format($stats['total_customers']),
                'icon' => 'fa-users',
                'change' => '+15.3%',
                'trend' => 'up'
            ],
            [
                'title' => 'Pending Orders',
                'value' => $stats['pending_orders'],
                'icon' => 'fa-chart-line',
                'change' => $stats['pending_orders'] > 0 ? $stats['pending_orders'] . ' active' : '0',
                'trend' => $stats['pending_orders'] > 0 ? 'down' : 'up'
            ],
        ];
        @endphp

        <div class="stagger-reveal" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:1.5rem; margin-bottom:2rem;">
            @foreach($statCards as $stat)
            <div class="card card-hover card-2x">
                <div class="card-body">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1rem;">
                        <div style="padding:0.75rem; border:2px solid var(--border); border-radius:var(--radius);">
                            <i class="fas {{ $stat['icon'] }} text-primary" style="font-size:1.25rem;"></i>
                        </div>
                        <span class="badge {{ $stat['trend'] === 'up' ? 'badge-success' : 'badge-danger' }}">
                            {{ $stat['change'] }}
                        </span>
                    </div>
                    <p class="font-mono text-muted uppercase" style="font-size:0.75rem; letter-spacing:0.05em; margin-bottom:0.5rem;">{{ $stat['title'] }}</p>
                    <p class="font-black" style="font-size:1.875rem;">{{ $stat['value'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Charts Row — matches AdminPage.tsx LineChart + BarChart --}}
        <div style="display:grid; grid-template-columns:1fr; gap:1.5rem; margin-bottom:2rem;" class="admin-charts">
            {{-- Revenue Overview Chart --}}
            <div class="card card-2x reveal">
                <div class="card-header" style="border-bottom-width:2px; display:flex; align-items:center; justify-content:space-between;">
                    <h2 class="font-black uppercase" style="font-size:0.95rem; display:flex; align-items:center; gap:0.75rem;">
                        <i class="fas fa-chart-line text-primary"></i> Revenue Overview
                    </h2>
                    <span class="badge badge-outline font-mono">RECENT</span>
                </div>
                <div class="card-body">
                    {{-- CSS Bar Chart --}}
                    <div style="display:flex; align-items:flex-end; gap:1rem; height:200px; padding:1rem 0;">
                        @php
                        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
                        $revenues = [45, 52, 48, 61, 55];
                        $maxRev = max($revenues);
                        @endphp
                        @foreach($months as $i => $month)
                        <div style="flex:1; display:flex; flex-direction:column; align-items:center; gap:0.5rem; height:100%;">
                            <div style="flex:1; width:100%; display:flex; align-items:flex-end;">
                                <div class="chart-bar" style="width:100%; background:linear-gradient(to top, #FF0000, #ff4444); border-radius:2px 2px 0 0; height:{{ ($revenues[$i] / $maxRev) * 100 }}%; transition:height 1s ease; min-height:8px; position:relative;">
                                    <span class="font-mono" style="position:absolute; top:-1.5rem; left:50%; transform:translateX(-50%); font-size:0.65rem; color:var(--muted-fg); white-space:nowrap;">{{ $revenues[$i] }}M</span>
                                </div>
                            </div>
                            <span class="font-mono" style="font-size:0.7rem; color:var(--muted-fg);">{{ $month }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Sales by Category --}}
            <div class="card card-2x reveal">
                <div class="card-header" style="border-bottom-width:2px; display:flex; align-items:center; justify-content:space-between;">
                    <h2 class="font-black uppercase" style="font-size:0.95rem; display:flex; align-items:center; gap:0.75rem;">
                        <i class="fas fa-box text-primary"></i> Sales by Category
                    </h2>
                    <span class="badge badge-outline font-mono">CURRENT MONTH</span>
                </div>
                <div class="card-body">
                    <div style="display:flex; flex-direction:column; gap:1rem;">
                        @php
                        $catSales = [
                            ['name' => 'Microcontrollers', 'count' => $stats['total_products'] > 0 ? rand(80, 150) : 127, 'max' => 300],
                            ['name' => 'Sensors', 'count' => $stats['total_products'] > 0 ? rand(150, 300) : 284, 'max' => 300],
                            ['name' => 'Modules', 'count' => $stats['total_products'] > 0 ? rand(50, 120) : 95, 'max' => 300],
                            ['name' => 'Kits', 'count' => $stats['total_products'] > 0 ? rand(30, 80) : 68, 'max' => 300],
                        ];
                        @endphp
                        @foreach($catSales as $cat)
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.4rem;">
                                <span class="font-mono" style="font-size:0.8rem;">{{ $cat['name'] }}</span>
                                <span class="font-mono font-black" style="font-size:0.8rem;">{{ $cat['count'] }}</span>
                            </div>
                            <div style="width:100%; height:8px; background:var(--muted); border-radius:var(--radius); overflow:hidden;">
                                <div style="width:{{ ($cat['count'] / $cat['max']) * 100 }}%; height:100%; background:#FF0000; border-radius:var(--radius); transition:width 1s ease;"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Tables Row — Recent Orders + Top Products --}}
        <div style="display:grid; grid-template-columns:1fr; gap:1.5rem; margin-bottom:2rem;" class="admin-tables">
            {{-- Recent Orders --}}
            <div class="card card-2x reveal">
                <div class="card-header" style="border-bottom-width:2px; display:flex; align-items:center; justify-content:space-between;">
                    <h2 class="font-black uppercase" style="font-size:0.95rem; display:flex; align-items:center; gap:0.75rem;">
                        <i class="fas fa-clock text-primary"></i> Recent Orders
                    </h2>
                    <span class="badge badge-outline font-mono">LATEST</span>
                </div>
                <div class="card-body">
                    @forelse($recentOrders as $order)
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:0.75rem 0; {{ !$loop->last ? 'border-bottom:1px solid var(--border);' : '' }} flex-wrap:wrap; gap:0.5rem;">
                        <div style="display:flex; align-items:center; gap:1rem;">
                            <div style="padding:0.5rem; border:2px solid var(--border); border-radius:var(--radius);">
                                @if($order->status === 'completed' || $order->status === 'delivered')
                                    <i class="fas fa-check-circle text-primary" style="font-size:1rem;"></i>
                                @elseif($order->status === 'cancelled')
                                    <i class="fas fa-times-circle text-danger" style="font-size:1rem;"></i>
                                @else
                                    <i class="fas fa-clock text-primary" style="font-size:1rem;"></i>
                                @endif
                            </div>
                            <div>
                                <p class="font-mono font-bold" style="font-size:0.85rem;">{{ $order->order_number }}</p>
                                <p class="font-mono text-muted" style="font-size:0.7rem;">{{ $order->user->name ?? 'N/A' }} • {{ $order->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div style="display:flex; align-items:center; gap:0.75rem;">
                            <span class="font-mono font-black" style="font-size:0.85rem;">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            @php
                                $statusColors = ['pending'=>'badge-warning','processing'=>'badge-primary','shipped'=>'badge-primary','completed'=>'badge-success','delivered'=>'badge-success','cancelled'=>'badge-danger'];
                            @endphp
                            <span class="badge {{ $statusColors[$order->status] ?? 'badge-secondary' }}">
                                {{ strtoupper($order->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center; padding:2rem;">
                        <i class="fas fa-inbox text-muted" style="font-size:2rem; margin-bottom:0.75rem; display:block;"></i>
                        <p class="font-mono text-muted" style="font-size:0.85rem;">No orders yet</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Top Products --}}
            <div class="card card-2x reveal">
                <div class="card-header" style="border-bottom-width:2px; display:flex; align-items:center; justify-content:space-between;">
                    <h2 class="font-black uppercase" style="font-size:0.95rem; display:flex; align-items:center; gap:0.75rem;">
                        <i class="fas fa-fire text-primary"></i> Top Products
                    </h2>
                    <span class="badge badge-outline font-mono">BY VIEWS</span>
                </div>
                <div class="card-body">
                    @forelse($topProducts as $product)
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:0.75rem 0; {{ !$loop->last ? 'border-bottom:1px solid var(--border);' : '' }}">
                        <div style="display:flex; align-items:center; gap:0.75rem;">
                            <div style="width:40px; height:40px; background:var(--muted); border-radius:var(--radius); display:flex; align-items:center; justify-content:center; font-size:1.25rem; flex-shrink:0;">
                                {{ $product->category->icon ?? '📦' }}
                            </div>
                            <div>
                                <p class="font-bold" style="font-size:0.85rem;">{{ Str::limit($product->name, 30) }}</p>
                                <p class="font-mono text-muted" style="font-size:0.7rem;">
                                    {{ $product->category->name ?? 'N/A' }} • Stock: {{ $product->stock }}
                                </p>
                            </div>
                        </div>
                        <div style="display:flex; align-items:center; gap:0.5rem;">
                            <i class="fas fa-eye text-muted" style="font-size:0.7rem;"></i>
                            <span class="font-mono text-muted" style="font-size:0.8rem;">{{ $product->views_count }}</span>
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center; padding:2rem;">
                        <p class="font-mono text-muted" style="font-size:0.85rem;">No products yet</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- System Status — matches AdminPage.tsx exactly --}}
        <div class="card card-2x reveal">
            <div class="card-header" style="border-bottom-width:2px;">
                <h2 class="font-black uppercase" style="font-size:0.95rem;">System Status</h2>
            </div>
            <div class="card-body">
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1.5rem;">
                    <div style="padding:1rem; background:color-mix(in srgb, var(--muted) 20%, transparent); border:1px solid var(--border); border-radius:var(--radius);">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.5rem;">
                            <span class="font-mono text-muted uppercase" style="font-size:0.75rem;">Server Status</span>
                            <span class="badge badge-success">ONLINE</span>
                        </div>
                        <p class="font-mono text-muted" style="font-size:0.7rem;">Uptime: 99.98%</p>
                    </div>
                    <div style="padding:1rem; background:color-mix(in srgb, var(--muted) 20%, transparent); border:1px solid var(--border); border-radius:var(--radius);">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.5rem;">
                            <span class="font-mono text-muted uppercase" style="font-size:0.75rem;">Database</span>
                            <span class="badge badge-success">ACTIVE</span>
                        </div>
                        <p class="font-mono text-muted" style="font-size:0.7rem;">Response: 12ms avg</p>
                    </div>
                    <div style="padding:1rem; background:color-mix(in srgb, var(--muted) 20%, transparent); border:1px solid var(--border); border-radius:var(--radius);">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.5rem;">
                            <span class="font-mono text-muted uppercase" style="font-size:0.75rem;">API Status</span>
                            <span class="badge badge-success">OPERATIONAL</span>
                        </div>
                        <p class="font-mono text-muted" style="font-size:0.7rem;">Requests: 2.4K/min</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    @media(min-width: 1024px) {
        .admin-charts { grid-template-columns: 1.2fr 0.8fr !important; }
        .admin-tables { grid-template-columns: 1fr 1fr !important; }
    }
    .chart-bar:hover { opacity:0.85; }
</style>
@endpush
@endsection
