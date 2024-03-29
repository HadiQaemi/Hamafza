<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProblemprojectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('problem_project', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('problemid');
			$table->integer('projectid');
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
		Schema::dropIfExists('problem_project');
	}

}
