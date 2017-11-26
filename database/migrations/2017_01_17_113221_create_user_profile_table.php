<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserProfileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_profile', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->string('Byear', 16);
			$table->integer('Province')->default(0);
			$table->smallInteger('City')->unsigned()->default(0);
			$table->string('Mobile', 11);
			$table->string('Tel_code', 4);
			$table->string('Tel_number', 10);
			$table->string('Fax_code', 4);
			$table->string('Fax_number', 10);
			$table->string('Website', 16);
			$table->string('Company');
			$table->longText('Brief');
			$table->longText('Mission');
			$table->longText('Body');
			$table->longText('Comment');
			$table->dateTime('Reg_date');
			$table->dateTime('Edit_date');
			$table->integer('Vname')->unsigned()->default(0);
			$table->integer('Vfamily')->unsigned()->default(0);
			$table->integer('Vsummary')->unsigned()->default(0);
			$table->integer('Vgender')->unsigned()->default(0);
			$table->integer('Vbyear')->unsigned()->default(0);
			$table->integer('Vplace')->unsigned()->default(0);
			$table->integer('Vprovince')->unsigned()->default(0);
			$table->integer('Vcity')->unsigned()->default(0);
			$table->integer('Vtel')->unsigned()->default(1);
			$table->integer('Vfax')->unsigned()->default(0);
			$table->integer('Vmobile')->unsigned()->default(1);
			$table->integer('Vwebsite')->unsigned()->default(0);
			$table->integer('Vemail')->unsigned()->default(1);
			$table->integer('Vcomment')->unsigned()->default(0);
			$table->integer('Vpic')->unsigned()->default(0);
            $table->date('birth_date')->nullable()->default(null);
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
		Schema::dropIfExists('user_profile');
	}

}
