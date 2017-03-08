<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->tinyInteger('type');
            $table->integer('total');
            $table->tinyInteger('send_method');
            $table->tinyInteger('send_type');
            $table->integer('has_join_num');
            $table->text('rules');
            $table->dateTime('begin_time');
            $table->dateTime('end_time');
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
        Schema::drop('product_activities');
    }
}
