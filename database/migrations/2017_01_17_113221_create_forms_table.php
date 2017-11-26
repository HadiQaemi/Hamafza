<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forms', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('admin')->default(1);
			$table->string('title');
			$table->longText('help');
			$table->boolean('type')->default(1);
			$table->boolean('col')->default(1);
			$table->dateTime('reg_date');
			$table->dateTime('start_time')->nullable();
			$table->dateTime('end_time')->nullable();
			$table->smallInteger('onereport')->nullable();
			$table->smallInteger('isdraft')->nullable()->default(0);
			$table->longText('after_end')->nullable();
			$table->longText('before_start')->nullable();
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
		Schema::dropIfExists('forms');
	}

}
