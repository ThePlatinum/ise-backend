<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'firstname' => $this->faker->firstName(),
      'lastname' => $this->faker->lastName(),
      'username' => $this->faker->userName(),
      'email' => $this->faker->unique()->safeEmail(),
      'email_verified_at' => now(),
      'phone' => $this->faker->phoneNumber(),
      'phone_verified_at' => $this->faker->randomElements([null, now(), now()->addDays(-1), now()->addDays(1)], 1)[0],
      'identified' => $this->faker->randomElements([0, 1], 1)[0],
      'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
      'remember_token' => Str::random(10),
      'created_at' => $this->faker->dateTimeBetween('-5 months', 'now'),
      'updated_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
    ];
  }

  /**
   * Indicate that the model's email address should be unverified.
   *
   * @return \Illuminate\Database\Eloquent\Factories\Factory
   */
  public function unverified()
  {
    return $this->state(function (array $attributes) {
      return [
        'email_verified_at' => null,
      ];
    });
  }
}
