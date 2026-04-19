@extends('layouts.app')
@section('title', 'Home')

@section('content')
<!-- Hero Section (Carren/Beats Inspired) -->
<section style="position: relative; background: radial-gradient(circle at center, #1a1a1a 0%, #000 70%); border-bottom: 2px solid #222; text-align: center; padding: 6rem 1rem;">
    <div class="container" style="position: relative; z-index: 2;">
        <h2 style="font-size: 1rem; color: var(--primary); font-weight: 700; letter-spacing: 4px; margin-bottom: 1rem; text-transform: uppercase;">New Arrival</h2>
        <h1 style="font-size: 3.5rem; font-weight: 900; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 1.5rem;">HIGH PERFORMANCE<br/>IOT MODULES</h1>
        <p style="color: var(--text-secondary); max-width: 600px; margin: 0 auto 3rem; line-height: 1.8;">
            Experience precision and stability with our latest microcontrollers. Engineered for professional makers, offering ultra-low latency and maximum power efficiency exactly where you need it.
        </p>
        
        <div style="margin: 0 auto 3rem; width: 300px; height: 300px; position: relative;">
            <div style="position: absolute; top:50%; left:50%; transform: translate(-50%, -50%); width: 250px; height: 250px; background: rgba(229,9,20, 0.1); border-radius: 50%; box-shadow: 0 0 50px rgba(229,9,20,0.3); z-index: -1;"></div>
            <div style="font-size: 12rem; line-height: 300px; color: #FFF; text-shadow: 0 10px 30px rgba(0,0,0,0.5);">🎛️</div>
        </div>

        <div style="display: flex; gap: 2rem; justify-content: center; align-items: center;">
            <span style="font-size: 1.5rem; font-weight: 800; color: #FFF;">CODE : <span style="color: var(--primary);">ESP32</span></span>
            <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 12px 40px; border-radius: 2px;">Shop Now</a>
        </div>
    </div>
</section>

<!-- Categories (Slider feel) -->
<section style="background: #000; padding: 5rem 0;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #222; padding-bottom: 1rem; margin-bottom: 3rem;">
            <h2 style="font-size: 1.5rem; font-weight: 700; letter-spacing: 1px;"><i class="fas fa-layer-group" style="color:var(--primary); margin-right:10px;"></i> CATEGORIES</h2>
            <div style="display: flex; gap: 10px;">
                <button style="background:none; border:1px solid #333; color:#fff; width:40px; height:40px; cursor:pointer;"><i class="fas fa-chevron-left" style="color:var(--primary);"></i></button>
                <button style="background:none; border:1px solid #333; color:#fff; width:40px; height:40px; cursor:pointer;"><i class="fas fa-chevron-right" style="color:var(--primary);"></i></button>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 1.5rem;">
            @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}" style="text-decoration:none; text-align:center; group;">
                <div style="background: linear-gradient(180deg, #111 0%, #000 100%); padding: 3rem 1rem; border: 1px solid #1a1a1a; transition: all 0.3s; margin-bottom: 1rem;" 
                     onmouseover="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 10px 20px rgba(229,9,20,0.1)';" onmouseout="this.style.borderColor='#1a1a1a'; this.style.boxShadow='none';">
                    <div style="font-size: 3rem; margin-bottom: 1rem; color: #FFF;">{{ $category->icon }}</div>
                </div>
                <h3 style="color:#FFF; font-size: 0.9rem; font-weight: 600; text-transform: uppercase;">{{ $category->name }}</h3>
                <div style="color:var(--primary); font-size: 0.7rem; font-weight:700; margin-top:5px;">SEE ALL &gt;</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Grids (Beats Layout) -->
<section style="background: #000; padding: 4rem 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
            @foreach($featuredProducts->take(3) as $product)
            <div style="border: 1px solid #222; background: #050505;">
                <a href="{{ route('products.show', $product->slug) }}" style="display:block; text-decoration:none;">
                    <div style="height: 250px; display: flex; align-items: center; justify-content: center; position: relative; border-bottom: 1px solid #111;">
                        <div style="font-size: 5rem;">{{ $product->category->icon ?? '📦' }}</div>
                        <h3 style="position: absolute; bottom: 15px; right: 20px; font-size: 1.5rem; font-weight: 800; color: var(--primary);">{{ Str::limit($product->name, 15) }}</h3>
                    </div>
                </a>
                <div style="padding: 1.5rem;">
                    <p style="color: var(--text-secondary); font-size: 0.85rem; line-height: 1.6; margin-bottom: 1.5rem; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;">
                        High quality hardware specifically engineered for top performance. Ideal for long-lasting IoT projects that require precision, low latency, and absolute reliability under any condition.
                    </p>
                    <div style="text-align: right;">
                        <a href="{{ route('products.show', $product->slug) }}" style="color: #FFF; font-size: 0.9rem; font-weight: 600; text-decoration: none;">
                            more <i class="fas fa-chevron-circle-right" style="color: var(--primary); margin-left: 5px;"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- More Products List -->
<section style="background: #0a0a0a; border-top: 1px solid #1a1a1a; padding: 5rem 0;">
    <div class="container">
        <h2 style="font-size: 1.2rem; font-weight: 700; color: #FFF; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 2rem; padding-left: 1rem; border-left: 3px solid var(--primary);">ALL GEARS</h2>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
            @foreach($newProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
        
        <div style="text-align: center; margin-top: 4rem;">
            <a href="{{ route('products.index') }}" class="btn btn-outline" style="min-width: 200px;">Load More</a>
        </div>
    </div>
</section>
@endsection
