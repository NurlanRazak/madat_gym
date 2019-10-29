<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaneatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planeats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('foodprogram_id');
            $table->foreign('foodprogram_id')->references('id')->on('foodprograms')->onDelete('cascade');
            $table->unsignedBigInteger('meal_id');
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
            $table->unsignedBigInteger('eathour_id');
            $table->foreign('eathour_id')->references('id')->on('eathours')->onDelete('cascade');
            $table->integer('days');

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
        Schema::dropIfExists('planeats');
    }
}
