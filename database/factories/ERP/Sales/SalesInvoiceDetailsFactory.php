<?php

namespace Database\Factories\ERP\Sales;

use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Sales\SalesInvoice;
use App\Models\ERP\Sales\SalesInvoiceDetails;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ERP\Sales\SalesInvoiceDetails>
 */
class SalesInvoiceDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesInvoiceDetails::class;


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
            'sales_invoice_id' => SalesInvoice::inRandomOrder()->first()->id,
            'product_id' => $product_id,
            'description' => Product::where('id', $product_id)->pluck('description')->first(),
            'quantity' => $this->faker->numberBetween(3, 5),
            'unit_price' => Product::where('id', $product_id)->pluck('sell_price')->first(),
            'first_tax_id' => 1,
            'second_tax_id' => null,
            'row_total' => 0.00,
        ];
    }
}
