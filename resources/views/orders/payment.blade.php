@extends('layouts.app')
@section('title', 'Payment ' . $order->order_number . ' — NODE SHOP')

@section('content')
<section style="min-height:100vh; padding:2rem 0;">
    <div class="container" style="max-width:980px;">
        @php
            $isPaid = $order->payment_status === 'paid';
            $canPayNow = in_array($order->payment_status, ['unpaid', 'pending'], true)
                && !in_array($order->status, ['cancelled', 'delivered'], true)
                && !empty($order->snap_token);
            $statusClass = $isPaid ? 'badge-success' : 'badge-warning';
        @endphp

        <a href="{{ route('orders.show', $order) }}" class="reveal" style="display:inline-flex; align-items:center; gap:0.5rem; margin-bottom:2rem; font-family:'JetBrains Mono'; text-transform:uppercase; font-size:0.85rem; transition:color 0.2s;"
           onmouseover="this.style.color='#FF0000'" onmouseout="this.style.color='var(--fg)'">
            <i class="fas fa-chevron-left" style="font-size:0.7rem;"></i> Back to Order Detail
        </a>

        <div class="reveal" style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:1rem; margin-bottom:1.5rem;">
            <div>
                <p class="font-mono text-muted" style="font-size:0.8rem; text-transform:uppercase; margin-bottom:0.4rem;">Payment Gateway</p>
                <h1 class="font-black uppercase" style="font-size:clamp(2rem, 4vw, 3rem); line-height:1;">
                    Midtrans <span class="text-primary">Checkout</span>
                </h1>
                <p class="font-mono text-muted" style="font-size:0.82rem; margin-top:0.6rem;">Order {{ $order->order_number }}</p>
            </div>
            <span class="badge {{ $statusClass }}" style="font-size:0.8rem; padding:0.45rem 0.9rem;">
                PAYMENT {{ strtoupper($order->payment_status ?? 'UNPAID') }}
            </span>
        </div>

        <div class="payment-grid">
            <div class="card card-2x reveal">
                <div class="card-header" style="border-bottom-width:2px; display:flex; align-items:center; justify-content:space-between; gap:0.75rem; flex-wrap:wrap;">
                    <h2 class="font-black uppercase" style="font-size:1rem; display:flex; align-items:center; gap:0.55rem;">
                        <i class="fas fa-credit-card text-primary"></i> Payment Action
                    </h2>
                    <span class="font-mono text-muted" style="font-size:0.75rem;">Snap Token: {{ $order->snap_token ? 'READY' : 'MISSING' }}</span>
                </div>
                <div class="card-body" style="display:flex; flex-direction:column; gap:1rem;">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.9rem;" class="payment-meta-grid">
                        <div class="payment-meta-box">
                            <p class="label">Order Number</p>
                            <p class="value">{{ $order->order_number }}</p>
                        </div>
                        <div class="payment-meta-box">
                            <p class="label">Order Status</p>
                            <p class="value">{{ strtoupper($order->status) }}</p>
                        </div>
                        <div class="payment-meta-box">
                            <p class="label">Payment Method</p>
                            <p class="value">{{ strtoupper($order->payment_method ?? 'MIDTRANS') }}</p>
                        </div>
                        <div class="payment-meta-box">
                            <p class="label">Total Payment</p>
                            <p class="value text-primary" style="font-size:1.1rem;">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    @if($isPaid)
                        <div class="alert alert-success" style="margin-bottom:0;">
                            Pembayaran sudah berhasil. Kamu bisa lanjut ke detail order.
                        </div>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-lg" style="width:fit-content;">
                            <i class="fas fa-receipt"></i> Lihat Detail Pesanan
                        </a>
                    @elseif(!$canPayNow)
                        <div class="alert alert-danger" style="margin-bottom:0;">
                            Pembayaran tidak dapat dilanjutkan saat ini. Silakan cek status order atau buat pesanan baru.
                        </div>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline btn-lg" style="width:fit-content;">
                            <i class="fas fa-arrow-right"></i> Kembali ke Detail Order
                        </a>
                    @else
                        <p class="font-mono text-muted" style="font-size:0.8rem; margin:0;">
                            Klik tombol di bawah untuk membuka modal pembayaran Midtrans.
                        </p>
                        <button id="pay-button" type="button" class="btn btn-primary btn-lg" style="width:fit-content;">
                            <i class="fas fa-lock"></i> Bayar Sekarang via Midtrans
                        </button>
                    @endif
                </div>
            </div>

            <div class="card card-2x reveal" style="height:fit-content;">
                <div class="card-header" style="border-bottom-width:2px;">
                    <h3 class="font-black uppercase" style="font-size:0.9rem; display:flex; align-items:center; gap:0.5rem;">
                        <i class="fas fa-receipt text-primary"></i> Ringkasan Pesanan
                    </h3>
                </div>
                <div class="card-body" style="display:flex; flex-direction:column; gap:0.8rem;">
                    @foreach($order->items as $item)
                        <div style="display:flex; align-items:center; justify-content:space-between; gap:0.75rem;">
                            <div style="display:flex; align-items:center; gap:0.6rem; min-width:0;">
                                <span style="font-size:1rem;">{{ $item->product->category->icon ?? '📦' }}</span>
                                <div style="min-width:0;">
                                    <p class="font-mono" style="font-size:0.78rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $item->product_name }}</p>
                                    <p class="font-mono text-muted" style="font-size:0.68rem;">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <span class="font-mono font-black" style="font-size:0.8rem; white-space:nowrap;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    <div style="height:1px; background:var(--border); margin:0.3rem 0;"></div>

                    <div class="font-mono" style="font-size:0.8rem; display:flex; flex-direction:column; gap:0.35rem;">
                        <div style="display:flex; justify-content:space-between;">
                            <span class="text-muted">Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between;">
                            <span class="text-muted">Shipping</span>
                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:1.05rem; padding-top:0.45rem; border-top:1px solid var(--border);">
                            <span class="font-black uppercase">Total</span>
                            <span class="font-black text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
