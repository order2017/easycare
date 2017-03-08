<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barcodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('generate_barcode_task_id')->unsigned();
            $table->foreign('generate_barcode_task_id')->references('id')->on('generate_barcode_tasks')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->string('serial_number')->unique();
            $table->string('commission_password');
            $table->tinyInteger('commission_status');
            $table->integer('commission_verify_times')->default(0);
            $table->dateTime('commission_verified_at')->nullable();
            $table->unsignedInteger('commission_user_id')->nullable();
            $table->foreign('commission_user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('integral_password');
            $table->tinyInteger('integral_status');
            $table->integer('integral_verify_times')->default(0);
            $table->dateTime('integral_verified_at')->nullable();
            $table->unsignedInteger('integral_user_id')->nullable();
            $table->foreign('integral_user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('barcodes');
    }
}
