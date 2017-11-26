<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('parent_id')->default(0)->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('shid')->unsigned()->default(0)->comment('post_id for share');
			$table->integer('sid')->unsigned()->default(0);
            $table->integer('portal_id')->nullable()->default(0);
            $table->integer('type')->default(1);
            $table->integer('likes')->unsigned()->default(0);
            $table->integer('coms')->unsigned()->default(0);
            $table->integer('shares')->unsigned()->default(0);
            $table->longText('desc');
            $table->string('pic');
            $table->string('video');
            $table->string('reg_date', 20);
            $table->enum('view', array('0','1'))->default('1');
            $table->enum('read', array('0','1'))->default('0');
            $table->enum('faq', array('1','0'))->nullable()->default('0');
            $table->integer('viewcount')->nullable()->default(0);
            $table->string('title', 500);
            $table->boolean('accepted')->nullable()->default(0);
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
		Schema::dropIfExists('posts');
	}

}
