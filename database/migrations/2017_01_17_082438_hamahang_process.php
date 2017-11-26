<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangProcess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_process', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned();
			$table->string('title', 255)->nullable()->default(null);
			$table->tinyInteger('type')->unsigned()->nullable()->default(null);
			$table->integer('responsible')->unsigned()->nullable()->default(null);
			$table->string('description', 255)->nullable()->default(null);
			$table->integer('org_unit')->unsigned()->nullable()->default(null);
			$table->integer('draft')->unsigned()->default(0);
			$table->integer('start_task_id')->unsigned()->default(0);
			$table->integer('end_task_id')->unsigned()->default(0);
			$table->integer('status')->unsigned()->default(0);
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
        Schema::dropIfExists('hamahang_process');
    }
}
