<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Sales;
use App\Models\Inventory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    public function test_brand_can_be_created()
    {
        $brand = Brand::create([
            'name' => 'Test Brand',
            'description' => 'A test brand for unit testing'
        ]);

        $this->assertInstanceOf(Brand::class, $brand);
        $this->assertEquals('Test Brand', $brand->name);
        $this->assertEquals('A test brand for unit testing', $brand->description);
    }

    public function test_brand_has_many_products()
    {
        $brand = Brand::create(['name' => 'Product Brand']);

        $product1 = Product::create([
            'name' => 'Brand Product 1',
            'price' => 25.00,
            'quantity' => 100,
            'brand_id' => $brand->id,
            'perishable' => 'no'
        ]);

        $product2 = Product::create([
            'name' => 'Brand Product 2',
            'price' => 35.00,
            'quantity' => 50,
            'brand_id' => $brand->id,
            'perishable' => 'yes'
        ]);

        $this->assertCount(2, $brand->products);
        $this->assertInstanceOf(Product::class, $brand->products->first());
        $this->assertEquals('Brand Product 1', $brand->products->first()->name);
    }

    public function test_brand_has_many_sales()
    {
        $brand = Brand::create(['name' => 'Sales Brand']);
        $product = Product::create(['name' => 'Test Product', 'price' => 20.00, 'quantity' => 100, 'perishable' => 'no']);

        $sales1 = Sales::create([
            'product_id' => $product->id,
            'brand_id' => $brand->id,
            'quantity_sold' => 5,
            'unit_price' => 20.00,
            'total_amount' => 100.00
        ]);

        $sales2 = Sales::create([
            'product_id' => $product->id,
            'brand_id' => $brand->id,
            'quantity_sold' => 3,
            'unit_price' => 20.00,
            'total_amount' => 60.00
        ]);

        $this->assertCount(2, $brand->sales);
        $this->assertInstanceOf(Sales::class, $brand->sales->first());
    }

    public function test_brand_has_many_inventory()
    {
        $brand = Brand::create(['name' => 'Inventory Brand']);
        $product = Product::create(['name' => 'Test Product', 'price' => 15.00, 'quantity' => 50, 'perishable' => 'no']);

        $inventory1 = Inventory::create([
            'product_id' => $product->id,
            'brand_id' => $brand->id,
            'quantity_added' => 20,
            'unit_cost' => 10.00,
            'total_cost' => 200.00,
            'date_added' => now()
        ]);

        $inventory2 = Inventory::create([
            'product_id' => $product->id,
            'brand_id' => $brand->id,
            'quantity_added' => 15,
            'unit_cost' => 10.00,
            'total_cost' => 150.00,
            'date_added' => now()
        ]);

        $this->assertCount(2, $brand->inventory);
        $this->assertInstanceOf(Inventory::class, $brand->inventory->first());
    }

    public function test_brand_name_is_required()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Brand::create([
            'description' => 'Brand without name'
        ]);
    }

    public function test_brand_fillable_attributes()
    {
        $brand = new Brand();
        $fillable = $brand->getFillable();
        
        $expectedFillable = [
            'name',
            'description'
        ];

        $this->assertEquals($expectedFillable, $fillable);
    }

    public function test_brand_can_have_null_description()
    {
        $brand = Brand::create([
            'name' => 'No Description Brand',
            'description' => null
        ]);

        $this->assertEquals('No Description Brand', $brand->name);
        $this->assertNull($brand->description);
    }

    public function test_brand_products_relationship()
    {
        $brand = Brand::create(['name' => 'Relationship Brand']);

        $product = Product::create([
            'name' => 'Related Product',
            'price' => 30.00,
            'quantity' => 75,
            'brand_id' => $brand->id,
            'perishable' => 'no'
        ]);

        $retrievedBrand = Brand::with('products')->find($brand->id);
        
        $this->assertCount(1, $retrievedBrand->products);
        $this->assertEquals('Related Product', $retrievedBrand->products->first()->name);
        $this->assertEquals($brand->id, $retrievedBrand->products->first()->brand_id);
    }
}