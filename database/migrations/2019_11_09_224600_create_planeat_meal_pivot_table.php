<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaneatMealPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planeat_meal', function (Blueprint $table) {
            $table->unsignedBigInteger('planeat_id')->nullable();
            $table->foreign('planeat_id')->references('id')->on('planeats')->onDelete('cascade');
            $table->unsignedBigInteger('meal_id')->nullable();
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planeat_meal_pivot');
    }
}
