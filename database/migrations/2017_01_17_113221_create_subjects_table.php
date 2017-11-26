<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subjects', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->smallInteger('admin');
			$table->string('title', 900);
			$table->integer('kind')->default(0)->comment('stid');
			$table->integer('group')->default(0);
			$table->string('author');
			$table->boolean('lang')->default(1);
			$table->boolean('priority')->default(1);
			$table->integer('pform')->default(0);
			$table->binary('theme', 1);
			$table->integer('themeid')->default(0);
			$table->binary('frame', 1);
			$table->integer('frameid')->default(0);
			$table->binary('synch', 1);
			$table->binary('list', 1);
			$table->binary('graph', 1);
			$table->binary('search', 1);
			$table->binary('top', 1);
			$table->binary('view', 1);
			$table->smallInteger('period')->default(30);
			$table->dateTime('reg_date');
			$table->dateTime('edit_date');
			$table->dateTime('eve_date');
			$table->binary('archive', 1);
			$table->integer('manager')->default(0);
			$table->integer('supporter')->default(0);
			$table->integer('supervisor')->default(0);
			$table->integer('visit')->unsigned()->default(0);
			$table->integer('like')->unsigned()->default(0);
			$table->integer('follow')->unsigned()->default(0);
			$table->integer('relation')->unsigned()->default(0);
			$table->integer('suggest')->unsigned()->default(0);
			$table->integer('comment')->unsigned()->default(0);
			$table->enum('ispublic', array('1','0','2'))->default('1');
			$table->date('publicdate')->nullable();
			$table->date('topublicdate')->nullable();
			$table->integer('asubject');
            $table->integer('created_by')->default(0)->unsigned();
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `subjects` 
			MODIFY `theme` BINARY DEFAULT 0,
			MODIFY `frame` BINARY DEFAULT 0,
			MODIFY `synch` BINARY DEFAULT 0,
			MODIFY `list` BINARY DEFAULT 1,
			MODIFY `graph` BINARY DEFAULT 1,
			MODIFY `search` BINARY DEFAULT 1,
			MODIFY `top` BINARY DEFAULT 0,
			MODIFY `view` BINARY DEFAULT 1,
			MODIFY `archive` BINARY DEFAULT 0;');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('subjects');
	}

}
