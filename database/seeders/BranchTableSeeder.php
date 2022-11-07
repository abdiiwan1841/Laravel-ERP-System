<?php

namespace Database\Seeders;

use App\Models\ERP\Branch;
use Illuminate\Database\Seeder;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::create([
            'number'    => 1,
            'name_ar' => 'المركز الرئيسى',
            'name_en' => 'Main Branch',
            'address_ar' => 'القاهرة',
            'address_en' => 'Cairo',
            'sequential_code_id' => 1,
            'full_code' => 'BRAN-00001'
        ]);

        Branch::create([
            'number'    => 2,
            'name_ar' => 'أسوان',
            'name_en' => 'Aswan',
            'address_ar' => 'أسوان',
            'address_en' => 'Aswan',
            'sequential_code_id' => 1,
            'full_code' => 'BRAN-00002'
        ]);
    }
}
