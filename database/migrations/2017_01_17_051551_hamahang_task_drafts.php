<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangTaskDrafts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_task_drafts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('user_id')->unsigned()->default(0);
            $table->longText('form_data')->default(null);
            $table->tinyInteger('type')->unsigned()->nullable()->default(0);
            $table->tinyInteger('report_on_create_point')->unsigned()->nullable()->default(0);
            $table->tinyInteger('report_on_completion_point')->unsigned()->nullable()->default(0);
            $table->tinyInteger('report_to_managers')->unsigned()->nullable()->default(0);
            $table->tinyInteger('importance')->unsigned()->nullable()->default(null);
            $table->tinyInteger('immediate')->unsigned()->nullable()->default(null);
            $table->integer('duration_timestamp')->unsigned()->nullable()->default(null);
            $table->string('title', 255);
            $table->integer('timing_type')->unsigned()->nullable()->default(null);
            $table->string('desc', 255)->nullable()->default(null);
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
        Schema::dropIfExists('hamahang_task_drafts');
    }
}
