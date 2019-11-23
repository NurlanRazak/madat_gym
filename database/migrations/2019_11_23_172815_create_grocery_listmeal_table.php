<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroceryListmealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grocery_listmeal', function (Blueprint $table) {
            $table->unsignedBigInteger('listmeal_id')->nullable();
            $table->foreign('listmeal_id')->references('id')->on('listmeals')->onDelete('cascade');
            $table->unsignedBigInteger('grocery_id')->nullable();
            $table->foreign('grocery_id')->references('id')->on('groceries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grocery_listmeal');
    }
}
