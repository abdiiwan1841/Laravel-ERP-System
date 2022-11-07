<?php

namespace Database\Seeders;

use App\Models\ERP\Settings\GeneralSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_settings')->delete();

        GeneralSetting::create([
            'business_name' => 'XYZ-Company',
            'first_name' => 'Mohammed',
            'last_name' => 'Saad',
            'email' => 'mossaad577@gmail.com',
            'phone' => '125863524',
            'mobile' => '01090411577',
            'fax' => '958475852',
            'phone_code' => '+ 20',
            'street_address' => 'شارع حسن زهدى, شارع خالد بن الوليد',
            'city' => 'Tanta',
            'state' => 'Gharbya',
            'postal_code' => '12345',
            'country' => 'egypt',
            'commercial_record' => '123456',
            'tax_registration' => '123456789',
            'basic_currency' => 'EGP',
            'basic_currency_symbol' => 'ج.م.',
            'extra_currencies' => ["USD","EUR"],
            'extra_currencies_symbols' => ["$","\u20ac"],
            'time_zone' => 'Africa/Cairo',
            'language' => 'ar',
            'logo' => 'defaultLogo.png',
        ]);
    }
}
