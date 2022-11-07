<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->text('commercial_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->text('phone');
            $table->text('mobile');
            $table->text('fax');
            $table->text('phone_code');
            $table->text('street_address');
            $table->text('city');
            $table->text('state');
            $table->text('postal_code')->nullable();
            $table->text('country');
            $table->text('commercial_record');
            $table->text('tax_registration');
            $table->string('currency');
            $table->string('currency_symbol');
            $table->bigInteger('opening_balance');
            $table->date('opening_balance_date');
            $table->mediumText('notes');
            $table->integer('status')->default(1);
            $table->string('created_by');
            $table->unsignedBigInteger('sequential_code_id');
            $table->foreign('sequential_code_id')->references('id')->on('sequential_codes')->onDelete('cascade');
            $table->bigInteger('number')->default(0);
            $table->string('full_code')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
