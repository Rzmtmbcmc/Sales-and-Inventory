<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Sales;
use App\Models\Branch;
use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_analytics_returns_correct_structure()
    {
        $this->createTestData();

        $response = $this->getJson('/api/dashboard/analytics');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'totalSales',
                    'totalProfit',
                    'totalProducts',
                    'lowStockProducts',
                    'salesData',
                    'profitData'
                ]);
    }

    public function test_dashboard_profit_calculation_with_original_price()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);
        
        // Create product with known original price
        $product = Product::create([
            'name' => 'Apple',
            'price' => 32.00,
            'original_price' => 12.00,
            'quantity' => 50,
            'perishable' => 'yes'
        ]);

        // Create sales record
        Sales::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'quantity_sold' => 10,
            'unit_price' => 32.00,
            'total_amount' => 320.00,
            'profit_per_unit' => 20.00, // 32 - 12 = 20
            'total_profit' => 200.00,   // 20 * 10 = 200
            'created_at' => now()
        ]);

        $response = $this->getJson('/api/dashboard/analytics');

        $response->assertStatus(200);
        
        $data = $response->json();
        
        // Verify profit calculations use original_price correctly
        $this->assertEquals(320.00, $data['totalSales']);
        $this->assertEquals(200.00, $data['totalProfit']);
    }

    public function test_dashboard_handles_null_original_price()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);
        
        // Create product without original price
        $product = Product::create([
            'name' => 'No Cost Product',
            'price' => 25.00,
            'original_price' => null,
            'quantity' => 30,
            'perishable' => 'no'
        ]);

        Sales::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'quantity_sold' => 5,
            'unit_price' => 25.00,
            'total_amount' => 125.00,
            'profit_per_unit' => 25.00, // Should use 0 as original cost when null
            'total_profit' => 125.00,
            'created_at' => now()
        ]);

        $response = $this->getJson('/api/dashboard/analytics');

        $response->assertStatus(200);
        
        $data = $response->json();
        
        // Should handle null original_price gracefully
        $this->assertEquals(125.00, $data['totalSales']);
        $this->assertEquals(125.00, $data['totalProfit']);
    }

    public function test_dashboard_low_stock_products()
    {
        Branch::create(['name' => 'Test Branch']);
        Brand::create(['name' => 'Test Brand']);
        
        // Create low stock product
        Product::create([
            'name' => 'Low Stock Item',
            'price' => 15.00,
            'original_price' => 8.00,
            'quantity' => 5, // Low stock
            'perishable' => 'no'
        ]);

        // Create normal stock product
        Product::create([
            'name' => 'Normal Stock Item',
            'price' => 20.00,
            'original_price' => 12.00,
            'quantity' => 50, // Normal stock
            'perishable' => 'no'
        ]);

        $response = $this->getJson('/api/dashboard/analytics');

        $response->assertStatus(200);
        
        $data = $response->json();
        
        $this->assertEquals(1, $data['lowStockProducts']);
        $this->assertEquals(2, $data['totalProducts']);
    }

    public function test_dashboard_sales_trend_data()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);
        $product = Product::create([
            'name' => 'Trend Product',
            'price' => 30.00,
            'original_price' => 18.00,
            'quantity' => 100,
            'perishable' => 'no'
        ]);

        // Create sales for different dates
        Sales::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'quantity_sold' => 5,
            'unit_price' => 30.00,
            'total_amount' => 150.00,
            'profit_per_unit' => 12.00,
            'total_profit' => 60.00,
            'created_at' => now()->subDays(2)
        ]);

        Sales::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'quantity_sold' => 8,
            'unit_price' => 30.00,
            'total_amount' => 240.00,
            'profit_per_unit' => 12.00,
            'total_profit' => 96.00,
            'created_at' => now()->subDay()
        ]);

        $response = $this->getJson('/api/dashboard/analytics');

        $response->assertStatus(200);
        
        $data = $response->json();
        
        $this->assertIsArray($data['salesData']);
        $this->assertIsArray($data['profitData']);
        $this->assertEquals(390.00, $data['totalSales']); // 150 + 240
        $this->assertEquals(156.00, $data['totalProfit']); // 60 + 96
    }

    public function test_dashboard_with_no_data()
    {
        $response = $this->getJson('/api/dashboard/analytics');

        $response->assertStatus(200)
                ->assertJson([
                    'totalSales' => 0,
                    'totalProfit' => 0,
                    'totalProducts' => 0,
                    'lowStockProducts' => 0,
                    'salesData' => [],
                    'profitData' => []
                ]);
    }

    private function createTestData()
    {
        $branch = Branch::create(['name' => 'Test Branch']);
        $brand = Brand::create(['name' => 'Test Brand']);
        
        $product = Product::create([
            'name' => 'Test Product',
            'price' => 25.00,
            'original_price' => 15.00,
            'quantity' => 40,
            'perishable' => 'no'
        ]);

        Sales::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'brand_id' => $brand->id,
            'quantity_sold' => 3,
            'unit_price' => 25.00,
            'total_amount' => 75.00,
            'profit_per_unit' => 10.00,
            'total_profit' => 30.00,
            'created_at' => now()
        ]);
    }
}