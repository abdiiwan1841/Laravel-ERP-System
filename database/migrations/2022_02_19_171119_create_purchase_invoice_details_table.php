<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_invoice_id')->constrained('purchase_invoices')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade');
            $table->text('description')->nullable();
            $table->decimal('quantity', 8, 2)->default(0.00);
            $table->decimal('unit_price', 8, 2)->default(0.00);
            $table->unsignedBigInteger('first_tax_id')->nullable();
            $table->foreign('first_tax_id')->references('id')->on('taxes')->onUpdate('cascade');
            $table->unsignedBigInteger('second_tax_id')->nullable();
            $table->foreign('second_tax_id')->references('id')->on('taxes')->onUpdate('cascade');
            $table->mediumText('row_total')->default(0.00);
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
        Schema::dropIfExists('purchase_invoice_details');
    }
}
