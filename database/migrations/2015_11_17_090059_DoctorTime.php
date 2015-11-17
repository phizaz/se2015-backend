<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DoctorTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::create('DoctorTime', function (Blueprint $table) {
            $table->integer('doctor_id');
            $table->datetime('doctorTime_begin');
            $table->dateTime('doctorTime_end');
   
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('DoctorTime');
    }
}
