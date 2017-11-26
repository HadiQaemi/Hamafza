<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageDraftTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('page_draft', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->longText('body');
			$table->dateTime('edit_date');
			$table->dateTime('last_date');
			$table->binary('editing', 1);
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `page_draft` 
			MODIFY `editing` BINARY DEFAULT 0');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('page_draft');
	}

}
