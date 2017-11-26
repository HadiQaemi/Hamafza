<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScheduleRelationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule_relations', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('user_id')->unsigned()->default(0);
            $table->integer('schedule_id')->nullable()->unsigned()->default(null);
            $table->string('target_table', 255)->nullable()->default(null);
			$table->integer('target_id')->nullable()->unsigned()->default(null);
			$table->enum('use_as_repeater', array('0','1'))->nullable()->default('0');
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
		Schema::dropIfExists('schedule_relations');
	}

}
