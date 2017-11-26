<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_files', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->string('originalName', 255)->nullable()->default(null);
            $table->string('extension', 255)->nullable()->default(null);
            $table->string('mimeType', 255)->nullable()->default(null);
            $table->double('size')->nullable()->default(null);
            $table->string('path', 255)->nullable()->default(null);
            $table->string('filename', 255)->nullable()->default(null);
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
        Schema::dropIfExists('hamahang_files');
    }
}
