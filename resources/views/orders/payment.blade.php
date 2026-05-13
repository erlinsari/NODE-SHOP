@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Pembayaran Pesanan</h2>

    <p>Order ID: {{ $order->order_number }}</p>

    <p>Total: Rp {{ number_format($order->total, 0, ',', '.') }}</p>

    <button id="pay-button" class="btn btn-primary">
        Bayar Sekarang
    </button>

</div>

<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
const syncPaymentStatus = async (result) => {
    const response = await fetch('{{ route('orders.payment.sync', $order) }}', {
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

document.getElementById('pay-button').onclick = function () {

    snap.pay('{{ $order->snap_token }}', {

        onSuccess: async function(result) {

            try {
                await syncPaymentStatus(result);
            } catch (error) {
                console.error(error);
            }

            alert("Pembayaran berhasil!");

            window.location.href = "{{ route('orders.show', $order) }}";
        },

        onPending: function(result) {

            alert("Menunggu pembayaran");
        },

        onError: function(result) {

            alert("Pembayaran gagal");
        },

        onClose: function() {

            alert('Popup pembayaran ditutup');
        }

    });

};

(() => {
    const orderUrl = @json(route('orders.show', $order));
    let lastSignature = @json([
        'status' => $order->status,
        'payment_status' => $order->payment_status ?? 'unpaid',
        'paid_at' => optional($order->paid_at)->toDateTimeString(),
        'updated_at' => optional($order->updated_at)->toDateTimeString(),
    ]);

    const pollOrderState = async () => {
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
                if (payload.payment_status === 'paid') {
                    window.location.href = orderUrl;
                    return;
                }

                window.location.reload();
            }
        } catch (error) {
            console.error('Payment live sync failed:', error);
        }
    };

    pollOrderState();
    window.setInterval(pollOrderState, 10000);
})();
</script>

@endsection