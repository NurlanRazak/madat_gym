<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramtrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programtrainings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('agerestrict')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('duration')->nullable();
            $table->string('price')->nullable();

            $table->unsignedBigInteger('programtype_id')->nullable();
            $table->foreign('programtype_id')->references('id')->on('programtypes')->onDelete('cascade');

            $table->unsignedBigInteger('foodprogram_id')->nullable();
            $table->foreign('foodprogram_id')->references('id')->on('foodprograms')->onDelete('cascade');

            $table->unsignedBigInteger('relaxprogram_id')->nullable();
            $table->foreign('relaxprogram_id')->references('id')->on('relaxprograms')->onDelete('cascade');

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
        Schema::dropIfExists('programtrainings');
    }
}
