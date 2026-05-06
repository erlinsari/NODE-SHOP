@extends('layouts.app')
@section('title', 'Product Catalog — NODE SHOP')

@section('content')
<section style="min-height:100vh; padding:2rem 0;">
    <div class="container">
        {{-- Header — matches ShopPage.tsx exactly --}}
        <div class="reveal" style="margin-bottom:2rem;">
            <h1 class="font-black uppercase" style="font-size:clamp(3rem, 6vw, 4.5rem); margin-bottom:0.5rem;">
                PRODUCT <span class="text-primary">CATALOG</span>
            </h1>
            <p class="font-mono text-muted">{{ $products->total() }} products available</p>
        </div>

        <div style="display:flex; gap:2rem;">
            {{-- ── Sidebar Filter — matches ShopPage.tsx ── --}}
            <aside id="filter-sidebar" class="filter-sidebar">
                <form method="GET" action="{{ route('products.index') }}">
                    <div style="width:16rem; border:2px solid var(--border); border-radius:var(--radius); padding:1.5rem; position:sticky; top:6rem; height:fit-content; max-height:calc(100vh - 8rem); overflow-y:auto; background:var(--card);">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
                            <h3 class="font-black uppercase" style="display:flex; align-items:center; gap:0.5rem;">
                                <i class="fas fa-sliders-h text-primary" style="font-size:0.85rem;"></i> Filters
                            </h3>
                            {{-- Mobile close --}}
                            <button type="button" class="filter-close-btn" onclick="document.getElementById('filter-sidebar').classList.remove('show')" style="display:none; background:none; border:none; color:var(--fg); cursor:pointer; font-size:1.25rem;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:1.5rem;">
                            {{-- Search --}}
                            <div>
                                <label class="form-label">Search</label>
                                <div class="form-input-icon">
                                    <i class="fas fa-search icon"></i>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="form-input" style="font-size:0.85rem;">
                                </div>
                            </div>

                            {{-- Category --}}
                            <div>
                                <label class="form-label">Category</label>
                                <div style="display:flex; flex-direction:column; gap:0.35rem;">
                                    <button type="submit" name="category" value=""
                                        class="font-mono filter-cat-btn {{ !request('category') ? 'active' : '' }}"
                                        style="width:100%; text-align:left; padding:0.5rem 0.75rem; border-radius:var(--radius); transition:all 0.2s; border:none; cursor:pointer; font-size:0.8rem;">
                                        All Categories
                                    </button>
                                    @foreach($categories as $cat)
                                    <button type="submit" name="category" value="{{ $cat->slug }}"
                                        class="font-mono filter-cat-btn {{ request('category') == $cat->slug ? 'active' : '' }}"
                                        style="width:100%; text-align:left; padding:0.5rem 0.75rem; border-radius:var(--radius); transition:all 0.2s; border:none; cursor:pointer; font-size:0.8rem;">
                                        {{ $cat->icon }} {{ $cat->name }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Condition --}}
                            <div>
                                <label class="form-label">Condition</label>
                                <select name="condition" class="form-input" style="font-size:0.85rem;">
                                    <option value="">All</option>
                                    <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
                                    <option value="preloved" {{ request('condition') == 'preloved' ? 'selected' : '' }}>Preloved</option>
                                </select>
                            </div>

                            {{-- Price Range --}}
                            <div>
                                <label class="form-label">Price Range</label>
                                <div style="display:flex; gap:0.5rem; align-items:center;">
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="form-input" style="font-size:0.8rem;">
                                    <span class="text-muted font-mono" style="font-size:0.8rem;">—</span>
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="form-input" style="font-size:0.8rem;">
                                </div>
                            </div>

                            {{-- Sort --}}
                            <div>
                                <label class="form-label">Sort By</label>
                                <select name="sort" class="form-input" style="font-size:0.85rem;">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search" style="margin-right:0.5rem; font-size:0.75rem;"></i> Apply Filters
                            </button>

                            @if(request()->hasAny(['category', 'condition', 'min_price', 'max_price', 'sort', 'search']))
                                <a href="{{ route('products.index') }}" class="btn btn-outline btn-block btn-sm">
                                    <i class="fas fa-times" style="margin-right:0.5rem; font-size:0.65rem;"></i> Reset All
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </aside>

            {{-- ── Products Grid — matches reference 3-col ── --}}
            <div style="flex:1;">
                {{-- Active Filters + Mobile toggle --}}
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:0.75rem;">
                    <div class="mobile-filter-btn">
                        <button class="btn btn-outline btn-sm" onclick="document.getElementById('filter-sidebar').classList.toggle('show')">
                            <i class="fas fa-filter" style="font-size:0.7rem; margin-right:0.5rem;"></i> Filters
                        </button>
                    </div>

                    {{-- Active filter badges --}}
                    @if(request()->hasAny(['category', 'condition', 'search']))
                    <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
                        @if(request('search'))
                            <span class="badge badge-outline" style="display:flex; align-items:center; gap:0.3rem;">
                                Search: "{{ request('search') }}"
                            </span>
                        @endif
                        @if(request('category'))
                            <span class="badge badge-primary">{{ request('category') }}</span>
                        @endif
                        @if(request('condition'))
                            <span class="badge badge-outline">{{ request('condition') }}</span>
                        @endif
                    </div>
                    @endif

                    <span class="font-mono text-muted" style="font-size:0.8rem;">
                        Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
                    </span>
                </div>

                @if($products->count() > 0)
                    <div class="stagger-reveal" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:1.5rem;">
                        @foreach($products as $product)
                            @include('components.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($products->hasPages())
                    <div style="margin-top:2rem; display:flex; justify-content:center;">
                        {{ $products->links() }}
                    </div>
                    @endif
                @else
                    {{-- Empty State --}}
                    <div style="min-height:50vh; display:flex; align-items:center; justify-content:center;">
                        <div style="text-align:center;">
                            <div style="display:inline-flex; padding:2rem; border:2px solid var(--border); border-radius:var(--radius); margin-bottom:1.5rem;">
                                <i class="fas fa-search" style="font-size:3rem; color:var(--muted-fg);"></i>
                            </div>
                            <h3 class="font-black uppercase" style="font-size:1.5rem; margin-bottom:0.75rem;">No Products Found</h3>
                            <p class="font-mono text-muted" style="margin-bottom:1.5rem;">Try adjusting your filters or search terms</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Reset Filters</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .filter-sidebar { display:none; }
    .filter-sidebar.show { 
        display:block; position:fixed; top:0; left:0; z-index:1001; 
        width:100%; height:100vh; background:var(--bg); padding:1rem; overflow-y:auto; 
    }
    .filter-sidebar.show .filter-close-btn { display:block !important; }
    @media(min-width:1024px) {
        .filter-sidebar { display:block !important; position:static; width:auto; height:auto; background:none; padding:0; }
        .mobile-filter-btn { display:none !important; }
    }

    .filter-cat-btn { background:transparent; color:var(--fg); }
    .filter-cat-btn:hover { background:var(--muted); }
    .filter-cat-btn.active { background:#FF0000 !important; color:#fff !important; }
</style>
@endpush
@endsection
