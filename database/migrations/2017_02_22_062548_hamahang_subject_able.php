<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangSubjectAble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_subject_ables', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->integer('target_id')->unsigned();
            $table->string('target_type');
            $table->integer('created_by')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hamahang_subject_ables');
    }
}
