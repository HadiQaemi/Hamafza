<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangCalendarSessionsEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_calendar_sessions_events', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('event_id')->unsigned();
            $table->smallInteger('type')->unsigned()->default(1);
            $table->string('agenda', 450);
            $table->string('term', 45)->nullable()->default(null);
            $table->integer('session_chief')->nullable()->default(null)->unsigned();
            $table->integer('session_secretary')->nullable()->default(null)->unsigned();
            $table->integer('session_facilitator')->nullable()->default(null)->unsigned();
            $table->longText('location')->nullable()->default(null);
            $table->decimal('long', 11, 8)->nullable()->default(null);
            $table->decimal('lat', 10, 8)->nullable()->default(null);
            $table->string('location_phone', 12)->nullable()->default(null);
            $table->string('coordination_phone', 12)->nullable()->default(null);
            $table->tinyInteger('send_invitation')->nullable()->default(1);
            $table->tinyInteger('create_session_page')->nullable()->default(1);
            $table->tinyInteger('allow_inform_invitees')->nullable()->default(null);
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
        Schema::dropIfExists('hamahang_calendar_sessions_events');
    }
}
