<?php

namespace Database\Factories\ERP\Inventory;

use App\Models\ERP\Branch;
use App\Models\ERP\Inventory\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ERP\Inventory\Warehouse>
 */
class WarehouseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Warehouse::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $branches = Branch::all()->pluck('id')->toArray();
        return [
            'name' => rtrim($this->faker->sentence(2), '.'),
            'shipping_address' => $this->faker->address,
            'status' => 1,
            'branch_id' => $this->faker->unique()->randomElement($branches)
        ];
    }
}
