<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErrorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('errors', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('contentid')->default(0);
			$table->string('typeid', 7)->default('1');
			$table->integer('catid')->default(0);
			$table->integer('admin');
			$table->string('title');
			$table->integer('kind');
			$table->longText('quote');
			$table->longText('comment');
			$table->integer('parent');
			$table->boolean('private')->default(0);
			$table->binary('handle', 1);
			$table->integer('handler')->default(0);
			$table->boolean('active')->default(0);
			$table->dateTime('com_date');
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `errors` 
			MODIFY `handle` BINARY DEFAULT 0');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('errors');
	}

}
