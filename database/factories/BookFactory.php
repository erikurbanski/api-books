<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title(),
            'publisher' => $this->faker->name(),
            'year' => $this->faker->year(),
            'edition' => $this->faker->numerify(),
            'value' => $this->faker->randomFloat(),
        ];
    }
}
