@extends('layouts.app')
@section('title', 'Beranda')
@section('meta_description', 'Node Shop — Marketplace IoT #1 di Indonesia. Jual beli mikrokontroler, sensor, module baru & preloved dengan harga terjangkau.')

@section('content')
<!-- Hero Section -->
<section style="padding: 4rem 2rem 3rem; background: var(--gradient-dark); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -150px; right: -150px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(108,92,231,0.15) 0%, transparent 70%); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -100px; left: -100px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(0,206,201,0.1) 0%, transparent 70%); border-radius: 50%;"></div>

    <div class="container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; position: relative; z-index: 1;">
        <div>
            <div style="display: inline-block; background: rgba(108,92,231,0.15); border: 1px solid rgba(108,92,231,0.3); border-radius: 20px; padding: 6px 16px; font-size: 0.75rem; color: var(--primary-light); font-weight: 600; margin-bottom: 1.2rem;">
                🚀 Marketplace IoT #1 Indonesia
            </div>
            <h1 style="font-size: 3rem; font-weight: 900; line-height: 1.15; margin-bottom: 1.2rem;">
                Semua Kebutuhan
                <span style="background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">IoT</span>
                dalam Satu Platform
            </h1>
            <p style="color: var(--text-secondary); font-size: 1.05rem; line-height: 1.7; margin-bottom: 2rem;">
                Temukan mikrokontroler, sensor, module, dan starter kit IoT dengan harga terjangkau. Tersedia produk <strong style="color: var(--secondary);">baru</strong> dan <strong style="color: var(--accent);">preloved</strong> terverifikasi.
            </p>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 14px 32px; font-size: 0.95rem;">
                    <i class="fas fa-shopping-bag"></i> Belanja Sekarang
                </a>
                <a href="{{ route('products.index', ['condition' => 'preloved']) }}" class="btn btn-outline" style="padding: 14px 32px; font-size: 0.95rem;">
                    ♻️ Lihat Preloved
                </a>
            </div>
            <div style="display: flex; gap: 2.5rem; margin-top: 2.5rem;">
                <div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary-light);">{{ $featuredProducts->count() > 0 ? '24+' : '0' }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary);">Produk IoT</div>
                </div>
                <div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--secondary);">{{ $categories->count() }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary);">Kategori</div>
                </div>
                <div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--accent);">100%</div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary);">Terverifikasi</div>
                </div>
            </div>
        </div>
        <div style="text-align: center;">
            <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.2); border-radius: 24px; padding: 2rem; position: relative;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    @foreach($featuredProducts->take(4) as $product)
                    <div style="background: var(--dark-surface); border-radius: 16px; padding: 1.2rem; text-align: center; border: 1px solid rgba(108,92,231,0.1); transition: all 0.3s;"
                         onmouseover="this.style.borderColor='rgba(108,92,231,0.4)'; this.style.transform='translateY(-4px)'"
                         onmouseout="this.style.borderColor='rgba(108,92,231,0.1)'; this.style.transform='translateY(0)'">
                        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $product->category->icon ?? '📦' }}</div>
                        <div style="font-size: 0.75rem; font-weight: 600; margin-bottom: 0.3rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Str::limit($product->name, 18) }}</div>
                        <div style="font-size: 0.7rem; color: var(--primary-light); font-weight: 700;">{{ $product->formatted_price }}</div>
                    </div>
                    @endforeach
                </div>
                <div style="position: absolute; top: -10px; right: -10px; background: var(--accent); color: white; padding: 6px 14px; border-radius: 10px; font-size: 0.7rem; font-weight: 700;">HOT 🔥</div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section style="padding: 3rem 2rem;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h2 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 0.5rem;">Kategori Produk</h2>
            <p style="color: var(--text-secondary); font-size: 0.9rem;">Temukan komponen IoT yang kamu butuhkan</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 1rem;">
            @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}"
               style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 16px; padding: 1.5rem 1rem; text-align: center; text-decoration: none; transition: all 0.3s;"
               onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-6px)'; this.style.boxShadow='0 10px 30px rgba(108,92,231,0.15)'"
               onmouseout="this.style.borderColor='rgba(108,92,231,0.1)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $category->icon }}</div>
                <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-primary);">{{ $category->name }}</div>
                <div style="font-size: 0.7rem; color: var(--text-secondary); margin-top: 0.3rem;">{{ $category->products->count() }} produk</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section style="padding: 2rem 2rem 3rem;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2 style="font-size: 1.8rem; font-weight: 800;">⭐ Produk Unggulan</h2>
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 0.3rem;">Pilihan terbaik untuk project IoT kamu</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline">Lihat Semua →</a>
        </div>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.2rem;">
            @foreach($featuredProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

<!-- New Products -->
<section style="padding: 2rem 2rem 3rem; background: var(--dark-card);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2 style="font-size: 1.8rem; font-weight: 800;">🆕 Produk Terbaru</h2>
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 0.3rem;">Baru ditambahkan ke katalog kami</p>
            </div>
            <a href="{{ route('products.index', ['sort' => 'latest']) }}" class="btn btn-sm btn-outline">Lihat Semua →</a>
        </div>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.2rem;">
            @foreach($newProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

<!-- Preloved Section -->
@if($prelovedProducts->count() > 0)
<section style="padding: 3rem 2rem;">
    <div class="container">
        <div style="background: linear-gradient(135deg, rgba(253,121,168,0.1), rgba(108,92,231,0.1)); border: 1px solid rgba(253,121,168,0.2); border-radius: 24px; padding: 2.5rem; display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; align-items: center;">
            <div>
                <div style="font-size: 0.75rem; color: var(--accent); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">♻️ Preloved & Verified</div>
                <h2 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 0.8rem;">Perangkat IoT Bekas Berkualitas</h2>
                <p style="color: var(--text-secondary); font-size: 0.85rem; line-height: 1.7; margin-bottom: 1.2rem;">Semua produk preloved telah diverifikasi dan ditest. Hemat budget hingga 50% tanpa mengorbankan kualitas!</p>
                <a href="{{ route('products.index', ['condition' => 'preloved']) }}" class="btn btn-primary btn-sm">Lihat Preloved →</a>
            </div>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
                @foreach($prelovedProducts as $product)
                <a href="{{ route('products.show', $product->slug) }}" style="background: var(--dark-card); border-radius: 14px; padding: 1rem; text-align: center; text-decoration: none; border: 1px solid rgba(253,121,168,0.15); transition: all 0.3s;"
                   onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="font-size: 1.8rem; margin-bottom: 0.5rem;">{{ $product->category->icon ?? '📦' }}</div>
                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.2rem;">{{ Str::limit($product->name, 20) }}</div>
                    <div style="font-size: 0.7rem; color: var(--accent); font-weight: 700;">{{ $product->formatted_price }}</div>
                    @if($product->original_price)
                    <div style="font-size: 0.6rem; color: var(--text-secondary); text-decoration: line-through;">Rp {{ number_format($product->original_price, 0, ',', '.') }}</div>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Why Node Shop -->
<section style="padding: 3rem 2rem 4rem;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.8rem; font-weight: 800;">Kenapa Pilih Node Shop?</h2>
            <p style="color: var(--text-secondary); font-size: 0.9rem;">Platform IoT terpercaya untuk semua level</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
            <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 20px; padding: 2rem; text-align: center;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, rgba(108,92,231,0.2), rgba(162,155,254,0.2)); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem;">🛡️</div>
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem;">Produk Terverifikasi</h3>
                <p style="color: var(--text-secondary); font-size: 0.8rem; line-height: 1.6;">Semua produk, termasuk preloved, dicek kualitasnya sebelum dijual</p>
            </div>
            <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 20px; padding: 2rem; text-align: center;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, rgba(0,206,201,0.2), rgba(0,184,148,0.2)); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem;">💰</div>
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem;">Harga Terjangkau</h3>
                <p style="color: var(--text-secondary); font-size: 0.8rem; line-height: 1.6;">Harga kompetitif untuk mahasiswa dan maker. Hemat lebih dengan preloved!</p>
            </div>
            <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 20px; padding: 2rem; text-align: center;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, rgba(253,121,168,0.2), rgba(162,155,254,0.2)); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem;">🚚</div>
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem;">Pengiriman Cepat</h3>
                <p style="color: var(--text-secondary); font-size: 0.8rem; line-height: 1.6;">Kirim ke seluruh Indonesia via JNE, J&T, SiCepat, dan Same-Day Delivery</p>
            </div>
            <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 20px; padding: 2rem; text-align: center;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, rgba(253,203,110,0.2), rgba(255,107,107,0.2)); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem;">💳</div>
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem;">Pembayaran Aman</h3>
                <p style="color: var(--text-secondary); font-size: 0.8rem; line-height: 1.6;">VA Bank, GoPay, OVO, DANA, QRIS — metode pembayaran lengkap dan aman</p>
            </div>
        </div>
    </div>
</section>
@endsection
