<?php

namespace Database\Factories\ERP\Purchases;

use App\Models\ERP\Purchases\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ERP\Purchases\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;


    private static int $number = 1;
    private static int $full_code = 00001;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'commercial_name'=> $this->faker->userName,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->randomNumber(7),
            'mobile' => $this->faker->randomNumber(9),
            'fax' => $this->faker->randomNumber(7),
            'phone_code' => '+ 20',
            'street_address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'country' => 'egypt',
            'commercial_record' => $this->faker->randomNumber(6),
            'tax_registration' => $this->faker->randomNumber(9),
            'currency' => 'EGP',
            'currency_symbol' =>  'ج.م.',
            'opening_balance' =>  $this->faker->numberBetween(1000, 100000),
            'opening_balance_date' => date('Y-m-d'),
            'notes' => 'إختبار',
            'status' => rand(1,2),
            'created_by' => $this->faker->randomElement(['Super Admin', 'Admin Admin', 'User User']),
            'sequential_code_id' => 5,
            'number' => self::$number++,
            'full_code' => 'SUPP'.self::$full_code++,
        ];
    }
}
