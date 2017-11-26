<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserSpecialEndorseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_special_endorse', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('user_id')->default(0)->unsigned();
			$table->integer('user_special_id')->nullable();
            $table->integer('created_by')->unsigned()->default(0);
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
		Schema::dropIfExists('user_special_endorse');
	}

}
