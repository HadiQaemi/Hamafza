<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageVisitTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('page_visit', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned()->index('uid');
			$table->integer('pid')->index('pid');
			$table->dateTime('view_page');
			$table->binary('edit', 1);
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `page_visit` 
			MODIFY `edit` BINARY DEFAULT 0');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('page_visit');
	}

}
