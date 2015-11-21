<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_employees', function (Blueprint $table) {
            $table->increments('emp_id',10)->unique();

            $table->string('username');
            $table->string('password',60);
            $table->string('firstname');
            $table->string('lastname');
            $table->string('tel');
            $table->string('email');
            $table->string('role');
            // $table->string('type');
            $table->string('specialty');

            $table->boolean('valid')->default(false);

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
        Schema::drop('hospital_employees');
    }
}
