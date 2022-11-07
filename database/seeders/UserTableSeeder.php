<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'first_name' => 'Admin',
            'middle_name' => 'Admin',
            'last_name' => 'Admin',
            'gender'    => 'male',
            'birth_date' => '1986-10-01',
            'email' => 'admin@app.com',
            'phone' => '01090411575',
            'address_1' => 'company address',
            'address_2' => 'company address',
            'password' => bcrypt('12345678'),
            'roles_name' => ["admin"],
            'status' => 1,
            'branch_id' => 1,
            'department_id' => 1,
            'job_id' => 2,
            'system_not_user' => 0,
            'system_user'   => 1,
//            'number'    => 2,
//            'sequential_code_id' => 2,
//            'full_code' => 'USER-00002'
        ]);
        $role = Role::where('name', 'admin')->first();
//        $permissions = Permission::pluck('id','id')->all();
//        $role->syncPermissions($permissions);
        $admin->assignRole([$role->id]);

        $user = User::create([
            'first_name' => 'User',
            'middle_name' => 'User',
            'last_name' => 'User',
            'gender'    => 'male',
            'birth_date' => '1986-10-01',
            'email' => 'user@app.com',
            'phone' => '01090411576',
            'address_1' => 'company address',
            'address_2' => 'company address',
            'password' => bcrypt('12345678'),
            'roles_name' => ["staff"],
            'status' => 1,
            'branch_id' => 1,
            'department_id' => 1,
            'job_id' => 3,
            'system_not_user' => 0,
            'system_user'   => 1,
//            'number'    => 3,
//            'sequential_code_id' => 2,
//            'full_code' => 'USER-00003'
        ]);
        $role = Role::where('name', 'staff')->first();
//        $permissions = Permission::pluck('id','id')->first();
//        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
