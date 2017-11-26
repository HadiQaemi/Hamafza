<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangCalendar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_calendar', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
            $table->integer('user_id')->default(null)->unsigned();
            $table->string('title', 255)->default(null);
            $table->integer('type')->default(0)->unsigned()->comment('نوع تقویم ( شخصی:۱، رسمی:۲، تقویم پیش فرض:۳)');
            $table->integer('is_default')->unsigned()->default(0);
            $table->integer('prayer_times')->unsigned()->default(1);
            $table->integer('prayer_time_province')->unsigned()->default(null)->nullable();
            $table->integer('prayer_time_city')->unsigned()->default(1);
            $table->integer('beginning_day')->unsigned();
            $table->integer('monasebat')->default(null)->nullable();
            $table->integer('birth_day')->unsigned()->default(null)->nullable();
            $table->longText('description')->nullable();
            $table->longText('default_options')->nullable();
            $table->longText('sharing_options')->nullable();
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
        Schema::dropIfExists('hamahang_calendar');
    }
}
