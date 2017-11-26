<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProcessSubjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('process_subject', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('pid')->nullable()->default(0)->comment('processid');
			$table->integer('sid')->nullable()->default(0)->comment('subjectid');
			$table->binary('full', 1);
			$table->binary('active', 1);
			$table->dateTime('reg_date')->nullable();
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `process_subject` 
			MODIFY `full` BINARY DEFAULT 0 NULL,
			MODIFY `active` BINARY DEFAULT 1');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('process_subject');
	}

}
