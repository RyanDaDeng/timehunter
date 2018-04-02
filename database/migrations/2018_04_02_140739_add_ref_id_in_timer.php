<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRefIdInTimer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('timers', function (Blueprint $table) {
            $table->integer('task_id')->nullable();
            $table->integer('todo_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //

        Schema::table('timers', function (Blueprint $table) {
            $table->dropColumn('task_id');
            $table->dropColumn('todo_id');
        });
    }
}
