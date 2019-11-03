<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelaxtrainingsRelaxexercisesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relaxtrainings_relaxexercises', function (Blueprint $table) {
            $table->unsignedBigInteger('exercise_id')->nullable();
            $table->foreign('exercise_id')->references('id')->on('relaxexercises')->onDelete('cascade');
            $table->unsignedBigInteger('relaxtraining_id')->nullable();
            $table->foreign('relaxtraining_id')->references('id')->on('relaxtrainings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relaxtrainings_relaxexercises_pivot');
    }
}
