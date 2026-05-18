<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth();
        $endDate = $request->end_date ?? now()->endOfMonth();
        
        $dailySales = Order::where('status', 'completed')->whereDate('created_at', today())->sum('total') ?? 0;
        $monthlySales = Order::where('status', 'completed')->whereMonth('created_at', now()->month)->sum('total') ?? 0;
        $yearlySales = Order::where('status', 'completed')->whereYear('created_at', now()->year)->sum('total') ?? 0;
        $filteredSales = Order::where('status', 'completed')->whereBetween('created_at', [$startDate, $endDate])->sum('total') ?? 0;
        
        $totalOrders = Order::count();
        $pendingOrders = Order::where('shipping_status', 'pending')->count();
        $completedOrders = Order::where('shipping_status', 'delivered')->count();
        
        $topProducts = Product::withCount('orderItems')->withSum('orderItems', 'quantity')->orderBy('order_items_sum_quantity', 'desc')->take(10)->get();
        $recentOrders = Order::with('user')->latest()->take(10)->get();
        $totalCustomers = User::where('role', 'user')->count();
        
        return view('admin.reports.index', compact('dailySales', 'monthlySales', 'yearlySales', 'filteredSales', 'totalOrders', 'pendingOrders', 'completedOrders', 'topProducts', 'recentOrders', 'totalCustomers', 'startDate', 'endDate'));
    }
    
    public function exportPDF(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth();
        $endDate = $request->end_date ?? now()->endOfMonth();
        $orders = Order::with('user')->whereBetween('created_at', [$startDate, $endDate])->get();
        $totalRevenue = $orders->sum('total');
        $totalOrders = $orders->count();
        $pdf = Pdf::loadView('admin.reports.pdf.sales_report', compact('orders', 'totalRevenue', 'totalOrders', 'startDate', 'endDate'));
        return $pdf->download('sales_report_' . now()->format('Y-m-d') . '.pdf');
    }
    
    public function exportExcel(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth();
        $endDate = $request->end_date ?? now()->endOfMonth();
        return Excel::download(new SalesExport($startDate, $endDate), 'sales_report_' . now()->format('Y-m-d') . '.xlsx');
    }
}