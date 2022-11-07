<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PermissionsCategory;

class PermissionsCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions_categories')->delete();

        $perms_cate_en = [
            'sales',
            'purchases',
            'stocks',
            'human resources'
        ];

        $perms_cate_ar = [
            'المبيعات',
            'المشتريات',
            'المخازن',
            'الموارد البشرية'
        ];
        foreach ($perms_cate_en as $cat_en)
        {
            PermissionsCategory::create([
                'name_en' => $cat_en,
            ]);
        }

        $categories = PermissionsCategory::all()->pluck('id')->toArray();
        for($i=0, $iMax = count($perms_cate_en); $i < $iMax; $i++){
            PermissionsCategory::where('id', $categories[$i])->update([
                'name_en' =>  $perms_cate_en[$i],
                'name_ar' =>  $perms_cate_ar[$i],
            ]);
        }
    }
}
