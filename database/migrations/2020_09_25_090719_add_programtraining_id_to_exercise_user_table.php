<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProgramtrainingIdToExerciseUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exercise_user', function (Blueprint $table) {
            $table->unsignedBigInteger('programtraining_id')->nullable();
            $table->foreign('programtraining_id')->references('id')->on('programtrainings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exercise_user', function (Blueprint $table) {
            $table->dropForeign('programtraining_id');
            $table->dropColumn('programtraining_id');
        });
    }
}
