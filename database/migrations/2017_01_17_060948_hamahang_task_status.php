<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangTaskStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_task_status', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('user_id')->unsigned();
            $table->integer('task_id')->unsigned();
            $table->integer('percent')->unsigned()->nullable()->default(0);
            $table->integer('type')->unsigned()->nullable()->default(null);
            $table->integer('timestamp')->unsigned()->nullable()->default(null);
            /*$table->integer('task_assignment_id')->unsigned()->nullable()->default(null);*/
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
        Schema::dropIfExists('hamahang_task_status');
    }
}
