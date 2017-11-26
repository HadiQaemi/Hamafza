<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubjectProjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subject_project', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('sid')->index('sid');
			$table->integer('pid');
			$table->integer('ssid');
			$table->integer('spid');
		    $table->timestamps();
            $table->softDeletes();
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('subject_project');
	}

}
