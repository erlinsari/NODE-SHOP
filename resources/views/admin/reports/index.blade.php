@extends('admin.layouts.admin')

@section('content')
<div class="p-8">
    <div class="mb-8"><h1 class="text-3xl font-bold text-gray-800">Sales Reports</h1><p class="text-gray-500">Complete sales analytics</p></div>

    <!-- Filter & Export -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div><label class="text-sm font-medium">Start Date</label><input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="border rounded-lg px-3 py-2"></div>
            <div><label class="text-sm font-medium">End Date</label><input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="border rounded-lg px-3 py-2"></div>
            <div><button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700"><i class="fas fa-filter mr-2"></i>Filter</button></div>
            <div class="flex gap-2 ml-auto">
                <a href="{{ route('admin.reports.export-pdf', request()->all()) }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700"><i class="fas fa-file-pdf mr-2"></i>PDF</a>
                <a href="{{ route('admin.reports.export-excel', request()->all()) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700"><i class="fas fa-file-excel mr-2"></i>Excel</a>
            </div>
        </form>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white"><p class="text-sm">Filtered Revenue</p><p class="text-2xl font-bold">Rp {{ number_format($filteredSales,0,',','.') }}</p></div>
        <div class="bg-white rounded-xl shadow-sm p-6 border"><p class="text-gray-500">Daily Sales</p><p class="text-2xl font-bold">Rp {{ number_format($dailySales,0,',','.') }}</p></div>
        <div class="bg-white rounded-xl shadow-sm p-6 border"><p class="text-gray-500">Monthly Sales</p><p class="text-2xl font-bold">Rp {{ number_format($monthlySales,0,',','.') }}</p></div>
        <div class="bg-white rounded-xl shadow-sm p-6 border"><p class="text-gray-500">Yearly Sales</p><p class="text-2xl font-bold">Rp {{ number_format($yearlySales,0,',','.') }}</p></div>
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-xl shadow-sm p-6 border mb-8">
        <h2 class="text-lg font-semibold mb-4">Top Selling Products</h2>
        @foreach($topProducts as $product)
        <div class="flex justify-between items-center py-3 border-b"><div><p class="font-medium">{{ $product->name }}</p><p class="text-sm text-gray-500">Sold: {{ $product->order_items_sum_quantity ?? 0 }} units</p></div><p class="font-bold text-red-600">Rp {{ number_format($product->price,0,',','.') }}</p></div>
        @endforeach
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-xl shadow-sm p-6 border">
        <h2 class="text-lg font-semibold mb-4">Recent Orders</h2>
        <table class="min-w-full"><thead class="bg-gray-50"><tr><th class="px-4 py-3 text-left">Order ID</th><th class="px-4 py-3 text-left">Customer</th><th class="px-4 py-3 text-left">Total</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-left">Date</th></tr></thead>
        <tbody>@foreach($recentOrders as $order)<tr><td class="px-4 py-3">#{{ $order->id }}</td><td class="px-4 py-3">{{ $order->user->name ?? 'Guest' }}</td><td class="px-4 py-3">Rp {{ number_format($order->total,0,',','.') }}</td><td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">{{ $order->shipping_status }}</span></td><td class="px-4 py-3">{{ $order->created_at->format('d M Y') }}</td></tr>@endforeach</tbody></table>
    </div>
</div>
@endsection