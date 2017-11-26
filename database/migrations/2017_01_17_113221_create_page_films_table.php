<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagefilmsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('page_films', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->string('pretitle', 500)->nullable();
			$table->string('title', 500)->nullable();
			$table->string('film', 500)->nullable();
			$table->string('pic', 500)->nullable();
			$table->string('descr', 1000)->nullable();
			$table->string('length', 50)->nullable();
			$table->integer('pid')->nullable();
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
		Schema::dropIfExists('page_films');
	}

}
