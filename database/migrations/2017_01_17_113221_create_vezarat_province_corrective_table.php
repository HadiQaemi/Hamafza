<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVezaratProvinceCorrectiveTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vezarat_province_corrective', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->string('a')->nullable();
			$table->string('b')->nullable();
			$table->string('c')->nullable();
			$table->string('d')->nullable();
			$table->string('e')->nullable();
			$table->string('f')->nullable();
			$table->string('g')->nullable();
			$table->string('h')->nullable();
			$table->string('i')->nullable();
			$table->string('j')->nullable();
			$table->string('k')->nullable();
			$table->string('l')->nullable();
			$table->string('m')->nullable();
			$table->string('n')->nullable();
			$table->string('o')->nullable();
			$table->string('p')->nullable();
			$table->string('q')->nullable();
			$table->string('r')->nullable();
			$table->string('s')->nullable();
			$table->string('t')->nullable();
			$table->string('u')->nullable();
			$table->string('v')->nullable();
			$table->string('w')->nullable();
			$table->string('x')->nullable();
			$table->string('y')->nullable();
			$table->string('z')->nullable();
			$table->string('aa')->nullable();
			$table->string('ab')->nullable();
			$table->string('ac')->nullable();
			$table->string('ad')->nullable();
			$table->string('ae')->nullable();
			$table->string('af')->nullable();
			$table->string('ag')->nullable();
			$table->string('ah')->nullable();
			$table->string('ai')->nullable();
			$table->string('aj')->nullable();
			$table->string('ak')->nullable();
			$table->string('al')->nullable();
			$table->string('am')->nullable();
			$table->string('an')->nullable();
			$table->string('ao')->nullable();
			$table->string('ap')->nullable();
			$table->string('aq')->nullable();
			$table->string('ar')->nullable();
			$table->string('as1')->nullable();
			$table->string('at')->nullable();
			$table->string('au')->nullable();
			$table->string('av')->nullable();
			$table->string('aw')->nullable();
			$table->string('ax')->nullable();
			$table->string('ay')->nullable();
			$table->string('az')->nullable();
			$table->string('ba')->nullable();
			$table->string('bb')->nullable();
			$table->string('bc')->nullable();
			$table->string('bd')->nullable();
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
		Schema::dropIfExists('vezarat_province_corrective');
	}

}
