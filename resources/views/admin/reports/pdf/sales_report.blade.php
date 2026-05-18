<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Sales Report</title><style>body{font-family:Arial;font-size:12px}.header{text-align:center;margin-bottom:30px;border-bottom:2px solid #dc2626}.title{font-size:24px;font-weight:bold;color:#dc2626}table{width:100%;border-collapse:collapse;margin-top:20px}th,td{border:1px solid #ddd;padding:8px;text-align:left}th{background:#f3f4f6}.total{margin-top:20px;text-align:right;font-weight:bold}</style></head>
<body><div class="header"><div class="title">NODESHOP Sales Report</div><div class="subtitle">{{ $startDate->format('d F Y') }} - {{ $endDate->format('d F Y') }}</div></div>
<table><thead><tr><th>Order ID</th><th>Customer</th><th>Total (Rp)</th><th>Status</th><th>Date</th></tr></thead>
<tbody>@foreach($orders as $order)<tr><td>#{{ $order->id }}</td><td>{{ $order->user->name ?? 'Guest' }}</td><td>{{ number_format($order->total,0,',','.') }}</td><td>{{ $order->shipping_status }}</td><td>{{ $order->created_at->format('d M Y') }}</td></tr>@endforeach</tbody></table>
<div class="total">Total Revenue: Rp {{ number_format($totalRevenue,0,',','.') }}<br>Total Orders: {{ $totalOrders }}</div>
</body></html>