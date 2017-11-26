<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserFriendTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_friend', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('fid')->default(0)->index('fid')->comment('friend_id');
			$table->integer('cid')->default(0)->comment('circle_id');
			$table->enum('relation', array('0','1','2'))->default('0');
			$table->enum('follow', array('0','1'))->default('0');
			$table->enum('like', array('0','1'))->default('0');
			$table->dateTime('reg_date');
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
		Schema::dropIfExists('user_friend');
	}

}
