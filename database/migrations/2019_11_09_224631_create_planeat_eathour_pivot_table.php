<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaneatEathourPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planeat_eathour', function (Blueprint $table) {
            $table->unsignedBigInteger('planeat_id')->nullable();
            $table->foreign('planeat_id')->references('id')->on('planeats')->onDelete('cascade');
            $table->unsignedBigInteger('eathour_id')->nullable();
            $table->foreign('eathour_id')->references('id')->on('eathours')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planeat_eathour_pivot');
    }
}
