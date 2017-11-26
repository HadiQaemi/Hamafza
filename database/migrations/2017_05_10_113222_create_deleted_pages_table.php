<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeletedPagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('deleted_pages', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->unsigned()->default(0);
            $table->integer('sid')->unsigned();
            $table->integer('type')->unsigned()->default(0)->comment('tid');
            $table->tinyInteger('btype')->unsigned()->default(1);
			$table->longText('description');
			$table->longText('body');
			$table->integer('state')->unsigned()->default(0);
			$table->tinyInteger('score')->unsigned()->default(0);
			$table->smallInteger('form')->unsigned()->default(0);
			$table->binary('part', 1);
			$table->binary('view', 1);
			$table->binary('edit', 1);
			$table->dateTime('edit_date');
			$table->date('ver_date');
			$table->dateTime('com_date');
			$table->dateTime('end_date');
			$table->integer('editor')->unsigned()->default(0);
			$table->string('defimage', 500)->default(null);
			$table->enum('showDefimg', array('0','1'))->default('0');
			$table->enum('viewtext', array('1','0'))->default('1');
			$table->enum('viewslide', array('0','1'))->default('0');
			$table->enum('viewfilm', array('1','0'))->default('0');
			$table->timestamps();
            $table->softDeletes();
		});
		DB::statement('ALTER TABLE `deleted_pages` 
			MODIFY `part` BINARY DEFAULT 0,
			MODIFY `view` BINARY DEFAULT 1,
			MODIFY `edit` BINARY DEFAULT 0');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('deleted_pages');
	}

}
