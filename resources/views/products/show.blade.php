@extends('layouts.app')
@section('title', $product->name . ' — NODE SHOP')

@section('content')
<section style="min-height:100vh; padding:2rem 0;">
    <div class="container">
        {{-- Back Button --}}
        <a href="{{ route('products.index') }}" class="reveal" style="display:inline-flex; align-items:center; gap:0.5rem; margin-bottom:2rem; font-family:'JetBrains Mono'; text-transform:uppercase; font-size:0.85rem; transition:color 0.2s;"
           onmouseover="this.style.color='#FF0000'" onmouseout="this.style.color='var(--fg)'">
            <i class="fas fa-chevron-left" style="font-size:0.7rem;"></i> Back to Shop
        </a>

        {{-- 2-column grid — matches ProductDetailPage.tsx --}}
        <div class="product-detail-grid">
            {{-- Left: Sticky Image + Info Cards --}}
            <div class="reveal" style="position:sticky; top:6rem; height:fit-content;">
                <div class="card card-2x" style="overflow:hidden;">
                    <div style="position:relative; aspect-ratio:1; background:var(--muted); cursor:zoom-in; overflow:hidden;">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                 style="width:100%; height:100%; object-fit:cover; transition:transform 0.5s;" 
                                 onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"
                                 id="product-main-image">
                        @else
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:8rem;">{{ $product->category->icon ?? '📦' }}</div>
                        @endif
                        
                        {{-- Badges --}}
                        @if($product->condition === 'preloved')
                            <span class="badge badge-outline" style="position:absolute; top:1rem; left:1rem; background:var(--bg);">PRELOVED</span>
                        @endif
                        @if($product->discount_percent > 0)
                            <span class="badge badge-primary" style="position:absolute; top:1rem; left:{{ $product->condition === 'preloved' ? '7rem' : '1rem' }};">-{{ $product->discount_percent }}%</span>
                        @endif
                        <div style="position:absolute; top:1rem; right:1rem;">
                            <span class="badge {{ $product->stock > 50 ? 'badge-success' : ($product->stock > 0 ? 'badge-warning' : 'badge-danger') }}">
                                {{ $product->stock > 0 ? 'IN STOCK: ' . $product->stock : 'OUT OF STOCK' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Info Cards 3-col --}}
                <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:0.75rem; margin-top:0.75rem;">
                    <div class="card" style="padding:1rem; display:flex; align-items:center; gap:0.75rem;">
                        <i class="fas fa-shipping-fast text-primary" style="font-size:1.1rem;"></i>
                        <div>
                            <p class="font-mono text-muted" style="font-size:0.65rem;">Free Shipping</p>
                            <p class="font-black" style="font-size:0.7rem;">Orders > 500K</p>
                        </div>
                    </div>
                    <div class="card" style="padding:1rem; display:flex; align-items:center; gap:0.75rem;">
                        <i class="fas fa-shield-alt text-primary" style="font-size:1.1rem;"></i>
                        <div>
                            <p class="font-mono text-muted" style="font-size:0.65rem;">Warranty</p>
                            <p class="font-black" style="font-size:0.7rem;">12 Months</p>
                        </div>
                    </div>
                    <div class="card" style="padding:1rem; display:flex; align-items:center; gap:0.75rem;">
                        <i class="fas fa-bolt text-primary" style="font-size:1.1rem;"></i>
                        <div>
                            <p class="font-mono text-muted" style="font-size:0.65rem;">Delivery</p>
                            <p class="font-black" style="font-size:0.7rem;">1-3 Days</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Product Info --}}
            <div class="reveal">
                {{-- Category Badge --}}
                <span class="badge badge-outline" style="margin-bottom:1rem;">{{ $product->category->name ?? 'HARDWARE' }}</span>

                {{-- Title --}}
                <h1 class="font-black uppercase" style="font-size:clamp(2rem, 5vw, 3.75rem); margin-bottom:1rem; line-height:1;">
                    {{ $product->name }}
                </h1>

                {{-- Rating --}}
                @if($product->reviews->count() > 0)
                <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
                    <div style="display:flex; gap:2px;">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star" style="font-size:0.85rem; color:{{ $i <= round($product->average_rating) ? '#FF0000' : 'var(--border)' }};"></i>
                        @endfor
                    </div>
                    <span class="font-mono text-muted" style="font-size:0.8rem;">{{ number_format($product->average_rating, 1) }} ({{ $product->reviews->count() }} reviews)</span>
                </div>
                @endif

                {{-- Price --}}
                <div style="display:flex; align-items:baseline; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap;">
                    <span class="font-black" style="font-size:3rem; line-height:1;">{{ $product->formatted_price }}</span>
                    @if($product->original_price && $product->original_price > $product->price)
                        <span class="font-mono text-muted line-through" style="font-size:1.1rem;">
                            Rp {{ number_format($product->original_price, 0, ',', '.') }}
                        </span>
                        <span class="badge badge-primary">SAVE {{ $product->discount_percent }}%</span>
                    @endif
                </div>

                {{-- Description --}}
                <p class="font-mono text-muted" style="font-size:1rem; margin-bottom:2rem; line-height:1.8;">
                    {{ $product->description }}
                </p>

                {{-- Technical Specifications --}}
                @if($product->specifications)
                <div class="card card-2x" style="margin-bottom:2rem;">
                    <div class="card-header" style="border-bottom-width:2px;">
                        <h3 class="font-black uppercase" style="display:flex; align-items:center; gap:0.5rem;">
                            <i class="fas fa-microchip text-primary"></i> Technical Specifications
                        </h3>
                    </div>
                    <div class="card-body">
                        <div style="display:flex; flex-direction:column;">
                            @foreach(explode('|', $product->specifications) as $spec)
                                @php $parts = explode(':', $spec); @endphp
                                <div style="display:flex; justify-content:space-between; align-items:flex-start; padding:0.75rem 0; {{ !$loop->last ? 'border-bottom:1px solid var(--border);' : '' }}">
                                    <span class="font-mono text-muted uppercase" style="font-size:0.8rem; letter-spacing:0.05em;">{{ trim($parts[0] ?? '') }}</span>
                                    <span class="font-mono font-bold" style="font-size:0.85rem; text-align:right; max-width:60%;">{{ trim($parts[1] ?? '') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                {{-- Quantity + Add to Cart --}}
                @if($product->stock > 0)
                <div class="card card-2x" style="margin-bottom:2rem;">
                    <div class="card-body">
                        <form method="POST" action="{{ route('cart.store') }}" id="add-to-cart-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
                                <div>
                                    <p class="font-mono text-muted" style="font-size:0.85rem; margin-bottom:0.5rem;">Quantity</p>
                                    <div style="display:flex; align-items:center; gap:1rem;">
                                        <button type="button" onclick="changeQty(-1)"
                                                class="qty-btn" style="width:44px; height:44px; border:2px solid var(--border); border-radius:var(--radius); background:none; color:var(--fg); cursor:pointer; display:flex; align-items:center; justify-content:center; transition:border-color 0.2s;">
                                            <i class="fas fa-minus" style="font-size:0.7rem;"></i>
                                        </button>
                                        <span id="qty-display" class="font-black" style="font-size:1.75rem; width:3rem; text-align:center;">1</span>
                                        <input type="hidden" name="quantity" id="qty" value="1">
                                        <button type="button" onclick="changeQty(1)"
                                                class="qty-btn" style="width:44px; height:44px; border:2px solid var(--border); border-radius:var(--radius); background:none; color:var(--fg); cursor:pointer; display:flex; align-items:center; justify-content:center; transition:border-color 0.2s;">
                                            <i class="fas fa-plus" style="font-size:0.7rem;"></i>
                                        </button>
                                    </div>
                                </div>
                                <div style="text-align:right;">
                                    <p class="font-mono text-muted" style="font-size:0.85rem; margin-bottom:0.5rem;">Subtotal</p>
                                    <p class="font-black text-primary" id="subtotal" style="font-size:2rem;">{{ $product->formatted_price }}</p>
                                </div>
                            </div>

                            {{-- Two buttons --}}
                            <div style="display:flex; gap:1rem;">
                                <button type="submit" class="btn btn-primary btn-lg" style="flex:1;">
                                    <i class="fas fa-shopping-cart" style="margin-right:0.5rem;"></i> Add to Cart
                                </button>
                                <button type="submit" class="btn btn-outline btn-lg" style="flex:1;" formaction="{{ route('cart.store') }}">
                                    <i class="fas fa-bolt" style="margin-right:0.5rem;"></i> Buy Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <div class="card card-2x" style="margin-bottom:2rem;">
                    <div class="card-body" style="text-align:center; padding:2rem;">
                        <i class="fas fa-box-open text-muted" style="font-size:2rem; margin-bottom:0.75rem;"></i>
                        <p class="font-black uppercase" style="margin-bottom:0.5rem;">Out of Stock</p>
                        <p class="font-mono text-muted" style="font-size:0.85rem;">This product is currently unavailable</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
        <div style="margin-top:4rem; border-top:2px solid var(--border); padding-top:4rem;">
            <div class="reveal" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
                <h2 class="font-black uppercase" style="font-size:clamp(1.5rem, 3vw, 2.5rem);">
                    RELATED <span class="text-primary">PRODUCTS</span>
                </h2>
                <a href="{{ route('products.index', ['category' => $product->category->slug ?? '']) }}" class="font-mono" style="font-size:0.85rem; color:#FF0000; display:flex; align-items:center; gap:0.5rem;">
                    View All <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i>
                </a>
            </div>
            <div class="stagger-reveal" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:1.5rem;">
                @foreach($relatedProducts as $related)
                    @include('components.product-card', ['product' => $related])
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@push('styles')
<style>
    .product-detail-grid { display:grid; grid-template-columns:1fr; gap:3rem; }
    @media(min-width:1024px) { .product-detail-grid { grid-template-columns:1fr 1fr; } }
    .qty-btn:hover { border-color:#FF0000 !important; }
</style>
@endpush

@push('scripts')
<script>
const productPrice = {{ $product->price }};
const maxStock = {{ $product->stock }};

function changeQty(delta) {
    const qtyInput = document.getElementById('qty');
    const display = document.getElementById('qty-display');
    let val = parseInt(qtyInput.value) + delta;
    val = Math.max(1, Math.min(maxStock, val));
    qtyInput.value = val;
    display.textContent = val;
    updateSubtotal();
}

function updateSubtotal() {
    const qty = parseInt(document.getElementById('qty').value) || 1;
    const formatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(productPrice * qty);
    document.getElementById('subtotal').textContent = formatted;
}
</script>
@endpush
@endsection
