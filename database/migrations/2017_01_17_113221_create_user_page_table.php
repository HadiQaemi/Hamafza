<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserPageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_page', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned()->index('uid');
			$table->binary('page', 1);
			$table->string('name');
			$table->string('link');
			$table->binary('first', 1);
			$table->binary('dist', 1);
			$table->boolean('orders')->default(0);
			$table->integer('cid')->default(0)->comment('circle_id');
			$table->longText('body');
			$table->dateTime('reg_date');
			$table->dateTime('edit_date');
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `user_page` 
			MODIFY `page` BINARY DEFAULT 0,
			MODIFY `first` BINARY DEFAULT 0,
			MODIFY `dist` BINARY DEFAULT 0');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('user_page');
	}

}
