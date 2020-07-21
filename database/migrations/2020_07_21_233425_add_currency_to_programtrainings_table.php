<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyToProgramtrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programtrainings', function (Blueprint $table) {
            $table->tinyInteger('currency')->default(\App\Models\Programtraining::KZT);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programtrainings', function (Blueprint $table) {
            //
        });
    }
}
