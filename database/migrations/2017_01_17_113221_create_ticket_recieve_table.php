<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketRecieveTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_recieve', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);;
			$table->integer('tid');
			$table->binary('view', 1);
			$table->smallInteger('del')->nullable()->default(0);
			$table->timestamps();
            $table->softDeletes();
		});
		DB::statement('ALTER TABLE `ticket_recieve` 
			MODIFY `view` BINARY DEFAULT 0');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ticket_recieve');
	}

}
