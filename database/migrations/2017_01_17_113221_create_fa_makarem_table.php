<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFaMakaremTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fa_makarem', function(Blueprint $table)
		{
			$table->increments('index')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('sura')->default(0);
			$table->integer('aya')->default(0);
			$table->longText('text');
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
		Schema::dropIfExists('fa_makarem');
	}

}
