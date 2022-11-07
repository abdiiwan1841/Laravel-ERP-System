<?php

namespace Database\Factories\ERP\Purchases;

use App\Models\ERP\Purchases\Supplier;
use App\Models\ERP\Purchases\SupplierContact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ERP\Purchases\SupplierContact>
 */
class SupplierContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SupplierContact::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'supp_cont_first_name' => $this->faker->firstName,
            'supp_cont_last_name' => $this->faker->lastName,
            'supp_cont_email' => $this->faker->email,
            'supp_cont_phone' => $this->faker->randomNumber(7),
            'supp_cont_mobile' => $this->faker->randomNumber(9),
            'supplier_id' => Supplier::inRandomOrder()->first()->id,
        ];
    }
}
