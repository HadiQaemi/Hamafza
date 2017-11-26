<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShoppingCartTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shopping_cart', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('bid')->nullable();
			$table->dateTime('reg_date')->nullable();
			$table->string('tedad')->nullable();
			$table->decimal('price', 10, 0)->nullable();
			$table->dateTime('finall_date')->nullable();
			$table->enum('finall', array('2','1','0'))->nullable()->default('0')->comment('1 ok 2 reject');
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
		Schema::dropIfExists('shopping_cart');
	}

}
