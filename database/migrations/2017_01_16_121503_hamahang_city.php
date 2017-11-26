<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangCity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_city', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(null);
            $table->integer('province_id')->unsigned()->nullable()->default(null);
            $table->string('name', 255)->nullable()->default(null);
            $table->string('description', 255)->nullable()->default(null);
            $table->double('lng', 11, 7)->nullable()->default(null);
            $table->double('lat', 11, 7)->nullable()->default(null);
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
        Schema::dropIfExists('hamahang_city');
    }
}
