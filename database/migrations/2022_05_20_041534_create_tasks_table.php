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
      $table->string('name');
      $table->string('slug')->unique()->nullable();
      $table->unsignedBigInteger('category_id');
      $table->unsignedBigInteger('user_id'); // Who created the Task
      $table->text('description');
      $table->string('duration');
      $table->string('duration_type');
      $table->integer('price');
      $table->string('currency');
      $table->string('status')->default('pending');
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
