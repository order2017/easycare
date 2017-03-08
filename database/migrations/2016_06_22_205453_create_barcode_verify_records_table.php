<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarcodeVerifyRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barcode_verify_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('barcode_id');
            $table->foreign('barcode_id')->references('id')->on('barcodes')->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('verified_at');
            $table->tinyInteger('verify_type');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('is_subscribe');
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
        Schema::drop('barcode_verify_records');
    }
}
