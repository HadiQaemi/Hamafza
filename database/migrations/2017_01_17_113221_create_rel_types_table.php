<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReltypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rel_types', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->string('type1', 128);
			$table->string('type2', 128);
			$table->longText('comment');
			$table->smallInteger('rel')->default(0);
			$table->boolean('workflow')->default(1);
			$table->dateTime('reg_date')->nullable()->default(null);
			$table->dateTime('edit_date')->nullable()->default(null);
		    $table->timestamps();
            $table->softDeletes();
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('rel_types');
	}

}
