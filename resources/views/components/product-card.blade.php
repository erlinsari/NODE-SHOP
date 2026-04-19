{{-- Product Card Component --}}
<div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 18px; overflow: hidden; transition: all 0.3s; display: flex; flex-direction: column;"
     onmouseover="this.style.borderColor='rgba(108,92,231,0.3)'; this.style.transform='translateY(-6px)'; this.style.boxShadow='0 15px 40px rgba(108,92,231,0.12)'"
     onmouseout="this.style.borderColor='rgba(108,92,231,0.1)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">

    <a href="{{ route('products.show', $product->slug) }}" style="text-decoration: none; display: block; padding: 1.5rem; text-align: center; background: var(--dark-surface); position: relative;">
        <div style="font-size: 3.5rem; line-height: 1;">{{ $product->category->icon ?? '📦' }}</div>

        @if($product->condition === 'preloved')
            <span style="position: absolute; top: 10px; left: 10px; background: var(--accent); color: white; padding: 3px 10px; border-radius: 8px; font-size: 0.65rem; font-weight: 700;">PRELOVED</span>
        @endif
        @if($product->discount_percent > 0)
            <span style="position: absolute; top: 10px; right: 10px; background: var(--danger); color: white; padding: 3px 10px; border-radius: 8px; font-size: 0.65rem; font-weight: 700;">-{{ $product->discount_percent }}%</span>
        @endif
    </a>

    <div style="padding: 1rem 1.2rem 1.2rem; flex: 1; display: flex; flex-direction: column;">
        <a href="{{ route('products.show', $product->slug) }}" style="text-decoration: none;">
            <div style="font-size: 0.7rem; color: var(--primary-light); font-weight: 600; margin-bottom: 0.3rem;">{{ $product->category->name ?? '' }}</div>
            <h3 style="font-size: 0.85rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $product->name }}</h3>
        </a>

        <div style="margin-top: auto;">
            <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 0.5rem;">
                <span style="font-size: 1rem; font-weight: 800; color: var(--primary-light);">{{ $product->formatted_price }}</span>
                @if($product->original_price)
                    <span style="font-size: 0.7rem; color: var(--text-secondary); text-decoration: line-through;">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                @endif
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.7rem; color: {{ $product->stock > 0 ? 'var(--success)' : 'var(--danger)' }};">
                    <i class="fas fa-{{ $product->stock > 0 ? 'check-circle' : 'times-circle' }}"></i>
                    {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Habis' }}
                </span>
                @if($product->stock > 0)
                <form method="POST" action="{{ route('cart.store') }}" style="display: inline;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-primary btn-sm" style="padding: 5px 12px; font-size: 0.7rem;">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
