<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->delete();

        $jobs_ar = [
            'مدير حسابات',
            'مدير مبيعات',
            'مدير مشتريات',
            'مندوب مبيعات',
            'مندوب مشتريات',
            'محاسب',
            'أمين مخزن',
            'سائق',
        ];

        $jobs_en = [
            'Account Manager',
            'Sales Manager',
            'Purchasing Manager',
            'Sales Representative',
            'Purchases Representative',
            'Accountant',
            'store keeper',
            'Driver',
        ];
        foreach ($jobs_ar as $job_ar)
        {
            Job::create([
                'name_ar' => $job_ar,
            ]);
        }

        $jobs = Job::all()->pluck('id')->toArray();
        for($i=0, $iMax = count($jobs_ar); $i < $iMax; $i++){
            Job::where('id', $jobs[$i])->update([
                'name_en' =>  $jobs_en[$i],
                'name_ar' =>  $jobs_ar[$i],
            ]);
        }
    }
}
