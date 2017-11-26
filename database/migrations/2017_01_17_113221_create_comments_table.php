<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('pid');
			$table->integer('tid')->default(0);
			$table->integer('admin');
			$table->integer('kind');
			$table->integer('about');
			$table->longText('quote');
			$table->longText('comment');
			$table->integer('parent');
			$table->binary('private', 1);
			$table->binary('sel', 1);
			$table->dateTime('com_date');
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `comments` 
			MODIFY `private` BINARY DEFAULT 0,
			MODIFY `sel` BINARY DEFAULT 0;');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('comments');
	}

}
