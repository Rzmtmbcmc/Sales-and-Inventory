<?php

namespace Tests\Unit\Models;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_created()
    {
        $product = Product::create([
            'name' => 'Apple',
            'price' => 32.00,
            'original_price' => 12.00,
            'quantity' => 50,
            'perishable' => 'yes',
            'expiration_date' => '2025-12-31',
        ]);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Apple', $product->name);
        $this->assertEquals('32.00', $product->price);
        $this->assertEquals('12.00', $product->original_price);
        $this->assertEquals(50, $product->quantity);
        $this->assertEquals('yes', $product->perishable);
    }

    public function test_product_profit_calculation()
    {
        $product = Product::create([
            'name' => 'Profit Test',
            'price' => 25.00,
            'original_price' => 15.00,
            'quantity' => 100,
            'perishable' => 'no',
        ]);

        $expectedProfit = (float)$product->price - (float)$product->original_price;
        $this->assertEquals(10.00, $expectedProfit);
    }

    public function test_product_low_stock_scope()
    {
        Product::create(['name' => 'Low Stock', 'price' => 10.00, 'quantity' => 5, 'perishable' => 'no']);
        Product::create(['name' => 'Normal Stock', 'price' => 15.00, 'quantity' => 50, 'perishable' => 'no']);
        Product::create(['name' => 'High Stock', 'price' => 20.00, 'quantity' => 100, 'perishable' => 'no']);

        $lowStockProducts = Product::lowStock()->get();

        $this->assertEquals(1, $lowStockProducts->count());
        $this->assertEquals('Low Stock', $lowStockProducts->first()->name);
    }

    public function test_product_out_of_stock_scope()
    {
        Product::create(['name' => 'In Stock', 'price' => 10.00, 'quantity' => 25, 'perishable' => 'no']);
        Product::create(['name' => 'Out of Stock', 'price' => 15.00, 'quantity' => 0, 'perishable' => 'no']);
        Product::create(['name' => 'High Stock', 'price' => 20.00, 'quantity' => 100, 'perishable' => 'no']);

        $outOfStockProducts = Product::outOfStock()->get();

        $this->assertEquals(1, $outOfStockProducts->count());
        $this->assertEquals('Out of Stock', $outOfStockProducts->first()->name);
    }

    public function test_product_fillable_attributes()
    {
        $product = new Product();
        $fillable = $product->getFillable();

        $expectedFillable = [
            'name',
            'price',
            'original_price',
            'quantity',
            'perishable',
            'expiration_date',
        ];

        $this->assertEquals($expectedFillable, $fillable);
    }

    public function test_product_casts()
    {
        $product = Product::create([
            'name' => 'Cast Test',
            'price' => '25.99',
            'original_price' => '15.50',
            'quantity' => '100',
            'perishable' => 'yes',
            'expiration_date' => '2025-12-31',
        ]);

        // Laravel decimal casting returns strings, not floats
        $this->assertIsString($product->price);
        $this->assertEquals('25.99', $product->price);
        $this->assertIsString($product->original_price);
        $this->assertEquals('15.50', $product->original_price);
        $this->assertIsInt($product->quantity);
        $this->assertInstanceOf(\Carbon\Carbon::class, $product->expiration_date);
    }

    public function test_product_has_inventory_relationship()
    {
        $product = Product::create([
            'name' => 'Inventory Test',
            'price' => 20.00,
            'quantity' => 50,
            'perishable' => 'no',
        ]);

        $inventory = Inventory::create([
            'product_id' => $product->id,
            'quantity' => 25,
        ]);

        $this->assertInstanceOf(Inventory::class, $product->inventory);
        $this->assertEquals(25, $product->inventory->quantity);
    }

    public function test_product_validation_rules()
    {
        // Test that required fields are enforced
        $this->expectException(\Illuminate\Database\QueryException::class);

        Product::create([
            'price' => 25.00,
            'quantity' => 50,
            // Missing required 'name' field should cause an error
        ]);
    }
}
