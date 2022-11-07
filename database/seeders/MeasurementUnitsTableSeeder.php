<?php

namespace Database\Seeders;

use App\Models\ERP\Settings\MeasurementUnit;
use App\Models\ERP\Settings\UnitsTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeasurementUnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units_templates')->delete();
        DB::table('measurement_units')->delete();

        UnitsTemplate::create([
            'template_name_ar' => 'الكمية',
            'template_name_en' => 'Quantity',
            'main_unit_ar' => 'قطعة',
            'main_unit_en' => 'Unit',
            'main_unit_symbol_ar' => 'ق',
            'main_unit_symbol_en' => 'U',
        ]);

        UnitsTemplate::create([
            'template_name_ar' => 'الوزن',
            'template_name_en' => 'Weight',
            'main_unit_ar' => 'جرام',
            'main_unit_en' => 'Gram',
            'main_unit_symbol_ar' => 'جم',
            'main_unit_symbol_en' => 'GM',
        ]);

        MeasurementUnit::create([
            'units_template_id' => 1,
            'largest_unit_ar' => 'قطعة',
            'largest_unit_en' => 'piece',
            'largest_unit_symbol_ar' => 'ق',
            'largest_unit_symbol_en' => 'pc',
            'conversion_factor' => 1.00,
        ]);

        MeasurementUnit::create([
            'units_template_id' => 2,
            'largest_unit_ar' => 'كيلو جرام',
            'largest_unit_en' => 'Kilogram',
            'largest_unit_symbol_ar' => 'كجم',
            'largest_unit_symbol_en' => 'KG',
            'conversion_factor' => 1000.00,
        ]);
    }
}
