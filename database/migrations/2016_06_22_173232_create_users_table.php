<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name')->nullable();
            $table->tinyInteger('sex')->nullable();
            $table->date('birthday')->nullable();
            $table->string('mobile')->nullable();
            $table->string('childName')->nullable();
            $table->tinyInteger('childSex')->nullable();
            $table->date('childBirthday')->nullable();
            $table->integer('integral')->default(0);
            $table->tinyInteger('status');
            $table->tinyInteger('role');
            $table->string('username')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('openid');
            $table->string('unionid');
            $table->dateTime('subscribed_at')->nullable();
            $table->timestamps();
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
        Schema::drop('users');
    }
}
