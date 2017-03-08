<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_applies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->integer('province_id');
            $table->string('province_name');
            $table->integer('city_id');
            $table->string('city_name');
            $table->integer('county_id');
            $table->string('county_name');
            $table->text('address');
            $table->unsignedInteger('departments_id');
            $table->foreign('departments_id')->references('id')->on('departments')->onUpdate('cascade')->onDelete('cascade');
            $table->string('reason');
            $table->tinyInteger('status');
            $table->dateTime('audited_at')->nullable();
            $table->unsignedInteger('audit_user_id')->nullable();
            $table->foreign('audit_user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('employee_applies');
    }
}
