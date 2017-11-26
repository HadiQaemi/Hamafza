<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->string('Uname', 32)->unique('Uname');
			$table->string('password', 64);
            $table->enum('new_pass', array('0','1'))->nullable()->default('0');
			$table->string('Email', 64)->unique('Email');
			$table->boolean('Active')->default(0);
			$table->boolean('Level_access')->default(2);
			$table->string('Random_key', 32)->nullable();
			$table->integer('Bookmark')->default(0);
			$table->integer('Home')->default(0);
			$table->dateTime('Lastlogin');
			$table->string('Lastip', 64);
			$table->integer('Role');
			$table->smallInteger('Groups');
			$table->integer('SecGroups');
			$table->binary('Type', 1);
			$table->string('Name', 64);
			$table->string('Family', 64);
			$table->string('Summary');
			$table->binary('Gender', 1);
			$table->integer('avatar')->default(null);
			$table->string('Pic', 64);
			$table->dateTime('Reg_date');
			$table->integer('Visit')->unsigned()->default(0);
			$table->integer('Like')->unsigned()->default(0);
			$table->integer('Follow')->unsigned()->default(0);
			$table->integer('Relation')->unsigned()->default(0);
			$table->integer('Suggest')->unsigned()->default(0);
			$table->integer('Comment')->unsigned()->default(0);
			$table->enum('edited', array('0','1'))->nullable()->default('0');
			$table->enum('new', array('0','1'))->nullable()->default('0');
			$table->integer('user_id');
			$table->enum('passtype', array('0','1'))->nullable()->default('1')->comment('1:Laravel,0:Old');
			$table->string('remember_token', 100)->nullable();
			$table->string('last_session_id')->nullable();
			$table->date('last_login')->nullable();
			$table->boolean('device_type')->nullable();
            $table->integer('default_address_id')->default(0);
            $table->string('melli_code')->nullable();
            $table->enum('is_new', array('0','1'))->nullable()->default('0');
            $table->string('reset_password_code', 255)->nullable()->default(null);
            $table->timestamp('reset_password_due_time')->nullable()->default(null);
			$table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `user` 
			MODIFY `Type` BINARY DEFAULT 0,
			MODIFY `Gender` BINARY DEFAULT 0');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('user');
	}

}
