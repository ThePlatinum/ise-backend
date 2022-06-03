<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('email')->unique();
      $table->string('password');
      $table->string('username')->nullable()->unique();

      $table->string('firstname')->nullable();
      $table->string('lastname')->nullable();
      $table->string('othername')->nullable();

      $table->string('phone')->nullable()->unique();
      $table->string('country_of_residence')->nullable();
      $table->string('state_of_residence')->nullable();

      $table->string('state_of_origin')->nullable();
      $table->string('country_of_origin')->nullable();

      $table->string('skills')->nullable();

      $table->string('gender')->nullable();
      $table->string('profile_image')->default('profile_pictures/avater.png');
      $table->string('bio')->default('No profile details');

      $table->string('role')->default(0);
      $table->string('identified')->default(0);

      $table->timestamp('dob')->nullable();
      $table->timestamp('email_verified_at')->nullable();
      $table->timestamp('phone_verified_at')->nullable();
      $table->rememberToken();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
