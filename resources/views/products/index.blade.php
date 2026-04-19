@extends('layouts.app')
@section('title', 'Katalog Produk')

@section('content')
<section style="padding: 2rem;">
    <div class="container">
        <div style="display: flex; gap: 2rem;">
            <!-- Sidebar Filter -->
            <aside style="width: 260px; flex-shrink: 0;">
                <form method="GET" action="{{ route('products.index') }}">
                    <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 18px; padding: 1.5rem; position: sticky; top: 88px;">
                        <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.2rem;"><i class="fas fa-filter" style="color: var(--primary-light);"></i> Filter</h3>

                        <!-- Category -->
                        <div style="margin-bottom: 1.2rem;">
                            <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); display: block; margin-bottom: 0.5rem;">Kategori</label>
                            <select name="category" style="width: 100%; background: var(--dark-surface); border: 1px solid rgba(108,92,231,0.2); border-radius: 10px; padding: 8px 12px; color: var(--text-primary); font-size: 0.8rem; outline: none;">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Condition -->
                        <div style="margin-bottom: 1.2rem;">
                            <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); display: block; margin-bottom: 0.5rem;">Kondisi</label>
                            <select name="condition" style="width: 100%; background: var(--dark-surface); border: 1px solid rgba(108,92,231,0.2); border-radius: 10px; padding: 8px 12px; color: var(--text-primary); font-size: 0.8rem; outline: none;">
                                <option value="">Semua</option>
                                <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>🆕 Baru</option>
                                <option value="preloved" {{ request('condition') == 'preloved' ? 'selected' : '' }}>♻️ Preloved</option>
                            </select>
                        </div>

                        <!-- Price -->
                        <div style="margin-bottom: 1.2rem;">
                            <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); display: block; margin-bottom: 0.5rem;">Harga (Rp)</label>
                            <div style="display: flex; gap: 8px;">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" style="width: 50%; background: var(--dark-surface); border: 1px solid rgba(108,92,231,0.2); border-radius: 10px; padding: 8px; color: var(--text-primary); font-size: 0.75rem; outline: none;">
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" style="width: 50%; background: var(--dark-surface); border: 1px solid rgba(108,92,231,0.2); border-radius: 10px; padding: 8px; color: var(--text-primary); font-size: 0.75rem; outline: none;">
                            </div>
                        </div>

                        <!-- Sort -->
                        <div style="margin-bottom: 1.2rem;">
                            <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); display: block; margin-bottom: 0.5rem;">Urutkan</label>
                            <select name="sort" style="width: 100%; background: var(--dark-surface); border: 1px solid rgba(108,92,231,0.2); border-radius: 10px; padding: 8px 12px; color: var(--text-primary); font-size: 0.8rem; outline: none;">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            </select>
                        </div>

                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                            <i class="fas fa-search"></i> Terapkan Filter
                        </button>

                        @if(request()->hasAny(['category', 'condition', 'min_price', 'max_price', 'sort', 'search']))
                            <a href="{{ route('products.index') }}" style="display: block; text-align: center; margin-top: 0.8rem; font-size: 0.8rem; color: var(--text-secondary); text-decoration: none;">
                                <i class="fas fa-times"></i> Reset Filter
                            </a>
                        @endif
                    </div>
                </form>
            </aside>

            <!-- Products Grid -->
            <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div>
                        <h1 style="font-size: 1.6rem; font-weight: 800;">
                            @if(request('search'))
                                Hasil Pencarian: "{{ request('search') }}"
                            @elseif(request('condition') == 'preloved')
                                ♻️ Produk Preloved
                            @else
                                Semua Produk
                            @endif
                        </h1>
                        <p style="color: var(--text-secondary); font-size: 0.85rem;">{{ $products->total() }} produk ditemukan</p>
                    </div>
                </div>

                @if($products->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.2rem;">
                        @foreach($products as $product)
                            @include('components.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    <div style="margin-top: 2rem; display: flex; justify-content: center;">
                        {{ $products->links() }}
                    </div>
                @else
                    <div style="text-align: center; padding: 4rem 2rem; background: var(--dark-card); border-radius: 18px;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
                        <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem;">Produk tidak ditemukan</h3>
                        <p style="color: var(--text-secondary); font-size: 0.85rem;">Coba ubah filter atau kata kunci pencarian</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
