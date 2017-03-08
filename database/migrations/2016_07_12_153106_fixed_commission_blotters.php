<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixedCommissionBlotters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commission_blotters', function (Blueprint $table) {
            $table->unsignedInteger('product_activity_id')->nullable();;
            $table->unsignedInteger('product_activity_rule_id')->nullable();;
            $table->dropColumn('balance');
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
