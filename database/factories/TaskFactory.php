<?php

namespace Database\Factories;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
          'name' => $this->faker->sentence(6, true),
          'description' => $this->faker->paragraph(10,true),
          'duration' => $this->faker->numberBetween(1, 100),
          'duration_type' => $this->faker->randomElement(['hours', 'days', 'weeks', 'months']),
          'price' => $this->faker->numberBetween(1, 100),
          'currency' => $this->faker->randomElement(['NGN', 'USD']),
          'category_id' => Categories::all()->random()->id,
          'user_id' => User::all()->random()->id,
        ];
    }
}
