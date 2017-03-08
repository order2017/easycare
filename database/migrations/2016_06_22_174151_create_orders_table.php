<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_number');
            $table->unique('order_number');
            $table->string('password');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('type');
            $table->unsignedInteger('goods_applies_id')->nullable();
            $table->foreign('goods_applies_id')->references('id')->on('goods_applies')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('coupon_applies_id')->nullable();
            $table->foreign('coupon_applies_id')->references('id')->on('coupon_applies')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('delivery_method');
            $table->integer('province_id');
            $table->string('province_name');
            $table->integer('city_id');
            $table->string('city_name');
            $table->integer('county_id');
            $table->string('county_name');
            $table->text('address');
            $table->string('contact');
            $table->string('phone');
            $table->string('tracking_number');
            $table->unsignedInteger('from_shop_id')->nullable();
            $table->foreign('from_shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('to_shop_id')->nullable();
            $table->foreign('to_shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('verify_user_id')->nullable();
            $table->foreign('verify_user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->tinyInteger('status');
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
        Schema::drop('orders');
    }
}
