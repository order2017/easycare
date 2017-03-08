<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shop_applies_id');
            $table->foreign('shop_applies_id')->references('id')->on('shop_applies')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('employees_id');
            $table->foreign('employees_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('boss_id');
            $table->foreign('boss_id')->references('id')->on('bosses')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('status');
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
        Schema::drop('shops');
    }
}
