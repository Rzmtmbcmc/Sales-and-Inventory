<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_can_be_created()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);

        $order = Order::create([
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'total_amount' => 150.00,
            'status' => 'pending'
        ]);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals(150.00, $order->total_amount);
        $this->assertEquals('pending', $order->status);
    }

    public function test_order_belongs_to_branch()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);
        
        $order = Order::create([
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'total_amount' => 100.00,
            'status' => 'pending'
        ]);

        $this->assertInstanceOf(Branch::class, $order->branch);
        $this->assertEquals('Test Branch', $order->branch->name);
    }

    public function test_order_belongs_to_brand()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);
        
        $order = Order::create([
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'total_amount' => 100.00,
            'status' => 'pending'
        ]);

        $this->assertInstanceOf(Brand::class, $order->brand);
        $this->assertEquals('Test Brand', $order->brand->name);
    }

    public function test_order_has_many_items()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);
        $product = Product::create([
            'name' => 'Test Product',
            'price' => 10.00,
            'quantity' => 100,
            'perishable' => 'no'
        ]);

        $order = Order::create([
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'total_amount' => 50.00,
            'status' => 'pending'
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 5,
            'price' => 10.00
        ]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $order->items);
        $this->assertEquals(1, $order->items->count());
        $this->assertEquals(5, $order->items->first()->quantity);
    }

    public function test_order_status_validation()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);

        $validStatuses = ['pending', 'completed', 'cancelled'];

        foreach ($validStatuses as $status) {
            $order = Order::create([
                'branch_id' => $branch->id,
                'brand_id' => $brand->id,
                'total_amount' => 100.00,
                'status' => $status
            ]);

            $this->assertEquals($status, $order->status);
        }
    }

    public function test_order_total_amount_calculation()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);
        $product1 = Product::create(['name' => 'Product 1', 'price' => 10.00, 'quantity' => 100, 'perishable' => 'no']);
        $product2 = Product::create(['name' => 'Product 2', 'price' => 15.00, 'quantity' => 100, 'perishable' => 'no']);

        $order = Order::create([
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'total_amount' => 0,
            'status' => 'pending'
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product1->id,
            'quantity' => 2,
            'price' => 10.00
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product2->id,
            'quantity' => 3,
            'price' => 15.00
        ]);

        $expectedTotal = (2 * 10.00) + (3 * 15.00); // 20 + 45 = 65
        $calculatedTotal = $order->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $this->assertEquals($expectedTotal, $calculatedTotal);
    }
}