@extends('layouts.app')
@section('title', 'My Orders — NODE SHOP')

@section('content')
<section style="min-height:100vh; padding:2rem 0;">
    <div class="container" style="max-width:1000px;">
        {{-- Header — matches OrdersPage.tsx exactly --}}
        <div class="reveal" style="margin-bottom:2rem;">
            <h1 class="font-black uppercase" style="font-size:clamp(2.5rem, 6vw, 4.5rem); margin-bottom:0.5rem;">
                Order <span class="text-primary">History</span>
            </h1>
            <p class="font-mono text-muted">
                @if($orders->total() > 0)
                    {{ $orders->total() }} total orders
                @else
                    Track and manage your orders
                @endif
            </p>
        </div>

        @if($orders->count() > 0)
        <div class="stagger-reveal" style="display:flex; flex-direction:column; gap:1rem;">
            @foreach($orders as $order)
            @php
                $statusColors = [
                    'pending' => 'badge-warning',
                    'processing' => 'badge-primary',
                    'shipped' => 'badge-primary',
                    'completed' => 'badge-success',
                    'delivered' => 'badge-success',
                    'cancelled' => 'badge-danger',
                ];
                $statusIcons = [
                    'pending' => 'fa-clock',
                    'processing' => 'fa-cog fa-spin',
                    'shipped' => 'fa-truck',
                    'completed' => 'fa-check-circle',
                    'delivered' => 'fa-check-double',
                    'cancelled' => 'fa-times-circle',
                ];
            @endphp
            @php
                $canPayNow = in_array($order->payment_status, ['unpaid', 'pending'], true)
                    && !in_array($order->status, ['cancelled', 'delivered'], true)
                    && !empty($order->snap_token);
            @endphp
            <div class="card card-hover card-2x order-card">
                {{-- Order Header — Clickable --}}
                <div class="card-header order-header" style="cursor:pointer; transition:background 0.2s;"
                     onclick="this.parentElement.querySelector('.order-details').classList.toggle('active'); this.querySelector('.chevron').classList.toggle('rotated');"
                     onmouseover="this.style.background='color-mix(in srgb, var(--muted) 30%, transparent)'" onmouseout="this.style.background='transparent'">
                    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
                        <div style="display:flex; align-items:center; gap:1rem;">
                            {{-- Status Icon --}}
                            <div style="padding:0.75rem; border:2px solid var(--border); border-radius:var(--radius);">
                                <i class="fas {{ $statusIcons[$order->status] ?? 'fa-clock' }} text-primary" style="font-size:1.25rem;"></i>
                            </div>
                            <div>
                                <p class="font-mono font-black" style="font-size:1rem;">{{ $order->order_number }}</p>
                                <p class="font-mono text-muted" style="font-size:0.8rem;">
                                    {{ $order->created_at->format('d F Y') }} • {{ $order->items->count() }} items
                                </p>
                            </div>
                        </div>

                        <div style="display:flex; align-items:center; gap:1rem;">
                            <div style="text-align:right;">
                                <span class="font-black" style="font-size:1.1rem;">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                <p class="font-mono text-muted" style="font-size:0.68rem; margin-top:0.25rem; text-transform:uppercase;">
                                    Payment: {{ strtoupper($order->payment_status ?? 'unpaid') }}
                                </p>
                            </div>
                            <span class="badge {{ $statusColors[$order->status] ?? 'badge-secondary' }}">
                                {{ strtoupper($order->status) }}
                            </span>
                            <i class="fas fa-chevron-down chevron" style="font-size:0.85rem; transition:transform 0.3s;"></i>
                        </div>
                    </div>
                </div>

                {{-- Order Details — Expandable --}}
                <div class="order-details" style="display:none;">
                    <div class="card-body" style="border-top:2px solid var(--border);">
                        {{-- Items List --}}
                        <p class="font-mono text-muted uppercase" style="font-size:0.75rem; letter-spacing:0.05em; margin-bottom:0.75rem;">Order Items</p>
                        <div style="display:flex; flex-direction:column; gap:0.75rem; margin-bottom:1.5rem;">
                            @foreach($order->items as $item)
                            <div style="display:flex; align-items:center; gap:1rem; padding:0.75rem; background:color-mix(in srgb, var(--muted) 20%, transparent); border:1px solid var(--border); border-radius:var(--radius);">
                                <div style="width:40px; height:40px; background:var(--muted); border-radius:var(--radius); display:flex; align-items:center; justify-content:center; font-size:1.25rem; flex-shrink:0;">
                                    {{ $item->product->category->icon ?? '📦' }}
                                </div>
                                <div style="flex:1; min-width:0;">
                                    <p class="font-bold" style="font-size:0.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $item->product_name }}</p>
                                    <p class="font-mono text-muted" style="font-size:0.7rem;">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <span class="font-mono font-black" style="font-size:0.85rem; flex-shrink:0;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>

                        {{-- Order Info Grid --}}
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem;" class="order-info-grid">
                            <div>
                                <p class="font-mono text-muted uppercase" style="font-size:0.75rem; letter-spacing:0.05em; margin-bottom:0.75rem;">Order Summary</p>
                                <div class="font-mono" style="font-size:0.85rem; display:flex; flex-direction:column; gap:0.5rem;">
                                    <div style="display:flex; justify-content:space-between;">
                                        <span class="text-muted">Subtotal</span>
                                        <span class="font-black">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                    <div style="display:flex; justify-content:space-between;">
                                        <span class="text-muted">Shipping</span>
                                        <span class="font-black">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                                    </div>
                                    <div style="height:1px; background:var(--border);"></div>
                                    <div style="display:flex; justify-content:space-between;">
                                        <span class="font-black uppercase">Total</span>
                                        <span class="font-black text-primary" style="font-size:1.1rem;">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="font-mono text-muted uppercase" style="font-size:0.75rem; letter-spacing:0.05em; margin-bottom:0.75rem;">Shipping Details</p>
                                <div class="font-mono" style="font-size:0.85rem; line-height:1.8;">
                                    <p class="font-bold">{{ $order->shipping_name }}</p>
                                    <p class="text-muted">{{ $order->shipping_phone }}</p>
                                    <p class="text-muted">{{ $order->shipping_address }}, {{ $order->shipping_city }}</p>
                                    @if($order->tracking_number)
                                    <div style="margin-top:0.5rem; padding:0.5rem 0.75rem; background:color-mix(in srgb, var(--muted) 30%, transparent); border:1px solid var(--border); border-radius:var(--radius); display:inline-block;">
                                        <span class="text-muted" style="font-size:0.7rem;">Tracking:</span>
                                        <span class="font-black">{{ $order->tracking_number }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Action Link --}}
                        <div style="margin-top:1.5rem; padding-top:1rem; border-top:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap;">
                            <div style="display:flex; align-items:center; gap:0.6rem; flex-wrap:wrap;">
                                <a href="{{ route('orders.show', $order) }}" class="font-mono" style="font-size:0.8rem; color:#FF0000; display:flex; align-items:center; gap:0.5rem;">
                                    View Full Details <i class="fas fa-chevron-right" style="font-size:0.65rem;"></i>
                                </a>
                                @if($canPayNow)
                                    <a href="{{ route('orders.payment', $order) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-credit-card"></i> Bayar Sekarang
                                    </a>
                                @endif
                            </div>
                            <span class="font-mono text-muted" style="font-size:0.7rem;">{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top:2rem;">{{ $orders->links() }}</div>
        @else
            {{-- Empty State — matches OrdersPage.tsx --}}
            <div style="min-height:60vh; display:flex; align-items:center; justify-content:center;" class="reveal">
                <div style="text-align:center;">
                    <div style="display:inline-flex; padding:2rem; border:2px solid var(--border); border-radius:var(--radius); margin-bottom:1.5rem;">
                        <i class="fas fa-box-open" style="font-size:4rem; color:var(--muted-fg);"></i>
                    </div>
                    <h2 class="font-black uppercase" style="font-size:1.875rem; margin-bottom:1rem;">No Orders Yet</h2>
                    <p class="font-mono text-muted" style="margin-bottom:2rem; max-width:400px;">Start shopping for premium IoT hardware to see your order history here</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        Browse Products <i class="fas fa-chevron-right" style="font-size:0.8rem; margin-left:0.5rem;"></i>
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

@push('styles')
<style>
    .order-details.active { display: block !important; }
    .chevron.rotated { transform: rotate(180deg); }
    @media(max-width: 768px) {
        .order-info-grid { grid-template-columns: 1fr !important; }
    }
</style>
@endpush
@endsection
