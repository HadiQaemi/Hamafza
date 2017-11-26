<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserGroupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_group', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->string('name', 128);
			$table->string('link', 64);
			$table->string('summary');
			$table->longText('descrip');
			$table->boolean('type');
			$table->longText('target');
			$table->longText('audience');
			$table->longText('strategy');
			$table->longText('description');
			$table->string('pic', 128);
			$table->enum('view', array('0','1'))->default('1');
			$table->enum('edit', array('0','1'))->default('0');
			$table->boolean('orders')->default(0);
			$table->dateTime('reg_date');
			$table->integer('visit')->unsigned()->default(0);
			$table->integer('like')->unsigned()->default(0);
			$table->integer('follow')->unsigned()->default(0);
			$table->integer('relation')->unsigned()->default(0);
			$table->integer('suggest')->unsigned()->default(0);
			$table->integer('comment')->unsigned()->default(0);
			$table->enum('new', array('0','1'))->nullable()->default('0');
			$table->enum('isorgan', array('0','1'))->nullable()->default('0');
			$table->longText('subject')->nullable();
			$table->longText('tel')->nullable();
			$table->longText('address')->nullable();
			$table->string('url', 500)->nullable();
			$table->string('email', 500)->nullable();
			$table->longText('activity');
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
		Schema::dropIfExists('user_group');
	}

}
