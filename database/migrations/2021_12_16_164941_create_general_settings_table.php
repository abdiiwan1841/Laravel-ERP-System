<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->text('business_name');
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
            $table->text('postal_code');
            $table->text('country');
            $table->text('commercial_record');
            $table->text('tax_registration');
            $table->string('basic_currency');
            $table->string('basic_currency_symbol');
            $table->json('extra_currencies');
            $table->json('extra_currencies_symbols');
            $table->string('time_zone');
            $table->string('language');
            $table->string('logo')->default('defaultLogo.png');
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
        Schema::dropIfExists('general_settings');
    }
}
