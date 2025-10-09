<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_can_be_created()
    {
        $product = Product::create([
            'name' => 'Test Product',
            'price' => 25.00,
            'quantity' => 100,
            'perishable' => 'no'
        ]);

        $inventory = Inventory::create([
            'product_id' => $product->id,
            'quantity' => 50
        ]);

        $this->assertInstanceOf(Inventory::class, $inventory);
        $this->assertEquals(50, $inventory->quantity);
        $this->assertEquals($product->id, $inventory->product_id);
    }

    public function test_inventory_belongs_to_product()
    {
        $product = Product::create([
            'name' => 'Inventory Product',
            'price' => 20.00,
            'quantity' => 50,
            'perishable' => 'no'
        ]);

        $inventory = Inventory::create([
            'product_id' => $product->id,
            'quantity' => 30
        ]);

        $this->assertInstanceOf(Product::class, $inventory->product);
        $this->assertEquals('Inventory Product', $inventory->product->name);
    }

    public function test_inventory_fillable_attributes()
    {
        $inventory = new Inventory();
        $fillable = $inventory->getFillable();
        
        $expectedFillable = [
            'product_id',
            'quantity'
        ];

        $this->assertEquals($expectedFillable, $fillable);
    }

    public function test_inventory_quantity_is_required()
    {
        $product = Product::create([
            'name' => 'Test Product',
            'price' => 15.00,
            'quantity' => 50,
            'perishable' => 'no'
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Inventory::create([
            'product_id' => $product->id
            // Missing required 'quantity' field
        ]);
    }

    public function test_inventory_product_id_is_required()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Inventory::create([
            'quantity' => 25
            // Missing required 'product_id' field
        ]);
    }

    public function test_inventory_casts()
    {
        $product = Product::create([
            'name' => 'Cast Product',
            'price' => 15.00,
            'quantity' => 50,
            'perishable' => 'no'
        ]);

        $inventory = Inventory::create([
            'product_id' => $product->id,
            'quantity' => '15'
        ]);

        $this->assertIsInt($inventory->quantity);
        $this->assertEquals(15, $inventory->quantity);
    }

    public function test_inventory_product_relationship()
    {
        $product = Product::create([
            'name' => 'Relationship Product',
            'price' => 30.00,
            'quantity' => 75,
            'perishable' => 'no'
        ]);

        $inventory = Inventory::create([
            'product_id' => $product->id,
            'quantity' => 25
        ]);

        $retrievedInventory = Inventory::with('product')->find($inventory->id);
        
        $this->assertEquals('Relationship Product', $retrievedInventory->product->name);
        $this->assertEquals($product->id, $retrievedInventory->product->id);
    }
}