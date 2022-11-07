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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->default('client');
            $table->string('email')->unique()->nullable();
            $table->text('phone')->nullable();
            $table->text('mobile')->nullable();
            $table->text('phone_code')->nullable();
            $table->text('street_address')->nullable();
            $table->text('city')->nullable();
            $table->text('state')->nullable();
            $table->text('postal_code')->nullable();
            $table->text('country')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->bigInteger('opening_balance')->nullable();
            $table->date('opening_balance_date')->nullable();
            $table->mediumText('notes')->nullable();
            $table->integer('status')->default(1)->nullable();
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
        Schema::dropIfExists('clients');
    }
};
