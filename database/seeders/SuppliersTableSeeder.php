<?php

namespace Database\Seeders;

use App\Models\ERP\Purchases\Supplier;
use App\Models\ERP\Purchases\SupplierContact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('supplier_contacts')->delete();
        DB::table('suppliers')->delete();

        Supplier::factory(5)->create()->each(function ($c){
            $c->contacts()->saveMany(SupplierContact::factory(rand(1,4))->make());
        });
/*
        Supplier::create([
            'commercial_name'=> 'توشيبا العربى',
            'first_name' => 'محمود',
            'last_name' => 'العربى',
            'email' => 'mossaad577@gmail.com',
            'phone' => '0102222222',
            'mobile' => '1234569872',
            'fax' => '425425425',
            'phone_code' => '+ 20',
            'street_address' => 'طريق مصر اسكندرية الزراعى',
            'city' => 'بنها',
            'state' => 'القليوبية',
            'postal_code' => '1234',
            'country' => 'egypt',
            'commercial_record' => '12345',
            'tax_registration' => '1236958',
            'currency' => 'EGP',
            'currency_symbol' => 'ج.م.',
            'opening_balance' => '100000',
            'opening_balance_date' => date('Y-m-d'),
            'notes' => 'إختبار',
            'status' => 1,
            'created_by' => 'Super Admin',
            'sequential_code_id' => 5,
            'number' => 1,
            'full_code' => 'SUPP-00001',
        ]);
        Supplier::create([
            'commercial_name'=> 'زانوسى',
            'first_name' => 'Mohammed',
            'last_name' => 'Supplier',
            'email' => 'mossaad5757@gmail.com',
            'phone' => '555555',
            'mobile' => '8888888',
            'fax' => '999999',
            'phone_code' => '+ 20',
            'street_address' => 'شارع حسن زهدى, شارع خالد بن الوليد',
            'city' => 'Tanta',
            'state' => 'Gharbya',
            'postal_code' => '1234',
            'country' => 'egypt',
            'commercial_record' => '12345',
            'tax_registration' => '1236958',
            'currency' => 'EGP',
            'currency_symbol' => 'ج.م.',
            'opening_balance' => '100000',
            'opening_balance_date' => date('Y-m-d'),
            'notes' => 'إختبار',
            'status' => 1,
            'created_by' => 'Super Admin',
            'sequential_code_id' => 5,
            'number' => 2,
            'full_code' => 'SUPP-00002',
        ]);
        Supplier::create([
            'commercial_name'=> 'Avye Powers',
            'first_name' => 'Macey',
            'last_name' => 'Walet',
            'email' => 'revolyzik@mailinator.com',
            'phone' => '01022222223',
            'mobile' => '12345698724',
            'fax' => '4254254254',
            'phone_code' => '+ 20',
            'street_address' => 'طريق مصر الزراعى',
            'city' => 'بنها',
            'state' => 'القليوبية',
            'postal_code' => '1234',
            'country' => 'egypt',
            'commercial_record' => '12345',
            'tax_registration' => '1236958',
            'currency' => 'EGP',
            'currency_symbol' => 'ج.م.',
            'opening_balance' => '100000',
            'opening_balance_date' => date('Y-m-d'),
            'notes' => 'إختبار',
            'status' => 1,
            'created_by' => 'Super Admin',
            'sequential_code_id' => 5,
            'number' => 3,
            'full_code' => 'SUPP-00003',
        ]);

        SupplierContact::create([
            'supplier_id' => 1,
            'supp_cont_first_name' => 'Mohammed',
            'supp_cont_last_name' => 'Salah',
            'supp_cont_email' => 'sitetome@mailinator.com',
            'supp_cont_phone' => '666666666',
            'supp_cont_mobile' => '699999999',
        ]);
        SupplierContact::create([
            'supplier_id' => 1,
            'supp_cont_first_name' => 'Farrah',
            'supp_cont_last_name' => 'Farrah',
            'supp_cont_email' => 'ribopisa@mailinator.com',
            'supp_cont_phone' => '666655666',
            'supp_cont_mobile' => '69999998589',
        ]);
        SupplierContact::create([
            'supplier_id' => 2,
            'supp_cont_first_name' => 'Mohammed',
            'supp_cont_last_name' => 'Kaled',
            'supp_cont_email' => 'mossaa55d577@gmail.com',
            'supp_cont_phone' => '6666787866',
            'supp_cont_mobile' => '6992589999',
        ]);
        SupplierContact::create([
            'supplier_id' => 3,
            'supp_cont_first_name' => 'Rhona',
            'supp_cont_last_name' => 'Lloyd',
            'supp_cont_email' => 'kifedy@mailinator.com',
            'supp_cont_phone' => '66612587666',
            'supp_cont_mobile' => '68574219999',
        ]);*/
    }
}
