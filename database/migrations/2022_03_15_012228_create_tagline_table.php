<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaglineTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tagline', function (Blueprint $table) {
      $table->id();
      // $table->integer('service_id')->nullable();
      $table->foreignId('service_id')->nullable()->index('fk_tagline_to_service');
      $table->string('tagline');
      $table->softDeletes();
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
    Schema::dropIfExists('tagline');
  }
}
