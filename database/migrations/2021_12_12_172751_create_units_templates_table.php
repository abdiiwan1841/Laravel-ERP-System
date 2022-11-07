<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units_templates', function (Blueprint $table) {
            $table->id();
            $table->string('template_name_ar');
            $table->string('template_name_en');
            $table->string('main_unit_ar');
            $table->string('main_unit_en');
            $table->string('main_unit_symbol_ar');
            $table->string('main_unit_symbol_en');
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
        Schema::dropIfExists('units_templates');
    }
}
