<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangProcessTasksRelations extends Migration
{
    public function up()
    {
        Schema::create('hamahang_process_tasks_relations', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('relation_id')->unsigned();
            $table->integer('task_id')->unsigned();
            $table->integer('next_task_id')->unsigned()->nullable()->default(0);
            $table->integer('user_id')->unsigned();
			$table->integer('process_id')->unsigned()->default(0);
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
        Schema::dropIfExists('hamahang_process_tasks_relations');
    }
}
