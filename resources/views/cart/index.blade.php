@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<section style="padding: 2rem;">
    <div class="container" style="max-width: 900px;">
        <h1 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 1.5rem;"><i class="fas fa-shopping-cart" style="color: var(--primary-light);"></i> Keranjang Belanja</h1>

        @if($cartItems->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                @foreach($cartItems as $item)
                <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 16px; padding: 1.2rem; display: flex; align-items: center; gap: 1.2rem;">
                    <div style="width: 70px; height: 70px; background: var(--dark-surface); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 2rem; flex-shrink: 0;">
                        {{ $item->product->category->icon ?? '📦' }}
                    </div>
                    <div style="flex: 1;">
                        <a href="{{ route('products.show', $item->product->slug) }}" style="text-decoration: none; color: var(--text-primary); font-weight: 600; font-size: 0.9rem;">{{ $item->product->name }}</a>
                        <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.2rem;">
                            {{ $item->product->condition == 'preloved' ? '♻️ Preloved' : '🆕 Baru' }} • {{ $item->product->category->name }}
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <form method="POST" action="{{ route('cart.update', $item) }}" style="display: flex; align-items: center; background: var(--dark-surface); border-radius: 10px;">
                            @csrf @method('PATCH')
                            <button type="button" onclick="let q=this.parentNode.querySelector('input');q.value=Math.max(1,q.value-1);this.parentNode.submit()" style="background: none; border: none; color: var(--text-secondary); padding: 6px 10px; cursor: pointer;">−</button>
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width: 36px; text-align: center; background: transparent; border: none; color: var(--text-primary); font-size: 0.85rem; font-weight: 600; outline: none;" onchange="this.form.submit()">
                            <button type="button" onclick="let q=this.parentNode.querySelector('input');q.value=parseInt(q.value)+1;this.parentNode.submit()" style="background: none; border: none; color: var(--text-secondary); padding: 6px 10px; cursor: pointer;">+</button>
                        </form>
                    </div>
                    <div style="text-align: right; min-width: 120px;">
                        <div style="font-weight: 700; color: var(--primary-light);">Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}</div>
                        <div style="font-size: 0.7rem; color: var(--text-secondary);">@ Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                    </div>
                    <form method="POST" action="{{ route('cart.destroy', $item) }}">
                        @csrf @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: var(--danger); cursor: pointer; padding: 8px; font-size: 0.9rem;" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>

            <!-- Summary -->
            <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.15); border-radius: 18px; padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(108,92,231,0.1);">
                    <span style="font-size: 0.9rem; color: var(--text-secondary);">Total ({{ $cartItems->count() }} item)</span>
                    <span style="font-size: 1.5rem; font-weight: 900; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
                <a href="{{ route('orders.create') }}" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 0.95rem;">
                    <i class="fas fa-lock"></i> Checkout Sekarang
                </a>
            </div>
        @else
            <div style="text-align: center; padding: 4rem; background: var(--dark-card); border-radius: 18px;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🛒</div>
                <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem;">Keranjang Kosong</h3>
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Yuk mulai belanja komponen IoT favoritmu!</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Lihat Produk →</a>
            </div>
        @endif
    </div>
</section>
@endsection
