@extends('vertex.app')
@section('title', 'Vertex Theme - Home')

@section('content')
<style>
    .hero {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        text-align: center;
        overflow: hidden;
    }
    .hero h1 {
        font-size: 8vw;
        line-height: 0.85;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: -4px;
        z-index: 2;
        margin-bottom: 1rem;
    }
    .hero h3 {
        font-size: 1.5vw;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 4px;
        font-weight: 400;
        z-index: 2;
        margin-bottom: 3rem;
    }
    .hero .explore {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--text-primary);
        border: 1px solid rgba(255,255,255,0.2);
        padding: 1rem 3rem;
        border-radius: 50px;
        transition: all 0.3s ease;
        z-index: 2;
        backdrop-filter: blur(10px);
    }
    .hero .explore:hover {
        background: #fff;
        color: #000;
    }
    
    /* 3D background abstraction */
    .bg-sphere {
        position: absolute;
        width: 800px;
        height: 800px;
        background: radial-gradient(circle, rgba(229,9,20,0.1) 0%, transparent 60%);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
        filter: blur(40px);
        animation: pulse 10s infinite alternate ease-in-out;
    }

    @keyframes pulse {
        0% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
        100% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.5; }
    }

    .section-title {
        font-size: 4vw;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: -2px;
        margin-bottom: 4rem;
        line-height: 1;
    }

    /* Product Grid */
    .feature-grid { 
        display: grid; 
        grid-template-columns: repeat(3, 1fr); 
        gap: 1px; 
        background: #222; 
        border: 1px solid #222; 
    }
    .feature-grid .grid-item {
        background: #000;
        padding: 4rem 3rem;
        position: relative;
        transition: all 0.5s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 500px;
    }
    .feature-grid .grid-item:hover {
        background: #080808;
    }
    .feature-grid .icon {
        font-size: 5rem;
        margin-bottom: 2rem;
        transition: transform 0.5s ease;
    }
    .feature-grid .grid-item:hover .icon {
        transform: scale(1.1) translateY(-10px);
    }
    .feature-grid h2 {
        font-size: 1.5rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }
    .feature-grid .desc {
        color: var(--text-secondary);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }
    .feature-grid .action {
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 2px;
        color: var(--accent);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .all-projects-grid {
        display: grid; 
        grid-template-columns: repeat(4, 1fr); 
        gap: 2rem;
    }
    
    .project-card {
        display: block; 
        border: 1px solid #1a1a1a; 
        padding: 3rem 2rem; 
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); 
        background: #000;
        text-align: center;
        position: relative;
    }
    
    .project-card:hover {
        border-color: #333;
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
    
    .project-card .p-icon {
        font-size: 4rem; 
        margin-bottom: 2rem;
    }
    .project-card .p-cat {
        font-size: 0.65rem; 
        color: var(--text-secondary); 
        font-weight: 600; 
        text-transform: uppercase; 
        letter-spacing: 2px; 
        margin-bottom: 0.5rem;
    }
    .project-card .p-name {
        font-size: 1.1rem; 
        font-weight: 700; 
        white-space: nowrap; 
        overflow: hidden; 
        text-overflow: ellipsis; 
        margin-bottom: 1.5rem;
        text-transform: uppercase;
    }
    .project-card .p-price {
        font-size: 1rem; 
        font-weight: 400;
        color: var(--text-secondary);
    }
</style>

<div class="hero">
    <div class="bg-sphere"></div>
    <h1>DIGITAL TWIN<br/>HARDWARE</h1>
    <h3>Redefining E-Commerce UX</h3>
    <a href="#projects" class="explore">Inspect Catalog</a>
</div>

<div id="projects" style="padding: 10rem 0;">
    <div class="container">
        <h2 class="section-title">THE HARDWARE IS FLAT<br><span style="color:var(--text-secondary)">WE FIX THAT</span></h2>
        
        <div class="feature-grid">
            @foreach($featuredProducts->take(3) as $product)
            <div class="grid-item">
                <div>
                    <div class="icon">{{ $product->category->icon ?? '📦' }}</div>
                    <h2>{{ $product->name }}</h2>
                    <p class="desc">Engineered for immersive digital experiences and real-time visualization pipelines. High-performance architecture.</p>
                </div>
                <a href="{{ route('products.show', $product->slug) }}" class="action">
                    Inspect Case <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div style="padding: 10rem 0; background: #080808; border-top: 1px solid #111;">
    <div class="container">
        <h2 class="section-title" style="margin-bottom: 5rem; text-align: center;">ALL EXPERIENCES</h2>
        <div class="all-projects-grid">
            @foreach($newProducts as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="project-card">
                    <div class="p-icon">{{ $product->category->icon ?? '⚙️' }}</div>
                    <div class="p-cat">{{ $product->category->name ?? 'SYSTEM' }}</div>
                    <h3 class="p-name">{{ $product->name }}</h3>
                    <div class="p-price">{{ $product->formatted_price }}</div>
                </a>
            @endforeach
        </div>
    </div>
</div>

@endsection
