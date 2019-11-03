<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelaxexercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relaxexercises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('image');
            $table->string('video')->nullable();
            $table->string('audio')->nullable();

            $table->boolean('active')->nullable();
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
        Schema::dropIfExists('relaxexercises');
    }
}
