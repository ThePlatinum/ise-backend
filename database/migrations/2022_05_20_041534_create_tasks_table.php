<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tasks', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('category_id');
      $table->string('name');
      $table->unsignedBigInteger('user_id'); // Who created the Task
      $table->string('description');
      $table->string('duration');
      $table->integer('price');
      $table->timestamps();
      $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('tasks');
  }
}
