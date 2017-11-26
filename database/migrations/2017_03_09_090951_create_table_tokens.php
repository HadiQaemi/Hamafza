<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTokens extends Migration
{
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
            $table->string('token');
            $table->string('imei');
            $table->string('os_name');
            $table->string('os_version');
            $table->string('device_name');
            $table->integer('life_time');
            $table->timestamp('last_response_time');
            $table->tinyInteger('guest_mode');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tokens');
    }
}
