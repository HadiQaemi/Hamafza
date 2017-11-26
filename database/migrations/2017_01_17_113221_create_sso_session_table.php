<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSsoSessionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sso_session', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->string('sesid', 100)->nullable();
			$table->smallInteger('devtype')->nullable();
			$table->dateTime('login_date')->nullable();
			$table->dateTime('last_activity')->nullable();
			$table->string('last_session_id', 100)->nullable();
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
		Schema::dropIfExists('sso_session');
	}

}
