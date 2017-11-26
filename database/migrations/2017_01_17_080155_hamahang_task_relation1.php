<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangTaskRelation1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_task_relation1', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('task_id')->unsigned()->default(0);
            $table->integer('task_parent_id')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('hamahang_task_relation1');
    }
}
