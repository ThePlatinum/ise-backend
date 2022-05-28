<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentityDocumentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('identity_documents', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('file_name');
      $table->unsignedBigInteger('type_id');
      $table->string('file_type');
      $table->string('file_url');
      $table->string('name_on_document');
      $table->string('document_number');
      $table->string('status')->default('pending');
      $table->timestamp('document_expiry')->nullable();
      $table->timestamps();
      $table->foreign('type_id')->references('id')->on('accepted_documents')->onDelete('cascade');
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
    Schema::dropIfExists('identity_documents');
  }
}
