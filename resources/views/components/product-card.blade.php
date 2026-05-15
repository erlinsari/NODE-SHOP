{{-- Product Card Component — Matching Reference Exactly --}}
<div class="product-card card card-hover" style="overflow:hidden; display:flex; flex-direction:column; height:100%; perspective:1000px; cursor:pointer;"
     onmousemove="tiltCard(event, this)" onmouseleave="resetTilt(this)">

    <div onclick="window.location='{{ route('products.show', $product->slug) }}'" style="position:relative; height:14rem; overflow:hidden; background:var(--muted);">
        @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                 style="width:100%; height:100%; object-fit:cover; transition: transform 0.6s ease;"
                 class="card-img">
        @else
            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:4rem;">
                {{ $product->category->icon ?? '📦' }}
            </div>
        @endif

        <div style="position:absolute; top:0.75rem; right:0.75rem;">
            <span class="badge {{ $product->stock > 50 ? 'badge-success' : ($product->stock > 0 ? 'badge-warning' : 'badge-danger') }}">
                {{ $product->stock > 0 ? 'Stock: ' . $product->stock : 'Out of Stock' }}
            </span>
        </div>

        @if($product->condition === 'preloved')
            <span class="badge badge-outline" style="position:absolute; top:0.75rem; left:0.75rem; background:var(--bg);">PRELOVED</span>
        @endif
        @if($product->discount_percent > 0)
            <span class="badge badge-primary" style="position:absolute; bottom:0.75rem; left:0.75rem;">-{{ $product->discount_percent }}%</span>
        @endif
    </div>

    <div class="card-body" style="flex:1; display:flex; flex-direction:column; padding:1.5rem;">
        <span class="badge badge-outline" style="width:fit-content; margin-bottom:0.75rem;">
            {{ $product->category->name ?? 'HARDWARE' }}
        </span>

        <h3 class="card-title font-black" style="font-size:1.1rem; margin-bottom:0.5rem; transition:color 0.2s; cursor:pointer;"
            onclick="window.location='{{ route('products.show', $product->slug) }}'">
            {{ $product->name }}
        </h3>

        <p class="font-mono text-muted line-clamp-2" style="font-size:0.85rem; margin-bottom:1rem; flex:1;">
            {{ Str::limit($product->description, 80) }}
        </p>

        <div style="display:flex; align-items:flex-end; justify-content:space-between; margin-top:auto;">
            <div>
                <p class="font-mono text-muted" style="font-size:0.75rem; margin-bottom:0.25rem;">Price</p>
                @if($product->original_price)
                    <p class="font-mono text-muted line-through" style="font-size:0.7rem;">
                        Rp {{ number_format($product->original_price, 0, ',', '.') }}
                    </p>
                @endif
                <p class="font-black" style="font-size:1.5rem;">{{ $product->formatted_price }}</p>
            </div>

            @if($product->stock > 0)
            <form method="POST" action="{{ route('cart.store') }}" onclick="event.stopPropagation();">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-primary btn-sm">
                    Add to Cart
                </button>
            </form>
            @else
                <span class="btn btn-primary btn-sm" style="opacity:0.5; cursor:not-allowed;">
                    Out of Stock
                </span>
            @endif
        </div>
    </div>
</div>

@once
@push('styles')
<style>
    .product-card:hover .card-img { transform: scale(1.1); }
    .product-card:hover .card-title { color: #FF0000; }
</style>
@endpush
@push('scripts')
<script>
function tiltCard(e, card) {
    const rect = card.getBoundingClientRect();
    const x = (e.clientX - rect.left - rect.width / 2) / rect.width;
    const y = (e.clientY - rect.top - rect.height / 2) / rect.height;
    card.style.transform = `perspective(1000px) rotateY(${x * 5}deg) rotateX(${-y * 5}deg)`;
    card.style.transition = 'none';
}
function resetTilt(card) {
    card.style.transition = 'transform 0.5s ease';
    card.style.transform = 'perspective(1000px) rotateY(0) rotateX(0)';
}
</script>
@endpush
@endonce
