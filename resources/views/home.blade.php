@extends('layouts.app')
@section('title', 'Home — NODE SHOP')

@section('content')
{{-- ═══ HERO SECTION — matches HomePage.tsx exactly ═══ --}}
<section style="position:relative; height:90vh; overflow:hidden; display:flex; align-items:center;">
    {{-- Background parallax layer --}}
    <div class="hero-bg" style="position:absolute; inset:0; z-index:0;">
        <div style="position:absolute; inset:0; background:linear-gradient(135deg, var(--bg) 0%, var(--bg) 70%, rgba(255,0,0,0.05) 100%);"></div>
        <div style="position:absolute; top:0; right:0; width:50%; height:100%; opacity:0.1;">
            <div style="position:absolute; top:5rem; right:5rem; width:24rem; height:24rem; border:1px solid var(--border); border-radius:var(--radius); transform:rotate(12deg);"></div>
            <div style="position:absolute; top:10rem; right:10rem; width:16rem; height:16rem; border:1px solid var(--border); border-radius:var(--radius); transform:rotate(-6deg);"></div>
            <div style="position:absolute; bottom:5rem; right:2.5rem; width:20rem; height:20rem; border:2px solid rgba(255,0,0,0.3); border-radius:var(--radius);"></div>
        </div>
    </div>

    <div class="container" style="position:relative; z-index:10;">
        <div style="max-width:56rem;">
            <div class="reveal">
                <span class="badge badge-outline" style="margin-bottom:1.5rem;">INDUSTRIAL IoT SOLUTIONS</span>
            </div>

            <div style="margin-bottom:2rem; overflow:hidden;">
                @foreach(['PROFESSIONAL', 'IoT', 'HARDWARE'] as $i => $word)
                <div style="overflow:hidden;">
                    <h1 class="hero-word" style="font-weight:900; font-size:clamp(3.75rem, 8vw, 9rem); line-height:0.95; margin-bottom:0.5rem; opacity:0; transform:translateY(100px);
                        {{ $word === 'IoT' ? 'color:#FF0000;' : '' }}">
                        {{ $word }}
                    </h1>
                </div>
                @endforeach
            </div>

            <p class="font-mono text-muted reveal" style="font-size:clamp(1rem, 1.5vw, 1.5rem); max-width:40rem; margin-bottom:2rem; line-height:1.6;">
                Premium microcontrollers, sensors, and development boards for professionals
            </p>

            <div class="reveal" style="display:flex; flex-wrap:wrap; gap:1rem;">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                    Browse Catalog <i class="fas fa-chevron-right" style="font-size:0.8rem; margin-left:0.5rem;"></i>
                </a>
                <a href="#categories" class="btn btn-outline btn-lg">View Specs</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══ CATEGORIES — py-24 to match reference ═══ --}}
<section id="categories" style="padding:6rem 0; border-top:1px solid var(--border);">
    <div class="container">
        <div class="reveal" style="text-align:center; margin-bottom:4rem;">
            <h2 class="font-black uppercase" style="font-size:clamp(2rem, 4vw, 3.75rem); margin-bottom:1rem;">
                PRODUCT <span class="text-primary">CATEGORIES</span>
            </h2>
            <p class="font-mono text-muted">Explore our curated selection of premium IoT components</p>
        </div>

        <div class="stagger-reveal" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:1.5rem;">
            @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="card card-hover" style="overflow:hidden; text-decoration:none; cursor:pointer; height:100%; display:flex; flex-direction:column;">
                <div style="position:relative; height:12rem; overflow:hidden;">
                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:4rem; background:var(--muted); transition:transform 0.6s;" class="cat-icon">
                        {{ $category->icon }}
                    </div>
                    <div style="position:absolute; inset:0; background:linear-gradient(to top, var(--bg) 0%, transparent 60%);"></div>
                    <div style="position:absolute; bottom:1rem; left:1rem; right:1rem;">
                        <h3 class="font-black" style="font-size:1.25rem; margin-bottom:0.25rem;">{{ strtoupper($category->name) }}</h3>
                        <p class="font-mono text-muted" style="font-size:0.85rem;">{{ $category->icon }} {{ $category->products_count ?? '' }} products</p>
                    </div>
                </div>
                <div class="card-body" style="display:flex; justify-content:space-between; align-items:center; padding:1.5rem; margin-top:auto;">
                    <span class="font-mono text-muted" style="font-size:0.85rem;">{{ $category->products_count ?? 0 }} products</span>
                    <i class="fas fa-chevron-right cat-arrow" style="font-size:0.85rem; transition:transform 0.3s;"></i>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ WHY CHOOSE US — bg-muted/30 ═══ --}}
