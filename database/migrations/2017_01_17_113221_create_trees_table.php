<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTreesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trees', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('tid')->default(0)->index('tid');
			$table->string('name');
			$table->longText('comment');
			$table->integer('did')->default(0);
			$table->integer('orders')->default(0);
			$table->integer('parent_id')->default(0)->index('parent_id');
			$table->binary('slave', 1);
			$table->binary('admin', 1);
			$table->integer('pid')->default(0);
			$table->boolean('depth')->default(0);
			$table->boolean('shpage')->default(0);
			$table->binary('view', 1);
			$table->binary('distance', 1);
			$table->dateTime('reg_date');
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `trees` 
			MODIFY `slave` BINARY DEFAULT 0,
			MODIFY `admin` BINARY DEFAULT 0,
			MODIFY `view` BINARY DEFAULT 0,
			MODIFY `distance` BINARY DEFAULT 0');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('trees');
	}

}
