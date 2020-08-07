<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHourStartAndFinishToTrainingsAndRelaxtrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('hour_start')->nullable();
            $table->string('hour_finish')->nullable();
        });
        Schema::table('relaxtrainings', function (Blueprint $table) {
            $table->string('hour_start')->nullable();
            $table->string('hour_finish')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trainings_and_relaxtrainings', function (Blueprint $table) {
            //
        });
    }
}
