<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangLibraryTaskParent extends Migration
{
    public function up()
    {
        Schema::create('hamahang_library_task_parent', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('library_task_id')->unsigned();
            $table->integer('parent_type')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hamahang_library_task_parent');
    }
}
