<?php

namespace Database\Seeders;

use App\Models\ERP\Settings\SequentialCode;
use Illuminate\Database\Seeder;

class SequentialCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SequentialCode::create([
            'prefix' => 'BRAN',
            'numbers_length' => 5,
            'model' => 'branches',
        ]);

        SequentialCode::create([
            'prefix' => 'USER',
            'numbers_length' => 5,
            'model' => 'users',
        ]);

        SequentialCode::create([
            'prefix' => 'PRO',
            'numbers_length' => 5,
            'model' => 'products',
        ]);

        SequentialCode::create([
            'prefix' => 'PUR-INV',
            'numbers_length' => 5,
            'model' => 'purchase_invoices',
        ]);

        SequentialCode::create([
            'prefix' => 'SUPP',
            'numbers_length' => 5,
            'model' => 'suppliers',
        ]);

        SequentialCode::create([
            'prefix' => 'CLNT',
            'numbers_length' => 5,
            'model' => 'clients',
        ]);

        SequentialCode::create([
            'prefix' => 'SLS-INV',
            'numbers_length' => 5,
            'model' => 'sales_invoices',
        ]);
    }
}
