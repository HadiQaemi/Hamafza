<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserSuggestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_suggest', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
			$table->enum('type', array('page','group','user','site'))->default('page');
			$table->integer('tid')->unsigned()->default(0);
			$table->string('sname', 64);
			$table->string('semail', 64);
			$table->string('rcid', 255)->default('0');
			$table->string('rgid', 255)->default('0');
			$table->string('ruid', 255)->default('0');
			$table->string('remail', 64);
			$table->longText('quote');
			$table->string('comment', 255);
			$table->dateTime('reg_date');
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
		Schema::drop('user_suggest');
	}

}
