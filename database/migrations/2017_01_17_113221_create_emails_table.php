<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('emails', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->string('subject', 500)->nullable();
			$table->longText('body')->nullable();
			$table->dateTime('sendate')->nullable();
			$table->enum('read', array('0','1'))->nullable()->default('0');
			$table->string('type')->nullable();
			$table->enum('view', array('0','1'))->nullable()->default('0');
			$table->string('subject2', 500);
			$table->string('link', 500);
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
		Schema::dropIfExists('emails');
	}

}
