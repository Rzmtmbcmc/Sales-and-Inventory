<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Sales;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalesTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_can_be_created()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);
        $product = Product::create([
            'name' => 'Test Product',
            'price' => 25.00,
            'original_price' => 15.00,
            'quantity' => 100,
            'perishable' => 'no'
        ]);

        $sales = Sales::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'quantity_sold' => 5,
            'unit_price' => 25.00,
            'total_amount' => 125.00,
            'profit_per_unit' => 10.00,
            'total_profit' => 50.00
        ]);

        $this->assertInstanceOf(Sales::class, $sales);
        $this->assertEquals(5, $sales->quantity_sold);
        $this->assertEquals(25.00, $sales->unit_price);
        $this->assertEquals(125.00, $sales->total_amount);
        $this->assertEquals(50.00, $sales->total_profit);
    }

    public function test_sales_belongs_to_product()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);
        $product = Product::create([
            'name' => 'Sales Product',
            'price' => 20.00,
            'quantity' => 50,
            'perishable' => 'no'
        ]);

        $sales = Sales::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'quantity_sold' => 3,
            'unit_price' => 20.00,
            'total_amount' => 60.00
        ]);

        $this->assertInstanceOf(Product::class, $sales->product);
        $this->assertEquals('Sales Product', $sales->product->name);
    }

    public function test_sales_belongs_to_branch()
    {
        $branch = Branch::create(['name' => 'Sales Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);
        $product = Product::create(['name' => 'Test Product', 'price' => 10.00, 'quantity' => 100, 'perishable' => 'no']);

        $sales = Sales::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'quantity_sold' => 2,
            'unit_price' => 10.00,
            'total_amount' => 20.00
        ]);

        $this->assertInstanceOf(Branch::class, $sales->branch);
        $this->assertEquals('Sales Branch', $sales->branch->name);
    }

    public function test_sales_belongs_to_brand()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Sales Brand']);
        $product = Product::create(['name' => 'Test Product', 'price' => 10.00, 'quantity' => 100, 'perishable' => 'no']);

        $sales = Sales::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'quantity_sold' => 1,
            'unit_price' => 10.00,
            'total_amount' => 10.00
        ]);

        $this->assertInstanceOf(Brand::class, $sales->brand);
        $this->assertEquals('Sales Brand', $sales->brand->name);
    }

    public function test_sales_profit_calculation()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);
        $product = Product::create([
            'name' => 'Profit Product',
            'price' => 30.00,
            'original_price' => 20.00,
            'quantity' => 100,
            'perishable' => 'no'
        ]);

        $quantitySold = 4;
        $unitPrice = 30.00;
        $profitPerUnit = $unitPrice - $product->original_price; // 30 - 20 = 10
        $totalProfit = $profitPerUnit * $quantitySold; // 10 * 4 = 40

        $sales = Sales::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'quantity_sold' => $quantitySold,
            'unit_price' => $unitPrice,
            'total_amount' => $unitPrice * $quantitySold,
            'profit_per_unit' => $profitPerUnit,
            'total_profit' => $totalProfit
        ]);

        $this->assertEquals(10.00, $sales->profit_per_unit);
        $this->assertEquals(40.00, $sales->total_profit);
        $this->assertEquals(120.00, $sales->total_amount); // 30 * 4
    }

    public function test_sales_fillable_attributes()
    {
        $sales = new Sales();
        $fillable = $sales->getFillable();
        
        $expectedFillable = [
            'product_id',
            'branch_id',
            'brand_id',
            'quantity_sold',
            'unit_price',
            'total_amount',
            'profit_per_unit',
            'total_profit'
        ];

        $this->assertEquals($expectedFillable, $fillable);
    }

    public function test_sales_casts()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);
        $product = Product::create(['name' => 'Cast Product', 'price' => 15.00, 'quantity' => 50, 'perishable' => 'no']);

        $sales = Sales::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'quantity_sold' => '3',
            'unit_price' => '15.99',
            'total_amount' => '47.97',
            'profit_per_unit' => '5.99',
            'total_profit' => '17.97'
        ]);

        $this->assertIsInt($sales->quantity_sold);
        // Laravel decimal casting returns strings, not floats
        $this->assertIsString($sales->unit_price);
        $this->assertIsString($sales->total_amount);
        $this->assertIsString($sales->profit_per_unit);
        $this->assertIsString($sales->total_profit);
    }
}