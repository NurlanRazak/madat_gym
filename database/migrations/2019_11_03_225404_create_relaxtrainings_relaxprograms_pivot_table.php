<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelaxtrainingsRelaxprogramsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relaxtrainings_relaxprograms_pivot', function (Blueprint $table) {
            $table->unsignedBigInteger('relaxprogram_id')->nullable();
            $table->foreign('relaxprogram_id')->references('id')->on('relaxprograms')->onDelete('cascade');
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
        Schema::dropIfExists('relaxtrainings_relaxprograms_pivot');
    }
}
