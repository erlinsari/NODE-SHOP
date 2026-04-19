@extends('layouts.app')
@section('title', 'Pesanan Saya')

@section('content')
<section style="padding: 2rem;">
    <div class="container" style="max-width: 900px;">
        <h1 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 1.5rem;"><i class="fas fa-box" style="color: var(--primary-light);"></i> Pesanan Saya</h1>

        @if($orders->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($orders as $order)
                <a href="{{ route('orders.show', $order) }}" style="text-decoration: none; background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 16px; padding: 1.2rem; display: flex; align-items: center; justify-content: space-between; transition: all 0.3s;"
                   onmouseover="this.style.borderColor='rgba(108,92,231,0.3)'" onmouseout="this.style.borderColor='rgba(108,92,231,0.1)'">
                    <div>
                        <div style="font-weight: 700; color: var(--text-primary); font-size: 0.9rem;">{{ $order->order_number }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.2rem;">{{ $order->created_at->format('d M Y, H:i') }} • {{ $order->items->count() }} item</div>
                    </div>
                    <div style="text-align: right;">
                        <span style="display: inline-block; padding: 4px 12px; border-radius: 8px; font-size: 0.7rem; font-weight: 700;
                            background: rgba({{ $order->status_color == 'success' ? '0,184,148' : ($order->status_color == 'warning' ? '253,203,110' : ($order->status_color == 'danger' ? '255,107,107' : '108,92,231')) }}, 0.15);
                            color: {{ $order->status_color == 'success' ? 'var(--success)' : ($order->status_color == 'warning' ? 'var(--warning)' : ($order->status_color == 'danger' ? 'var(--danger)' : 'var(--primary-light)')) }};">
                            {{ $order->status_label }}
                        </span>
                        <div style="font-weight: 700; color: var(--primary-light); margin-top: 0.3rem; font-size: 0.9rem;">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                    </div>
                </a>
                @endforeach
            </div>
            <div style="margin-top: 1.5rem;">{{ $orders->links() }}</div>
        @else
            <div style="text-align: center; padding: 4rem; background: var(--dark-card); border-radius: 18px;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📋</div>
                <h3 style="font-weight: 700; margin-bottom: 0.5rem;">Belum Ada Pesanan</h3>
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Mulai belanja dan pesananmu akan muncul di sini.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Belanja Sekarang →</a>
            </div>
        @endif
    </div>
</section>
@endsection
