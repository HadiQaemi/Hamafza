<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubjecttypetabTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subject_type_tab', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('admin')->default(0);
			$table->integer('stid')->default(0)->index('stid');
			$table->integer('tid')->default(0);
			$table->string('name', 128);
			$table->binary('shname', 1);
			$table->boolean('type')->default(0);
			$table->integer('sptid')->default(0);
			$table->binary('brief', 1);
			$table->binary('first', 1);
			$table->binary('view', 1);
			$table->binary('dist', 1);
			$table->integer('orders')->default(0);
			$table->dateTime('reg_date');
			$table->dateTime('edit_date');
			$table->longText('tem')->nullable();
			$table->integer('help_pid')->nullable();
			$table->string('help_tag')->nullable();
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `subject_type_tab` 
			MODIFY `shname` BINARY DEFAULT 1,
			MODIFY `brief` BINARY DEFAULT 0,
			MODIFY `first` BINARY DEFAULT 0,
			MODIFY `view` BINARY DEFAULT 0,
			MODIFY `dist` BINARY DEFAULT 0');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('subject_type_tab');
	}

}
