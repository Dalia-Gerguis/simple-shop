<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'image' => $this->faker->imageUrl($width = 640, $height = 480),
            'details' => $this->faker->paragraph( 1, true),
            'product_code' => Str::random(5),
            'amount' => $this->faker->randomNumber(2),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
