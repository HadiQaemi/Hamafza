<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewTableTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_table', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('sid')->index('sid');
			$table->integer('type')->default(0)->comment('tid');
			$table->boolean('btype')->default(1);
			$table->longText('description');
			$table->longText('body');
			$table->integer('state')->default(0);
			$table->boolean('score')->default(0);
			$table->smallInteger('form')->default(0);
			$table->binary('part', 1);
			$table->binary('view', 1);
			$table->binary('edit', 1);
			$table->dateTime('edit_date');
			$table->date('ver_date');
			$table->dateTime('com_date');
			$table->dateTime('end_date');
			$table->integer('editor')->default(0);
			$table->string('defimage', 500)->nullable();
			$table->enum('showDefimg', array('0','1'))->nullable()->default('0');
			$table->enum('viewtext', array('1','0'))->nullable()->default('1');
			$table->enum('viewslide', array('0','1'))->nullable()->default('0');
			$table->enum('viewfilm', array('1','0'))->nullable()->default('0');
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `new_table` 
			MODIFY `part` BINARY DEFAULT 0,
			MODIFY `view` BINARY DEFAULT 1,
			MODIFY `edit` BINARY DEFAULT 0;');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('new_table');
	}

}
