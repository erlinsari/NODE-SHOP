@extends('admin.layouts.admin')

@section('content')
<div class="p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Orders</h1>
        <p class="text-gray-500 mt-1">Manage all customer orders</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">#{{ $order->id }}</td>
                    <td class="px-6 py-4">{{ $order->user->name ?? 'Guest' }}</td>
                    <td class="px-6 py-4 font-semibold text-red-600">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($order->shipping_status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->shipping_status == 'shipped') bg-blue-100 text-blue-800
                            @elseif($order->shipping_status == 'delivered') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($order->shipping_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-red-600 hover:text-red-700">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No orders found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
</div>
@endsection