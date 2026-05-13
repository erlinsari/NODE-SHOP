@extends('layouts.app')
@section('title', 'Shopping Cart — NODE SHOP')

@section('content')
<section style="min-height:100vh; padding:2rem 0;">
    <div class="container">
        {{-- Back link --}}
        <a href="{{ route('products.index') }}" class="reveal" style="display:inline-flex; align-items:center; gap:0.5rem; margin-bottom:2rem; font-family:'JetBrains Mono'; text-transform:uppercase; font-size:0.85rem; transition:color 0.2s;"
           onmouseover="this.style.color='#FF0000'" onmouseout="this.style.color='var(--fg)'">
            <i class="fas fa-chevron-left" style="font-size:0.7rem;"></i> Continue Shopping
        </a>

        {{-- Header — matches CartPage.tsx --}}
        <div class="reveal" style="margin-bottom:2rem;">
            <h1 class="font-black uppercase" style="font-size:clamp(3rem, 6vw, 4.5rem); margin-bottom:0.5rem;">
                Shopping <span class="text-primary">Cart</span>
            </h1>
            <p class="font-mono text-muted">
                @if($cartItems->count() > 0)
                    {{ $cartItems->count() }} items in your cart
                @else
                    Your cart is empty
                @endif
            </p>
        </div>

        @if($cartItems->count() > 0)
        @php
            $shipping = 0;
            $tax = $total * 0.11;
            $grandTotal = $total + $shipping + $tax;
        @endphp

        {{-- Cart Grid — lg:grid-cols-3 col-span-2 matching reference --}}
        <div class="cart-grid">
            {{-- Cart Items — col-span-2 --}}
            <div class="cart-items-col" style="display:flex; flex-direction:column; gap:1rem;">
                @foreach($cartItems as $i => $item)
                <div class="card card-2x card-hover reveal" style="animation-delay:{{ $i * 0.08 }}s;">
                    <div class="card-body" style="display:flex; gap:1.5rem; flex-wrap:wrap;">
                        {{-- Product Image --}}
                        <div style="width:7rem; height:7rem; border-radius:var(--radius); overflow:hidden; background:var(--muted); flex-shrink:0; display:flex; align-items:center; justify-content:center; cursor:pointer;"
                             onclick="window.location='{{ route('products.show', $item->product->slug) }}'">
                            @if($item->product->image_url)
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" style="width:100%; height:100%; object-fit:cover; transition:transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            @else
                                <span style="font-size:2.5rem;">{{ $item->product->category->icon ?? '📦' }}</span>
                            @endif
                        </div>

                        {{-- Product Info --}}
                        <div style="flex:1; min-width:200px;">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:0.5rem;">
                                <div>
                                    <span class="badge badge-outline" style="margin-bottom:0.5rem;">{{ $item->product->category->name ?? 'HARDWARE' }}</span>
                                    <h3 class="font-black" style="font-size:1.1rem; cursor:pointer; transition:color 0.2s;"
                                        onclick="window.location='{{ route('products.show', $item->product->slug) }}'"
                                        onmouseover="this.style.color='#FF0000'" onmouseout="this.style.color='var(--fg)'">
                                        {{ $item->product->name }}
                                    </h3>
                                </div>
                                <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="delete-btn" style="padding:0.5rem; background:none; border:1px solid var(--border); border-radius:var(--radius); color:var(--muted-fg); cursor:pointer; transition:all 0.2s;" title="Remove">
                                        <i class="fas fa-trash-alt" style="font-size:0.8rem;"></i>
                                    </button>
                                </form>
                            </div>

                            <p class="font-mono text-muted line-clamp-2" style="font-size:0.85rem; margin-bottom:1rem;">
                                {{ Str::limit($item->product->description, 80) }}
                            </p>

                            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
                                {{-- Quantity Controls --}}
                                <div style="display:flex; align-items:center; gap:0.75rem;">
                                    <form method="POST" action="{{ route('cart.update', $item) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                        <button type="submit" class="qty-btn" style="width:36px; height:36px; border:2px solid var(--border); border-radius:var(--radius); background:none; color:var(--fg); cursor:pointer; display:flex; align-items:center; justify-content:center; transition:border-color 0.2s;">
                                            <i class="fas fa-minus" style="font-size:0.6rem;"></i>
                                        </button>
                                    </form>
                                    <span class="font-mono font-black" style="font-size:1.25rem; width:2.5rem; text-align:center;">{{ $item->quantity }}</span>
                                    <form method="POST" action="{{ route('cart.update', $item) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                        <button type="submit" class="qty-btn" style="width:36px; height:36px; border:2px solid var(--border); border-radius:var(--radius); background:none; color:var(--fg); cursor:pointer; display:flex; align-items:center; justify-content:center; transition:border-color 0.2s;">
                                            <i class="fas fa-plus" style="font-size:0.6rem;"></i>
                                        </button>
                                    </form>
                                </div>

                                {{-- Item Total --}}
                                <div style="text-align:right;">
                                    <p class="font-mono text-muted" style="font-size:0.7rem; margin-bottom:0.15rem;">{{ $item->quantity }} × Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    <span class="font-black" style="font-size:1.5rem;">Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Order Summary Sidebar — matches CartPage.tsx --}}
            <div class="reveal" style="position:sticky; top:6rem; height:fit-content;">
                <div class="card card-2x">
                    <div class="card-header" style="border-bottom-width:2px;">
                        <h2 class="font-black uppercase" style="font-size:1.25rem; display:flex; align-items:center; gap:0.5rem;">
                            <i class="fas fa-receipt text-primary"></i> Order Summary
                        </h2>
                    </div>
                    <div class="card-body font-mono" style="display:flex; flex-direction:column; gap:0.75rem;">
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:0.5rem 0;">
                            <span class="text-muted">Subtotal ({{ $cartItems->count() }} items)</span>
                            <span class="font-black">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:0.5rem 0;">
                            <span class="text-muted">Shipping</span>
                            <span class="font-black">
                                @if($shipping === 0)
                                    <span class="badge badge-success">FREE</span>
                                @else
                                    Rp {{ number_format($shipping, 0, ',', '.') }}
                                @endif
                            </span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:0.5rem 0;">
                            <span class="text-muted">Tax (11%)</span>
                            <span class="font-black">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>

                        @if($total < 500000)
                        <div style="background:color-mix(in srgb, var(--muted) 50%, transparent); padding:0.75rem; border:1px solid var(--border); border-radius:var(--radius);">
                            <p class="font-mono" style="font-size:0.75rem;">
                                <i class="fas fa-info-circle text-primary" style="margin-right:0.25rem;"></i>
                                Add <span class="font-black text-primary">Rp {{ number_format(500000 - $total, 0, ',', '.') }}</span> more for free shipping
                            </p>
                        </div>
                        @endif

                        <div style="height:2px; background:var(--border); margin:0.5rem 0;"></div>

                        <div style="display:flex; justify-content:space-between; align-items:center; padding:0.5rem 0;">
                            <span class="font-black uppercase" style="font-size:1.1rem;">Total</span>
                            <span class="font-black text-primary" style="font-size:1.875rem;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="card-footer" style="border-top-width:2px;">
                        <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg btn-block">
                            <i class="fas fa-lock" style="margin-right:0.5rem;"></i> Proceed to Checkout
                        </a>
                    </div>
                </div>

                {{-- Benefit cards --}}
                <div style="margin-top:1rem; display:flex; flex-direction:column; gap:0.5rem;">
                    @foreach([
                        ['icon' => 'fa-shipping-fast', 'text' => 'Free shipping on orders over Rp 500.000'],
                        ['icon' => 'fa-shield-alt', 'text' => '12-month warranty on all products'],
                        ['icon' => 'fa-lock', 'text' => 'Secure payment processing']
                    ] as $benefit)
                    <div class="card" style="padding:0.75rem 1rem; display:flex; align-items:center; gap:0.75rem;">
                        <i class="fas {{ $benefit['icon'] }} text-primary" style="font-size:0.85rem; flex-shrink:0;"></i>
                        <p class="font-mono text-muted" style="font-size:0.75rem;">{{ $benefit['text'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
            {{-- Empty State — matches CartPage.tsx --}}
            <div style="min-height:60vh; display:flex; align-items:center; justify-content:center;" class="reveal">
                <div style="text-align:center;">
                    <div style="display:inline-flex; padding:2rem; border:2px solid var(--border); border-radius:var(--radius); margin-bottom:1.5rem;">
                        <i class="fas fa-shopping-bag" style="font-size:4rem; color:var(--muted-fg);"></i>
                    </div>
                    <h2 class="font-black uppercase" style="font-size:1.875rem; margin-bottom:0.75rem;">Your Cart is Empty</h2>
                    <p class="font-mono text-muted" style="margin-bottom:2rem; max-width:400px;">Add some professional IoT hardware to get started</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        Browse Products <i class="fas fa-chevron-right" style="font-size:0.8rem; margin-left:0.5rem;"></i>
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

@push('styles')
<style>
    .cart-grid { display:grid; grid-template-columns:1fr; gap:2rem; }
    @media(min-width:1024px) { .cart-grid { grid-template-columns:2fr 1fr; } }
    .delete-btn:hover { color:#FF0000 !important; border-color:#FF0000 !important; background:var(--muted); }
    .qty-btn:hover { border-color:#FF0000 !important; }
</style>
@endpush
@endsection
