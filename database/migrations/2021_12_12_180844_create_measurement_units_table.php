<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasurementUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurement_units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('units_template_id');
            $table->foreign('units_template_id')->references('id')->on('units_templates')->onDelete('cascade');
            $table->string('largest_unit_ar');
            $table->string('largest_unit_en');
            $table->string('largest_unit_symbol_ar');
            $table->string('largest_unit_symbol_en');
            $table->decimal('conversion_factor', 12, 2);
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
        Schema::dropIfExists('measurement_units');
    }
}
