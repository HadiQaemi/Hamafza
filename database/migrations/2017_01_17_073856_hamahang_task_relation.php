<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangTaskRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_task_relation', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned();
            $table->integer('t1')->unsigned()->nullable()->default(null);
            $table->integer('t2')->unsigned()->nullable()->default(null);
            $table->integer('ste')->unsigned()->nullable()->default(null);
            $table->integer('ets')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('hamahang_task_relation');
    }
}
