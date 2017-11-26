<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlertsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alerts', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('uid')->default(0)->unsigned();
			$table->string('name', 128);
			$table->binary('scroll', 1);
			$table->longText('comment');
			$table->smallInteger('orders')->default(0);
			$table->integer('workflow');
			$table->dateTime('reg_date')->nullable()->default(null);
			$table->dateTime('edit_date')->nullable()->default(null);
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `alerts` 
			MODIFY `scroll` BINARY DEFAULT 0');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('alerts');
	}

}
