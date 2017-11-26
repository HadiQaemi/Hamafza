<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditHamahangCalendarPersianEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hamahang_calendar_persian_events', function(Blueprint $table) {
            DB::statement('ALTER TABLE `hamahang_calendar_persian_events` 
					ADD COLUMN `g_time` datetime NULL AFTER `Year`;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hamahang_calendar_persian_events', function(Blueprint $table) {
            DB::statement('Alter TABLE `hamahang_calendar_persian_events` 
                          DROP COLUMN `g_time`');
        });
    }
}
