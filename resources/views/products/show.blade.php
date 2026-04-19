@extends('layouts.app')
@section('title', $product->name)

@section('content')
<section style="padding: 2rem;">
    <div class="container">
        <!-- Breadcrumb -->
        <div style="margin-bottom: 1.5rem; font-size: 0.8rem; color: var(--text-secondary);">
            <a href="{{ url('/') }}" style="color: var(--text-secondary); text-decoration: none;">Beranda</a> /
            <a href="{{ route('products.index') }}" style="color: var(--text-secondary); text-decoration: none;">Produk</a> /
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" style="color: var(--text-secondary); text-decoration: none;">{{ $product->category->name }}</a> /
            <span style="color: var(--primary-light);">{{ Str::limit($product->name, 30) }}</span>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem;">
            <!-- Product Image -->
            <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 24px; padding: 3rem; text-align: center; display: flex; align-items: center; justify-content: center; min-height: 400px; position: relative;">
                <div style="font-size: 8rem;">{{ $product->category->icon ?? '📦' }}</div>
                @if($product->condition === 'preloved')
                    <span style="position: absolute; top: 16px; left: 16px; background: var(--accent); color: white; padding: 6px 16px; border-radius: 10px; font-size: 0.75rem; font-weight: 700;">♻️ PRELOVED {{ $product->preloved_grade ? '— Grade ' . $product->preloved_grade : '' }}</span>
                @endif
                @if($product->discount_percent > 0)
                    <span style="position: absolute; top: 16px; right: 16px; background: var(--danger); color: white; padding: 6px 16px; border-radius: 10px; font-size: 0.75rem; font-weight: 700;">-{{ $product->discount_percent }}%</span>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <div style="font-size: 0.75rem; color: var(--primary-light); font-weight: 600; margin-bottom: 0.5rem;">{{ $product->category->name }}</div>
                <h1 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 0.8rem; line-height: 1.3;">{{ $product->name }}</h1>

                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; gap: 3px; color: #FDCB6E;">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star" style="font-size: 0.85rem; opacity: {{ $i <= round($product->average_rating) ? '1' : '0.3' }};"></i>
                        @endfor
                    </div>
                    <span style="font-size: 0.8rem; color: var(--text-secondary);">({{ $product->reviews->count() }} ulasan)</span>
                    <span style="font-size: 0.8rem; color: var(--text-secondary);"><i class="fas fa-eye"></i> {{ $product->views_count }}x dilihat</span>
                </div>

                <div style="background: var(--dark-card); border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem; border: 1px solid rgba(108,92,231,0.1);">
                    <div style="display: flex; align-items: baseline; gap: 10px; margin-bottom: 0.5rem;">
                        <span style="font-size: 2rem; font-weight: 900; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ $product->formatted_price }}</span>
                        @if($product->original_price)
                            <span style="font-size: 1rem; color: var(--text-secondary); text-decoration: line-through;">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                            <span style="background: rgba(255,107,107,0.15); color: var(--danger); padding: 3px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 700;">Hemat {{ $product->discount_percent }}%</span>
                        @endif
                    </div>
                    <div style="font-size: 0.8rem; color: {{ $product->stock > 0 ? 'var(--success)' : 'var(--danger)' }};">
                        <i class="fas fa-{{ $product->stock > 0 ? 'check-circle' : 'times-circle' }}"></i>
                        {{ $product->stock > 0 ? 'Stok tersedia: ' . $product->stock . ' unit' : 'Stok habis' }}
                    </div>
                </div>

                @if($product->stock > 0)
                <form method="POST" action="{{ route('cart.store') }}" style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1.5rem;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div style="display: flex; align-items: center; background: var(--dark-surface); border-radius: 12px; border: 1px solid rgba(108,92,231,0.2);">
                        <button type="button" onclick="let q=this.parentNode.querySelector('input');q.value=Math.max(1,q.value-1)" style="background: none; border: none; color: var(--text-secondary); padding: 10px 14px; cursor: pointer; font-size: 1rem;">−</button>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 50px; text-align: center; background: transparent; border: none; color: var(--text-primary); font-size: 0.9rem; font-weight: 600; outline: none;">
                        <button type="button" onclick="let q=this.parentNode.querySelector('input');q.value=Math.min({{ $product->stock }},parseInt(q.value)+1)" style="background: none; border: none; color: var(--text-secondary); padding: 10px 14px; cursor: pointer; font-size: 1rem;">+</button>
                    </div>
                    <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center; padding: 14px;">
                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                    </button>
                </form>
                @endif

                <!-- Description -->
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 0.8rem;">📋 Deskripsi</h3>
                    <p style="color: var(--text-secondary); font-size: 0.85rem; line-height: 1.8;">{{ $product->description }}</p>
                </div>

                @if($product->specifications)
                <div style="background: var(--dark-card); border-radius: 14px; padding: 1.2rem; border: 1px solid rgba(108,92,231,0.1);">
                    <h3 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 0.8rem;">⚙️ Spesifikasi</h3>
                    <div style="display: grid; gap: 0.4rem;">
                        @foreach(explode('|', $product->specifications) as $spec)
                        <div style="display: flex; font-size: 0.8rem; padding: 6px 0; border-bottom: 1px solid rgba(108,92,231,0.05);">
                            @php $parts = explode(':', $spec); @endphp
                            <span style="color: var(--text-secondary); min-width: 140px; font-weight: 600;">{{ trim($parts[0] ?? '') }}</span>
                            <span style="color: var(--text-primary);">{{ trim($parts[1] ?? '') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div style="margin-top: 3rem;">
            <h2 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 1.2rem;">Produk Terkait</h2>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.2rem;">
                @foreach($relatedProducts as $related)
                    @include('components.product-card', ['product' => $related])
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
