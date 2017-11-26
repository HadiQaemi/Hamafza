<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserSpecialTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_special', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('user_id')->default(0)->unsigned();
            $table->integer('keyword_id')->default(0)->unsigned();
            $table->integer('created_by')->unsigned()->nullable()->default(0);
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
		Schema::dropIfExists('user_special');
	}

}
