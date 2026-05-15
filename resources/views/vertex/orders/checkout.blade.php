@extends('vertex.app')
@section('title', 'Checkout')

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
    .checkout-container {
        padding: 10rem 0 5rem;
        max-width: 1200px;
        margin: 0 auto;
    }
    .grid-container {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 3rem;
    }
    .panel {
        background: #000;
        border: 1px solid #1a1a1a;
        padding: 3rem;
    }
    .panel-title {
        font-size: 1.2rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 2rem;
        color: #fff;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }
    .form-group input, .form-group textarea {
        width: 100%;
        background: transparent;
        border: 0;
        border-bottom: 1px solid #333;
        color: #fff;
        padding: 10px 0;
        font-size: 1rem;
        font-family: inherit;
        outline: none;
        transition: border-color 0.3s;
    }
    .form-group input:focus, .form-group textarea:focus {
        border-bottom-color: var(--accent);
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #1a1a1a;
    }
    .summary-item:last-child {
        border-bottom: none;
    }
    .btn-checkout {
        display: inline-block;
        width: 100%;
        padding: 1.5rem;
        background: #fff;
        color: #000;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 900;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
        margin-top: 2rem;
    }
    .btn-checkout:hover {
        background: var(--accent);
        color: #fff;
    }
</style>

<div class="cart-bg"></div>

<div class="container checkout-container">
    <h1 style="font-size: 4rem; font-weight: 900; text-transform: uppercase; letter-spacing: -2px; margin-bottom: 4rem;">CHECKOUT</h1>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <div class="grid-container">
            <!-- Left: Form -->
            <div class="panel">
                <h3 class="panel-title">SHIPPING DETAILS</h3>

                <div class="form-group">
                    <label>Recipient Name *</label>
                    <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user() ? auth()->user()->name : '') }}" required>
                </div>
                <div class="form-group">
                    <label>Phone Number *</label>
                    <input type="text" name="shipping_phone" value="{{ old('shipping_phone', auth()->user() ? auth()->user()->phone : '') }}" required>
                </div>
                <div class="form-group">
                    <label>Full Address *</label>
                    <textarea name="shipping_address" rows="2" required>{{ old('shipping_address', auth()->user() ? auth()->user()->address : '') }}</textarea>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>City *</label>
                        <input type="text" name="shipping_city" value="{{ old('shipping_city', auth()->user() ? auth()->user()->city : '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Province *</label>
                        <input type="text" name="shipping_province" value="{{ old('shipping_province', auth()->user() ? auth()->user()->province : '') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Postal Code *</label>
                    <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code', auth()->user() ? auth()->user()->postal_code : '') }}" required>
                </div>
                <div class="form-group">
                    <label>Notes (Optional)</label>
                    <textarea name="notes" rows="1" placeholder="Special logic instructions...">{{ old('notes') }}</textarea>
                </div>

                @if($errors->any())
                    <div style="color: var(--accent); font-size: 0.8rem; margin-top: 1rem;">
                        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
            </div>

            <!-- Right: Summary -->
            <div>
                <div class="panel" style="position: sticky; top: 120px;">
                    <h3 class="panel-title">ORDER SUMMARY</h3>

                    <div style="margin-bottom: 2rem;">
                        @foreach($cartItems as $item)
                        <div class="summary-item">
                            <div>
                                <div style="font-weight: 700; font-size: 0.9rem; text-transform: uppercase;">{{ Str::limit($item->product->name, 20) }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-secondary);">QTY: {{ $item->quantity }}</div>
                            </div>
                            <div style="font-weight: 700; color: #fff;">
                                Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="summary-item">
                        <span style="color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-item">
                        <span style="color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Shipping</span>
                        <span style="color: var(--text-secondary);">Gratis</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2rem; font-size: 1.5rem; font-weight: 900;">
                        <span>TOTAL</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn-checkout">INITIATE PURCHASE</button>
                    <div style="text-align: center; font-size: 0.65rem; color: var(--text-secondary); margin-top: 1rem; text-transform: uppercase; letter-spacing: 1px;">
                        SECURE PAYMENTS BY MIDTRANS
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
