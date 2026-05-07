@extends('vertex.app')
@section('title', 'Cart')

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
    .cart-container {
        padding: 10rem 0 5rem;
        max-width: 1000px;
        margin: 0 auto;
    }
    .cart-item {
        display: flex;
        align-items: center;
        padding: 2rem;
        background: #000;
        border: 1px solid #1a1a1a;
        margin-bottom: 1rem;
        transition: border-color 0.3s;
    }
    .cart-item:hover {
        border-color: #333;
    }
    .cart-icon {
        font-size: 4rem;
        margin-right: 2rem;
        width: 100px;
        text-align: center;
    }
    .cart-details {
        flex: 1;
    }
    .cart-name {
        font-size: 1.2rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #fff;
        margin-bottom: 0.5rem;
        display: block;
    }
    .cart-cat {
        font-size: 0.7rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    .cart-quantity {
        display: flex;
        align-items: center;
        border: 1px solid #1a1a1a;
    }
    .cart-quantity button {
        background: none; border: none; color: #fff; padding: 10px 15px; cursor: pointer;
    }
    .cart-quantity input {
        width: 40px; background: transparent; border: none; color: #fff; text-align: center; font-weight: 700; outline: none;
    }
    .cart-price {
        font-size: 1.1rem;
        font-weight: 900;
        color: #fff;
        text-align: right;
        min-width: 150px;
    }
    .cart-remove {
        background: none; border: none; color: var(--accent); font-size: 1.2rem; cursor: pointer; margin-left: 2rem;
    }
    .cart-summary {
        background: #000;
        border: 1px solid #1a1a1a;
        padding: 3rem;
        margin-top: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .btn-checkout {
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
    }
    .btn-checkout:hover {
        background: var(--accent);
        color: #fff;
    }
    .empty-cart {
        text-align: center;
        padding: 8rem 0;
        border: 1px solid #1a1a1a;
        background: #000;
    }
</style>

<div class="cart-bg"></div>

<div class="container cart-container">
    <h1 style="font-size: 4rem; font-weight: 900; text-transform: uppercase; letter-spacing: -2px; margin-bottom: 4rem;">YOUR HARDWARE</h1>

    @if($cartItems->count() > 0)
        <div>
            @foreach($cartItems as $item)
            <div class="cart-item">
                <div class="cart-icon">{{ $item->product->category->icon ?? '📦' }}</div>
                
                <div class="cart-details">
                    <a href="{{ route('products.show', $item->product->slug) }}" class="cart-name">{{ $item->product->name }}</a>
                    <div class="cart-cat">{{ $item->product->category->name }}</div>
                </div>

                <div style="margin-right: 2rem;">
                    <form method="POST" action="{{ route('cart.update', $item) }}" class="cart-quantity">
                        @csrf @method('PATCH')
                        <button type="button" onclick="let q=this.parentNode.querySelector('input');q.value=Math.max(1,q.value-1);this.parentNode.submit()">−</button>
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" onchange="this.form.submit()">
                        <button type="button" onclick="let q=this.parentNode.querySelector('input');q.value=parseInt(q.value)+1;this.parentNode.submit()">+</button>
                    </form>
                </div>

                <div class="cart-price">
                    Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                </div>

                <form method="POST" action="{{ route('cart.destroy', $item) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="cart-remove" title="Remove">×</button>
                </form>
            </div>
            @endforeach
        </div>

        <div class="cart-summary">
            <div>
                <div style="font-size: 0.8rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 2px;">TOTAL ({{ $cartItems->count() }} ITEMS)</div>
                <div style="font-size: 3rem; font-weight: 900; color: #fff;">Rp {{ number_format($total, 0, ',', '.') }}</div>
            </div>
            <a href="{{ route('orders.create') }}" class="btn-checkout">PROCEED TO CHECKOUT</a>
        </div>
    @else
        <div class="empty-cart">
            <div style="font-size: 4rem; margin-bottom: 2rem;">🛒</div>
            <h3 style="font-size: 1.5rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 2rem;">YOUR CART IS EMPTY</h3>
            <a href="{{ route('products.index') }}" class="btn-checkout">INSPECT CATALOG</a>
        </div>
    @endif
</div>
@endsection
