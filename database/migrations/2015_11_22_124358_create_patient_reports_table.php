<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_reports', function (Blueprint $table) {
            
            $table->increments('report_id');
            $table->integer('patient_id');
            $table->double('height');
            $table->double('weight');
            $table->string('pressure');
            $table->string('information');
            $table->datetime('date');
            
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
        Schema::drop('patient_reports');
    }
}
