<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProcessPhaseSubjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('process_phase_subject', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('pid')->nullable()->default(0)->comment('processid');
			$table->integer('ppid')->nullable()->default(0)->comment('phaseid');
			$table->integer('psid')->nullable()->default(0)->comment('processsubjectid');
			$table->integer('sid')->nullable()->default(0)->comment('subjectid');
			$table->integer('rid')->nullable()->default(0)->comment('reportid');
			$table->binary('pass', 1);
			$table->binary('active', 1);
			$table->dateTime('reg_date')->nullable();
			$table->enum('view', array('0','1'))->nullable()->default('0');
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `process_phase_subject` 
			MODIFY `pass` BINARY DEFAULT 0 NULL,
			MODIFY `active` BINARY DEFAULT 0 NULL');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('process_phase_subject');
	}

}
