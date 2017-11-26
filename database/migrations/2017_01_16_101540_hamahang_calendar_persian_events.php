<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangCalendarPersianEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_calendar_persian_events', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->smallInteger('Month')->unsigned()->dafault(null)->nullable();
            $table->smallInteger('Day')->unsigned()->dafault(null)->nullable();
            $table->smallInteger('Year')->unsigned()->dafault(null)->nullable();
            $table->longText('Description')->nullable();
            $table->smallInteger('IsVacation')->unsigned()->dafault(null)->nullable();
            $table->string('type', 255)->dafault(null)->nullable();
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
        Schema::dropIfExists('hamahang_calendar_persian_events');
    }
}
