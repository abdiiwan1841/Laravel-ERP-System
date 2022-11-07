<?php

namespace Database\Seeders;

use App\Models\ERP\Settings\Products\Brand;
use App\Models\ERP\Settings\Products\BrandCategory;
use App\Models\ERP\Settings\Products\BrandSection;
use App\Models\ERP\Settings\Products\Category;
use App\Models\ERP\Settings\Products\Section;
use App\Models\ERP\Settings\Products\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->delete();
        DB::table('brands')->delete();
        DB::table('brand_section')->delete();
        DB::table('categories')->delete();
        DB::table('brand_category')->delete();
        DB::table('sub_categories')->delete();

        //Sections
        Section::create([
           'name' => 'أجهزة كهربائية',
           'status' => 1
        ]);
        Section::create([
            'name' => 'سيارات',
            'status' => 1
        ]);
        Section::create([
            'name' => 'أجهزة إلكترونية',
            'status' => 1
        ]);

        //brands
        Brand::create([
            'name' => 'توشيبا',
            'status' => 1
        ]);
        Brand::create([
            'name' => 'سامسونج',
            'status' => 1
        ]);
        Brand::create([
            'name' => 'تورنادو',
            'status' => 1
        ]);
        Brand::create([
            'name' => 'شيفرولية',
            'status' => 1
        ]);
        Brand::create([
            'name' => 'تويوتا',
            'status' => 1
        ]);
        Brand::create([
            'name' => 'ايسوزو',
            'status' => 1
        ]);

        //brand-section
        BrandSection::create([
            'section_id' => 1,
            'brand_id' => 1,
        ]);
        BrandSection::create([
            'section_id' => 3,
            'brand_id' => 1,
        ]);
        BrandSection::create([
            'section_id' => 1,
            'brand_id' => 2,
        ]);
        BrandSection::create([
            'section_id' => 3,
            'brand_id' => 2,
        ]);
        BrandSection::create([
            'section_id' => 1,
            'brand_id' => 3,
        ]);
        BrandSection::create([
            'section_id' => 2,
            'brand_id' => 4,
        ]);
        BrandSection::create([
            'section_id' => 2,
            'brand_id' => 5,
        ]);
        BrandSection::create([
            'section_id' => 2,
            'brand_id' => 6,
        ]);

        //categories
        Category::create([
            'name' => 'ثلاجات',
            'status' => 1,
            'section_id' => 1
        ]);
        Category::create([
            'name' => 'غسالات',
            'status' => 1,
            'section_id' => 1
        ]);
        Category::create([
            'name' => 'نقل',
            'status' => 1,
            'section_id' => 2
        ]);
        Category::create([
            'name' => 'ملاكي',
            'status' => 1,
            'section_id' => 2
        ]);
        Category::create([
            'name' => 'موبايلات',
            'status' => 1,
            'section_id' => 3
        ]);
        Category::create([
            'name' => 'تابلت',
            'status' => 1,
            'section_id' => 3
        ]);

        //brand-category
        BrandCategory::create([
           'brand_id' => 1,
           'category_id'  => 1
        ]);
        BrandCategory::create([
            'brand_id' => 2,
            'category_id'  => 1
        ]);
        BrandCategory::create([
            'brand_id' => 3,
            'category_id'  => 1
        ]);
        BrandCategory::create([
            'brand_id' => 1,
            'category_id'  => 2
        ]);
        BrandCategory::create([
            'brand_id' => 2,
            'category_id'  => 2
        ]);
        BrandCategory::create([
            'brand_id' => 3,
            'category_id'  => 2
        ]);
        BrandCategory::create([
            'brand_id' => 4,
            'category_id'  => 3
        ]);
        BrandCategory::create([
            'brand_id' => 5,
            'category_id'  => 3
        ]);
        BrandCategory::create([
            'brand_id' => 6,
            'category_id'  => 3
        ]);
        BrandCategory::create([
            'brand_id' => 4,
            'category_id'  => 4
        ]);
        BrandCategory::create([
            'brand_id' => 5,
            'category_id'  => 4
        ]);
        BrandCategory::create([
            'brand_id' => 6,
            'category_id'  => 4
        ]);
        BrandCategory::create([
            'brand_id' => 1,
            'category_id'  => 5
        ]);
        BrandCategory::create([
            'brand_id' => 2,
            'category_id'  => 5
        ]);
        BrandCategory::create([
            'brand_id' => 1,
            'category_id'  => 6
        ]);
        BrandCategory::create([
            'brand_id' => 2,
            'category_id'  => 6
        ]);

        //sub-categories
        SubCategory::create([
            'name' => 'ثلاجه 16 قدم باب واحد',
            'status' => 1,
            'category_id' => 1,
        ]);
        SubCategory::create([
            'name' => 'ثلاجه 16 قدم بابين',
            'status' => 1,
            'category_id' => 1,
        ]);
        SubCategory::create([
            'name' => 'غسالة تحميل امامى',
            'status' => 1,
            'category_id' => 2,
        ]);
        SubCategory::create([
            'name' => 'غسالة تحميل راسى',
            'status' => 1,
            'category_id' => 2,
        ]);
        SubCategory::create([
            'name' => 'نقل خفيف',
            'status' => 1,
            'category_id' => 3,
        ]);
        SubCategory::create([
            'name' => 'نقل ثقيل',
            'status' => 1,
            'category_id' => 3,
        ]);
        SubCategory::create([
            'name' => 'سيدان',
            'status' => 1,
            'category_id' => 4,
        ]);
        SubCategory::create([
            'name' => 'دفع رباعى',
            'status' => 1,
            'category_id' => 4,
        ]);

    }
}
