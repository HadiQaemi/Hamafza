<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_project', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(null);
            $table->string('title', 255)->nullable()->default(null);
            $table->string('desc', 255)->nullable()->default(null);
            $table->string('page', 255)->nullable()->default(null);
            $table->string('top_goals', 255)->nullable()->default(null);
            $table->string('org_unit', 255)->nullable()->default(null);
            $table->tinyInteger('observation_permission_all')->unsigned()->nullable()->default(null);
            $table->tinyInteger('modify_permission_all')->unsigned()->nullable()->default(null);
            $table->integer('priority')->unsigned()->nullable()->default(null);
            $table->integer('state_date')->unsigned()->nullable()->default(null);
            $table->integer('end_date')->unsigned()->nullable()->default(null);
            $table->integer('start_date')->unsigned()->nullable()->default(null);
            $table->integer('current_date')->unsigned()->nullable()->default(null);
            $table->string('schedule_on', 255)->nullable()->default(null);
            $table->integer('base_calendar')->unsigned()->nullable()->default(null);
            $table->string('type', 255)->nullable()->default(null);
            $table->tinyInteger('draft')->nullable()->default(null);
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
        Schema::dropIfExists('hamahang_project');
    }
}
