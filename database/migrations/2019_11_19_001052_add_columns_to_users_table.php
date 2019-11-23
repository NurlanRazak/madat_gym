<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //пользователи
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('date_birth')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->float('current_weight')->nullable();
            $table->float('height')->nullable();
            $table->string('iin')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('social_media')->nullable();
            $table->text('comment')->nullable();
            $table->timestamp('date_register')->nullable();
            $table->tinyInteger('type_employee')->nullable();
            //сотрудники
            $table->timestamp('date_hired')->nullable();
            $table->string('position')->nullable();
            $table->timestamp('date_fired')->nullable();
            $table->text('address')->nullable();
            $table->string('image')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
