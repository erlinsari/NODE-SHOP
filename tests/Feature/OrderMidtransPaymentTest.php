<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderMidtransPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_payment_sync_marks_order_paid_and_processing(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $category = Category::create([
            'name' => 'Perangkat Jaringan',
            'slug' => 'perangkat-jaringan',
            'icon' => '📡',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Router Test',
            'slug' => 'router-test',
            'description' => 'Produk untuk pengujian pembayaran Midtrans.',
            'price' => 150000,
            'stock' => 5,
            'condition' => 'new',
            'weight' => 500,
            'is_active' => true,
            'is_featured' => false,
            'views_count' => 0,
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'NS-20260511-TEST01',
            'status' => 'processing',
            'subtotal' => 150000,
            'shipping_cost' => 0,
            'total' => 150000,
            'shipping_name' => 'Customer Test',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Testing No. 1',
            'shipping_city' => 'Bandung',
            'shipping_province' => 'Jawa Barat',
            'shipping_postal_code' => '40111',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'subtotal' => $product->price,
        ]);

        $this->actingAs($customer)
            ->postJson(route('orders.payment.sync', $order), [
                'transaction_status' => 'settlement',
                'payment_type' => 'bank_transfer',
                'transaction_id' => 'trx-123',
            ])
            ->assertOk()
            ->assertJsonFragment([
                'order_status' => 'processing',
                'payment_status' => 'paid',
            ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'processing',
            'payment_status' => 'paid',
            'payment_method' => 'bank_transfer',
            'midtrans_transaction_id' => 'trx-123',
        ]);
    }

    public function test_admin_dashboard_shows_paid_payment_status(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'NS-20260511-TEST02',
            'status' => 'shipped',
            'subtotal' => 200000,
            'shipping_cost' => 0,
            'total' => 200000,
            'payment_status' => 'paid',
            'payment_method' => 'bank_transfer',
            'shipping_name' => 'Customer Test',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Testing No. 1',
            'shipping_city' => 'Bandung',
            'shipping_province' => 'Jawa Barat',
            'shipping_postal_code' => '40111',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee($order->order_number)
            ->assertSee('PAID')
            ->assertSee('SHIPPED');
    }
}