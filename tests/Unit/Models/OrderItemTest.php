<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_item_can_be_created()
    {
        $order = Order::create([
            'customer_name' => 'Test Customer',
            'customer_email' => 'test@example.com',
            'total_amount' => 100.00,
            'status' => 'pending',
        ]);

        $product = Product::create([
            'name' => 'Test Product',
            'price' => 25.00,
            'quantity' => 100,
            'perishable' => 'no',
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 4,
            'unit_price' => 25.00,
            'total_price' => 100.00,
        ]);

        $this->assertInstanceOf(OrderItem::class, $orderItem);
        $this->assertEquals(4, $orderItem->quantity);
        $this->assertEquals(25.00, $orderItem->unit_price);
        $this->assertEquals(100.00, $orderItem->total_price);
    }

    public function test_order_item_belongs_to_order()
    {
        $order = Order::create([
            'customer_name' => 'Item Customer',
            'customer_email' => 'item@example.com',
            'total_amount' => 50.00,
            'status' => 'pending',
        ]);

        $product = Product::create([
            'name' => 'Item Product',
            'price' => 12.50,
            'quantity' => 50,
            'perishable' => 'no',
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 4,
            'unit_price' => 12.50,
            'total_price' => 50.00,
        ]);

        $this->assertInstanceOf(Order::class, $orderItem->order);
        $this->assertEquals('Item Customer', $orderItem->order->customer_name);
    }

    public function test_order_item_belongs_to_product()
    {
        $order = Order::create([
            'customer_name' => 'Product Customer',
            'customer_email' => 'product@example.com',
            'total_amount' => 75.00,
            'status' => 'pending',
        ]);

        $product = Product::create([
            'name' => 'Order Product',
            'price' => 25.00,
            'quantity' => 30,
            'perishable' => 'no',
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 3,
            'unit_price' => 25.00,
            'total_price' => 75.00,
        ]);

        $this->assertInstanceOf(Product::class, $orderItem->product);
        $this->assertEquals('Order Product', $orderItem->product->name);
    }

    public function test_order_item_price_calculation()
    {
        $order = Order::create([
            'customer_name' => 'Calc Customer',
            'customer_email' => 'calc@example.com',
            'total_amount' => 150.00,
            'status' => 'pending',
        ]);

        $product = Product::create([
            'name' => 'Calc Product',
            'price' => 30.00,
            'quantity' => 20,
            'perishable' => 'no',
        ]);

        $quantity = 5;
        $unitPrice = 30.00;
        $expectedTotalPrice = $quantity * $unitPrice; // 5 * 30 = 150

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $expectedTotalPrice,
        ]);

        $this->assertEquals(30.00, $orderItem->unit_price);
        $this->assertEquals(150.00, $orderItem->total_price);
        $this->assertEquals(5, $orderItem->quantity);
    }

    public function test_order_item_fillable_attributes()
    {
        $orderItem = new OrderItem();
        $fillable = $orderItem->getFillable();

        $expectedFillable = [
            'order_id',
            'product_id',
            'quantity',
            'unit_price',
            'total_price',
        ];

        $this->assertEquals($expectedFillable, $fillable);
    }

    public function test_order_item_required_relationships()
    {
        // Test that order_id is required
        $this->expectException(\Illuminate\Database\QueryException::class);

        OrderItem::create([
            'product_id' => 1,
            'quantity' => 2,
            'unit_price' => 15.00,
            'total_price' => 30.00,
        ]);
    }

    public function test_order_item_casts()
    {
        $order = Order::create([
            'customer_name' => 'Cast Customer',
            'customer_email' => 'cast@example.com',
            'total_amount' => 200.00,
            'status' => 'pending',
        ]);

        $product = Product::create([
            'name' => 'Cast Product',
            'price' => 40.00,
            'quantity' => 25,
            'perishable' => 'no',
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => '5',
            'unit_price' => '40.00',
            'total_price' => '200.00',
        ]);

        $this->assertIsInt($orderItem->quantity);
        // Laravel decimal casting returns strings, not floats
        $this->assertIsString($orderItem->unit_price);
        $this->assertIsString($orderItem->total_price);
    }
}
