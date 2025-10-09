<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        // Remove columns since the user does not want them stored in past orders and items
        Schema::table('past_orders', function (Blueprint $table) {
            if (Schema::hasColumn('past_orders', 'total_profit')) {
                $table->dropColumn('total_profit');
            }
        });

        Schema::table('past_order_items', function (Blueprint $table) {
            if (Schema::hasColumn('past_order_items', 'profit')) {
                $table->dropColumn('profit');
            }
            if (Schema::hasColumn('past_order_items', 'cost_price')) {
                $table->dropColumn('cost_price');
            }
        });
    }

    public function down(): void
    {
        // Recreate dropped columns on rollback
        Schema::table('past_orders', function (Blueprint $table) {
            if (! Schema::hasColumn('past_orders', 'total_profit')) {
                $table->decimal('total_profit', 12, 2)->default(0)->after('total_amount');
            }
        });

        Schema::table('past_order_items', function (Blueprint $table) {
            if (! Schema::hasColumn('past_order_items', 'cost_price')) {
                $table->decimal('cost_price', 10, 2)->nullable()->after('price');
            }
            if (! Schema::hasColumn('past_order_items', 'profit')) {
                $table->decimal('profit', 12, 2)->default(0)->after('cost_price');
            }
        });
    }
};
