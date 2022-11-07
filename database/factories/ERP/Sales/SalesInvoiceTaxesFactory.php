<?php

namespace Database\Factories\ERP\Sales;

use App\Models\ERP\Sales\SalesInvoiceTaxes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ERP\Sales\SalesInvoiceTaxes>
 */
class SalesInvoiceTaxesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesInvoiceTaxes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sales_invoice_id' => 1,
            'total_tax_inv' => 'القيمة المضافة (14%)',
            'total_tax_inv_sum' => 0.00
        ];
    }
}
