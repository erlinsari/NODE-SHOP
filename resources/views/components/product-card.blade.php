{{-- Product Card Component --}}
<div style="background: #000; border: 1px solid #1a1a1a; margin-bottom: 20px; transition: all 0.3s;"
     onmouseover="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 15px rgba(229,9,20,0.1)';"
     onmouseout="this.style.borderColor='#1a1a1a'; this.style.boxShadow='none';">

    <a href="{{ route('products.show', $product->slug) }}" style="text-decoration: none; display: block; padding: 2rem 1rem; text-align: center; background: radial-gradient(circle at center, #111 0%, #000 100%); position: relative; min-height: 140px;">
        <div style="font-size: 4rem; line-height: 1; color: #FFF;">{{ $product->category->icon ?? '📦' }}</div>

        @if($product->condition === 'preloved')
            <span style="position: absolute; top: 10px; left: 10px; background: transparent; border: 1px solid var(--primary); color: var(--primary); padding: 2px 8px; font-size: 0.6rem; font-weight: 700; text-transform: uppercase;">PRELOVED</span>
        @endif
        @if($product->discount_percent > 0)
            <span style="position: absolute; top: 10px; right: 10px; background: var(--primary); color: #fff; padding: 2px 8px; font-size: 0.6rem; font-weight: 700;">-{{ $product->discount_percent }}%</span>
        @endif
    </a>

    <div style="padding: 1.2rem; border-top: 1px solid #1a1a1a;">
        <a href="{{ route('products.show', $product->slug) }}" style="text-decoration: none;">
            <div style="font-size: 0.65rem; color: var(--text-secondary); font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 1px;">{{ $product->category->name ?? 'Hardware' }}</div>
            <h3 style="font-size: 0.9rem; font-weight: 700; color: #FFF; margin-bottom: 1rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 35px;">{{ $product->name }}</h3>
        </a>

        <div style="display: flex; justify-content: space-between; align-items: flex-end;">
            <div>
                @if($product->original_price)
                    <div style="font-size: 0.7rem; color: var(--text-secondary); text-decoration: line-through; margin-bottom: 2px;">Rp {{ number_format($product->original_price, 0, ',', '.') }}</div>
                @endif
                <div style="font-size: 1.1rem; font-weight: 900; color: #FFF;">{{ $product->formatted_price }}</div>
            </div>

            @if($product->stock > 0)
            <form method="POST" action="{{ route('cart.store') }}" style="display: inline;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" style="background: var(--primary); color: #fff; border: none; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.3s;"
                        onmouseover="this.style.background='var(--primary-dark)'" onmouseout="this.style.background='var(--primary)'">
                    <i class="fas fa-plus"></i>
                </button>
            </form>
            @else
                <span style="font-size: 0.7rem; color: #555; font-weight: 700; text-transform: uppercase;">OUT OF STOCK</span>
            @endif
        </div>
    </div>
</div>
