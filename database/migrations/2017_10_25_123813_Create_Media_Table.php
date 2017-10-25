<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->string('src');
            $table->string('original')->nullable();
            $table->string('large')->nullable();
            $table->string('medium')->nullable();
            $table->string('phone')->nullable();
            $table->string('small')->nullable();
            $table->integer('product_id')->unsigned()->index()->default(0);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('media_type')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
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
        Schema::dropIfExists('media');
    }
}
