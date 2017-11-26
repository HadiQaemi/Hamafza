<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_task', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->string('title', 255);
            $table->string('desc', 255)->nullable()->default(null);
            $table->tinyInteger('type')->unsigned()->nullable()->default(0);
            $table->tinyInteger('report_on_create_point')->unsigned()->nullable()->default(0);
            $table->tinyInteger('report_on_completion_point')->unsigned()->nullable()->default(0);
            $table->tinyInteger('report_to_managers')->unsigned()->nullable()->default(0);
            $table->integer('duration_timestamp')->unsigned()->nullable()->default(null);
            $table->longText('form_data')->default(null);
            $table->tinyInteger('end_on_assigner_accept')->nullable()->default(0);
            $table->tinyInteger('transferable')->nullable()->default(null);
			$table->integer('use_type')->unsigned()->nullable()->default(null);
			$table->dateTime('schedule_time')->nullable()->default(null);
			$table->integer('schedule_id')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('hamahang_task');
    }
}
