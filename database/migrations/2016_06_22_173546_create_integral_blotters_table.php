<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegralBlottersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integral_blotters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial_number');
            $table->unique('serial_number');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('numerical');
            $table->unsignedInteger('barcode_id')->nullable();
            $table->unsignedInteger('product_activity_id')->nullable();
            $table->unsignedInteger('product_activity_rule_id')->nullable();
            $table->unsignedInteger('order_id')->nullable();
            $table->tinyInteger('status');
            $table->integer('balance');
            $table->string('remark');
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
        Schema::drop('integral_blotters');
    }
}
