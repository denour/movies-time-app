<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'published_at' => $this->faker->dateTime,
            'status' => $this->faker->boolean,
            'thumbnail' => $this->faker->imageUrl
        ];
    }
}
