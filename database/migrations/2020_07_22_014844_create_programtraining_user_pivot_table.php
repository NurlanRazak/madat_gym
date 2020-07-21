<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Pivots\ProgramtrainingUser;

class CreateProgramtrainingUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programtraining_user', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('programtraining_id');
            $table->foreign('programtraining_id')->references('id')->on('programtrainings')->onDelete('cascade');

            $table->tinyInteger('status')->default(ProgramtrainingUser::NOT_ACTIVE);

            $table->datetime('created_at');
            $table->timestamp('bought_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programtraining_user_pivot');
    }
}
