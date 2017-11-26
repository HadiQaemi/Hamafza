<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('actions', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('admin');
			$table->integer('pid')->index('pid');
			$table->longText('title');
			$table->longText('quote');
			$table->longText('Descr')->nullable();
			$table->string('file', 500)->nullable();
			$table->enum('allowredirect', array('1','0'))->nullable();
			$table->dateTime('res_date');
			$table->enum('urgency', array('2','1','0','3'))->nullable();
			$table->boolean('priority')->default(1);
			$table->dateTime('reg_date');
			$table->enum('isdraft', array('0','1'))->nullable()->default('0');
			$table->enum('checked', array('1','0'))->nullable()->default('0');
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
		Schema::dropIfExists('actions');
	}

}
