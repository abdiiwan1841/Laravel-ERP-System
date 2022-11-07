<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_totals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('total_quantity_purchased', 12, 2)->default(0.00);
            $table->decimal('total_purchases_cost', 12, 2)->default(0.00);
            $table->decimal('total_sales_value_of_purchases', 12, 2)->default(0.00);
            $table->decimal('expected_profit', 12, 2)->default(0.00);
            $table->decimal('total_quantity_sold', 12, 2)->default(0.00);
            $table->decimal('total_sold_cost', 12, 2)->default(0.00);
            $table->decimal('total_value_of_sales', 12, 2)->default(0.00);
            $table->decimal('actual_profit', 12, 2)->default(0.00);
            $table->decimal('weighted_average_cost', 12, 2)->default(0.00);
            $table->decimal('total_quantity_remain', 12, 2)->default(0.00);
            $table->decimal('total_remain_cost', 12, 2)->default(0.00);
            $table->decimal('total_sales_value_of_remain', 12, 2)->default(0.00);
            $table->decimal('expected_profit_of_remain', 12, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_totals');
    }
};
