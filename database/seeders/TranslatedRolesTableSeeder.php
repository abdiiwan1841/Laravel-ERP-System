<?php

namespace Database\Seeders;

use App\Models\TranslatedRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class TranslatedRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('translated_roles')->delete();

        $rolesID = Role::all()->pluck('id');

        $roles_en = [
            'superadmin',
            'admin',
            'staff',
        ];

        $roles_ar = [
            'مشرف عام',
            'مشرف',
            'موظف',
        ];

        foreach ($rolesID as $role_id){
            TranslatedRole::create([
                'role_id' =>  $role_id,
            ]);
        }

        $roles = TranslatedRole::all()->pluck('role_id')->toArray();
        for($i=0, $iMax = count($roles_en); $i < $iMax; $i++){
            TranslatedRole::where('role_id', $roles[$i])->update([
                'name_en' =>  $roles_en[$i],
                'name_ar' =>  $roles_ar[$i],
                'role_id' =>  $roles[$i],
            ]);
        }

    }
}
