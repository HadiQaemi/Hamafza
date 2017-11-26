<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('history', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->smallInteger('admin');
			$table->integer('pid')->index('pid');
			$table->longText('first');
			$table->longText('second');
			$table->longText('body');
			$table->binary('part', 1);
			$table->smallInteger('edit')->default(0);
			$table->binary('active', 1);
			$table->longText('com');
			$table->dateTime('edit_date');
			$table->binary('version', 1);
			$table->date('ver_date');
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `history` 
			MODIFY `part` BINARY DEFAULT 0,
			MODIFY `active` BINARY DEFAULT 0,
			MODIFY `version` BINARY DEFAULT 0;');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('history');
	}

}