(() => {
    const clientKey = @json(config('midtrans.client_key'));
    const snapToken = @json($order->snap_token);
    const paymentSyncUrl = @json(route('orders.payment.sync', $order));
    const orderUrl = @json(route('orders.show', $order));
    const payButton = document.getElementById('pay-button');

    if (!payButton) {
        return;
    }

    const loadSnapSdk = () => new Promise((resolve, reject) => {
        if (window.snap) {
            resolve(window.snap);
            return;
        }

        const existingScript = document.querySelector('script[data-midtrans-snap="true"]');
        if (existingScript && window.snap) {
            resolve(window.snap);
            return;
        }

        const script = document.createElement('script');
        script.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
        script.async = true;
        script.setAttribute('data-client-key', clientKey);
        script.setAttribute('data-midtrans-snap', 'true');
        script.onload = () => resolve(window.snap);
        script.onerror = () => reject(new Error('Midtrans Snap SDK gagal dimuat.'));
        document.head.appendChild(script);
    });

    const syncPaymentStatus = async (result) => {
        const response = await fetch(paymentSyncUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(result),
        });

        if (!response.ok) {
            throw new Error('Gagal menyinkronkan status pembayaran.');
        }

        return response.json();
    };

    const openPaymentModal = async () => {
        payButton.disabled = true;

        try {
            await loadSnapSdk();

            if (!window.snap || typeof window.snap.pay !== 'function') {
                throw new Error('Midtrans Snap tidak tersedia di browser.');
            }

            window.snap.pay(snapToken, {
                onSuccess: async function (result) {
                    try {
                        await syncPaymentStatus(result);
                    } catch (error) {
                        console.error(error);
                    }

                    alert('Pembayaran berhasil!');
                    window.location.href = orderUrl;
                },
                onPending: function () {
                    alert('Menunggu pembayaran');
                },
                onError: function () {
                    alert('Pembayaran gagal');
                },
                onClose: function () {
                    alert('Popup pembayaran ditutup');
                },
            });
        } catch (error) {
            console.error(error);
            alert(error.message || 'Midtrans gagal dibuka.');
            payButton.disabled = false;
        }
    };

    payButton.addEventListener('click', openPaymentModal);
})();
</script>
@endpush

@push('styles')
<style>
    .payment-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 1.25rem;
    }
    .payment-meta-box {
        padding: 0.85rem;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: color-mix(in srgb, var(--muted) 22%, transparent);
    }
    .payment-meta-box .label {
        font-family: 'JetBrains Mono';
        font-size: 0.68rem;
        text-transform: uppercase;
        color: var(--muted-fg);
        margin-bottom: 0.35rem;
    }
    .payment-meta-box .value {
        font-family: 'JetBrains Mono';
        font-size: 0.78rem;
        font-weight: 700;
    }
    @media(max-width: 900px) {
        .payment-grid {
            grid-template-columns: 1fr;
        }
    }
    @media(max-width: 620px) {
        .payment-meta-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush

@endsection