<?php

namespace Database\Factories;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    $name = $this->faker->sentence(5, true);
    return [
      //
      'name' => $name,
      'slug' => Str::slug($name, '_'),
      'description' => $this->faker->paragraph(10, true),
      'duration' => $this->faker->numberBetween(5, 50),
      'duration_type' => $this->faker->randomElement(['hours', 'days', 'weeks', 'months']),
      'price' => $this->faker->numberBetween(1000, 10000),
      'currency' => $this->faker->randomElement(['NGN', 'USD']),
      'category_id' => Categories::all()->random()->id,
      'user_id' => User::all()->random()->id,
      'status' => $this->faker->randomElement(['pending', 'approved', 'pending', 'approved', 'rejected']),
    ];
  }
}
