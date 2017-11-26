<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormsReportTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forms_report', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('form_id');
			$table->integer('pid')->default(0)->comment('pageid');
			$table->integer('sid')->default(0)->comment('subjectid');
			$table->integer('ppid')->default(0)->comment('process_phase_id');
			$table->integer('ppsid')->default(0)->comment('process_phase_subject_id');
			$table->binary('view', 1);
			$table->binary('publish', 1);
			$table->dateTime('reg_date');
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `forms_report` 
			MODIFY `view` BINARY DEFAULT 0,
			MODIFY `publish` BINARY DEFAULT 0;');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('forms_report');
	}

}
