<?php

namespace Database\Factories\ERP\Sales;

use App\Models\ERP\Sales\SalesInvoicePayment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ERP\Sales\SalesInvoicePayment>
 */
class SalesInvoicePaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesInvoicePayment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sales_invoice_id' => 1,
            'deposit_payment_method' => $this->faker->randomElement(['cash', 'cheque', 'bank_transfer']),
            'payment_amount' => 0.00,
            'payment_date' => date('Y-m-d'),
            'payment_status' => 'completed',
            'collected_by_id' => User::inRandomOrder()->first()->id,
            'transaction_id' => 7777777,
            'receipt_notes' => 'test receipt note'
        ];
    }
}
