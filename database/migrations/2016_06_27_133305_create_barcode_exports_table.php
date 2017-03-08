<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarcodeExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barcode_exports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('generate_barcode_task_id');
            $table->foreign('generate_barcode_task_id')->references('id')->on('generate_barcode_tasks')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('total');
            $table->bigInteger('finish_num');
            $table->string('file');
            $table->tinyInteger('status');
            $table->dateTime('running_at');
            $table->dateTime('finished_at');
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
        Schema::drop('barcode_exports');
    }
}
