<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => array_rand(['villa' , 'appartement' , 'garage']) . $this->faker->city,
            'price' => $this->faker->numberBetween(100 , 45000),
            'category_id' => rand(1 , 3) ,
            'created_at' => now(),
            'updated_at' => now(),

        ];
    }
}
