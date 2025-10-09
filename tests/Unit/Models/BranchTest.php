<?php

namespace Tests\Unit\Models;

use App\Models\Branch;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchTest extends TestCase
{
    use RefreshDatabase;

    public function test_branch_can_be_created()
    {
        $branch = Branch::create([
            'name' => 'Test Branch',
            'location' => 'Test Location',
            'manager_id' => null,
        ]);

        $this->assertInstanceOf(Branch::class, $branch);
        $this->assertEquals('Test Branch', $branch->name);
        $this->assertEquals('Test Location', $branch->location);
    }

    public function test_branch_belongs_to_manager()
    {
        $manager = User::create([
            'name' => 'Branch Manager',
            'email' => 'manager@test.com',
            'password' => bcrypt('password'),
            'role' => 'manager',
        ]);

        $branch = Branch::create([
            'name' => 'Managed Branch',
            'location' => 'Manager Location',
            'manager_id' => $manager->id,
        ]);

        $this->assertInstanceOf(User::class, $branch->manager);
        $this->assertEquals('Branch Manager', $branch->manager->name);
        $this->assertEquals('manager', $branch->manager->role);
    }

    public function test_branch_has_many_sales()
    {
        $branch = Branch::create(['name' => 'Sales Branch']);
        $product = Product::create(['name' => 'Test Product', 'price' => 20.00, 'quantity' => 100, 'perishable' => 'no']);

        $sales1 = Sales::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'quantity_sold' => 5,
            'unit_price' => 20.00,
            'total_amount' => 100.00,
        ]);

        $sales2 = Sales::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'quantity_sold' => 3,
            'unit_price' => 20.00,
            'total_amount' => 60.00,
        ]);

        $this->assertCount(2, $branch->sales);
        $this->assertInstanceOf(Sales::class, $branch->sales->first());
    }

    public function test_branch_has_many_inventory()
    {
        $branch = Branch::create(['name' => 'Inventory Branch']);
        $product = Product::create(['name' => 'Test Product', 'price' => 15.00, 'quantity' => 50, 'perishable' => 'no']);

        $inventory1 = Inventory::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'quantity_added' => 20,
            'unit_cost' => 10.00,
            'total_cost' => 200.00,
            'date_added' => now(),
        ]);

        $inventory2 = Inventory::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'quantity_added' => 15,
            'unit_cost' => 10.00,
            'total_cost' => 150.00,
            'date_added' => now(),
        ]);

        $this->assertCount(2, $branch->inventory);
        $this->assertInstanceOf(Inventory::class, $branch->inventory->first());
    }

    public function test_branch_name_is_required()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Branch::create([
            'location' => 'Test Location',
        ]);
    }

    public function test_branch_fillable_attributes()
    {
        $branch = new Branch();
        $fillable = $branch->getFillable();

        $expectedFillable = [
            'name',
            'location',
            'manager_id',
        ];

        $this->assertEquals($expectedFillable, $fillable);
    }

    public function test_branch_can_have_null_manager()
    {
        $branch = Branch::create([
            'name' => 'No Manager Branch',
            'location' => 'Unmanaged Location',
            'manager_id' => null,
        ]);

        $this->assertNull($branch->manager_id);
        $this->assertNull($branch->manager);
    }

    public function test_branch_manager_relationship_with_existing_user()
    {
        $user = User::create([
            'name' => 'Test Manager',
            'email' => 'test.manager@example.com',
            'password' => bcrypt('password'),
            'role' => 'manager',
        ]);

        $branch = Branch::create([
            'name' => 'Test Branch',
            'location' => 'Test Location',
            'manager_id' => $user->id,
        ]);

        $this->assertEquals($user->id, $branch->manager_id);
        $this->assertEquals('Test Manager', $branch->manager->name);
    }
}
