<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangTaskFiles extends Migration
{
    public function up()
    {
        Schema::create('hamahang_task_files', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('task_id')->unsigned()->nullable()->default(null);
            $table->integer('file_id')->unsigned()->nullable()->default(null);
            $table->integer('field')->unsigned()->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hamahang_task_files');
    }
}
