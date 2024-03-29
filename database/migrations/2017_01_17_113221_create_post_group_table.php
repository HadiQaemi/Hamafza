<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostGroupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_group', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('pid')->unsigned()->default(0);
			$table->integer('gid')->unsigned()->default(0);
			$table->enum('view', array('0','1'))->default('0');
			$table->index(['pid','gid'], 'pid');
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
		Schema::dropIfExists('post_group');
	}

}
