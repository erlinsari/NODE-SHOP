<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', $this->dashboardData());
    }

    public function liveData(): JsonResponse
    {
        return response()->json($this->dashboardData());
    }

    private function dashboardData(): array
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'total_customers' => User::where('role', 'customer')->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get()->map(function (Order $order) {
            return [
                'order_number' => $order->order_number,
                'user_name' => $order->user->name ?? 'N/A',
                'created_at_human' => $order->created_at->diffForHumans(),
                'total' => $order->total,
                'status' => $order->status,
                'payment_status' => $order->payment_status ?? 'unpaid',
            ];
        });

        $topProducts = Product::with('category')->orderBy('views_count', 'desc')->take(5)->get()->map(function (Product $product) {
            return [
                'name' => $product->name,
                'category_name' => $product->category->name ?? 'N/A',
                'category_icon' => $product->category->icon ?? '📦',
                'stock' => $product->stock,
                'views_count' => $product->views_count,
            ];
        });

        return compact('stats', 'recentOrders', 'topProducts');
    }
}
