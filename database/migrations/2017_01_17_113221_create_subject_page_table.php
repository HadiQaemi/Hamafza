<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubjectPageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subject_page', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('sid')->default(0);
			$table->integer('sttid')->default(0);
			$table->longText('description');
			$table->longText('body');
			$table->integer('part')->default(0);
			$table->integer('state')->default(0);
			$table->binary('view', 1);
			$table->binary('viewpart', 1);
			$table->binary('edit', 1);
			$table->binary('editing', 1);
			$table->integer('form')->default(0);
			$table->dateTime('edit_date');
			$table->dateTime('ver_date');
			$table->dateTime('com_date');
			$table->dateTime('end_date');
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `subject_page` 
			MODIFY `view` BINARY DEFAULT 0,
			MODIFY `viewpart` BINARY DEFAULT 0,
			MODIFY `edit` BINARY DEFAULT 0,
			MODIFY `editing` BINARY DEFAULT 0');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('subject_page');
	}

}
