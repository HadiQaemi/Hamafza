<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFieldsValueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fields_value', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('field_id')->unsigned()->default(0)->index('fid');
			$table->string('field_value');
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
		Schema::dropIfExists('fields_value');
	}

}
