<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVezaratProgramTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vezarat_program', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('uid')->default(0)->unsigned();
			$table->string('name')->nullable();
			$table->string('parent')->nullable();
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
		Schema::dropIfExists('vezarat_program');
	}

}
