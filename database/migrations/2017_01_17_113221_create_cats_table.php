<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cats', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->string('name', 128);
			$table->integer('stat')->default(0);
			$table->integer('orders')->default(0);
			$table->binary('slave', 1);
			$table->integer('parent_id')->default(0)->index('parent_id');
			$table->boolean('workflow')->default(1);
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `cats` 
			MODIFY `slave` BINARY DEFAULT 0;');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('cats');
	}

}
