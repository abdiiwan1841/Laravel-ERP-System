<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'create slaes invoice',
            'edit slaes invoice',
            'delete slaes invoice',
            'show slaes reports',

            'create purchase invoice',
            'edit purchase invoice',
            'delete purchase invoice',
            'show purchases reports',

            'display stock movement price',
            'edit stock movement price',
            'add storage permission',
            'edit storage permission',
            'show storage permission',
            'delete storage permission',
            'Allow buy less than the lowest price of product',
            'stock tracking',
            'stock transfer',

            'add new employee',
            'edit employee',
            'delete employee',
            'show employee profile',
            'add new role',
            'edit role',
            'delete role',
            'add new permission',
            'edit permission',
            'delete permission',
        ];
        foreach ($permissions as $permission)
        {
            Permission::create(['name' => $permission]);
        }
    }
}
