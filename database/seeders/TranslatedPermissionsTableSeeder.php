<?php

namespace Database\Seeders;

use App\Models\PermissionsCategory;
use Illuminate\Database\Seeder;
use App\Models\TranslatedPermission;
use Spatie\Permission\Models\Permission;

class TranslatedPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('translated_permissions')->delete();

        $permissionsID = Permission::all()->pluck('id');

        foreach ($permissionsID as $permission_id){
            TranslatedPermission::create([
                'permission_id' =>  $permission_id,
                'category_id' =>  1,
            ]);
        }

        //sales permissions
        $sales_permissions = TranslatedPermission::where('permission_id', '<=', 4)->pluck('permission_id')->toArray();
        $sales_en = [
            'create slaes invoice',
            'edit slaes invoice',
            'delete slaes invoice',
            'show slaes reports'
        ];

        $sales_ar = [
            'إضافة فاتورة بيع',
            'تعديل فاتورة بيع',
            'حذف فاتورة بيع',
            'عرض تقارير المبيعات'
        ];

        for($i=0, $iMax = count($sales_en); $i < $iMax; $i++){
            TranslatedPermission::where('permission_id', $sales_permissions[$i])->update([
                'name_en' =>  $sales_en[$i],
                'name_ar' =>  $sales_ar[$i],
                'permission_id' => $sales_permissions[$i],
                'category_id' => 1
            ]);
        }


        //purchases permissions
        $purchases_permissions = TranslatedPermission::where('permission_id', '>' ,4)->where('permission_id', '<=' ,8)->pluck('permission_id')->toArray();
        $purchases_en = [
            'create purchase invoice',
            'edit purchase invoice',
            'delete purchase invoice',
            'show purchases reports'
        ];

        $purchases_ar = [
            'إضافة فاتورة مشتريات',
            'تعديل فاتورة مشتريات',
            'حذف فاتورة مشتريات',
            'عرض تقارير المشتريات'
        ];

        for($i=0, $iMax = count($purchases_en); $i < $iMax; $i++){
            TranslatedPermission::where('permission_id', $purchases_permissions[$i])->update([
                'name_en' =>  $purchases_en[$i],
                'name_ar' =>  $purchases_ar[$i],
                'permission_id' => $purchases_permissions[$i],
                'category_id' => 2
            ]);
        }

        //stocks permissions
        $stocks_permissions = TranslatedPermission::where('permission_id', '>' ,8)->where('permission_id', '<=' ,17)->pluck('permission_id')->toArray();
        $stocks_en = [
            'display stock movement price',
            'edit stock movement price',
            'add storage permission',
            'edit storage permission',
            'show storage permission',
            'delete storage permission',
            'Allow buy less than the lowest price of product',
            'stock tracking',
            'stock transfer'
        ];

        $stocks_ar = [
            'عرض سعر حركة المخزون',
            'تعديل سعر حركة المخزون',
            'إضافة إذن مخزني',
            'تعديل الإذن المخزني',
            'عرض الإذن المخزني',
            'حذف الإذن المخزني',
            'السماح للشراء بأقل من السعر الأدني للمنتج',
            'متابعة المخزون',
            'نقل المخزون',
        ];

        for($i=0, $iMax = count($stocks_en); $i < $iMax; $i++){
            TranslatedPermission::where('permission_id', $stocks_permissions[$i])->update([
                'name_en' =>  $stocks_en[$i],
                'name_ar' =>  $stocks_ar[$i],
                'permission_id' => $stocks_permissions[$i],
                'category_id' => 3
            ]);
        }

        //human resources permissions
        $hr_permissions = TranslatedPermission::where('permission_id', '>' ,17)->where('permission_id', '<=' ,27)->pluck('permission_id')->toArray();
        $hr_en = [
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

        $hr_ar = [
            'إضافة موظف جديد',
            'تعديل موظف',
            'حذف موظف',
            'عرض الملف الشخصى لموظف',
            'إضافة دور جديد',
            'تعديل دور',
            'حذف دور',
            'إضافة صلاحية جديده',
            'تعديل صلاحية',
            'حذف صلاحية',
        ];

        for($i=0, $iMax = count($hr_en); $i < $iMax; $i++){
            TranslatedPermission::where('permission_id', $hr_permissions[$i])->update([
                'name_en' =>  $hr_en[$i],
                'name_ar' =>  $hr_ar[$i],
                'permission_id' => $hr_permissions[$i],
                'category_id' => 4
            ]);
        }
    }
}
