@extends('admin.layouts.admin')

@section('content')
<div class="p-8 min-h-screen"
    style="background: linear-gradient(135deg, #f0f2ff 0%, #fce4f3 50%, #e0f7fa 100%);">

    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-4xl font-bold" style="color:#1a1a2e;">
                Admin Dashboard
            </h1>

            <p class="mt-2 text-sm" style="color:#6b7280;">
                Welcome back, Administrator 👋
            </p>
        </div>

        <div class="bg-white/70 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/50 shadow-sm">
            <p class="text-xs text-gray-500">Today</p>
            <p class="font-semibold text-gray-800">
                {{ now()->format('d M Y') }}
            </p>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <!-- Revenue -->
        <div class="rounded-2xl p-6"
            style="
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(12px);
            border:1px solid rgba(255,255,255,0.6);
            box-shadow:0 4px 20px rgba(0,0,0,0.05);
        ">
            <div class="flex items-center justify-between mb-4">

                <div class="rounded-xl p-3"
                    style="background: rgba(220,38,38,0.12); color:#dc2626;">
                    <i class="fas fa-wallet text-lg"></i>
                </div>

            </div>

            <p class="text-sm text-gray-500 mb-1">Total Revenue</p>

            <h2 class="text-3xl font-bold" style="color:#1a1a2e;">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </h2>

            <p class="text-xs text-gray-400 mt-2">
                Total income from completed orders
            </p>
        </div>

        <!-- Orders -->
        <div class="rounded-2xl p-6"
            style="
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(12px);
            border:1px solid rgba(255,255,255,0.6);
            box-shadow:0 4px 20px rgba(0,0,0,0.05);
        ">
            <div class="flex items-center justify-between mb-4">

                <div class="rounded-xl p-3"
                    style="background: rgba(220,38,38,0.12); color:#dc2626;">
                    <i class="fas fa-shopping-cart text-lg"></i>
                </div>

            </div>

            <p class="text-sm text-gray-500 mb-1">Total Orders</p>

            <h2 class="text-3xl font-bold" style="color:#1a1a2e;">
                {{ $totalOrders }}
            </h2>

            <p class="text-xs text-gray-400 mt-2">
                All customer transactions
            </p>
        </div>

        <!-- Users -->
        <div class="rounded-2xl p-6"
            style="
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(12px);
            border:1px solid rgba(255,255,255,0.6);
            box-shadow:0 4px 20px rgba(0,0,0,0.05);
        ">
            <div class="flex items-center justify-between mb-4">

                <div class="rounded-xl p-3"
                    style="background: rgba(220,38,38,0.12); color:#dc2626;">
                    <i class="fas fa-users text-lg"></i>
                </div>

            </div>

            <p class="text-sm text-gray-500 mb-1">Active Users</p>

            <h2 class="text-3xl font-bold" style="color:#1a1a2e;">
                {{ $totalUsers }}
            </h2>

            <p class="text-xs text-gray-400 mt-2">
                Registered customers
            </p>
        </div>

        <!-- Conversion -->
        <div class="rounded-2xl p-6"
            style="
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(12px);
            border:1px solid rgba(255,255,255,0.6);
            box-shadow:0 4px 20px rgba(0,0,0,0.05);
        ">
            <div class="flex items-center justify-between mb-4">

                <div class="rounded-xl p-3"
                    style="background: rgba(220,38,38,0.12); color:#dc2626;">
                    <i class="fas fa-chart-line text-lg"></i>
                </div>

            </div>

            <p class="text-sm text-gray-500 mb-1">Conversion Rate</p>

            <h2 class="text-3xl font-bold" style="color:#1a1a2e;">
                {{ $totalOrders > 0 ? number_format(($completedOrders / max($totalUsers,1)) * 100,2) : 0 }}%
            </h2>

            <p class="text-xs text-gray-400 mt-2">
                Successful customer purchases
            </p>
        </div>

    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-white/50 shadow-sm">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 mb-2">Total Products</p>
                    <h2 class="text-3xl font-bold text-red-600">
                        {{ $totalProducts ?? 0 }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
                    style="background: rgba(220,38,38,0.1); color:#dc2626;">
                    <i class="fas fa-box text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-white/50 shadow-sm">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 mb-2">Pending Orders</p>
                    <h2 class="text-3xl font-bold text-red-600">
                        {{ $pendingOrders ?? 0 }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
                    style="background: rgba(220,38,38,0.1); color:#dc2626;">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-white/50 shadow-sm">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 mb-2">Low Stock Alert</p>
                    <h2 class="text-3xl font-bold text-red-600">
                        {{ $lowStockProducts ?? 0 }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
                    style="background: rgba(220,38,38,0.1); color:#dc2626;">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart & Top Products -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

        <!-- Revenue Chart -->
        <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-white/50 shadow-sm">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        Revenue Overview
                    </h2>

                    <p class="text-sm text-gray-500">
                        Monthly income analytics
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                    style="background: rgba(220,38,38,0.1); color:#dc2626;">
                    <i class="fas fa-chart-area"></i>
                </div>
            </div>

            <canvas id="revenueChart" height="280"></canvas>

        </div>

        <!-- Top Products -->
        <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-white/50 shadow-sm">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        Top Products
                    </h2>

                    <p class="text-sm text-gray-500">
                        Best selling products
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                    style="background: rgba(220,38,38,0.1); color:#dc2626;">
                    <i class="fas fa-fire"></i>
                </div>
            </div>

            @forelse($topProducts as $index => $product)

            <div class="flex justify-between items-center py-4 border-b border-gray-100">

                <div class="flex items-center gap-4">

                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold"
                        style="
                        background: rgba(220,38,38,0.1);
                        color:#dc2626;
                    ">
                        {{ $index + 1 }}
                    </div>

                    <div>
                        <p class="font-semibold text-gray-800">
                            {{ $product->name }}
                        </p>

                        <p class="text-sm text-gray-400">
                            Stock: {{ $product->stock }}
                        </p>
                    </div>

                </div>

                <div class="text-right">
                    <p class="font-bold text-red-600">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>

            </div>

            @empty

            <div class="text-center py-10 text-gray-400">
                No products available
            </div>

            @endforelse

        </div>

    </div>

    <!-- Recent Orders -->
    <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-white/50 shadow-sm">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Recent Orders
                </h2>

                <p class="text-sm text-gray-500">
                    Latest customer transactions
                </p>
            </div>

            <a href="{{ route('admin.orders.index') }}"
                class="px-5 py-2 rounded-xl text-white font-medium"
                style="background:#dc2626;">
                View All
            </a>

        </div>

        @forelse($recentOrders as $order)

        <div class="flex justify-between items-center py-4 border-b border-gray-100">

            <div class="flex items-center gap-4">

                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold"
                    style="background:#dc2626;">
                    #{{ $order->id }}
                </div>

                <div>
                    <p class="font-semibold text-gray-800">
                        {{ $order->user->name ?? 'Guest' }}
                    </p>

                    <p class="text-sm text-gray-400">
                        {{ $order->created_at->diffForHumans() }}
                    </p>
                </div>

            </div>

            <div class="text-right">

                <p class="font-bold text-gray-800">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </p>

                <span class="text-xs px-3 py-1 rounded-full"
                    style="
                    background: rgba(220,38,38,0.1);
                    color:#dc2626;
                ">
                    {{ ucfirst($order->shipping_status) }}
                </span>

            </div>

        </div>

        @empty

        <div class="text-center py-10 text-gray-400">
            No orders yet
        </div>

        @endforelse

    </div>

</div>
@endsection

@push('scripts')
<script>
const months = @json($monthlyRevenue->pluck('month'));
const revenues = @json($monthlyRevenue->pluck('revenue'));

const monthNames = [
    'Jan','Feb','Mar','Apr','May','Jun',
    'Jul','Aug','Sep','Oct','Nov','Dec'
];

new Chart(document.getElementById('revenueChart'), {
    type: 'line',

    data: {
        labels: months.map(m => monthNames[parseInt(m)-1]),

       datasets: [{
    label: 'Revenue',

    data: revenues.length ? revenues : [120000, 190000, 90000, 250000, 180000, 320000, 210000, 450000, 300000, 500000, 420000, 650000],

    borderColor: '#dc2626',

    backgroundColor: 'rgba(220,38,38,0.10)',

    fill: true,

    tension: 0.45,

    pointBackgroundColor: '#dc2626',

    pointBorderColor: '#ffffff',

    pointBorderWidth: 2,

    pointRadius: 5,

    pointHoverRadius: 7,

    borderWidth: 4,
}]
    },

    options: {

        responsive: true,

        plugins: {
            legend: {
                display: false
            }
        },

        scales: {

            y: {

                beginAtZero: true,

                grid: {
                    color: 'rgba(0,0,0,0.05)'
                },

                ticks: {
                    color: '#9ca3af'
                }
            },

            x: {

                grid: {
                    display: false
                },

                ticks: {
                    color: '#9ca3af'
                }
            }
        }
    }
});
</script>
@endpush