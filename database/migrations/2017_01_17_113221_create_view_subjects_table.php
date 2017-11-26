<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateViewSubjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('view_subjects', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('sid')->nullable();
			$table->integer('pid')->nullable();
			$table->integer('kind')->nullable();
			$table->integer('type')->nullable();
			$table->string('title', 128)->nullable();
			$table->binary('frame', 1);
			$table->binary('theme', 1);
			$table->decimal('nstate', 32, 0)->nullable();
			$table->decimal('ncoms', 41, 0)->nullable();
			$table->dateTime('reg_date')->nullable();
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `view_subjects` 
			MODIFY `frame` BINARY NULL,
			MODIFY `theme` BINARY NULL');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('view_subjects');
	}

}
