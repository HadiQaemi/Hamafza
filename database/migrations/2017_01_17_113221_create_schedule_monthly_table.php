<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScheduleMonthlyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule_monthly', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('user_id')->unsigned()->default(0);
            $table->integer('schedule_id')->unsigned()->nullable()->default(null);
            $table->string('months', 255)->nullable()->default(null);
			$table->tinyInteger('type')->nullable()->default(null);
			$table->string('days', 255)->nullable()->default(null);
			$table->string('weeknums', 255)->nullable()->default(null);
			$table->string('weekdays', 255)->nullable()->default(null);
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
		Schema::dropIfExists('schedule_monthly');
	}

}
