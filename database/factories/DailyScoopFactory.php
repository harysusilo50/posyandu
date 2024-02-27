<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DailyScoopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'nama_petugas' => $this->faker->firstName(),
            'time' => $this->faker->randomElement(['08.00', '12.00', '16.00', '20.00']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
