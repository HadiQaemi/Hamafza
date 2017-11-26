<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVezaratPreferenceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vezarat_preference', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('uid')->default(0)->unsigned();
			$table->string('a')->nullable();
			$table->string('d')->nullable();
			$table->string('e')->nullable();
			$table->longText('f')->nullable();
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
		Schema::dropIfExists('vezarat_preference');
	}

}
