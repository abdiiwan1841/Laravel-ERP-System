<?php

namespace Database\Seeders;

use App\Models\ERP\Settings\Tax;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taxes')->delete();

        Tax::create([
            'tax_name_ar' => 'القيمة المضافة',
            'tax_name_en' => 'Value Add',
            'tax_value' => 14,
            'unit_price_inc' => 0,
        ]);

        Tax::create([
            'tax_name_ar' => 'الدمغة',
            'tax_name_en' => 'Damgha',
            'tax_value' => 2,
            'unit_price_inc' => 0,
        ]);

    }
}
