<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add original_price to products if not exists
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'original_price')) {
                $table->decimal('original_price', 10, 2)->nullable()->after('price');
            }
        });

        // Migrate existing data from inventory.original_price to products.original_price
        if (Schema::hasTable('inventory') && Schema::hasColumn('inventory', 'original_price')) {
            DB::statement(
                'UPDATE products p 
                 JOIN inventory i ON i.product_id = p.id 
                 SET p.original_price = i.original_price 
                 WHERE i.original_price IS NOT NULL'
            );
        }

        // Drop original_price from inventory if exists
        if (Schema::hasTable('inventory') && Schema::hasColumn('inventory', 'original_price')) {
            Schema::table('inventory', function (Blueprint $table) {
                $table->dropColumn('original_price');
            });
        }
    }

    public function down(): void
    {
        // Re-add column to inventory
        if (Schema::hasTable('inventory') && !Schema::hasColumn('inventory', 'original_price')) {
            Schema::table('inventory', function (Blueprint $table) {
                $table->decimal('original_price', 10, 2)->nullable()->after('quantity');
            });
        }

        // Move data back from products to inventory where possible
        if (Schema::hasTable('inventory') && Schema::hasColumn('inventory', 'original_price')) {
            DB::statement(
                'UPDATE inventory i 
                 JOIN products p ON p.id = i.product_id 
                 SET i.original_price = p.original_price 
                 WHERE p.original_price IS NOT NULL'
            );
        }

        // Drop from products
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'original_price')) {
                $table->dropColumn('original_price');
            }
        });
    }
};
