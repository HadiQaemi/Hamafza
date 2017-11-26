<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActionrecieveTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('action_recieve', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('mid')->index('mid');
			$table->boolean('complete');
			$table->enum('checked', array('3','2','1','0'))->default('0');
			$table->enum('new', array('1','0'))->default('0');
			$table->dateTime('checked_date')->nullable();
			$table->longText('descr')->nullable();
			$table->enum('is_bc', array('1','0'))->default('0');
			$table->dateTime('accept_date')->nullable();
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
		Schema::dropIfExists('action_recieve');
	}

}
