<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubjectJudgeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subject_judge', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('admin');
			$table->integer('sid');
			$table->binary('type', 1);
			$table->binary('send', 1);
			$table->binary('response', 1);
			$table->integer('score')->default(0);
			$table->binary('accept', 1);
			$table->integer('form_id')->default(0);
			$table->integer('report_id');
			$table->dateTime('response_date');
			$table->dateTime('reg_date');
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `subject_judge` 
			MODIFY `type` BINARY DEFAULT 0,
			MODIFY `send` BINARY DEFAULT 0,
			MODIFY `response` BINARY DEFAULT 0,
			MODIFY `accept` BINARY DEFAULT 0');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('subject_judge');
	}

}
