<?php

namespace Database\Factories\ERP\Inventory;

use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Purchases\Supplier;
use App\Models\ERP\Settings\MeasurementUnit;
use App\Models\ERP\Settings\Products\Brand;
use App\Models\ERP\Settings\Products\Category;
use App\Models\ERP\Settings\Products\Section;
use App\Models\ERP\Settings\Products\SubCategory;
use App\Models\ERP\Settings\Tax;
use App\Models\ERP\Settings\UnitsTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Picqer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ERP\Inventory\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;


    private static int $number = 1;
    private static int $barcodeImgNumber = 1;
    private static int $full_code = 1;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sbcs = Section::inRandomOrder()->first()->id . Brand::inRandomOrder()->first()->id . Category::inRandomOrder()->first()->id . SubCategory::inRandomOrder()->first()->id;
        $sku = 'PRO'.'-'.$sbcs.'-'. str_pad(self::$full_code++, 5, '0', STR_PAD_LEFT);
        $barcodeImage = 'testBarcode'.self::$barcodeImgNumber++.'.jpg';
        return [
            'name' => rtrim($this->faker->sentence(2), '.'),
            'description' => $this->faker->sentence(5),
            'section_id' => Section::inRandomOrder()->first()->id,
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'subcategory_id' => SubCategory::inRandomOrder()->first()->id,
            'unit_template_id' => UnitsTemplate::inRandomOrder()->first()->id,
            'measurement_unit_id' => MeasurementUnit::inRandomOrder()->first()->id,
            'supplier_id' => Supplier::inRandomOrder()->first()->id,
            'barcode' => $barcodeImage,
            'purchase_price' => $this->faker->randomElement([10000, 15000, 20000]),
            'sell_price' => $this->faker->randomElement([25000,30000,35000]),
            'first_tax_id' => Tax::inRandomOrder()->first()->id,
            'second_tax_id' => Tax::inRandomOrder()->first()->id,
            'lowest_sell_price' => $this->faker->randomElement([22000,24000,26000]),
            'discount' => rand(1,5),
            'discount_type' => 1,
            'profit_margin' => rand(10, 25),
            'lowest_stock_alert' => 50,
            'notes' => $this->faker->sentence(5),
            'status' => rand(1,2),
            'number' => self::$number++,
            'sequential_code_id' => 3,
            'sku' => $sku,
            'total_quantity' => 0.00,
            'product_image' => 'defaultProduct.png'
        ];
    }
}
