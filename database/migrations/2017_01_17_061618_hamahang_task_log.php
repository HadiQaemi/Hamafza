<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangTaskLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_task_log', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('assign_id')->unsigned()->nullable()->default(null);
            $table->integer('task_id')->unsigned()->nullable()->default(null);
            $table->integer('task_type')->unsigned()->nullable()->default(null);
            $table->string('type', 255)->nullable()->default(null);
            $table->integer('new_assign_id')->unsigned()->nullable()->default(0);
            $table->integer('timestamp')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('hamahang_task_log');
    }
}
