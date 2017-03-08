<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_coupon_applies_id_foreign');
            $table->dropColumn('coupon_applies_id');
            $table->dropColumn('type');
            $table->unsignedInteger('goods_id');
            $table->foreign('goods_id')->references('id')->on('goods')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('boss_id')->nullable();
            $table->foreign('boss_id')->references('id')->on('bosses')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('integral');
        });
        Schema::create('user_coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coupon_number')->unique();
            $table->string('password');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('coupon_id');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('coupon_applies_id');
            $table->foreign('coupon_applies_id')->references('id')->on('coupon_applies')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('from_shop_id')->nullable();
            $table->foreign('from_shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('to_shop_id')->nullable();
            $table->foreign('to_shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('verify_user_id')->nullable();
            $table->foreign('verify_user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('boss_id')->nullable();
            $table->foreign('boss_id')->references('id')->on('bosses')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('integral');
            $table->tinyInteger('status');
            $table->softDeletes();
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
        Schema::drop('user_coupons');
    }
}
