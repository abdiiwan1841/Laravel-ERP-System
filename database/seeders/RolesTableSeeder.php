<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        $roles = [
            'superadmin',
            'admin',
            'staff',
        ];
        foreach ($roles as $role)
        {
            Role::create(['name' => $role]);
        }

        $superadminRole = Role::where('name' , 'superadmin')->first();
        $superadminPermissions = Permission::pluck('id','id')->all();
        $superadminRole->syncPermissions($superadminPermissions);

        $adminRole = Role::where('name', 'admin')->first();
        $adminPermissions = Permission::pluck('id','id')->all();
        $adminRole->syncPermissions($adminPermissions);

        $staffRole = Role::where('name', 'staff')->first();
        $staffPermissions = Permission::pluck('id','id')->first();
        $staffRole->syncPermissions($staffPermissions);

    }
}
