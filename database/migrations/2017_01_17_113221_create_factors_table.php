<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFactorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('factors', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('addressid')->nullable();
			$table->decimal('shpprice', 10, 0)->nullable();
			$table->decimal('postprice', 10, 0)->nullable();
			$table->decimal('totalprice', 10, 0)->nullable();
			$table->enum('pay', array('0','1','2'))->nullable()->default('0');
			$table->dateTime('pay_date')->nullable();
			$table->string('retvalue')->nullable();
			$table->string('refid', 300);
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
		Schema::dropIfExists('factors');
	}

}
