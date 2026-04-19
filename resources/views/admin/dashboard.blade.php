@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<section style="padding: 2rem;">
    <div class="container">
        <h1 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 1.5rem;"><i class="fas fa-tachometer-alt" style="color: var(--primary-light);"></i> Admin Dashboard</h1>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; margin-bottom: 2rem;">
            <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 16px; padding: 1.2rem;">
                <div style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 0.3rem;">Total Produk</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: var(--primary-light);">{{ $stats['total_products'] }}</div>
            </div>
            <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 16px; padding: 1.2rem;">
                <div style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 0.3rem;">Total Pesanan</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: var(--secondary);">{{ $stats['total_orders'] }}</div>
            </div>
            <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 16px; padding: 1.2rem;">
                <div style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 0.3rem;">Revenue</div>
                <div style="font-size: 1.4rem; font-weight: 800; color: var(--success);">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
            </div>
            <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 16px; padding: 1.2rem;">
                <div style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 0.3rem;">Pelanggan</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: var(--accent);">{{ $stats['total_customers'] }}</div>
            </div>
            <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 16px; padding: 1.2rem;">
                <div style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 0.3rem;">Pending</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: var(--warning);">{{ $stats['pending_orders'] }}</div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <!-- Recent Orders -->
            <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 18px; padding: 1.5rem;">
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem;">📋 Pesanan Terbaru</h3>
                @forelse($recentOrders as $order)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.8rem 0; {{ !$loop->last ? 'border-bottom: 1px solid rgba(108,92,231,0.05);' : '' }}">
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600;">{{ $order->order_number }}</div>
                        <div style="font-size: 0.7rem; color: var(--text-secondary);">{{ $order->user->name ?? 'N/A' }} • {{ $order->created_at->diffForHumans() }}</div>
                    </div>
                    <span style="padding: 3px 10px; border-radius: 6px; font-size: 0.65rem; font-weight: 700; background: rgba(108,92,231,0.1); color: var(--primary-light);">{{ $order->status_label }}</span>
                </div>
                @empty
                <p style="color: var(--text-secondary); font-size: 0.85rem;">Belum ada pesanan.</p>
                @endforelse
            </div>

            <!-- Top Products -->
            <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 18px; padding: 1.5rem;">
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem;">🔥 Produk Terpopuler</h3>
                @foreach($topProducts as $product)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.8rem 0; {{ !$loop->last ? 'border-bottom: 1px solid rgba(108,92,231,0.05);' : '' }}">
                    <div style="display: flex; align-items: center; gap: 0.8rem;">
                        <span style="font-size: 1.3rem;">{{ $product->category->icon ?? '📦' }}</span>
                        <div>
                            <div style="font-size: 0.85rem; font-weight: 600;">{{ Str::limit($product->name, 25) }}</div>
                            <div style="font-size: 0.7rem; color: var(--text-secondary);">Stok: {{ $product->stock }}</div>
                        </div>
                    </div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary);"><i class="fas fa-eye"></i> {{ $product->views_count }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
