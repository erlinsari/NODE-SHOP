<a href="{{ route('products.show', $product->slug) }}" style="display: block; border: 1px solid #1a1a1a; padding: 2rem; transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); background: #000; text-align: center; position: relative;">
    <div style="font-size: 4rem; margin-bottom: 2rem; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.1) translateY(-10px)'" onmouseout="this.style.transform='scale(1) translateY(0)'">{{ $product->category->icon ?? '⚙️' }}</div>
    <div style="font-size: 0.65rem; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 0.5rem;">{{ $product->category->name ?? 'SYSTEM' }}</div>
    
    @if($product->condition === 'preloved')
        <span style="position: absolute; top: 10px; left: 10px; background: transparent; border: 1px solid var(--accent); color: var(--accent); padding: 2px 8px; font-size: 0.6rem; font-weight: 700; text-transform: uppercase;">PRELOVED</span>
    @endif
    @if($product->discount_percent > 0)
        <span style="position: absolute; top: 10px; right: 10px; background: var(--accent); color: #fff; padding: 2px 8px; font-size: 0.6rem; font-weight: 700;">-{{ $product->discount_percent }}%</span>
    @endif

    <h3 style="font-size: 1.1rem; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 1.5rem; text-transform: uppercase; color: #fff;">{{ $product->name }}</h3>
    <div style="font-size: 1rem; font-weight: 400; color: var(--text-secondary);">{{ $product->formatted_price }}</div>
</a>
