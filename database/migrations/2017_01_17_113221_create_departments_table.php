<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepartmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('departments', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('admin')->default(0);
			$table->string('name');
			$table->integer('pid')->default(0);
			$table->longText('body');
			$table->longText('description');
			$table->integer('orders')->default(0);
			$table->binary('view', 1);
			$table->dateTime('reg_date');
			$table->dateTime('edit_date');
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `departments` 
			MODIFY `view` BINARY DEFAULT 1');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('departments');
	}

}
