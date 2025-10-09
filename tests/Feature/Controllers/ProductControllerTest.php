<?php

namespace Tests\Feature\Controllers;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_api_returns_paginated_data()
    {
        // Create test data
        Branch::create(['name' => 'Test Branch']);
        Brand::create(['name' => 'Test Brand']);

        Product::create([
            'name' => 'Apple',
            'price' => 32.00,
            'original_price' => 12.00,
            'quantity' => 50,
            'perishable' => 'yes',
        ]);

        Product::create([
            'name' => 'Orange',
            'price' => 25.00,
            'original_price' => 15.00,
            'quantity' => 30,
            'perishable' => 'yes',
        ]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'price',
                            'original_price',
                            'quantity',
                            'perishable',
                        ],
                    ],
                    'current_page',
                    'per_page',
                    'total',
                ]);
    }

    public function test_products_api_returns_correct_original_price()
    {
        Branch::create(['name' => 'Test Branch']);
        Brand::create(['name' => 'Test Brand']);

        $product = Product::create([
            'name' => 'Apple',
            'price' => 32.00,
            'original_price' => 12.00,
            'quantity' => 50,
            'perishable' => 'yes',
        ]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);

        $data = $response->json();
        $appleProduct = collect($data['data'])->firstWhere('name', 'Apple');

        $this->assertNotNull($appleProduct);
        $this->assertEquals(12.00, $appleProduct['original_price']);
        $this->assertEquals(32.00, $appleProduct['price']);
    }

    public function test_products_api_with_search_filter()
    {
        Branch::create(['name' => 'Test Branch']);
        Brand::create(['name' => 'Test Brand']);

        Product::create([
            'name' => 'Apple Juice',
            'price' => 25.00,
            'original_price' => 10.00,
            'quantity' => 40,
            'perishable' => 'yes',
        ]);

        Product::create([
            'name' => 'Orange Juice',
            'price' => 30.00,
            'original_price' => 15.00,
            'quantity' => 35,
            'perishable' => 'yes',
        ]);

        $response = $this->getJson('/api/products?search=Apple');

        $response->assertStatus(200);

        $data = $response->json();
        $this->assertEquals(1, count($data['data']));
        $this->assertEquals('Apple Juice', $data['data'][0]['name']);
    }

    public function test_products_api_pagination_parameters()
    {
        Branch::create(['name' => 'Test Branch']);
        Brand::create(['name' => 'Test Brand']);

        // Create 15 products to test pagination
        for ($i = 1; $i <= 15; $i++) {
            Product::create([
                'name' => "Product {$i}",
                'price' => 20.00 + $i,
                'original_price' => 10.00 + $i,
                'quantity' => 50,
                'perishable' => 'no',
            ]);
        }

        $response = $this->getJson('/api/products?per_page=5&page=2');

        $response->assertStatus(200);

        $data = $response->json();
        $this->assertEquals(2, $data['current_page']);
        $this->assertEquals(5, $data['per_page']);
        $this->assertEquals(15, $data['total']);
        $this->assertEquals(5, count($data['data']));
    }

    public function test_products_api_handles_empty_results()
    {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [],
                    'total' => 0,
                ]);
    }

    public function test_products_api_with_invalid_search()
    {
        Branch::create(['name' => 'Test Branch']);
        Brand::create(['name' => 'Test Brand']);

        Product::create([
            'name' => 'Apple',
            'price' => 32.00,
            'original_price' => 12.00,
            'quantity' => 50,
            'perishable' => 'yes',
        ]);

        $response = $this->getJson('/api/products?search=NonexistentProduct');

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [],
                    'total' => 0,
                ]);
    }

    public function test_products_api_profit_calculation()
    {
        Branch::create(['name' => 'Test Branch']);
        Brand::create(['name' => 'Test Brand']);

        Product::create([
            'name' => 'Profit Product',
            'price' => 50.00,
            'original_price' => 30.00,
            'quantity' => 25,
            'perishable' => 'no',
        ]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);

        $data = $response->json();
        $product = $data['data'][0];

        // Verify the API returns the correct data for profit calculation
        $expectedProfit = $product['price'] - $product['original_price']; // 50 - 30 = 20
        $this->assertEquals(20.00, $expectedProfit);
        $this->assertEquals(30.00, $product['original_price']);
        $this->assertEquals(50.00, $product['price']);
    }
}