<section style="padding:6rem 0; border-top:1px solid var(--border); background:color-mix(in srgb, var(--muted) 30%, transparent);">
    <div class="container">
        <div class="reveal" style="text-align:center; margin-bottom:4rem;">
            <h2 class="font-black uppercase" style="font-size:clamp(2rem, 4vw, 3.75rem); margin-bottom:1rem;">
                WHY CHOOSE <span class="text-primary">NODE SHOP</span>
            </h2>
        </div>

        @php
        $features = [
            ['icon' => 'fa-microchip', 'title' => 'Professional Grade', 'desc' => 'Industrial-quality components for production-ready applications'],
            ['icon' => 'fa-bolt', 'title' => 'High Performance', 'desc' => 'Optimized for speed, efficiency, and reliability'],
            ['icon' => 'fa-shield-alt', 'title' => 'Guaranteed Quality', 'desc' => 'Rigorous testing and quality control on every component'],
            ['icon' => 'fa-chart-line', 'title' => 'Latest Technology', 'desc' => 'Cutting-edge IoT hardware with the newest specifications'],
        ];
        @endphp

        <div class="stagger-reveal" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:2rem;">
            @foreach($features as $f)
            <div class="feature-item" style="text-align:center;">
                <div class="feature-icon-box" style="display:inline-flex; padding:1rem; border:2px solid var(--border); border-radius:var(--radius); margin-bottom:1.5rem; transition:border-color 0.3s;">
                    <i class="fas {{ $f['icon'] }} feature-icon" style="font-size:2rem; transition:color 0.3s;"></i>
                </div>
                <h3 class="font-black uppercase" style="font-size:1.25rem; margin-bottom:0.75rem;">{{ $f['title'] }}</h3>
                <p class="font-mono text-muted" style="font-size:0.85rem; line-height:1.6;">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ FEATURED PRODUCT — grid md:grid-cols-2, p-12 ═══ --}}
@if($featuredProducts->count() > 0)
@php $featured = $featuredProducts->first(); @endphp
<section style="padding:6rem 0; border-top:1px solid var(--border);">
    <div class="container">
        <div class="card card-2x reveal" style="overflow:hidden;">
            <div class="featured-grid">
                <div style="padding:3rem; display:flex; flex-direction:column; justify-content:center;">
                    <span class="badge badge-primary" style="width:fit-content; margin-bottom:1.5rem;">FEATURED</span>
                    <h2 class="font-black uppercase" style="font-size:clamp(2rem, 4vw, 3.25rem); margin-bottom:1rem; line-height:1;">
                        {{ strtoupper($featured->name) }}
                    </h2>
                    <p class="font-mono text-muted" style="margin-bottom:2rem; line-height:1.6;">
                        {{ Str::limit($featured->description, 200) }}
                    </p>
                    @if($featured->specifications)
                    <div style="margin-bottom:2rem; display:flex; flex-direction:column; gap:0.75rem;">
                        @foreach(array_slice(explode('|', $featured->specifications), 0, 3) as $spec)
                        <div style="display:flex; align-items:center; gap:0.75rem;">
                            <i class="fas fa-check" style="font-size:0.6rem; color:#FF0000; flex-shrink:0;"></i>
                            <span class="font-mono" style="font-size:0.85rem;">{{ trim($spec) }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <a href="{{ route('products.show', $featured->slug) }}" class="btn btn-primary" style="width:fit-content;">
                        View Details <i class="fas fa-chevron-right" style="font-size:0.75rem; margin-left:0.5rem;"></i>
                    </a>
                </div>
                <div style="min-height:24rem; background:linear-gradient(135deg, var(--muted), color-mix(in srgb, var(--muted) 50%, transparent)); display:flex; align-items:center; justify-content:center; position:relative; overflow:hidden;">
                    @if($featured->image_url)
                        <img src="{{ $featured->image_url }}" alt="{{ $featured->name }}" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <div style="display:flex; flex-direction:column; align-items:center; gap:1.5rem;">
                            <div style="padding:2rem; border:2px solid var(--border); border-radius:var(--radius);">
                                <i class="fas fa-microchip" style="font-size:4rem; color:var(--muted-fg);"></i>
                            </div>
                            <span class="font-mono text-muted uppercase" style="font-size:0.8rem; letter-spacing:0.1em;">{{ $featured->category->name ?? 'Hardware' }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ═══ NEW ARRIVALS ═══ --}}
<section style="padding:6rem 0; border-top:1px solid var(--border);">
    <div class="container">
        <div class="reveal" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
            <h2 class="font-black uppercase" style="font-size:clamp(1.5rem, 3vw, 2.5rem);">
                NEW <span class="text-primary">ARRIVALS</span>
            </h2>
            <a href="{{ route('products.index') }}" class="font-mono" style="font-size:0.85rem; color:#FF0000; display:flex; align-items:center; gap:0.5rem;">
                View All <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i>
            </a>
        </div>

        <div class="stagger-reveal" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:1.5rem;">
            @foreach($newProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

@push('styles')
<style>
    .featured-grid { display:grid; grid-template-columns:1fr; }
    @media(min-width:768px) { .featured-grid { grid-template-columns:1fr 1fr; } }
    @media(min-width:1024px) { .featured-grid div:first-child { padding:3rem; } }

    .card-hover:hover .cat-arrow { transform:translateX(4px); }
    .card-hover:hover .cat-icon { transform:scale(1.1); }

    .feature-item:hover .feature-icon-box { border-color:#FF0000; }
    .feature-item:hover .feature-icon { color:#FF0000; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            gsap.to('.hero-word', {
                opacity: 1, y: 0, duration: 0.8,
                stagger: 0.15, ease: "power4.out"
            });
        }, 1500);
    });
</script>
@endpush
@endsection
