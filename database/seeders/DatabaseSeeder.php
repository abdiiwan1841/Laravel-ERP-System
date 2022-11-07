<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            PermissionsTableSeeder::class,
            PermissionsCategoryTableSeeder::class,
            TranslatedPermissionsTableSeeder::class,
            RolesTableSeeder::class,
            TranslatedRolesTableSeeder::class,
            SequentialCodeTableSeeder::class,
            BranchTableSeeder::class,
            JobsTableSeeder::class,
            CreateSuperAdminSeeder::class,
            UserTableSeeder::class,
            TaxesTableSeeder::class,
            MeasurementUnitsTableSeeder::class,
            GeneralSettingsTableSeeder::class,
            ProductsSettingsTableSeeder::class,
            SuppliersTableSeeder::class,
            ClientsTableSeeder::class,
            ProductsTableSeeder::class,
            WarehousesTableSeeder::class,
//            PurchaseInvoicesTableSeeder::class,
//            SalesInvoicesTableSeeder::class
        ]);
    }
}
