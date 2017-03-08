<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixedCoupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupon_applies', function (Blueprint $table) {
            $table->dropColumn('data');
            $table->string('scope');
            $table->decimal('condition');
            $table->decimal('money')->default(0);
            $table->integer('integral');
            $table->decimal('discount')->default(0);
            $table->dateTime('begin_time');
            $table->dateTime('end_time');
            $table->integer('duration');
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
