<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionBlottersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commission_blotters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial_number');
            $table->unique('serial_number');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('numerical');
            $table->decimal('balance');
            $table->string('wechat_order_number')->nullable();
            $table->unsignedInteger('barcode_id')->nullable();
            $table->string('remark');
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
        Schema::drop('commission_blotters');
    }
}
