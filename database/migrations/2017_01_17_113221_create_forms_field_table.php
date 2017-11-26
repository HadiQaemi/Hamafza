<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormsFieldTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forms_field', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->smallInteger('form_id');
			$table->longText('field_name');
			$table->string('field_type', 64);
			$table->longText('field_value');
			$table->binary('requires', 1);
			$table->binary('scores', 1);
			$table->integer('orders');
			$table->smallInteger('level');
			$table->smallInteger('question');
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `forms_field` 
			MODIFY `requires` BINARY DEFAULT 0,
			MODIFY `scores` BINARY DEFAULT 0;');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('forms_field');
	}

}
