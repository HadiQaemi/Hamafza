<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSchedulePeriodTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule_period', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('user_id')->unsigned()->default(0);
            $table->integer('schedule_id')->unsigned()->nullable()->default(null);
            $table->time('start_time')->nullable()->default(null);
			$table->integer('recur_type')->nullable()->unsigned()->default(null);
			$table->integer('count')->unsigned()->nullable()->default(null);
			$table->time('end_time')->nullable()->default(null);
			$table->integer('recur_freq')->unsigned()->nullable()->default(null);
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
		Schema::dropIfExists('schedule_period');
	}

}
