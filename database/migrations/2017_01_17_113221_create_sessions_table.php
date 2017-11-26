<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSessionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sessions', function ($table) {
			$table->string('id')->unique();
			$table->integer('user_id')->nullable();
			$table->string('ip_address', 45)->nullable();
			$table->longText('user_agent')->nullable();
			$table->longText('payload');
			$table->integer('last_activity');

		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('sessions');
	}

}
