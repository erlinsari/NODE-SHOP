@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<section style="padding: 2rem;">
    <div class="container" style="max-width: 900px;">
        <h1 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 1.5rem;"><i class="fas fa-lock" style="color: var(--primary-light);"></i> Checkout</h1>

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 1.5rem;">
                <!-- Shipping Info -->
                <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 18px; padding: 1.5rem;">
                    <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem;">📦 Alamat Pengiriman</h3>

                    @php $inputStyle = 'width: 100%; background: var(--dark-surface); border: 1px solid rgba(108,92,231,0.2); border-radius: 10px; padding: 10px 14px; color: var(--text-primary); font-size: 0.85rem; outline: none; margin-bottom: 1rem;'; @endphp

                    <label style="font-size: 0.8rem; color: var(--text-secondary); font-weight: 600;">Nama Penerima *</label>
                    <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required style="{{ $inputStyle }}">

                    <label style="font-size: 0.8rem; color: var(--text-secondary); font-weight: 600;">No. Telepon *</label>
                    <input type="text" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" required style="{{ $inputStyle }}">

                    <label style="font-size: 0.8rem; color: var(--text-secondary); font-weight: 600;">Alamat Lengkap *</label>
                    <textarea name="shipping_address" rows="3" required style="{{ $inputStyle }} resize: vertical;">{{ old('shipping_address', auth()->user()->address) }}</textarea>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="font-size: 0.8rem; color: var(--text-secondary); font-weight: 600;">Kota *</label>
                            <input type="text" name="shipping_city" value="{{ old('shipping_city', auth()->user()->city) }}" required style="{{ $inputStyle }}">
                        </div>
                        <div>
                            <label style="font-size: 0.8rem; color: var(--text-secondary); font-weight: 600;">Provinsi *</label>
                            <input type="text" name="shipping_province" value="{{ old('shipping_province', auth()->user()->province) }}" required style="{{ $inputStyle }}">
                        </div>
                    </div>

                    <label style="font-size: 0.8rem; color: var(--text-secondary); font-weight: 600;">Kode Pos *</label>
                    <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code', auth()->user()->postal_code) }}" required style="{{ $inputStyle }}">

                    <label style="font-size: 0.8rem; color: var(--text-secondary); font-weight: 600;">Catatan (opsional)</label>
                    <textarea name="notes" rows="2" style="{{ $inputStyle }} resize: vertical;" placeholder="Contoh: warna hitam, paket bubble wrap"></textarea>

                    @if($errors->any())
                    <div class="alert alert-danger" style="margin-top: 0.5rem;">
                        <ul style="margin: 0; padding-left: 1rem; font-size: 0.8rem;">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                <!-- Order Summary -->
                <div>
                    <div style="background: var(--dark-card); border: 1px solid rgba(108,92,231,0.1); border-radius: 18px; padding: 1.5rem; position: sticky; top: 88px;">
                        <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem;">🧾 Ringkasan Pesanan</h3>

                        <div style="display: flex; flex-direction: column; gap: 0.8rem; margin-bottom: 1rem;">
                            @foreach($cartItems as $item)
                            <div style="display: flex; gap: 0.8rem; align-items: center; font-size: 0.8rem;">
                                <div style="width: 40px; height: 40px; background: var(--dark-surface); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">{{ $item->product->category->icon ?? '📦' }}</div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600;">{{ Str::limit($item->product->name, 25) }}</div>
                                    <div style="color: var(--text-secondary); font-size: 0.7rem;">{{ $item->quantity }}x Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                </div>
                                <div style="font-weight: 600; color: var(--primary-light);">Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}</div>
                            </div>
                            @endforeach
                        </div>

                        <div style="border-top: 1px solid rgba(108,92,231,0.1); padding-top: 1rem;">
                            <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 0.5rem;">
                                <span style="color: var(--text-secondary);">Subtotal</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 0.5rem;">
                                <span style="color: var(--text-secondary);">Ongkos Kirim</span>
                                <span style="color: var(--secondary);">Rp 15.000</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 1.1rem; font-weight: 800; padding-top: 0.8rem; border-top: 1px solid rgba(108,92,231,0.1);">
                                <span>Total</span>
                                <span style="background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Rp {{ number_format($subtotal + 15000, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 0.95rem; margin-top: 1.2rem;">
                            <i class="fas fa-check-circle"></i> Buat Pesanan
                        </button>
                        <p style="font-size: 0.7rem; color: var(--text-secondary); text-align: center; margin-top: 0.8rem;">
                            <i class="fas fa-shield-alt"></i> Pembayaran aman via Midtrans
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
