<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangProjectTaskRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_project_task_relations', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(null);
            $table->integer('project_id')->unsigned()->nullable()->default(null);
            $table->integer('first_task_id')->unsigned()->nullable()->default(null);
            $table->integer('second_task_id')->unsigned()->nullable()->default(null);
            $table->string('relation', 255)->nullable()->default(null);
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
        Schema::dropIfExists('hamahang_project_task_relations');
    }
}
