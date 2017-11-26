<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangCalendarEventsDecisionTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_calendar_events_decision_task', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('decision_id')->unsigned();
            $table->integer('task_id')->unsigned();
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
        Schema::dropIfExists('hamahang_calendar_events_decision_task');
    }
}
