<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('roles')->delete();
        DB::table('users')->delete();

        $user = User::create([
            'first_name' => 'Super',
            'middle_name' => 'Super',
            'last_name' => 'Admin',
            'gender'    => 'male',
            'birth_date' => '1986-10-01',
            'email' => 'superadmin@app.com',
            'phone' => '01090411577',
            'address_1' => 'company address',
            'address_2' => 'company address',
            'password' => bcrypt('12345678'),
            'roles_name' => ["superadmin"],
            'status' => 1,
            'branch_id' => 1,
            'department_id' => 1,
            'job_id' => 1,
            'system_not_user' => 0,
            'system_user'   => 1,
//            'number'    => 1,
//            'sequential_code_id' => 2,
//            'full_code' => 'USER-00001'
        ]);

        $role = Role::where('name' , 'superadmin')->first();

//        $permissions = Permission::pluck('id','id')->all();
//
//        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
