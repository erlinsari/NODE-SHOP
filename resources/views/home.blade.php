@extends('layouts.app')
@section('title', 'Home — NODE SHOP')

@section('content')
{{-- ═══ HERO SECTION — Product Background Display ═══ --}}
<section
    class="home-hero-product"
    style="--hero-image: url('{{ asset('images/background1.jpeg') }}');"
>
    {{-- Background visual layer --}}
    <div class="home-hero-bg">
        <div class="home-hero-grid"></div>
        <div class="home-hero-shape shape-one"></div>
        <div class="home-hero-shape shape-two"></div>
        <div class="home-hero-shape shape-three"></div>
    </div>

    <div class="container home-hero-container">
        <div class="home-hero-content">
            <div class="reveal">
                <span class="badge badge-outline home-hero-badge">
                    INDUSTRIAL IoT SOLUTIONS
                </span>
            </div>

            <div class="home-hero-title-wrap">
                @foreach(['PROFESSIONAL', 'IoT', 'HARDWARE'] as $word)
                    <div style="overflow:hidden;">
                        <h1
                            class="hero-word home-hero-word"
                            style="{{ $word === 'IoT' ? 'color:#FF0000;' : '' }}"
                        >
                            {{ $word }}
                        </h1>
                    </div>
                @endforeach
            </div>

            <p class="font-mono text-muted reveal home-hero-description">
                Premium microcontrollers, sensors, and development boards for professionals
            </p>

            <div class="reveal home-hero-actions">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                    Browse Catalog
                    <i class="fas fa-chevron-right" style="font-size:0.8rem; margin-left:0.5rem;"></i>
                </a>

                <a href="#categories" class="btn btn-outline btn-lg">
                    View Specs
                </a>
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
                            <h3 class="font-black" style="font-size:1.25rem; margin-bottom:0.25rem;">
                                {{ strtoupper($category->name) }}
                            </h3>
                            <p class="font-mono text-muted" style="font-size:0.85rem;">
                                {{ $category->icon }} {{ $category->products_count ?? '' }} products
                            </p>
                        </div>
                    </div>

                    <div class="card-body" style="display:flex; justify-content:space-between; align-items:center; padding:1.5rem; margin-top:auto;">
                        <span class="font-mono text-muted" style="font-size:0.85rem;">
                            {{ $category->products_count ?? 0 }} products
                        </span>
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

                    <h3 class="font-black uppercase" style="font-size:1.25rem; margin-bottom:0.75rem;">
                        {{ $f['title'] }}
                    </h3>

                    <p class="font-mono text-muted" style="font-size:0.85rem; line-height:1.6;">
                        {{ $f['desc'] }}
                    </p>
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
                                    <span class="font-mono" style="font-size:0.85rem;">
                                        {{ trim($spec) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <a href="{{ route('products.show', $featured->slug) }}" class="btn btn-primary" style="width:fit-content;">
                        View Details
                        <i class="fas fa-chevron-right" style="font-size:0.75rem; margin-left:0.5rem;"></i>
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

                            <span class="font-mono text-muted uppercase" style="font-size:0.8rem; letter-spacing:0.1em;">
                                {{ $featured->category->name ?? 'Hardware' }}
                            </span>
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
                View All
                <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i>
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
    /* ═══ HOME HERO WITH AI GENERATED PRODUCT BACKGROUND ═══ */

    .home-hero-product {
        position: relative;
        min-height: calc(100vh - 64px);
        overflow: hidden;
        display: flex;
        align-items: center;
        border-bottom: 1px solid var(--border);
        background:
            radial-gradient(circle at 78% 46%, rgba(255, 0, 0, 0.08), transparent 30%),
            radial-gradient(circle at 16% 18%, rgba(255, 255, 255, 0.96), transparent 30%),
            linear-gradient(135deg, #f7f5f1 0%, #f0ede8 48%, #f8eeee 100%);
    }

    html.dark .home-hero-product {
        background:
            radial-gradient(circle at 78% 46%, rgba(255, 0, 0, 0.16), transparent 32%),
            radial-gradient(circle at 16% 18%, rgba(255, 255, 255, 0.05), transparent 30%),
            linear-gradient(135deg, #11100f 0%, #171514 48%, #241110 100%);
    }

    .home-hero-product::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 2;
        pointer-events: none;
        background-image: var(--hero-image);
        background-repeat: no-repeat;
        background-size: min(68vw, 1180px) auto;
        background-position: right center;
        opacity: 0.98;
        filter: drop-shadow(0 40px 84px rgba(0, 0, 0, 0.13));

        mask-image: linear-gradient(
            to right,
            transparent 0%,
            rgba(0, 0, 0, 0.04) 28%,
            rgba(0, 0, 0, 0.75) 48%,
            black 100%
        );
        -webkit-mask-image: linear-gradient(
            to right,
            transparent 0%,
            rgba(0, 0, 0, 0.04) 28%,
            rgba(0, 0, 0, 0.75) 48%,
            black 100%
        );
    }

    html.dark .home-hero-product::after {
        opacity: 0.78;
        filter:
            drop-shadow(0 42px 92px rgba(0, 0, 0, 0.32))
            drop-shadow(0 18px 44px rgba(255, 0, 0, 0.08));
    }

    .home-hero-bg {
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
    }

    .home-hero-grid {
        position: absolute;
        inset: 0;
        opacity: 0.45;
        background-image:
            linear-gradient(rgba(0, 0, 0, 0.025) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 0, 0, 0.025) 1px, transparent 1px);
        background-size: 48px 48px;
    }

    html.dark .home-hero-grid {
        opacity: 0.55;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.035) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.035) 1px, transparent 1px);
    }

    .home-hero-shape {
        position: absolute;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        opacity: 0.35;
    }

    .shape-one {
        top: 5rem;
        right: 7rem;
        width: 25rem;
        height: 25rem;
        transform: rotate(12deg);
    }

    .shape-two {
        top: 11rem;
        right: 14rem;
        width: 16rem;
        height: 16rem;
        transform: rotate(-7deg);
    }

    .shape-three {
        bottom: 4rem;
        right: 4rem;
        width: 22rem;
        height: 22rem;
        border-color: rgba(255, 0, 0, 0.24);
    }

    .home-hero-container {
        position: relative;
        z-index: 5;
    }

    .home-hero-content {
        max-width: 56rem;
        position: relative;
        z-index: 6;
        padding: 7rem 0;
    }

    .home-hero-badge {
        margin-bottom: 1.5rem;
        background: rgba(255, 255, 255, 0.56);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    html.dark .home-hero-badge {
        background: rgba(255, 255, 255, 0.06);
    }

    .home-hero-title-wrap {
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .home-hero-word {
        font-weight: 900;
        font-size: clamp(3.75rem, 8vw, 9rem);
        line-height: 0.95;
        margin-bottom: 0.5rem;
        opacity: 0;
        transform: translateY(100px);
        letter-spacing: -0.07em;
    }

    .home-hero-description {
        font-size: clamp(1rem, 1.5vw, 1.5rem);
        max-width: 40rem;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .home-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .featured-grid {
        display: grid;
        grid-template-columns: 1fr;
    }

    @media(min-width:768px) {
        .featured-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media(min-width:1024px) {
        .featured-grid div:first-child {
            padding: 3rem;
        }
    }

    .card-hover:hover .cat-arrow {
        transform: translateX(4px);
    }

    .card-hover:hover .cat-icon {
        transform: scale(1.1);
    }

    .feature-item:hover .feature-icon-box {
        border-color: #FF0000;
    }

    .feature-item:hover .feature-icon {
        color: #FF0000;
    }

    @media(max-width: 1100px) {
        .home-hero-product::after {
            background-size: 86vw auto;
            background-position: right bottom;
            opacity: 0.32;

            mask-image: linear-gradient(to bottom, transparent 0%, black 34%);
            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 34%);
        }

        .home-hero-content {
            padding: 5rem 0;
        }
    }

    @media(max-width: 640px) {
        .home-hero-product {
            min-height: auto;
        }

        .home-hero-product::after {
            background-size: 125vw auto;
            background-position: center bottom;
            opacity: 0.2;
        }

        .home-hero-content {
            padding: 4rem 0 13rem;
        }

        .home-hero-word {
            font-size: clamp(3.2rem, 17vw, 5rem);
        }

        .home-hero-actions {
            align-items: stretch;
        }

        .home-hero-actions .btn {
            width: 100%;
        }

        .shape-one,
        .shape-two,
        .shape-three {
            opacity: 0.16;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            gsap.to('.hero-word', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.15,
                ease: "power4.out"
            });
        }, 1500);
    });
</script>
@endpush
@endsection