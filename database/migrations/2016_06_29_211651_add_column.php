<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_applies', function (Blueprint $table) {
            $table->unsignedInteger('shop_id')->nullable();
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('goods_applies', function (Blueprint $table) {
            $table->unsignedInteger('goods_id')->nullable();
            $table->foreign('goods_id')->references('id')->on('goods')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('coupon_applies', function (Blueprint $table) {
            $table->unsignedInteger('coupon_id')->nullable();
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
