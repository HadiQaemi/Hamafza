<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangCalendarEventsReminders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_calendar_events_reminders', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(1);
            $table->tinyInteger('type')->unsigned()->default(1)->nullable();
            $table->integer('event_id')->unsigned()->default(0);
            $table->integer('remind_date')->unsigned();
            $table->time('term')->nullable()->default(null);
            $table->tinyInteger('notification')->default(0);
            $table->tinyInteger('email')->default(0);
            $table->tinyInteger('in_events')->default(0);
            $table->tinyInteger('sms')->default(0);
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
        Schema::dropIfExists('hamahang_calendar_events_reminders');
    }
}
