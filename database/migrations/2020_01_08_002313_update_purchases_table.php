<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->unsignedBigInteger('typepurchase_id')->nullable()->change();

            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            //
        });
    }
}
