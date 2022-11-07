<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInvoicePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_invoice_id')->constrained('purchase_invoices')->onDelete('cascade');
            $table->string('deposit_payment_method')->default('cash')->nullable();
            $table->mediumText('payment_amount')->nullable()->default('0.00');
            $table->date('payment_date')->nullable();
            $table->string('payment_status')->default('completed')->nullable();
            $table->foreignId('collected_by_id')->constrained('users')->onDelete('cascade');
            $table->bigInteger('transaction_id')->nullable();
            $table->text('receipt_notes')->nullable();
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
        Schema::dropIfExists('purchase_invoice_payments');
    }
}
