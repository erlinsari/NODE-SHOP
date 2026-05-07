@extends('vertex.app')
@section('title', 'Vertex Catalog')

@section('content')
<div style="padding: 10rem 0 5rem; text-align: center;">
    <h1 style="font-size: 6vw; font-weight: 900; text-transform: uppercase; letter-spacing: -3px; margin-bottom: 2rem;">THE HARDWARE<br>CATALOG</h1>
</div>

<div class="container" style="padding-bottom: 10rem;">
    <!-- Filters -->
    <div style="display: flex; gap: 2rem; margin-bottom: 4rem; justify-content: center; flex-wrap: wrap; border-bottom: 1px solid #1a1a1a; padding-bottom: 2rem;">
        <a href="{{ route('products.index') }}" style="color: {{ !request('category') ? '#fff' : 'var(--text-secondary)' }}; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">ALL CATALOG</a>
        @if(isset($categories))
            @foreach($categories as $cat)
                <a href="{{ route('products.index', ['category' => $cat->slug]) }}" style="color: {{ request('category') === $cat->slug ? '#fff' : 'var(--text-secondary)' }}; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">{{ $cat->name }}</a>
            @endforeach
        @endif
    </div>

    @if($products->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem;">
            @foreach($products as $product)
                @include('vertex.components.product-card', ['product' => $product])
            @endforeach
        </div>
        <div style="margin-top: 4rem;">
            {{ $products->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 5rem; border: 1px solid #1a1a1a;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📭</div>
            <h3 style="color: var(--text-secondary); text-transform: uppercase; letter-spacing: 2px;">NO EXPERIENCES FOUND</h3>
        </div>
    @endif
</div>
@endsection
