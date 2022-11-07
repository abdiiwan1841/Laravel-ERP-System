<?php

namespace Database\Factories\ERP\Sales;

use App\Models\ERP\Sales\Client;
use App\Models\ERP\Sales\ClientContact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ERP\Sales\ClientContact>
 */
class ClientContactFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientContact::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_cont_first_name' => $this->faker->firstName,
            'client_cont_last_name' => $this->faker->lastName,
            'client_cont_email' => $this->faker->email,
            'client_cont_phone' => $this->faker->randomNumber(7),
            'client_cont_mobile' => $this->faker->randomNumber(9),
            'client_id' => Client::inRandomOrder()->first()->id,
        ];
    }

}
