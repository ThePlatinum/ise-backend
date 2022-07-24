<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('buyer_id');
      $table->unsignedBigInteger('seller_id');
      $table->unsignedBigInteger('task_id');
      $table->string('task_title');
      $table->string('order_price');
      $table->string('quantity');
      $table->string('duration');
      $table->string('duration_type');
      $table->boolean('paid')->default(false);
      $table->boolean('completed')->default(false);
      $table->boolean('accepted')->default(false);
      $table->timestamp('accepted_at')->nullable();
      $table->foreign('buyer_id')->references('id')->on('users');
      $table->foreign('seller_id')->references('id')->on('users');
      $table->foreign('task_id')->references('id')->on('tasks');
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
    Schema::dropIfExists('orders');
  }
}
