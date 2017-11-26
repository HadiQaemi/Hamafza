<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('types', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->string('name', 128);
			$table->longText('comment');
			$table->integer('stat')->default(0);
			$table->smallInteger('orders')->default(0);
			$table->smallInteger('rel')->default(0);
			$table->boolean('workflow')->default(1);
			$table->dateTime('reg_date')->nullable()->default(null);
			$table->dateTime('edit_date')->nullable()->default(null);
			$table->string('pic', 64);
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
		Schema::dropIfExists('types');
	}

}
