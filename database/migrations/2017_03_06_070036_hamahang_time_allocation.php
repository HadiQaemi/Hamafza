<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HamahangTimeAllocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_time_allocation',function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
            $table->integer('calendar_id')->default(0)->unsigned();
            $table->integer('task_id')->default(0)->unsigned();
            $table->date('allocate_date')->default(null);
            $table->integer('all_day')->default(0)->unsigned();
            $table->time('period_time')->default(null);
            $table->time('start_time')->default(null);
            $table->time('end_time')->default(null);
            $table->string('color',12)->default(null);
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
        Schema::dropIfExists('hamahang_time_allocation');
    }
}
