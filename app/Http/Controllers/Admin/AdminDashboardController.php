<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalRevenue = Order::where('status', 'completed')->sum('total') ?? 0;
        $totalOrders = Order::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalProducts = Product::count();
        $outOfStock = Product::where('stock', '<=', 0)->count();
        
        // Order status
        $pendingOrders = Order::where('shipping_status', 'pending')->count();
        $completedOrders = Order::where('shipping_status', 'delivered')->count();
        $shippedOrders = Order::where('shipping_status', 'shipped')->count();
        
        // Recent orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        
        // Top products
        $topProducts = Product::withCount('orderItems')
            ->withSum('orderItems', 'quantity')
            ->orderBy('order_items_sum_quantity', 'desc')
            ->take(5)
            ->get();
        
        // Monthly revenue for chart
        $monthlyRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', date('Y'))
            ->select(DB::raw('strftime("%m", created_at) as month'), DB::raw('SUM(total) as revenue'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        if ($monthlyRevenue->isEmpty()) {
            $monthlyRevenue = collect([]);
            for ($i = 1; $i <= 12; $i++) {
                $monthlyRevenue->push((object)['month' => str_pad($i, 2, '0', STR_PAD_LEFT), 'revenue' => 0]);
            }
        }
        
        // Preloved products are stored in the products table via the `condition` column.
        $pendingPreloved = Product::preloved()->count();
        
        return view('admin.dashboard.index', compact(
            'totalRevenue', 'totalOrders', 'totalUsers', 'totalProducts',
            'outOfStock', 'recentOrders', 'topProducts', 'monthlyRevenue',
            'pendingPreloved', 'pendingOrders', 'completedOrders', 'shippedOrders'
        ));
    }
} 