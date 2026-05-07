@extends('vertex.app')
@section('title', 'Purchase #' . $order->order_number)

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
    .order-container {
        padding: 10rem 0 5rem;
        max-width: 1200px;
        margin: 0 auto;
    }
    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border: 1px solid var(--text-secondary);
        font-size: 0.8rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    .grid-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-bottom: 3rem;
    }
    .panel {
        background: #000;
        border: 1px solid #1a1a1a;
        padding: 3rem;
    }
    .panel-title {
        font-size: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 2rem;
        color: #fff;
    }
    .info-row {
        margin-bottom: 1rem;
    }
    .info-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.3rem;
    }
    .info-value {
        font-size: 1rem;
        color: #fff;
        line-height: 1.5;
    }
    .item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem 0;
        border-bottom: 1px solid #1a1a1a;
    }
    .item-row:last-child {
        border-bottom: none;
    }
</style>

<div class="cart-bg"></div>

<div class="container order-container">
    <a href="{{ route('orders.index') }}" style="color: var(--text-secondary); text-transform: uppercase; letter-spacing: 2px; font-size: 0.8rem; display: inline-block; margin-bottom: 2rem;">← RECORD LIST</a>

    <div class="header-flex">
        <h1 style="font-size: 4rem; font-weight: 900; text-transform: uppercase; letter-spacing: -2px; line-height: 1;">PURCHASE<br>{{ $order->order_number }}</h1>
        <span class="status-badge" style="border-color: {{ $order->status_color == 'warning' ? '#F5A623' : ($order->status_color == 'success' ? '#7ED321' : ($order->status_color == 'danger' ? '#D0021B' : '#fff')) }}; color: {{ $order->status_color == 'warning' ? '#F5A623' : ($order->status_color == 'success' ? '#7ED321' : ($order->status_color == 'danger' ? '#D0021B' : '#fff')) }};">
            {{ $order->status_label }}
        </span>
    </div>

    <div class="grid-container">
        <!-- LOGISTICS -->
        <div class="panel">
            <h3 class="panel-title">LOGISTICS DATA</h3>
            
            <div class="info-row">
                <div class="info-label">RECIPIENT</div>
                <div class="info-value">{{ $order->shipping_name }} <br><span style="color:var(--text-secondary); font-size: 0.85rem;">{{ $order->shipping_phone }}</span></div>
            </div>
            
            <div class="info-row">
                <div class="info-label">DESTINATION</div>
                <div class="info-value">{{ $order->shipping_address }}<br>{{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</div>
            </div>

            @if($order->tracking_number)
            <div class="info-row">
                <div class="info-label">TRACKING SIGNATURE</div>
                <div class="info-value" style="color: var(--accent); font-weight: 700;">{{ $order->tracking_number }}</div>
            </div>
            @endif
        </div>

        <!-- TRANSACTIONS -->
        <div class="panel">
            <h3 class="panel-title">TRANSACTION LEDGER</h3>
            
            <div class="info-row">
                <div class="info-label">STATUS</div>
                <div class="info-value" style="font-weight: 700; color: {{ $order->payment_status == 'paid' ? '#7ED321' : '#F5A623' }}">{{ $order->payment_status == 'paid' ? 'AUTHORIZED' : 'PENDING FUNDS' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">INITIATED AT</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i:s') }}</div>
            </div>

            @if($order->paid_at)
            <div class="info-row">
                <div class="info-label">AUTHORIZED AT</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($order->paid_at)->format('d M Y, H:i:s') }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- ITEMS -->
    <div class="panel">
        <h3 class="panel-title">MANIFEST</h3>
        
        <div style="margin-bottom: 2rem;">
            @foreach($order->items as $item)
            <div class="item-row">
                <div style="display: flex; align-items: center;">
                    <div style="font-size: 3rem; margin-right: 2rem; width: 60px; text-align: center;">{{ $item->product->category->icon ?? '⚙️' }}</div>
                    <div>
                        <div style="font-weight: 700; font-size: 1.1rem; text-transform: uppercase;">{{ $item->product_name }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.8rem;">QTY: {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div style="font-weight: 900; font-size: 1.2rem; color: #fff;">
                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                </div>
            </div>
            @endforeach
        </div>

        <div style="border-top: 1px solid #1a1a1a; padding-top: 2rem; margin-left: auto; max-width: 400px;">
            <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 1rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                <span>SUBTOTAL</span>
                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 1rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                <span>SHIPPING</span>
                <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 1.5rem; font-weight: 900; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #1a1a1a;">
                <span>TOTAL</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
