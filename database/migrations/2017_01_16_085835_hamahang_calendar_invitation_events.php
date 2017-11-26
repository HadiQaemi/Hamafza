<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangCalendarInvitationEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_calendar_invitation_events', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('event_id')->unsigned()->default(1);
            $table->string('about', 450);
            $table->integer('type');
            $table->time('term')->default(null);
            $table->string('location', 45)->nullable()->default(null);
            $table->decimal('long', 11, 8)->nullable()->default(null);
            $table->decimal('lat', 10, 8)->nullable()->default(null);
            $table->tinyInteger('allow_inform_invitees')->nullable()->default(1);
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
        Schema::dropIfExists('hamahang_calendar_invitation_events');
    }
}
