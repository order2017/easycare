<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shop_id')->nullable();
            $table->foreign('shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('employees_id')->nullable();
            $table->foreign('employees_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('coupon_applies_id');
            $table->foreign('coupon_applies_id')->references('id')->on('coupon_applies')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('coupons');
    }
}
