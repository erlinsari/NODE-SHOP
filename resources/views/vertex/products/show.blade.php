@extends('vertex.app')
@section('title', $product->name)

@section('content')
<style>
    .show-bg {
        position: absolute;
        width: 100%;
        height: 100vh;
        top: 0; left: 0;
        background: radial-gradient(circle at 50% 30%, rgba(20,20,20,1) 0%, #000 70%);
        z-index: -1;
    }
    .spec-row {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid #1a1a1a;
        font-size: 0.85rem;
    }
    .spec-label {
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .btn-cart {
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
    }
    .btn-cart:hover {
        background: var(--accent);
        color: #fff;
    }
</style>

<div class="show-bg"></div>

<div class="container" style="padding-top: 10rem; padding-bottom: 5rem;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem;">
        
        <!-- Left: Huge Icon / Render -->
        <div style="display: flex; align-items: center; justify-content: center; border: 1px solid #1a1a1a; min-height: 60vh; position: relative;">
            <div style="font-size: 15rem; filter: drop-shadow(0 20px 30px rgba(255,255,255,0.05));">{{ $product->category->icon ?? '⚙️' }}</div>
            
            @if($product->condition === 'preloved')
                <div style="position: absolute; top: 2rem; left: 2rem; border: 1px solid var(--accent); color: var(--accent); padding: 0.5rem 1rem; font-size: 0.8rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1px;">
                    PRELOVED {{ $product->preloved_grade ? '- GRADE ' . $product->preloved_grade : '' }}
                </div>
            @endif
        </div>

        <!-- Right: Details -->
        <div style="display: flex; flex-direction: column; justify-content: center;">
            <div style="font-size: 0.8rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 3px; margin-bottom: 1rem;">
                <a href="{{ route('products.index') }}">CATALOG</a> / {{ $product->category->name }}
            </div>
            
            <h1 style="font-size: 4rem; font-weight: 900; text-transform: uppercase; line-height: 1; letter-spacing: -2px; margin-bottom: 1.5rem;">
                {{ $product->name }}
            </h1>
            
            <div style="display: flex; gap: 2rem; margin-bottom: 3rem; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                <span>★ {{ number_format($product->average_rating, 1) }} RATING</span>
                <span>{{ $product->views_count }} VIEWS</span>
                <span style="color: {{ $product->stock > 0 ? '#fff' : 'var(--accent)' }}">{{ $product->stock > 0 ? $product->stock . ' IN STOCK' : 'OUT OF STOCK' }}</span>
            </div>

            <div style="font-size: 2.5rem; font-weight: 900; margin-bottom: 2rem; color: #fff;">
                {{ $product->formatted_price }}
                @if($product->original_price)
                    <span style="font-size: 1.2rem; color: var(--text-secondary); text-decoration: line-through; margin-left: 1rem;">
                        Rp {{ number_format($product->original_price, 0, ',', '.') }}
                    </span>
                @endif
            </div>

            <div style="color: var(--text-secondary); line-height: 1.8; margin-bottom: 3rem; font-size: 0.95rem;">
                {{ $product->description }}
            </div>

            @if($product->specifications)
                <div style="margin-bottom: 3rem;">
                    @foreach(explode('|', $product->specifications) as $spec)
                        @php $parts = explode(':', $spec); @endphp
                        @if(isset($parts[0]) && isset($parts[1]))
                        <div class="spec-row">
                            <span class="spec-label">{{ trim($parts[0]) }}</span>
                            <span style="color: #fff; font-weight: 600;">{{ trim($parts[1]) }}</span>
                        </div>
                        @endif
                    @endforeach
                </div>
            @endif

            @if($product->stock > 0)
                <form method="POST" action="{{ route('cart.store') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div style="display: flex; gap: 1rem;">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 80px; background: transparent; border: 1px solid #333; color: #fff; text-align: center; font-size: 1.2rem; font-weight: 700; outline: none;">
                        <button type="submit" class="btn-cart">Add to Cart</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <!-- Related -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div style="margin-top: 10rem; border-top: 1px solid #1a1a1a; padding-top: 5rem;">
            <h2 style="font-size: 2rem; font-weight: 900; text-transform: uppercase; letter-spacing: -1px; margin-bottom: 3rem;">RELATED EXPERIENCES</h2>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem;">
                @foreach($relatedProducts as $related)
                    @include('vertex.components.product-card', ['product' => $related])
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
