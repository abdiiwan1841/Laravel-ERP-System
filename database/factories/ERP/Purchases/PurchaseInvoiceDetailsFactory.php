<?php

namespace Database\Factories\ERP\Purchases;

use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Purchases\PurchaseInvoice;
use App\Models\ERP\Purchases\PurchaseInvoiceDetails;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ERP\Purchases\PurchaseInvoiceDetails>
 */
class PurchaseInvoiceDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseInvoiceDetails::class;


    private static int $number = 1;
    private static int $full_code = 1;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product_id = Product::inRandomOrder()->first()->id;
        return [
            'purchase_invoice_id' => PurchaseInvoice::inRandomOrder()->first()->id,
            'product_id' => $product_id,
            'description' => Product::where('id', $product_id)->pluck('description')->first(),
            'quantity' => $this->faker->numberBetween(50, 100),
            'unit_price' => Product::where('id', $product_id)->pluck('purchase_price')->first(),
            'first_tax_id' => 1,
            'second_tax_id' => null,
            'row_total' => 0.00,
        ];
    }
}
