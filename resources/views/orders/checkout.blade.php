@extends('layouts.app')
@section('title', 'Checkout — NODE SHOP')

@section('content')
<section style="min-height:100vh; padding:2rem 0;">
    <div class="container" style="max-width:1100px;">
        {{-- Back link --}}
        <a href="{{ route('cart.index') }}" class="reveal" style="display:inline-flex; align-items:center; gap:0.5rem; margin-bottom:2rem; font-family:'JetBrains Mono'; text-transform:uppercase; font-size:0.85rem; transition:color 0.2s;"
           onmouseover="this.style.color='#FF0000'" onmouseout="this.style.color='var(--fg)'">
            <i class="fas fa-chevron-left" style="font-size:0.7rem;"></i> Back to Cart
        </a>

        {{-- Header --}}
        <h1 class="font-black uppercase reveal" style="font-size:clamp(2.5rem, 6vw, 4.5rem); margin-bottom:0.5rem;">
            Check<span class="text-primary">out</span>
        </h1>
        <p class="font-mono text-muted reveal" style="margin-bottom:2rem;">Complete your order</p>

        {{-- Step Indicator — matches CheckoutPage.tsx --}}
        <div class="reveal" style="display:flex; align-items:center; gap:0.5rem; margin-bottom:2rem;">
            <div style="display:flex; align-items:center; gap:0.5rem; padding:0.5rem 1rem; background:#FF0000; border-radius:var(--radius);">
                <div style="width:20px; height:20px; background:rgba(255,255,255,0.3); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                    <span style="font-size:0.65rem; color:#fff; font-weight:700;">1</span>
                </div>
                <span class="font-mono" style="font-size:0.75rem; color:#fff; font-weight:600;">SHIPPING</span>
            </div>
            <div style="width:2rem; height:2px; background:var(--border);"></div>
            <div style="display:flex; align-items:center; gap:0.5rem; padding:0.5rem 1rem; border:1px solid var(--border); border-radius:var(--radius);">
                <div style="width:20px; height:20px; border:1px solid var(--border); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                    <span class="text-muted" style="font-size:0.65rem; font-weight:700;">2</span>
                </div>
                <span class="font-mono text-muted" style="font-size:0.75rem; font-weight:600;">CONFIRMATION</span>
            </div>
        </div>

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <div style="display:grid; grid-template-columns:1fr; gap:2rem;" class="checkout-grid">
                {{-- Shipping Form — matches CheckoutPage.tsx --}}
                <div class="card card-2x reveal">
                    <div class="card-header" style="border-bottom-width:2px;">
                        <h2 class="font-black uppercase" style="font-size:1.1rem; display:flex; align-items:center; gap:0.75rem;">
                            <i class="fas fa-map-marker-alt text-primary"></i> Shipping Information
                        </h2>
                    </div>
                    <div class="card-body">
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;" class="checkout-form-grid">
                            <div>
                                <label class="form-label">Full Name *</label>
                                <div class="form-input-icon">
                                    <i class="fas fa-user icon"></i>
                                    <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required class="form-input" placeholder="John Doe">
                                </div>
                                @error('shipping_name') <p class="error-text">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Phone Number *</label>
                                <div class="form-input-icon">
                                    <i class="fas fa-phone icon"></i>
                                    <input type="text" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" required class="form-input" placeholder="08xxxxxxxxxx">
                                </div>
                                @error('shipping_phone') <p class="error-text">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div style="margin-bottom:1rem;">
                            <label class="form-label">Street Address *</label>
                            <div class="form-input-icon">
                                <i class="fas fa-home icon" style="top:1.5rem;"></i>
                                <textarea name="shipping_address" rows="3" required class="form-input" style="resize:vertical; padding-left:2.5rem;" placeholder="Full address...">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                            </div>
                            @error('shipping_address') <p class="error-text">{{ $message }}</p> @enderror
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:1rem; margin-bottom:1rem;" class="checkout-city-grid">
                            <div>
                                <label class="form-label">City *</label>
                                <input type="text" name="shipping_city" value="{{ old('shipping_city', auth()->user()->city) }}" required class="form-input" placeholder="City">
                                @error('shipping_city') <p class="error-text">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Province *</label>
                                <input type="text" name="shipping_province" value="{{ old('shipping_province', auth()->user()->province) }}" required class="form-input" placeholder="Province">
                                @error('shipping_province') <p class="error-text">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Postal Code *</label>
                                <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code', auth()->user()->postal_code) }}" required class="form-input" placeholder="12345">
                                @error('shipping_postal_code') <p class="error-text">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div style="margin-bottom:1rem;">
                            <label class="form-label">Order Notes (Optional)</label>
                            <textarea name="notes" rows="2" class="form-input" style="resize:vertical;" placeholder="e.g. bubble wrap, specific color preference...">{{ old('notes') }}</textarea>
                        </div>

                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin:0; padding-left:1rem; font-size:0.8rem;">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Order Summary Sidebar — matches CheckoutPage.tsx --}}
                <div style="position:sticky; top:5rem; height:fit-content;" class="reveal">
                    <div class="card card-2x">
                        <div class="card-header" style="border-bottom-width:2px;">
                            <h3 class="font-black uppercase" style="font-size:0.95rem; display:flex; align-items:center; gap:0.5rem;">
                                <i class="fas fa-receipt text-primary"></i> Order Summary
                            </h3>
                        </div>
                        <div class="card-body" style="display:flex; flex-direction:column; gap:0.75rem;">
                            {{-- Items --}}
                            @foreach($cartItems as $item)
                            <div style="display:flex; gap:0.75rem; align-items:center;">
                                <div style="width:48px; height:48px; background:var(--muted); border-radius:var(--radius); display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden;">
                                    @if($item->product->image_url)
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" style="width:100%; height:100%; object-fit:cover;">
                                    @else
                                        <span style="font-size:1.5rem;">{{ $item->product->category->icon ?? '📦' }}</span>
                                    @endif
                                </div>
                                <div style="flex:1; min-width:0;">
                                    <p class="font-mono font-black" style="font-size:0.8rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $item->product->name }}</p>
                                    <p class="font-mono text-muted" style="font-size:0.7rem;">Qty: {{ $item->quantity }}</p>
                                </div>
                                <span class="font-mono font-black" style="font-size:0.8rem; flex-shrink:0;">Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}</span>
                            </div>
                            @endforeach

                            <div style="height:1px; background:var(--border); margin:0.5rem 0;"></div>

                            {{-- Totals --}}
                            @php
                                $shipping = 0;
                                $tax = $subtotal * 0.11;
                                $grandTotal = $subtotal + $shipping + $tax;
                            @endphp
                            <div class="font-mono" style="font-size:0.85rem;">
                                <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="font-black">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">
                                    <span class="text-muted">Shipping</span>
                                    <span class="font-black">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                                </div>
                                <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">
                                    <span class="text-muted">Tax (11%)</span>
                                    <span class="font-black">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div style="height:1px; background:var(--border); margin:0.5rem 0;"></div>

                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span class="font-black uppercase" style="font-size:1rem;">Total</span>
                                <span class="font-black text-primary" style="font-size:1.5rem;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="card-footer" style="border-top-width:2px;">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                <i class="fas fa-check-circle"></i> Place Order
                            </button>
                            <p class="font-mono text-muted" style="text-align:center; margin-top:0.75rem; font-size:0.7rem;">
                                <i class="fas fa-shield-alt"></i> Secure checkout • SSL encrypted
                            </p>
                        </div>
                    </div>

                    {{-- Benefits --}}
                    <div style="margin-top:1rem; display:flex; flex-direction:column; gap:0.5rem;">
                        @foreach(['Free shipping on orders over Rp 500.000', '12-month warranty on all products', 'Secure payment processing'] as $benefit)
                        <div class="card" style="padding:0.75rem 1rem; display:flex; align-items:center; gap:0.75rem;">
                            <div style="width:4px; height:4px; background:#FF0000; border-radius:50%; flex-shrink:0;"></div>
                            <p class="font-mono text-muted" style="font-size:0.75rem;">{{ $benefit }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@push('styles')
<style>
    .error-text { color: #FF0000; font-size: 0.75rem; font-family: 'JetBrains Mono'; margin-top: 0.25rem; }
    @media(min-width: 1024px) {
        .checkout-grid { grid-template-columns: 1.3fr 0.7fr !important; }
    }
    @media(max-width: 768px) {
        .checkout-form-grid { grid-template-columns: 1fr !important; }
        .checkout-city-grid { grid-template-columns: 1fr !important; }
    }
</style>
@endpush
@endsection
