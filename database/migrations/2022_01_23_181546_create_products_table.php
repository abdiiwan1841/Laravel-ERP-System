<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->mediumText('description');
            $table->unsignedBigInteger('section_id')->nullable();
            $table->foreign('section_id')->references('id')->on('sections')->onUpdate('cascade');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands')->onUpdate('cascade');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade');
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->onUpdate('cascade');
            $table->unsignedBigInteger('unit_template_id')->nullable();
            $table->foreign('unit_template_id')->references('id')->on('units_templates')->onUpdate('cascade');
            $table->unsignedBigInteger('measurement_unit_id')->nullable();
            $table->foreign('measurement_unit_id')->references('id')->on('measurement_units')->onUpdate('cascade');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onUpdate('cascade');
            $table->decimal('total_quantity', 8, 2)->default(0);
            $table->decimal('purchase_price', 8, 2);
            $table->decimal('sell_price', 8, 2);
            $table->unsignedBigInteger('first_tax_id')->nullable();
            $table->foreign('first_tax_id')->references('id')->on('taxes')->onUpdate('cascade');
            $table->unsignedBigInteger('second_tax_id')->nullable();
            $table->foreign('second_tax_id')->references('id')->on('taxes')->onUpdate('cascade');
            $table->decimal('lowest_sell_price', 8, 2)->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->integer('discount_type')->default(1)->nullable()->comment('1 for percentage 0 for cash amount');
            $table->decimal('profit_margin', 8, 2)->nullable();
            $table->decimal('lowest_stock_alert', 8, 2)->nullable();
            $table->mediumText('notes')->nullable();
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('sequential_code_id');
            $table->foreign('sequential_code_id')->references('id')->on('sequential_codes')->onDelete('cascade');
            $table->bigInteger('number')->default(0);
            $table->string('sku')->nullable()->comment('Stock Keeping Unit');
            $table->text('barcode')->nullable();
            $table->string('product_image')->default('defaultProduct.png');
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
        Schema::dropIfExists('products');
    }
}
