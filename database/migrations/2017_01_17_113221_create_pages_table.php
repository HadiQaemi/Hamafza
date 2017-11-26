<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('sid')->index('sid');
			$table->integer('type')->default(0)->comment('tid');
			$table->boolean('btype')->default(1);
			$table->longText('description');
			$table->longText('body')->nullable();
			$table->integer('state')->default(0);
			$table->integer('score')->default(0);
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
			$table->integer('help_pid')->nullable();
			$table->string('help_tag')->nullable();
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `pages` 
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
		Schema::dropIfExists('pages');
	}

}
