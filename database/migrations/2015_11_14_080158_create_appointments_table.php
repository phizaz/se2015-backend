<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('appointment_id');
            $table->timestamp('time');  //<------ หา้มใส่ timestamps ต้องใช้ timestamp
            $table->integer('emp_id');
            $table->integer('patient_id');
            $table->string('filterType');
            $table->string('filterString');

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
        Schema::drop('appointments');
    }
}
