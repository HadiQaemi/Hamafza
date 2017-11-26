<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProcessPhaseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('process_phase', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('pid')->nullable()->default(0)->comment('processid');
			$table->string('name')->nullable();
			$table->integer('manager')->nullable()->default(0);
			$table->integer('manager1')->default(0);
			$table->integer('form')->nullable()->default(0);
			$table->integer('pform')->default(0);
			$table->integer('score')->default(0);
			$table->integer('alert')->nullable()->default(0);
			$table->binary('view', 1);
			$table->integer('orders')->nullable()->default(0);
			$table->dateTime('reg_date')->nullable();
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `process_phase` 
			MODIFY `view` BINARY DEFAULT 0 NULL');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('process_phase');
	}

}
