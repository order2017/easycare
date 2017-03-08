<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_applies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('province_id');
            $table->string('province_name');
            $table->integer('city_id');
            $table->string('city_name');
            $table->integer('county_id');
            $table->string('county_name');
            $table->text('address');
            $table->string('location');
            $table->string('phone');
            $table->unsignedInteger('boss_id');
            $table->foreign('boss_id')->references('id')->on('bosses')->onUpdate('cascade')->onDelete('cascade');
            $table->text('intro');
            $table->text('images');
            $table->string('reason');
            $table->tinyInteger('status');
            $table->dateTime('audited_at')->nullable();
            $table->unsignedInteger('audit_user_id')->nullable();
            $table->foreign('audit_user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('employees_id');
            $table->foreign('employees_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('shop_applies');
    }
}
