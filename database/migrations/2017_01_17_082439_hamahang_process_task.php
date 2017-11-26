<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangProcessTask extends Migration
{
    public function up()
    {
        Schema::create('hamahang_process_task', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned();
			$table->integer('assign_type')->unsigned()->default(0);
			$table->string('title', 255)->nullable()->default(null);
			$table->string('desc', 255)->nullable()->default(null);
			$table->tinyInteger('type')->unsigned()->nullable()->default(0);
			$table->tinyInteger('report_on_create_point')->unsigned()->nullable()->default(0);
			$table->tinyInteger('report_on_completion_point')->unsigned()->nullable()->default(0);
			$table->tinyInteger('report_to_managers')->unsigned()->nullable()->default(0);
			$table->integer('respite')->unsigned()->nullable()->default(null);
			$table->tinyInteger('importance')->unsigned()->nullable()->default(null);
			$table->tinyInteger('immediate')->unsigned()->nullable()->default(null);
			$table->integer('predicted_time')->unsigned()->nullable()->default(null);
			$table->date('start_timestamp')->nullable()->default(null);
			$table->date('end_timestamp')->nullable()->default(null);
			$table->tinyInteger('end_on_assigner_accept')->unsigned()->nullable()->default(null);
			$table->tinyInteger('transferable')->unsigned()->nullable()->default(null);
			$table->longText('users')->nullable();
			$table->longText('transcripts')->nullable();
			$table->longText('keywords')->nullable();
			$table->longText('files')->nullable();
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
        Schema::dropIfExists('hamahang_process_task');
    }
}
