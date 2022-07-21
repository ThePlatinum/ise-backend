<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
    ]);

    // Create a known user
    User::create([
      'email'     => 'dprince195@gmail.com',
      'password'  => Hash::make('12345678'),
      'email_verified_at' => now(),
      'phone' => '2347014293952',
      'phone_verified_at' => now(),
    ]);
    // Frontend Engineer
    // User::create([
    //   'email'     => 'quadratwemimo@gmail.com',
    //   'password'  => '$2y$10$P6TWJkB/BQnunoW5S5YVm.SWIHkwOpb9.ZTuM1dgflO4vp795O6aG',
    // ]);
    // Motunrayo
    // User::create([
    //   'email'     => 'motunrayomegbodofo@gmail.com',
    //   'username' => 'motunrayo',
    //   'password'  => '$2y$10$cmCaK0DjB3Sme71QRPlBP.bjPaUwIpGyqjUJ3yRUOF8W6yqbdAWZq',
    //   'phone' => '2348165656129',
    //   'phone_verified_at' => '2022-05-31 16:21:23',
    //   'email_verified_at' => '2022-05-31 15:52:10',
    // ]);

    $catlist = ['Programming and Tech', 'Graphics Design', 'Copywriting', 'Photography, Video and Animations'];
    // Creae categories
    foreach ($catlist as $cat ) {
      Categories::create([
        'name' => $cat,
        'slug' => Str::slug($cat)
      ]);
    }

    // Create tasks
    $this->call([
      TaskSeeder::class,
      AcceptedDocumentSeeder::class,
      PortfolioSeeder::class,
    ]);
  }
}
