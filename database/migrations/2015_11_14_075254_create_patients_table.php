<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');

            $table->string('personal_id', 13)->unique();

            $table->string('firstname');
            $table->string('lastname');
            $table->date('birthdate');
            $table->string('address');
            // gender: M, F
            $table->string('gender', 1);
            $table->string('nationality');
            $table->string('religion')->nullable();
            $table->string('bloodtype')->nullable();
            $table->string('tel');
            // status: บอกว่าผู้ป่วยได้ตรวจเสร็จแล้ว และตอนนี้กำลังรอรับยาหรือเปล่า ?
            $table->boolean('status')->default(0);
            $table->string('remark')->nullable();
            $table->integer('priority')->default(0);
            $table->string('photo_extension');
            $table->string('drugAllergic');
            
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
        Schema::drop('patients');
    }
}
