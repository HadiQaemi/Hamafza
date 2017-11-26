<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangCalendarEventsFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_calendar_events_files', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('event_id')->unsigned();
            $table->integer('file_id')->unsigned();
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
        Schema::dropIfExists('hamahang_calendar_events_files');
    }
}
