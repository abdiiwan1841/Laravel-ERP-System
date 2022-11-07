<?php

namespace Database\Factories\ERP\Sales;

use App\Models\ERP\Sales\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ERP\Sales\Client>
 */
class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;


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
            'full_name' => $this->faker->firstName() . $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->randomNumber(7),
            'mobile' => $this->faker->randomNumber(9),
            'phone_code' => '+ 20',
            'street_address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->citySuffix,
            'postal_code' => $this->faker->postcode,
            'country' => 'egypt',
            'currency' => 'EGP',
            'currency_symbol' => 'ج.م.',
            'opening_balance' => $this->faker->numberBetween(1000, 100000),
            'opening_balance_date' => date('Y-m-d'),
            'notes' => 'test notes',
            'status' => rand(1,2),
            'created_by' => $this->faker->randomElement(['Super Admin', 'Admin Admin', 'User User']),
            'sequential_code_id' => 6,
            'number' => self::$number++,
            'full_code' => 'CLNT'.self::$full_code++,
        ];
    }
}
