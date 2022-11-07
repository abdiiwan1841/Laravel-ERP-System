<?php

namespace Database\Seeders;

use App\Models\ERP\Branch;
use App\Models\ERP\Inventory\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('warehouses')->delete();

        Warehouse::factory(count(Branch::all()))->create();
    }
}
