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
            $table->integer('balance_id')->unique()->nullable();
            $table->integer('social_id')->unique()->nullable();
            $table->date('birth')->nullable();
            $table->smallInteger('gender')->nullable();
            $table->string('lang')->nullable();
            $table->text('bio')->nullable();
            $table->string('highlight')->nullable();
            $table->smallInteger('is_seller')->default(0);
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
            $table->dropColumn(['balance_id', 'social_id', 'birth', 'gender', 'lang', 'location', 'avatar',
            'nickname', 'deleted_at', 'is_seller']);
        });
    }
}
