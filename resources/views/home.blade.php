@extends('layouts.app')
@section('title', 'Home — NODE SHOP')

@section('content')
{{-- ═══ HERO SECTION — Text Left + Product Image Right ═══ --}}
<section class="home-hero-section">
    <div class="container">
        <div class="home-hero-grid">
            {{-- Left: Text Content --}}
            <div class="home-hero-copy">
                <div class="reveal">
                    <span class="badge badge-outline home-hero-badge">
                        INDUSTRIAL IoT SOLUTIONS
                    </span>
                </div>

                <div class="home-hero-title-wrap">
                    @foreach(['PROFESSIONAL', 'IoT', 'HARDWARE'] as $word)
                        <div class="home-hero-line">
                            <h1 class="hero-word home-hero-title {{ $word === 'IoT' ? 'is-red' : '' }}">
                                {{ $word }}
                            </h1>
                        </div>
                    @endforeach
                </div>

                <p class="font-mono text-muted reveal home-hero-description">
                    Premium microcontrollers, sensors, and development boards for professionals.
                    Everything you need for cutting-edge IoT projects.
                </p>

                <div class="reveal home-hero-actions">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        Browse Catalog
                        <i class="fas fa-chevron-right" style="font-size:0.8rem; margin-left:0.5rem;"></i>
                    </a>

                    <a href="#categories" class="btn btn-outline btn-lg">
                        Learn More
                    </a>
                </div>
            </div>

            {{-- Right: Product Image --}}
            <div class="home-hero-visual">
                <div class="home-hero-image-card">
                    <img
                        src="{{ asset('storage/images/background1-.png') }}"
                        alt="IoT sensors and development boards"
                        class="home-hero-image"
                    >
                </div>
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
    /* ═══ HOME HERO — FIXED TEXT SIZE + IMAGE RIGHT ═══ */

    .home-hero-section {
        position: relative;
        min-height: calc(100vh - 64px);
        overflow: hidden;
        display: flex;
        align-items: center;
        border-bottom: 1px solid var(--border);
        background:
            radial-gradient(circle at 76% 45%, rgba(255, 0, 0, 0.08), transparent 32%),
            radial-gradient(circle at 14% 20%, rgba(255,255,255,0.88), transparent 30%),
            linear-gradient(135deg, #f7f5f1 0%, #f1eee9 48%, #f8eeee 100%);
    }

    html.dark .home-hero-section {
        background:
            radial-gradient(circle at 76% 45%, rgba(255, 0, 0, 0.16), transparent 34%),
            radial-gradient(circle at 14% 20%, rgba(255,255,255,0.05), transparent 30%),
            linear-gradient(135deg, #11100f 0%, #171514 48%, #241110 100%);
    }

    .home-hero-section::before {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        opacity: 0.42;
        background-image:
            linear-gradient(rgba(0,0,0,0.025) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0,0,0,0.025) 1px, transparent 1px);
        background-size: 48px 48px;
    }

    html.dark .home-hero-section::before {
        opacity: 0.55;
        background-image:
            linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
    }

    .home-hero-grid {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: minmax(580px, 0.95fr) minmax(520px, 1.05fr);
        gap: 2.5rem;
        align-items: center;
        min-height: calc(100vh - 64px);
    }

    .home-hero-copy {
        position: relative;
        z-index: 4;
        padding: 5.5rem 0;
        max-width: 720px;
        overflow: visible;
    }

    .home-hero-badge {
        margin-bottom: 1.4rem;
        background: rgba(255,255,255,0.56);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    html.dark .home-hero-badge {
        background: rgba(255,255,255,0.06);
    }

    .home-hero-title-wrap {
        margin-bottom: 2rem;
        overflow: visible;
    }

    .home-hero-line {
        overflow: visible;
    }

    .home-hero-title {
        font-weight: 900;
        font-size: clamp(4.2rem, 5.7vw, 6.85rem);
        line-height: 0.93;
        margin-bottom: 0.5rem;
        letter-spacing: -0.065em;
        white-space: nowrap;
        opacity: 0;
        transform: translateY(80px);
    }

    .home-hero-title.is-red {
        color: #FF0000;
    }

    .home-hero-description {
        font-size: clamp(0.95rem, 1.25vw, 1.25rem);
        max-width: 38rem;
        margin-bottom: 2rem;
        line-height: 1.7;
    }

    .home-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .home-hero-visual {
        position: relative;
        z-index: 3;
        min-height: 600px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        overflow: visible;
    }

    .home-hero-image-card {
        position: relative;
        width: min(48vw, 740px);
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
        transform: translateX(1.5rem);
    }

    .home-hero-image-card::before {
        content: "";
        position: absolute;
        inset: 8%;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 0, 0, 0.12), transparent 62%);
        filter: blur(16px);
        opacity: 0.8;
        z-index: 0;
    }

    .home-hero-image-card::after {
        content: "";
        position: absolute;
        inset: 3rem;
        border: 1px solid rgba(255, 0, 0, 0.14);
        border-radius: 2rem;
        transform: rotate(-8deg);
        z-index: 0;
    }

    .home-hero-image {
        position: relative;
        z-index: 2;
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        filter: drop-shadow(0 34px 70px rgba(0, 0, 0, 0.18));
        transform: scale(1.02);
        user-select: none;
        pointer-events: none;
    }

    html.dark .home-hero-image {
        filter:
            drop-shadow(0 40px 80px rgba(0, 0, 0, 0.42))
            drop-shadow(0 18px 42px rgba(255, 0, 0, 0.08));
    }

    @media (max-width: 1280px) {
        .home-hero-grid {
            grid-template-columns: minmax(500px, 0.95fr) minmax(440px, 1fr);
            gap: 1.5rem;
        }

        .home-hero-title {
            font-size: clamp(3.8rem, 5.3vw, 6rem);
            letter-spacing: -0.055em;
        }

        .home-hero-image-card {
            width: min(47vw, 660px);
            transform: translateX(0.5rem);
        }
    }

    @media (max-width: 1024px) {
        .home-hero-grid {
            grid-template-columns: 1fr;
            min-height: auto;
        }

        .home-hero-copy {
            padding: 5rem 0 1rem;
            max-width: 100%;
        }

        .home-hero-title {
            font-size: clamp(3.6rem, 10vw, 6rem);
        }

        .home-hero-visual {
            min-height: 420px;
            justify-content: center;
            margin-top: -2rem;
        }

        .home-hero-image-card {
            width: min(90vw, 640px);
            transform: none;
        }
    }

    @media (max-width: 640px) {
        .home-hero-section {
            min-height: auto;
        }

        .home-hero-copy {
            padding: 4rem 0 0;
        }

        .home-hero-title {
            font-size: clamp(3rem, 15vw, 4.8rem);
            line-height: 0.95;
            letter-spacing: -0.055em;
        }

        .home-hero-description {
            font-size: 0.95rem;
        }

        .home-hero-actions {
            align-items: stretch;
        }

        .home-hero-actions .btn {
            width: 100%;
        }

        .home-hero-visual {
            min-height: 330px;
            margin-top: -1rem;
        }

        .home-hero-image-card {
            width: 108vw;
            margin-left: -4vw;
        }
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
</style>
@endpush
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            if (window.gsap) {
                gsap.to('.hero-word', { opacity: 1, y: 0, duration: 0.8, stagger: 0.12, ease: 'power4.out' });
            } else {
                document.querySelectorAll('.hero-word').forEach(el => { el.style.opacity = 1; el.style.transform = 'none'; });
            }
        }, 300);
    });
</script>
@endpush
@endsection
