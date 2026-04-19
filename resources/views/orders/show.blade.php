@extends('layouts.app')
@section('title', 'Pesanan ' . $order->order_number)

@section('content')
<section style="padding: 2rem;">
    <div class="container" style="max-width: 900px;">
        <a href="{{ route('orders.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-block; margin-bottom: 1rem;">← Kembali ke Pesanan</a>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.4rem; font-weight: 800;">Pesanan {{ $order->order_number }}</h1>
            <span style="padding: 6px 16px; border-radius: 10px; font-size: 0.8rem; font-weight: 700;
                background: rgba({{ $order->status_color == 'success' ? '0,184,148' : ($order->status_color == 'warning' ? '253,203,110' : '108,92,231') }}, 0.15);
                color: {{ $order->status_color == 'success' ? 'var(--success)' : ($order->status_color == 'warning' ? 'var(--warning)' : 'var(--primary-light)') }};">
                {{ $order->status_label }}
            </span>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div style="background: var(--dark-card); border-radius: 16px; padding: 1.2rem; border: 1px solid rgba(108,92,231,0.1);">
                <h3 style="font-size: 0.85rem; font-weight: 700; margin-bottom: 0.8rem; color: var(--primary-light);">📦 Pengiriman</h3>
                <p style="font-size: 0.8rem; color: var(--text-primary); font-weight: 600;">{{ $order->shipping_name }}</p>
                <p style="font-size: 0.8rem; color: var(--text-secondary);">{{ $order->shipping_phone }}</p>
                <p style="font-size: 0.8rem; color: var(--text-secondary); line-height: 1.6;">{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p>
                @if($order->tracking_number)
                <p style="margin-top: 0.5rem; font-size: 0.8rem;"><strong>Resi:</strong> <span style="color: var(--secondary);">{{ $order->tracking_number }}</span></p>
                @endif
            </div>
            <div style="background: var(--dark-card); border-radius: 16px; padding: 1.2rem; border: 1px solid rgba(108,92,231,0.1);">
                <h3 style="font-size: 0.85rem; font-weight: 700; margin-bottom: 0.8rem; color: var(--primary-light);">💳 Pembayaran</h3>
                <p style="font-size: 0.8rem; color: var(--text-secondary);">Status: <strong style="color: {{ $order->payment_status == 'paid' ? 'var(--success)' : 'var(--warning)' }};">{{ $order->payment_status == 'paid' ? 'Lunas' : 'Belum Dibayar' }}</strong></p>
                <p style="font-size: 0.8rem; color: var(--text-secondary);">Tanggal Order: {{ $order->created_at->format('d M Y, H:i') }}</p>
                @if($order->paid_at)
                <p style="font-size: 0.8rem; color: var(--text-secondary);">Dibayar: {{ $order->paid_at->format('d M Y, H:i') }}</p>
                @endif
            </div>
        </div>

        <!-- Items -->
        <div style="background: var(--dark-card); border-radius: 18px; padding: 1.5rem; border: 1px solid rgba(108,92,231,0.1);">
            <h3 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 1rem;">Item Pesanan</h3>
            @foreach($order->items as $item)
            <div style="display: flex; align-items: center; gap: 1rem; padding: 0.8rem 0; {{ !$loop->last ? 'border-bottom: 1px solid rgba(108,92,231,0.05);' : '' }}">
                <div style="width: 50px; height: 50px; background: var(--dark-surface); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    {{ $item->product->category->icon ?? '📦' }}
                </div>
                <div style="flex: 1;">
                    <div style="font-weight: 600; font-size: 0.85rem;">{{ $item->product_name }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                </div>
                <div style="font-weight: 700; color: var(--primary-light);">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
            </div>
            @endforeach

            <div style="border-top: 1px solid rgba(108,92,231,0.1); margin-top: 0.8rem; padding-top: 1rem;">
                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 0.4rem;">
                    <span style="color: var(--text-secondary);">Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 0.4rem;">
                    <span style="color: var(--text-secondary);">Ongkos Kirim</span>
                    <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 1.1rem; font-weight: 800; padding-top: 0.8rem; border-top: 1px solid rgba(108,92,231,0.1);">
                    <span>Total</span>
                    <span style="background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
