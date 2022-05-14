<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // Fake 5 users
    User::factory(5)->create();

    // Create super admin
    User::create([
      'firstname' => 'Ise',
      'lastname'  => 'Admin',
      'username' => 'superuser',
      'email'     => 'admin@ise.com',
      'password'  => Hash::make('12345678'),
      'role' => '1',
      'created_at' => now(),
    ]);
  }
}
