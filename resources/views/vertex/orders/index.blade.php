@extends('vertex.app')
@section('title', 'My Orders')

@section('content')
<style>
    .cart-bg {
        position: absolute;
        width: 100%;
        height: 100vh;
        top: 0; left: 0;
        background: radial-gradient(circle at 50% -20%, rgba(20,20,20,1) 0%, #000 70%);
        z-index: -1;
    }
    .orders-container {
        padding: 10rem 0 5rem;
        max-width: 1000px;
        margin: 0 auto;
    }
    .order-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 2rem;
        background: #000;
        border: 1px solid #1a1a1a;
        margin-bottom: 1rem;
        transition: all 0.3s;
    }
    .order-item:hover {
        border-color: #333;
        transform: translateX(10px);
    }
    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border: 1px solid var(--text-secondary);
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    .empty-orders {
        text-align: center;
        padding: 8rem 0;
        border: 1px solid #1a1a1a;
        background: #000;
        margin-top: 2rem;
    }
    .btn-action {
        display: inline-block;
        padding: 1.5rem 3rem;
        background: #fff;
        color: #000;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 900;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 2rem;
    }
    .btn-action:hover {
        background: var(--accent);
        color: #fff;
    }
</style>

<div class="cart-bg"></div>

<div class="container orders-container">
    <h1 style="font-size: 4rem; font-weight: 900; text-transform: uppercase; letter-spacing: -2px; margin-bottom: 4rem;">PURCHASE HISTORY</h1>

    @if($orders->count() > 0)
        <div>
            @foreach($orders as $order)
            <a href="{{ route('orders.show', $order) }}" class="order-item">
                <div>
                    <div style="font-weight: 900; font-size: 1.5rem; color: #fff; margin-bottom: 0.5rem;">{{ $order->order_number }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                        {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }} • {{ $order->items->count() }} ITEM(S)
                    </div>
                </div>
                
                <div style="text-align: right;">
                    <span class="status-badge" style="border-color: {{ $order->status_color == 'warning' ? '#F5A623' : ($order->status_color == 'success' ? '#7ED321' : ($order->status_color == 'danger' ? '#D0021B' : '#fff')) }}; color: {{ $order->status_color == 'warning' ? '#F5A623' : ($order->status_color == 'success' ? '#7ED321' : ($order->status_color == 'danger' ? '#D0021B' : '#fff')) }};">
                        {{ $order->status_label }}
                    </span>
                    <div style="font-weight: 900; font-size: 1.5rem; color: #fff; margin-top: 1rem;">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                </div>
            </a>
            @endforeach
        </div>
        
        <div style="margin-top: 2rem;">
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-orders">
            <div style="font-size: 4rem; margin-bottom: 2rem;">📋</div>
            <h3 style="font-size: 1.5rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 0.5rem; color: #fff;">NO RECORDS FOUND</h3>
            <p style="color: var(--text-secondary); letter-spacing: 1px; margin-bottom: 2rem;">Your transaction history will appear here.</p>
            <a href="{{ route('products.index') }}" class="btn-action">EXPLORE HARDWARE</a>
        </div>
    @endif
</div>
@endsection
