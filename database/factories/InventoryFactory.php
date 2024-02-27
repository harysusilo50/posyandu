<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image' => $this->faker->imageUrl(500, 500, 'animals', true),
            'pattern' => $this->faker->bothify('?????-#####'),
            'item_name' => $this->faker->name(),
            'qty' => $this->faker->randomNumber(3),
            'category' => $this->faker->randomElement(['ware', 'chemical']),
            'type' => $this->faker->randomElement(['glassware', 'silverware', 'chinaware']),
            'desc' => $this->faker->paragraph(8),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
