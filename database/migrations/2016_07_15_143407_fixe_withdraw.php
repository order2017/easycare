<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixeWithdraw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdraws', function (Blueprint $table) {
            $table->dropColumn('integral_blotters_id');
            $table->dropColumn('commission_blotters_id');
        });
        Schema::table('integral_blotters', function (Blueprint $table) {
            $table->unsignedInteger('withdraws_id')->nullable();
            $table->foreign('withdraws_id')->references('id')->on('withdraws')->onDelete('cascade')->onUpdate('cascade');
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
