<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sequential_code_id');
            $table->foreign('sequential_code_id')->references('id')->on('sequential_codes')->onDelete('cascade');
            $table->bigInteger('number')->default(0);
            $table->string('inv_number')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onUpdate('cascade');

            $table->mediumText('subtotal')->default('0.00');
            $table->decimal('discount', 8, 2)->default(0.00)->nullable();
            $table->integer('discount_type')->default(1)->nullable()->comment('1 for percentage 0 for cash amount');
            $table->mediumText('discount_inv')->default('0.00')->nullable();

            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onUpdate('cascade');
            $table->decimal('shipping_expense', 8, 2)->default(0.00)->nullable();
            $table->mediumText('shipping_expense_inv')->default('0.00')->nullable();
            $table->mediumText('total_inv')->default('0.00')->nullable();

            $table->decimal('down_payment', 8, 2)->default(0.00)->nullable();
            $table->integer('down_payment_type')->default(1)->nullable()->comment('1 for percentage 0 for cash amount');
            $table->mediumText('down_payment_inv')->default('0.00')->nullable();
            $table->mediumText('due_amount')->default('0.00')->nullable();
            $table->string('deposit_payment_method')->default('cash')->nullable();
            $table->bigInteger('deposit_transaction_id')->nullable();

            $table->string('payment_payment_method')->default('cash')->nullable();
            $table->bigInteger('payment_transaction_id')->nullable();
            $table->mediumText('paid_to_supplier_inv')->default('0.00')->nullable();
            $table->mediumText('due_amount_after_paid')->default('0.00')->nullable();
            $table->decimal('payments_total', 12, 2)->default(0.00)->nullable();
            $table->decimal('due_amount_after_payments', 12, 2)->default(0.00)->nullable();

            $table->text('notes')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');

            $table->integer('payment_status')->default(1)->nullable()->comment('1 unpaid, 2 partially paid, 3 paid');
            $table->integer('receiving_status')->default(1)->nullable()->comment('1 under receive, 2 received');
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
        Schema::dropIfExists('purchase_invoices');
    }
}
