<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('balance_id')->unique();
            $table->integer('social_id')->unique();
            $table->date('birth')->nullable();
            $table->smallInteger('gender')->nullable();
            $table->string('lang')->nullable();
            $table->string('location')->nullable();
            $table->string('avatar')->nullable();
            $table->string('nickname')->unique()->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['balance_id', 'social_id', 'birth', 'gender', 'lang', 'lang', 'location', 'avatar',
            'nickname']);
        });
    }
}
