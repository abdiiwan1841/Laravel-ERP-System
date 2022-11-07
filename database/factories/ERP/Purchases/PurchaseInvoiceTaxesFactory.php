<?php

namespace Database\Factories\ERP\Purchases;

use App\Models\ERP\Purchases\PurchaseInvoice;
use App\Models\ERP\Purchases\PurchaseInvoiceTaxes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ERP\Purchases\PurchaseInvoiceTaxes>
 */
class PurchaseInvoiceTaxesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseInvoiceTaxes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'purchase_invoice_id' => 1,
            'total_tax_inv' => 'القيمة المضافة (14%)',
            'total_tax_inv_sum' => 0.00
        ];
    }
}
