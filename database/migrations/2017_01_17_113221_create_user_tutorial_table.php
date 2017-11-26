<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTutorialTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_tutorial', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->string('company', 128);
			$table->string('course', 128);
			$table->integer('province')->unsigned()->default(0);
			$table->integer('city')->unsigned()->default(0);
			$table->boolean('n_hour')->default(0);
			$table->smallInteger('s_year')->unsigned()->default(0);
			$table->longText('comment');
			$table->integer('orders')->default(0);
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
		Schema::dropIfExists('user_tutorial');
	}

}
