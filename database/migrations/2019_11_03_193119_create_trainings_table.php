<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('day_number');
            $table->integer('approaches_number')->nullable();
            $table->integer('repetitions_number')->nullable();
            $table->float('weight', 8, 4)->nullable();
            $table->unsignedBigInteger('exercise_id')->nullable();
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
            $table->unsignedBigInteger('programtraining_id')->nullable();
            $table->foreign('programtraining_id')->references('id')->on('programtrainings')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('trainings');
    }
}
