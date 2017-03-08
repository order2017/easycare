<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_applies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shop_id')->nullable();
            $table->foreign('shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->decimal('price');
            $table->decimal('original_price');
            $table->decimal('shipping');
            $table->integer('inventory');
            $table->text('intro');
            $table->text('images');
            $table->string('reason');
            $table->tinyInteger('status');
            $table->dateTime('audited_at')->nullable();
            $table->unsignedInteger('audit_user_id')->nullable();
            $table->foreign('audit_user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('employees_id')->nullable();
            $table->foreign('employees_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('goods_applies');
    }
}
