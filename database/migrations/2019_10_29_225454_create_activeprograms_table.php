<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiveprogramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activeprograms', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->timestamp('date_start');
            $table->timestamp('date_finish');

            $table->unsignedBigInteger('program_id');
            $table->foreign('program_id')->references('id')->on('programtrainings')->onDelete('cascade');

            // $table->boolean('active')->default(false);
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
        Schema::dropIfExists('activeprograms');
    }
}
