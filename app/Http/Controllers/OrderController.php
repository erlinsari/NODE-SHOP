<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class OrderController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        Config::$overrideNotifUrl = route('midtrans.notification');
    }

    /*
    |--------------------------------------------------------------------------
    | Order List
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | Checkout Page
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product.category')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang belanja kosong!');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $shippingCost = 0;

        $total = $subtotal + $shippingCost;

        return view('orders.checkout', compact(
            'cartItems',
            'subtotal',
            'shippingCost',
            'total'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Store Order
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_province' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:10',
        ]);

        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Calculate Total
            |--------------------------------------------------------------------------
            */

            $subtotal = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            $shippingCost = 0;

            $total = $subtotal + $shippingCost;

            /*
            |--------------------------------------------------------------------------
            | Create Order
            |--------------------------------------------------------------------------
            */

            $order = Order::create([

                'user_id' => auth()->id(),

                'order_number' => Order::generateOrderNumber(),

                'status' => 'pending',

                'payment_status' => 'unpaid',

                'subtotal' => $subtotal,

                'shipping_cost' => $shippingCost,

                'total' => $total,

                'shipping_name' => $request->shipping_name,

                'shipping_phone' => $request->shipping_phone,

                'shipping_address' => $request->shipping_address,

                'shipping_city' => $request->shipping_city,

                'shipping_province' => $request->shipping_province,

                'shipping_postal_code' => $request->shipping_postal_code,

                'notes' => $request->notes,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Order Items
            |--------------------------------------------------------------------------
            */

            $itemDetails = [];

            foreach ($cartItems as $item) {

                OrderItem::create([

                    'order_id' => $order->id,

                    'product_id' => $item->product_id,

                    'product_name' => $item->product->name,

                    'price' => $item->product->price,

                    'quantity' => $item->quantity,

                    'subtotal' => $item->quantity * $item->product->price,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Midtrans Item Details
                |--------------------------------------------------------------------------
                */

                $itemDetails[] = [

                    'id' => $item->product->id,

                    'price' => (int) $item->product->price,

                    'quantity' => $item->quantity,

                    'name' => substr($item->product->name, 0, 50),
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | Shipping Cost Item
            |--------------------------------------------------------------------------
            */

            $itemDetails[] = [

                'id' => 'SHIPPING',

                'price' => (int) $shippingCost,

                'quantity' => 1,

                'name' => 'Biaya Pengiriman',
            ];

            /*
            |--------------------------------------------------------------------------
            | Midtrans Payload
            |--------------------------------------------------------------------------
            */

            $midtransParams = [

                'transaction_details' => [

                    'order_id' => $order->order_number,

                    'gross_amount' => (int) $total,
                ],

                'customer_details' => [

                    'first_name' => $request->shipping_name,

                    'email' => auth()->user()->email,

                    'phone' => $request->shipping_phone,
                ],

                'item_details' => $itemDetails,
            ];

            /*
            |--------------------------------------------------------------------------
            | Generate Snap Token
            |--------------------------------------------------------------------------
            */

            $snapToken = Snap::getSnapToken($midtransParams);

            $order->snap_token = $snapToken;

            $order->save();

            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | Redirect Payment Page
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('orders.payment', $order->id)
                ->with('success', 'Pesanan berhasil dibuat.');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('orders.create')
                ->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }

    public function syncMidtransPayment(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $this->refreshPaymentStatusFromMidtrans($order);
        $this->updateOrderPaymentStatus($order, $request->all());

        return response()->json([
            'message' => 'Status pembayaran berhasil disinkronkan.',
            'order_status' => $order->fresh()->status,
            'payment_status' => $order->fresh()->payment_status,
        ]);
    }

    public function midtransNotification(Request $request)
    {
        $signatureKey = hash(
            'sha512',
            $request->order_id . $request->status_code . $request->gross_amount . config('midtrans.server_key')
        );

        if ($request->signature_key !== $signatureKey) {
            abort(403, 'Invalid Midtrans signature.');
        }

        $order = Order::where('order_number', $request->order_id)->firstOrFail();

        $this->updateOrderPaymentStatus($order, $request->all());

        return response()->json(['message' => 'Notification processed.']);
    }

    private function updateOrderPaymentStatus(Order $order, array $payload): void
    {
        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? $order->payment_method;
        $transactionId = $payload['transaction_id'] ?? $order->midtrans_transaction_id;

        if ($order->payment_status === 'paid' && !in_array($transactionStatus, ['settlement', 'capture'], true)) {
            return;
        }

        if (in_array($order->status, ['shipped', 'delivered'], true) && !in_array($transactionStatus, ['settlement', 'capture'], true)) {
            return;
        }

        if (in_array($transactionStatus, ['settlement', 'capture'], true)) {
            $order->fill([
                'payment_status' => 'paid',
                'payment_method' => $paymentType,
                'midtrans_transaction_id' => $transactionId,
                'status' => 'shipped',
                'paid_at' => now(),
                'shipped_at' => now(),
            ])->save();

            return;
        }

        if (in_array($transactionStatus, ['pending'], true)) {
            $order->fill([
                'payment_status' => 'unpaid',
                'payment_method' => $paymentType,
                'midtrans_transaction_id' => $transactionId,
                'status' => 'pending',
            ])->save();

            return;
        }

        if (in_array($transactionStatus, ['deny', 'expire', 'cancel'], true)) {
            $order->fill([
                'payment_status' => 'unpaid',
                'payment_method' => $paymentType,
                'midtrans_transaction_id' => $transactionId,
                'status' => 'cancelled',
            ])->save();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Payment Page
    |--------------------------------------------------------------------------
    */

    public function payment(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $this->refreshPaymentStatusFromMidtrans($order);

        return view('orders.payment', compact('order'));
    }

    /*
    |--------------------------------------------------------------------------
    | Order Detail
    |--------------------------------------------------------------------------
    */

    public function show(Request $request, Order $order)
    {
        if (
            $order->user_id !== auth()->id()
            && !auth()->user()->isAdmin()
        ) {
            abort(403);
        }

        $this->refreshPaymentStatusFromMidtrans($order);
        $order->load('items.product.category');

        if ($request->expectsJson()) {
            return response()->json($this->orderPayload($order));
        }

        return view('orders.show', compact('order'));
    }

    private function refreshPaymentStatusFromMidtrans(Order $order): void
    {
        if ($order->payment_status === 'paid') {
            return;
        }

        try {
            $status = Transaction::status($order->order_number);
        } catch (\Throwable $e) {
            return;
        }

        $this->updateOrderPaymentStatus($order, [
            'transaction_status' => $status->transaction_status ?? null,
            'payment_type' => $status->payment_type ?? $order->payment_method,
            'transaction_id' => $status->transaction_id ?? $order->midtrans_transaction_id,
        ]);
    }

    private function orderPayload(Order $order): array
    {
        return [
            'order_number' => $order->order_number,
            'status' => $order->status,
            'payment_status' => $order->payment_status ?? 'unpaid',
            'payment_method' => $order->payment_method ?? 'Transfer Bank',
            'paid_at' => optional($order->paid_at)->toDateTimeString(),
            'updated_at' => optional($order->updated_at)->toDateTimeString(),
        ];
    }
}