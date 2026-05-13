@extends('layouts.app')
@section('title', 'Order ' . $order->order_number . ' — NODE SHOP')

@section('content')
<section style="min-height:100vh; padding:2rem 0;">
    <div class="container" style="max-width:900px;">
        {{-- Back Button --}}
        <a href="{{ route('orders.index') }}" class="reveal" style="display:inline-flex; align-items:center; gap:0.5rem; margin-bottom:2rem; font-family:'JetBrains Mono'; text-transform:uppercase; font-size:0.85rem; transition:color 0.2s;"
           onmouseover="this.style.color='#FF0000'" onmouseout="this.style.color='var(--fg)'">
            <i class="fas fa-chevron-left" style="font-size:0.7rem;"></i> Back to Orders
        </a>

        {{-- Order Header --}}
        @php
            $statusColors = ['pending'=>'badge-warning','processing'=>'badge-primary','shipped'=>'badge-primary','completed'=>'badge-success','delivered'=>'badge-success','cancelled'=>'badge-danger'];
            $statusIcons = ['pending'=>'fa-clock','processing'=>'fa-cog','shipped'=>'fa-truck','completed'=>'fa-check-circle','delivered'=>'fa-check-double','cancelled'=>'fa-times-circle'];
        @endphp

        <div class="reveal" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; flex-wrap:wrap; gap:1rem;">
            <div>
                <h1 class="font-black uppercase" style="font-size:clamp(1.5rem, 3vw, 2.5rem); margin-bottom:0.25rem;">
                    Order <span class="text-primary">{{ $order->order_number }}</span>
                </h1>
                <p class="font-mono text-muted" style="font-size:0.85rem;">Placed on {{ $order->created_at->format('d F Y, H:i') }}</p>
            </div>
            <span id="order-status-badge" class="badge {{ $statusColors[$order->status] ?? 'badge-secondary' }}" style="font-size:0.85rem; padding:0.5rem 1.25rem;">
                <i class="fas {{ $statusIcons[$order->status] ?? 'fa-clock' }}" style="margin-right:0.4rem;"></i>
                {{ strtoupper($order->status) }}
            </span>
        </div>

        {{-- Order Timeline --}}
        <div class="card card-2x reveal" style="margin-bottom:1.5rem;">
            <div class="card-body" style="padding:1.5rem 2rem;">
                <div style="display:flex; align-items:center; justify-content:space-between;">
                    @php
                        $steps = [
                            ['label' => 'Ordered', 'icon' => 'fa-receipt', 'done' => true],
                            ['label' => 'Processing', 'icon' => 'fa-cog', 'done' => in_array($order->status, ['processing','shipped','completed','delivered'])],
                            ['label' => 'Shipped', 'icon' => 'fa-truck', 'done' => in_array($order->status, ['shipped','completed','delivered'])],
                            ['label' => 'Delivered', 'icon' => 'fa-check-circle', 'done' => in_array($order->status, ['completed','delivered'])],
                        ];
                    @endphp
                    @foreach($steps as $i => $step)
                    <div style="text-align:center; flex:1; position:relative;">
                        <div style="display:inline-flex; width:40px; height:40px; border-radius:50%; align-items:center; justify-content:center; {{ $step['done'] ? 'background:#FF0000; color:#fff; border:2px solid #FF0000;' : 'background:transparent; color:var(--muted-fg); border:2px solid var(--border);' }} margin-bottom:0.5rem; transition:all 0.3s;">
                            <i class="fas {{ $step['icon'] }}" style="font-size:0.85rem;"></i>
                        </div>
                        <p class="font-mono {{ $step['done'] ? 'font-black' : 'text-muted' }}" style="font-size:0.7rem; text-transform:uppercase;">{{ $step['label'] }}</p>
                        @if(!$loop->last)
                        <div style="position:absolute; top:20px; left:60%; right:-40%; height:2px; {{ $step['done'] ? 'background:#FF0000;' : 'background:var(--border);' }} z-index:0;"></div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Info Cards --}}
        <div class="stagger-reveal" style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; margin-bottom:1.5rem;" class="order-show-grid">
            {{-- Shipping Info --}}
            <div class="card card-2x">
                <div class="card-header" style="border-bottom-width:2px;">
                    <h3 class="font-black uppercase" style="font-size:0.85rem; display:flex; align-items:center; gap:0.5rem;">
                        <i class="fas fa-truck text-primary"></i> Shipping Information
                    </h3>
                </div>
                <div class="card-body font-mono" style="font-size:0.85rem; line-height:1.8;">
                    <p class="font-bold">{{ $order->shipping_name }}</p>
                    <p class="text-muted">{{ $order->shipping_phone }}</p>
                    <p class="text-muted">{{ $order->shipping_address }}</p>
                    <p class="text-muted">{{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p>
                    @if($order->tracking_number)
                    <div style="margin-top:0.75rem; padding:0.75rem; background:color-mix(in srgb, var(--muted) 30%, transparent); border:1px solid var(--border); border-radius:var(--radius);">
                        <span class="text-muted" style="font-size:0.75rem;">Tracking Number:</span>
                        <span class="font-black" style="font-size:1rem;">{{ $order->tracking_number }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Payment Info --}}
            <div class="card card-2x">
                <div class="card-header" style="border-bottom-width:2px;">
                    <h3 class="font-black uppercase" style="font-size:0.85rem; display:flex; align-items:center; gap:0.5rem;">
                        <i class="fas fa-credit-card text-primary"></i> Payment Information
                    </h3>
                </div>
                <div class="card-body font-mono" style="font-size:0.85rem; line-height:2;">
                    <div style="display:flex; justify-content:space-between;">
                        <span class="text-muted">Status</span>
                        <span class="badge {{ $order->payment_status == 'paid' ? 'badge-success' : 'badge-warning' }}">
                            {{ strtoupper($order->payment_status ?? 'UNPAID') }}
                        </span>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span class="text-muted">Method</span>
                        <span class="font-bold">{{ $order->payment_method ?? 'Transfer Bank' }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span class="text-muted">Order Date</span>
                        <span class="font-bold">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($order->paid_at)
                    <div style="display:flex; justify-content:space-between;">
                        <span class="text-muted">Paid Date</span>
                        <span class="font-bold">{{ $order->paid_at->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Order Items --}}
        <div class="card card-2x reveal">
            <div class="card-header" style="border-bottom-width:2px; display:flex; align-items:center; justify-content:space-between;">
                <h3 class="font-black uppercase" style="font-size:0.95rem;">Order Items</h3>
                <span class="badge badge-outline font-mono">{{ $order->items->count() }} ITEMS</span>
            </div>
            <div class="card-body">
                @foreach($order->items as $item)
                <div style="display:flex; align-items:center; gap:1rem; padding:1rem 0; {{ !$loop->last ? 'border-bottom:1px solid var(--border);' : '' }}">
                    <div style="width:56px; height:56px; background:var(--muted); border-radius:var(--radius); display:flex; align-items:center; justify-content:center; font-size:1.75rem; flex-shrink:0;">
                        {{ $item->product->category->icon ?? '📦' }}
                    </div>
                    <div style="flex:1; min-width:0;">
                        <p class="font-bold" style="font-size:0.9rem;">{{ $item->product_name }}</p>
                        <p class="font-mono text-muted" style="font-size:0.75rem;">
                            {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}
                        </p>
                    </div>
                    <span class="font-black" style="font-size:1rem;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
                @endforeach

                {{-- Totals --}}
                <div style="border-top:2px solid var(--border); margin-top:0.75rem; padding-top:1rem;">
                    <div class="font-mono" style="font-size:0.85rem;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem;">
                            <span class="text-muted">Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem;">
                            <span class="text-muted">Shipping</span>
                            <span>
                                @if($order->shipping_cost == 0)
                                    <span class="badge badge-success">FREE</span>
                                @else
                                    Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                @endif
                            </span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:1.25rem; padding-top:0.75rem; border-top:2px solid var(--border);">
                            <span class="font-black uppercase">Total</span>
                            <span class="font-black text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($order->notes)
        <div class="card reveal" style="margin-top:1.5rem;">
            <div class="card-body" style="display:flex; align-items:flex-start; gap:0.75rem;">
                <i class="fas fa-sticky-note text-primary" style="margin-top:0.2rem;"></i>
                <div>
                    <p class="font-mono text-muted uppercase" style="font-size:0.7rem; margin-bottom:0.25rem;">Notes</p>
                    <p class="font-mono" style="font-size:0.85rem;">{{ $order->notes }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
(() => {
    const orderUrl = @json(route('orders.show', $order));
    let lastSignature = @json([
        'status' => $order->status,
        'payment_status' => $order->payment_status ?? 'unpaid',
        'paid_at' => optional($order->paid_at)->toDateTimeString(),
        'updated_at' => optional($order->updated_at)->toDateTimeString(),
    ]);

    const refreshOrderState = async () => {
        try {
            const response = await fetch(orderUrl, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            });

            if (!response.ok) {
                return;
            }

            const payload = await response.json();
            const signature = JSON.stringify(payload);

            if (signature !== JSON.stringify(lastSignature)) {
                window.location.reload();
                return;
            }
        } catch (error) {
            console.error('Order live sync failed:', error);
        }
    };

    refreshOrderState();
    window.setInterval(refreshOrderState, 10000);
})();
</script>
@endpush

@push('styles')
<style>
    @media(max-width: 768px) {
        .order-show-grid { grid-template-columns: 1fr !important; }
    }
</style>
@endpush
@endsection
