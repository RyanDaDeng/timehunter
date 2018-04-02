<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFrequencyIntoTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('frequency')->nullable();
        });

        Schema::table('todos', function (Blueprint $table) {
            $table->string('frequency')->nullable();
            $table->string('name')->nullable();
            $table->boolean('is_done')->default(false);
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
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('frequency');
        });


        Schema::table('todos', function (Blueprint $table) {
            $table->dropColumn('frequency');
            $table->dropColumn('name');
            $table->dropColumn('is_done');
        });
    }
}
