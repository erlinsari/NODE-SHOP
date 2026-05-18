@extends('admin.layouts.admin')

@section('content')
<div class="p-8 max-w-4xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.orders.index') }}" class="text-red-600 hover:text-red-700">
            <i class="fas fa-arrow-left mr-2"></i> Back to Orders
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b bg-gray-50">
            <h1 class="text-2xl font-bold text-gray-800">Order #{{ $order->id }}</h1>
            <p class="text-gray-500">Order Date: {{ $order->created_at->format('d F Y H:i') }}</p>
        </div>

        <div class="p-6">
            <!-- Customer Information -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user text-red-600 mr-2"></i> Customer Information
                </h2>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p><strong>Name:</strong> {{ $order->user->name ?? 'Guest' }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                    <p><strong>Phone:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
                    <p><strong>Address:</strong> {{ $order->shipping_address ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-box text-red-600 mr-2"></i> Order Items
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Product</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Quantity</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Price</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($order->items as $item)
                            <tr>
                                <td class="px-4 py-3">{{ $item->product->name ?? 'Product' }}</td>
                                <td class="px-4 py-3">{{ $item->quantity }}</td>
                                <td class="px-4 py-3">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 font-semibold">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right font-bold">Total:</td>
                                <td class="px-4 py-3 font-bold text-red-600">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Update Status Form -->
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-truck text-red-600 mr-2"></i> Update Status
                </h2>
                <form id="updateStatusForm" class="bg-gray-50 rounded-xl p-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Status</label>
                            <select name="shipping_status" id="shipping_status" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500">
                                <option value="pending" {{ $order->shipping_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processed" {{ $order->shipping_status == 'processed' ? 'selected' : '' }}>Processed</option>
                                <option value="shipped" {{ $order->shipping_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->shipping_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->shipping_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tracking Number</label>
                            <input type="text" name="tracking_number" id="tracking_number" value="{{ $order->tracking_number }}" placeholder="e.g., JNE-1234567890" class="w-full border rounded-lg px-3 py-2">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-save mr-2"></i> Update Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('updateStatusForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const status = document.getElementById('shipping_status').value;
        const tracking = document.getElementById('tracking_number').value;
        
        fetch('{{ route("admin.orders.update-status", $order) }}', {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                shipping_status: status,
                tracking_number: tracking
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Order status updated successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error updating order status');
        });
    });
</script>
@endsection