<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangTaskAssignments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_task_assignments', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('assigner_id')->unsigned()->default(0);
            $table->integer('employee_id')->unsigned()->nullable()->default(null);
            $table->integer('task_id')->unsigned()->nullable();
            $table->integer('transferred_to_id')->unsigned()->nullable()->default(null);
            $table->integer('transmitter_id')->unsigned()->nullable()->default(null);
            $table->string('reject_description')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hamahang_task_assignments');
    }
}
