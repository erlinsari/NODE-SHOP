@extends('layouts.app')

@section('title', 'NODE SHOP — PREMIUM IOT GEAR')

@section('content')
<div class="evolve-hero" style="padding: 10vh 2vw; position: relative; min-height: 80vh; display: flex; flex-direction: column; justify-content: center;">
    <div class="hero-text-wrapper" style="overflow: hidden;">
        <h1 style="font-size: 17vw; line-height: 0.8; letter-spacing: -0.06em; margin: 0; white-space: nowrap; transform-origin: left bottom;">
            WE BUILD
        </h1>
    </div>
    <div class="hero-text-wrapper" style="overflow: hidden; display: flex; align-items: center; gap: 2vw;">
        <h1 style="font-size: 17vw; line-height: 0.8; letter-spacing: -0.06em; margin: 0; color: #333; transform-origin: left bottom;">
            IOT
        </h1>
        <h1 style="font-size: 17vw; line-height: 0.8; letter-spacing: -0.06em; margin: 0; transform-origin: left bottom;">
            GEAR
        </h1>
    </div>
    <div class="hero-text-wrapper" style="overflow: hidden;">
        <h1 style="font-size: 17vw; line-height: 0.8; letter-spacing: -0.06em; margin: 0; transform-origin: left bottom;">
            <span style="font-style: italic; color: #FFF; font-family: 'Times New Roman', serif; font-weight: normal;">THAT</span> PERFORMS
        </h1>
    </div>

</div>

<div class="evolve-project-list" style="margin-top: 15vh; border-top: 1px solid #222;">
    <!-- Table Header -->
    <div style="display: grid; grid-template-columns: 3fr 2fr 1fr 3fr; padding: 1.5rem 2vw; border-bottom: 1px solid #222; font-size: 0.75rem; color: #666; text-transform: uppercase; letter-spacing: 2px;">
        <div>Partner / Item</div>
        <div>Platform / Type</div>
        <div>ID</div>
        <div>Specs / Features</div>
    </div>
    
    @foreach($featuredProducts->take(6) as $index => $product)
    <a href="{{ route('products.show', $product->slug) }}" class="evolve-list-item" data-cursor-label="VIEW" style="display: grid; grid-template-columns: 3fr 2fr 1fr 3fr; padding: 4rem 2vw; border-bottom: 1px solid #222; text-decoration: none; color: #FFF; transition: background 0.4s; align-items: center; position: relative;">
        <div style="font-size: 3vw; font-weight: 800; letter-spacing: -1px; text-transform: uppercase; z-index: 2; mix-blend-mode: difference;">{{ $product->name }}</div>
        <div style="font-size: 1rem; color: #888; font-weight: 500; text-transform: uppercase; z-index: 2; mix-blend-mode: difference;">{{ $product->category->name ?? 'IOT MODULE' }}</div>
        <div style="font-size: 0.9rem; color: #666; font-family: monospace; z-index: 2; mix-blend-mode: difference;">( {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }} )</div>
        <div style="font-size: 0.9rem; color: #CCC; font-weight: 500; line-height: 1.4; z-index: 2; mix-blend-mode: difference;">Microcontroller, Advanced Processing, Developer Kit</div>
        
        <div class="hover-bg" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #111; transform: scaleY(0); transform-origin: bottom; transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1); z-index: 1;"></div>
        
        <!-- Magnetic Image Reveal -->
        <div class="magnetic-img-wrap" style="position: absolute; top: 50%; left: 50%; width: 300px; height: 350px; background: #222; z-index: 0; pointer-events: none; opacity: 0; transform: translate(-50%, -50%) scale(0.8); overflow: hidden; display: flex; align-items: center; justify-content: center;">
            <div style="font-size: 5rem;">{{ $product->category->icon ?? '⚙️' }}</div>
        </div>
    </a>
    @endforeach
    
    <div style="padding: 4rem 2vw; display: flex; justify-content: flex-end;">
        <a href="{{ route('products.index') }}" data-cursor-label="SHOP" class="evolve-btn" style="text-decoration: none; color: #000; background: #FFF; padding: 1.5rem 4rem; font-weight: 900; font-size: 1.5rem; text-transform: uppercase; border-radius: 50px; transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
            VIEW ALL CATALOG <i class="fas fa-arrow-right" style="margin-left: 15px; transform: rotate(-45deg);"></i>
        </a>
    </div>
</div>

<div class="marquee-section" style="border-top: 1px solid #222; border-bottom: 1px solid #222; padding: 2rem 0; overflow: hidden; white-space: nowrap; margin-top: 5vh; margin-bottom: 10vh; background: #050505;">
    <div class="marquee-inner" style="display: inline-block; animation: marquee 25s linear infinite;">
        <h2 style="font-size: 5vw; margin: 0; display: inline-block; color: #333; font-weight: 900;">
            NODE SHOP — PREMIUM IOT GEAR — BUILT FOR DEVELOPERS — FAST SHIPPING — 
            NODE SHOP — PREMIUM IOT GEAR — BUILT FOR DEVELOPERS — FAST SHIPPING — 
        </h2>
    </div>
</div>

<style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    
    .evolve-btn:hover {
        transform: scale(1.05);
        background: #CCC;
    }
    
    .evolve-list-item:hover .hover-bg {
        transform: scaleY(1);
    }
</style>

<script>
    // Called by the preloader when it finishes
    function initHeroAnimation() {
        gsap.set(".hero-text-wrapper h1", { yPercent: 120, rotateZ: 3, opacity: 1 });
        
        gsap.to(".hero-text-wrapper h1", {
            yPercent: 0,
            rotateZ: 0,
            duration: 1.4,
            stagger: 0.15,
            ease: "power4.out"
        });

        gsap.from(".evolve-list-item", {
            y: 100,
            opacity: 0,
            duration: 1.2,
            stagger: 0.1,
            ease: "power3.out",
            scrollTrigger: {
                trigger: ".evolve-project-list",
                start: "top 80%"
            }
        });
        
        // Magnetic Image Logic for Project List
        const listItems = document.querySelectorAll('.evolve-list-item');
        listItems.forEach(item => {
            const imgWrap = item.querySelector('.magnetic-img-wrap');
            let xTo = gsap.quickTo(imgWrap, "x", {duration: 0.4, ease: "power3"}, "-50%");
            let yTo = gsap.quickTo(imgWrap, "y", {duration: 0.4, ease: "power3"}, "-50%");

            item.addEventListener('mouseenter', () => {
                gsap.to(imgWrap, {opacity: 1, scale: 1, duration: 0.4, ease: "power2.out"});
            });

            item.addEventListener('mouseleave', () => {
                gsap.to(imgWrap, {opacity: 0, scale: 0.8, duration: 0.4, ease: "power2.out"});
            });

            item.addEventListener('mousemove', (e) => {
                const rect = item.getBoundingClientRect();
                const relX = e.clientX - rect.left;
                const relY = e.clientY - rect.top;
                
                // Keep image centered on cursor relative to the row
                gsap.to(imgWrap, {
                    x: relX - rect.width/2,
                    y: relY - rect.height/2,
                    duration: 0.6,
                    ease: "power3.out"
                });
            });
        });
    }
</script>
@endsection
