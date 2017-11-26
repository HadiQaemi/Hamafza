<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);;
			$table->string('title');
			$table->dateTime('reg_date');
			$table->dateTime('answer_date');
			$table->binary('answer', 1);
			$table->binary('login', 1);
			$table->timestamps();
            $table->softDeletes();
		});
		DB::statement('ALTER TABLE `tickets` 
			MODIFY `answer` BINARY DEFAULT 0,
			MODIFY `login` BINARY DEFAULT 0');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tickets');
	}

}
