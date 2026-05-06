@extends('layouts.app')
@section('title', 'Admin Dashboard — NODE SHOP')

@section('content')
<section style="min-height:100vh; padding:2rem 0;">
    <div class="container">
        {{-- Header — matches AdminPage.tsx --}}
        <div class="reveal" style="margin-bottom:2rem;">
            <h1 class="font-black uppercase" style="font-size:clamp(2.5rem, 6vw, 4.5rem); margin-bottom:0.5rem; line-height:1;">
                Admin <span class="text-primary">Dashboard</span>
            </h1>
            <p class="font-mono text-muted">CONTROL PANEL / SYSTEM OVERVIEW</p>
        </div>

        {{-- Stats Cards — 4 cols matching AdminPage.tsx exactly --}}
        @php
        $statCards = [
            [
                'title' => 'Total Revenue',
                'value' => 'Rp ' . number_format($stats['total_revenue'] ?? 261000, 0, ',', '.'),
                'icon' => 'fa-dollar-sign',
                'change' => '+12.5%',
                'trend' => 'up'
            ],
            [
                'title' => 'Total Orders',
                'value' => number_format($stats['total_orders'] ?? 1378),
                'icon' => 'fa-box',
                'change' => '+8.2%',
                'trend' => 'up'
            ],
            [
                'title' => 'Active Users',
                'value' => number_format($stats['total_customers'] ?? 2847),
                'icon' => 'fa-users',
                'change' => '+15.3%',
                'trend' => 'up'
            ],
            [
                'title' => 'Conversion Rate',
                'value' => '3.24%',
                'icon' => 'fa-heartbeat',
                'change' => '-2.1%',
                'trend' => 'down'
            ],
        ];
        @endphp

        <div class="stagger-reveal" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:1.5rem; margin-bottom:2rem;">
            @foreach($statCards as $stat)
            <div class="card card-hover card-2x">
                <div class="card-body">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1rem;">
                        <div style="padding:0.75rem; border:1.5px solid var(--border); border-radius:var(--radius);">
                            <i class="fas {{ $stat['icon'] }} {{ $stat['title'] === 'Total Revenue' ? 'text-primary' : 'text-primary' }}" style="font-size:1.25rem;"></i>
                        </div>
                        <span class="badge {{ $stat['trend'] === 'up' ? 'badge-success' : 'badge-danger' }}" style="font-size:0.65rem;">
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
                    <span class="badge badge-outline font-mono">5 MONTHS</span>
                </div>
                <div class="card-body" style="padding:2rem;">
                    <div style="height:200px; position:relative; width:100%;">
                        <svg viewBox="0 0 500 100" preserveAspectRatio="none" style="width:100%; height:100%;">
                            <path d="M0,80 Q100,85 150,60 T300,40 T500,70" fill="none" stroke="#FF0000" stroke-width="3" stroke-linecap="round" />
                        </svg>
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
                <div class="card-body" style="padding:2rem;">
                    <div style="display:flex; align-items:flex-end; justify-content:center; gap:2rem; height:200px;">
                        <div style="width:30px; height:20%; background:var(--muted); border-radius:2px;"></div>
                        <div style="width:30px; height:40%; background:var(--muted); border-radius:2px;"></div>
                        <div style="width:30px; height:90%; background:#FF0000; border-radius:2px;"></div>
                        <div style="width:30px; height:60%; background:var(--muted); border-radius:2px;"></div>
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
